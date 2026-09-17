<?php

namespace App\Livewire\WebClubs;

use App\Classes\PdfFile;
use App\Mail\PaymentPlayerLetter;
use App\Mail\PaymentPlayerTransferPendingAdmin;
use App\Mail\PaymentPlayerTransferReceived;
use App\Models\PaymentPlayer;
use App\Models\Season;
use App\Services\PaymentGatewayService;
use App\Services\SchoolMailer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class PanelSearchPay extends Component
{
    use WithFileUploads;

    public $school;
    public $activeSeason;

    // Búsqueda por código
    public string $code = '';
    public $payment = null;

    // Búsqueda por email
    public string $email = '';
    public bool $showEmailFallback = false;
    public $emailPayments = null;
    public bool $emailSent = false;
    public int $lettersSent = 0;

    // Pago por transferencia
    public $receipt_file;

    // Pago con tarjeta (Redsys autosubmit)
    public ?array $redsysForm = null;

    // Mensajes de UI
    public string $errorMessage = '';
    public string $successMessage = '';
    public string $infoMessage = '';

    public function mount(): void
    {
        $this->school = currentSchool();

        if (! $this->school) {
            abort(404, 'Escuela no encontrada');
        }

        $this->activeSeason = Season::where('sports_school_id', $this->school->id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();

        // Retorno desde la pasarela: ?status=ok|ko&code=XXX
        $status = request()->query('status');
        $codeParam = request()->query('code');
        if ($status && $codeParam) {
            $this->code = strtoupper((string) $codeParam);
            $this->loadPaymentByCode();

            if ($status === 'ok' && $this->payment) {
                if ($this->isPaid()) {
                    $this->successMessage = '¡Pago realizado correctamente! El recibo ya consta como abonado.';
                } else {
                    $this->infoMessage = 'Estamos confirmando tu pago con la entidad bancaria. En unos minutos verás la confirmación.';
                }
            } elseif ($status === 'ko') {
                $this->errorMessage = 'El pago no se ha completado. Puedes volver a intentarlo cuando quieras.';
            }
        }
    }

    // ── Opción 1: Búsqueda por código ─────────────────────────────────────
    public function searchpay(): void
    {
        $this->resetErrorBag();
        $this->clearMessages();
        $this->emailPayments = null;
        $this->emailSent = false;

        $this->validate([
            'code' => 'required|string|max:60',
        ], [
            'code.required' => 'Introduce el código de la carta de pago.',
        ]);

        $this->code = strtoupper(trim($this->code));
        $this->loadPaymentByCode();

        if (! $this->payment) {
            $this->addError('code', 'El código introducido no existe.');
            $this->showEmailFallback = true;
        }
    }

    protected function loadPaymentByCode(): void
    {
        $this->payment = PaymentPlayer::query()
            ->where('code', $this->code)
            ->where('sports_school_id', $this->school->id)
            ->with(['player', 'paymentTeam'])
            ->first();
    }

    // ── Opción 2: Búsqueda por email + reenvío de cartas ──────────────────
    public function searchByEmail(): void
    {
        $this->resetErrorBag();
        $this->clearMessages();
        $this->emailSent = false;
        $this->emailPayments = null;

        $this->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Introduce tu correo electrónico.',
            'email.email'    => 'El correo electrónico no es válido.',
        ]);

        if (! $this->activeSeason) {
            $this->addError('email', 'Actualmente no hay ninguna temporada activa.');
            return;
        }

        $pendingState  = (int) config('constants.states_payment_orders.Pendiente');
        $awaitingState = (int) config('constants.states_payment_orders.Pendiente de validar');

        $this->emailPayments = PaymentPlayer::query()
            ->whereHas('player', fn ($q) => $q->where('email', $this->email))
            ->where('sports_school_id', $this->school->id)
            ->whereIn('state', [$pendingState, $awaitingState])
            ->whereHas('paymentTeam', fn ($q) => $q->where('season_id', $this->activeSeason->id))
            ->with(['player', 'paymentTeam'])
            ->orderBy('cuota')
            ->get();

        if ($this->emailPayments->isEmpty()) {
            $this->addError('email', 'No hemos encontrado recibos pendientes para este correo en la temporada activa.');
        }
    }

    public function sendPaymentLetters(): void
    {
        $this->resetErrorBag();
        $this->clearMessages();

        if (! $this->emailPayments || $this->emailPayments->isEmpty()) {
            $this->errorMessage = 'No hay cartas de pago para enviar.';
            return;
        }

        $sent = 0;
        foreach ($this->emailPayments as $payment) {
            $payment->loadMissing(['player', 'paymentTeam']);
            if (! $payment->player || empty($payment->player->email)) {
                continue;
            }

            try {
                $pdfContent = $this->buildPaymentPdf($payment);

                $mailable = new PaymentPlayerLetter(
                    payment: $payment,
                    school: $this->school,
                    pdfContent: $pdfContent,
                    pdfFilename: 'carta_pago_' . Str::slug($payment->code ?: (string) $payment->id) . '.pdf',
                );

                SchoolMailer::forSchool($this->school)
                    ->to(
                        $payment->player->email,
                        trim(($payment->player->name ?? '') . ' ' . ($payment->player->surname ?? ''))
                    )
                    ->send($mailable);

                $sent++;
            } catch (\Throwable $e) {
                Log::error('Error enviando carta de pago pública', [
                    'payment_player_id' => $payment->id,
                    'error'             => $e->getMessage(),
                ]);
            }
        }

        if ($sent > 0) {
            $this->emailSent = true;
            $this->lettersSent = $sent;
            $this->successMessage = 'Hemos enviado ' . $sent . ' ' . ($sent === 1 ? 'carta de pago' : 'cartas de pago') . ' a tu correo electrónico.';
        } else {
            $this->errorMessage = 'No se ha podido enviar ninguna carta de pago. Inténtalo de nuevo más tarde.';
        }
    }

    protected function buildPaymentPdf(PaymentPlayer $payment): string
    {
        $data = [
            'payment'       => $payment,
            'player'        => $payment->player,
            'sportsSchool'  => $this->school,
            'generatedDate' => now()->format('d/m/Y H:i'),
        ];

        $pdf = new PdfFile();
        $pdf->file_name = 'carta_pago_' . ($payment->code ?: $payment->id);
        $pdf->templates[0] = 'pdfs.payment-card';
        $pdf->records = ['data' => $data];

        return (string) $pdf->generateFromTemplate($pdf->templates[0]);
    }

    protected function sendTransferReceivedEmail(PaymentPlayer $payment): void
    {
        try {
            $payment->loadMissing(['player', 'paymentTeam']);

            if (! $payment->player || empty($payment->player->email)) {
                return;
            }

            $mailable = new PaymentPlayerTransferReceived(
                payment: $payment,
                school: $this->school,
            );

            SchoolMailer::forSchool($this->school)
                ->to(
                    $payment->player->email,
                    trim(($payment->player->name ?? '') . ' ' . ($payment->player->surname ?? ''))
                )
                ->send($mailable);
        } catch (\Throwable $e) {
            Log::error('Error enviando confirmación de justificante de transferencia', [
                'payment_player_id' => $payment->id,
                'error'             => $e->getMessage(),
            ]);
        }
    }

    protected function sendTransferPendingAdminEmail(PaymentPlayer $payment, string $receiptRelativePath): void
    {
        try {
            $adminEmail = $this->school->email
                ?: $this->school->mail_from_address
                ?: $this->school->mail_username;

            if (empty($adminEmail)) {
                return;
            }

            $absolutePath = Storage::disk('public')->path($receiptRelativePath);
            $filename     = basename($receiptRelativePath);

            $mailable = new PaymentPlayerTransferPendingAdmin(
                payment: $payment,
                school: $this->school,
                receiptAbsolutePath: is_file($absolutePath) ? $absolutePath : null,
                receiptFilename: $filename,
            );

            SchoolMailer::forSchool($this->school)
                ->to($adminEmail, $this->school->name ?? null)
                ->send($mailable);
        } catch (\Throwable $e) {
            Log::error('Error enviando aviso al club de transferencia pendiente', [
                'payment_player_id' => $payment->id,
                'error'             => $e->getMessage(),
            ]);
        }
    }

    // ── Pago con tarjeta ──────────────────────────────────────────────────
    public function payWithCard()
    {
        $this->resetErrorBag();
        $this->clearMessages();
        $this->redsysForm = null;

        if (! $this->payment) {
            return null;
        }

        if ($this->isPaid()) {
            $this->infoMessage = 'Este recibo ya consta como pagado.';
            return null;
        }

        if (! $this->school || ! $this->school->payments_enabled || ! $this->school->hasActivePayment()) {
            $this->errorMessage = 'La pasarela de pago no está disponible en este momento.';
            return null;
        }

        if ((float) $this->payment->amount <= 0) {
            $this->errorMessage = 'El importe del recibo no es válido.';
            return null;
        }

        $service = new PaymentGatewayService($this->school);
        $order   = $this->generatePaymentOrder();

        // Guardamos la referencia enviada a la pasarela para poder localizar el recibo desde la notificación
        $this->payment->payment_order = $order;
        $this->payment->save();

        try {
            if ($service->isStripe()) {
                return $this->startStripe($service, $order);
            }

            if ($service->isRedsys()) {
                $this->redsysForm = $service->redsysFormParams([
                    'order'        => $order,
                    'amount'       => (float) $this->payment->amount,
                    'description'  => 'Cuota ' . ($this->payment->cuota ?: '') . ' - ' . $this->school->name,
                    'url_ok'       => route('webclubs.payment.ok', ['code' => $this->payment->code]),
                    'url_ko'       => route('webclubs.payment.ko', ['code' => $this->payment->code]),
                    'merchant_url' => route('webclubs.payment.redsys-notify'),
                    'use_bizum'    => false,
                ]);
                return null;
            }
        } catch (\Throwable $e) {
            Log::error('PanelSearchPay error iniciando pago con tarjeta', [
                'payment_player_id' => $this->payment->id,
                'error'             => $e->getMessage(),
            ]);
            $this->errorMessage = 'No se ha podido iniciar el pago con tarjeta. Inténtalo de nuevo más tarde.';
            return null;
        }

        $this->errorMessage = 'Pasarela de pago no soportada.';
        return null;
    }

    protected function startStripe(PaymentGatewayService $service, string $order)
    {
        $stripe = $service->stripeClient();

        $successUrl = route('webclubs.payment.ok', ['code' => $this->payment->code]);
        $successUrl .= (str_contains($successUrl, '?') ? '&' : '?') . 'session_id={CHECKOUT_SESSION_ID}';

        $session = $stripe->checkout->sessions->create([
            'mode'                 => 'payment',
            'payment_method_types' => ['card'],
            'line_items'           => [[
                'quantity'   => 1,
                'price_data' => [
                    'currency'     => 'eur',
                    'unit_amount'  => (int) round(((float) $this->payment->amount) * 100),
                    'product_data' => [
                        'name'        => 'Cuota ' . ($this->payment->cuota ?: '') . ' - ' . $this->school->name,
                        'description' => 'Recibo ' . $this->payment->code,
                    ],
                ],
            ]],
            'metadata' => [
                'payment_player_id' => (string) $this->payment->id,
                'sports_school_id'  => (string) $this->school->id,
                'order'             => $order,
            ],
            'success_url' => $successUrl,
            'cancel_url'  => route('webclubs.payment.ko', ['code' => $this->payment->code]),
        ]);

        return redirect()->away($session->url);
    }

    protected function generatePaymentOrder(): string
    {
        return substr((string) date('YmdHis'), -4) . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
    }

    // ── Pago con transferencia ────────────────────────────────────────────
    public function submitTransfer(): void
    {
        $this->resetErrorBag();
        $this->clearMessages();

        if (! $this->payment) {
            return;
        }

        if ($this->isPaid()) {
            $this->infoMessage = 'Este recibo ya consta como pagado.';
            return;
        }

        $this->validate([
            'receipt_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'receipt_file.required' => 'Adjunta el justificante de la transferencia.',
            'receipt_file.mimes'    => 'El archivo debe ser PDF, JPG o PNG.',
            'receipt_file.max'      => 'El archivo no puede superar los 5 MB.',
        ]);

        try {
            $filename = 'receipt_' . $this->payment->id . '_' . now()->format('YmdHis') . '_' . Str::random(6)
                . '.' . $this->receipt_file->getClientOriginalExtension();

            $path = $this->receipt_file->storeAs(
                'payment-receipts/' . $this->school->id,
                $filename,
                'public'
            );

            $this->payment->payment_receipt = $path;
            $this->payment->payment_type    = 'pago por transferencia';
            $this->payment->dtnotification  = now();
            $this->payment->state           = (int) config('constants.states_payment_orders.Pendiente de validar');
            $this->payment->save();
            $this->payment->refresh();

            $this->sendTransferReceivedEmail($this->payment);
            $this->sendTransferPendingAdminEmail($this->payment, $path);

            $this->receipt_file = null;
            $this->successMessage = 'Hemos recibido tu justificante. Validaremos el pago en un plazo máximo de 7 días.';
        } catch (\Throwable $e) {
            Log::error('Error subiendo justificante de transferencia', [
                'payment_player_id' => $this->payment->id,
                'error'             => $e->getMessage(),
            ]);
            $this->errorMessage = 'No se ha podido subir el justificante. Inténtalo de nuevo.';
        }
    }

    public function resetSearch(): void
    {
        $this->payment       = null;
        $this->emailPayments = null;
        $this->emailSent     = false;
        $this->lettersSent   = 0;
        $this->code          = '';
        $this->email         = '';
        $this->showEmailFallback = false;
        $this->receipt_file  = null;
        $this->redsysForm    = null;
        $this->clearMessages();
        $this->resetErrorBag();
    }

    protected function clearMessages(): void
    {
        $this->errorMessage   = '';
        $this->successMessage = '';
        $this->infoMessage    = '';
    }

    public function isPaid(): bool
    {
        return $this->payment
            && (int) $this->payment->state === (int) config('constants.states_payment_orders.Pagado');
    }

    public function isAwaitingValidation(): bool
    {
        return $this->payment
            && (int) $this->payment->state === (int) config('constants.states_payment_orders.Pendiente de validar');
    }

    public function render()
    {
        return view('livewire.webclubs.panel-search-pay')
            ->layout('livewire.webclubs.layouts.app');
    }
}
