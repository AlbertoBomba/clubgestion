<?php

namespace App\Livewire\PaymentOrders;

use Livewire\Component;
use App\Models\Player;
use App\Models\PaymentPlayer;
use App\Classes\PdfFile;
use Illuminate\Support\Facades\Log;
use App\Mail\PaymentPlayerLetter;
use App\Mail\PaymentPlayerPaidConfirmation;
use App\Services\SchoolMailer;
use Illuminate\Support\Str;
use App\Traits\DetectsDevice;


class Show extends Component
{
    use DetectsDevice;
    public $playerId;
    public $player;
    public $payments;

    // Modal de selección de forma de pago al marcar como "Pagado"
    public $showPaymentTypeModal = false;
    public $pendingPaymentId = null;
    public $selectedPaymentType = 'transferencia';
    public $sendReceiptEmail = true;

    protected $paymentTypes = [
        'transferencia' => 'Pago por transferencia',
        'efectivo' => 'Pago en efectivo',
    ];

    public function mount($playerId)
    {
        $this->playerId = $playerId;
        $this->loadPlayer();
    }

    public function loadPlayer()
    {
        $this->player = Player::with(['teams.season', 'teams.category', 'teams.section'])
            ->find($this->playerId);

        if (!$this->player) {
            session()->flash('error', 'Jugador no encontrado.');
            return redirect()->route('payment-orders.index');
        }

        // Cargar pagos del jugador con información del pago del equipo
        $this->payments = PaymentPlayer::with(['paymentTeam'])
            ->where('player_id', $this->playerId)
            ->where('sports_school_id', auth()->user()->sports_school_id)
            ->orderBy('cuota', 'asc')
            ->get();
    }

    public function downloadPaymentPdf($paymentId)
    {
        try {
            $payment = PaymentPlayer::with(['player', 'paymentTeam.team.section'])
                ->where('id', $paymentId)
                ->where('sports_school_id', auth()->user()->sports_school_id)
                ->firstOrFail();

            // Verificar que el pago esté pendiente
            if ($payment->state == 1) {
                session()->flash('error', 'Esta cuota ya ha sido pagada.');
                return;
            }
            // dd($payment);

            $player = $payment->player;
            
            // Preparar datos para el PDF
            $data = [
                'payment' => $payment,
                'player' => $player,
                'sportsSchool' => $player->sportsSchool,
                'generatedDate' => now()->format('d/m/Y H:i'),
            ];

            // Generar carta de pago en
            $pdf = new PdfFile();
            $pdf->file_name = 'carta_pago_' . Str::slug($player->name . '_' . $player->surname) . '_cuota_' . $payment->cuota;
            $pdf->templates[0] = 'pdfs.payment-card';
            $pdf->records = ['data' => $data];
            
            $content = $pdf->generateFromTemplate($pdf->templates[0]);

            return response()->streamDownload(
                fn () => print($content),
                $pdf->getFileName(),
                [
                    'Content-Type'        => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $pdf->getFileName() . '"',
                ]
            );

        } catch (\Exception $e) {
            session()->flash('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    public function downloadPaymentReceipt($paymentId)
    {
        try {
            $payment = PaymentPlayer::with(['player', 'paymentTeam.team.section'])
                ->where('id', $paymentId)
                ->where('sports_school_id', auth()->user()->sports_school_id)
                ->firstOrFail();

            // Verificar que el pago esté pagado
            if ($payment->state != 1) {
                session()->flash('error', 'Solo se puede generar recibo para pagos completados.');
                return redirect()->route('pay-orders.show', $payment->player_id);
            }

            $player = $payment->player;
            
            // Preparar datos para el PDF
            $data = [
                'payment' => $payment,
                'player' => $player,
                'sportsSchool' => $player->sportsSchool,
                'generatedDate' => now()->format('d/m/Y H:i'),
            ];

            // Generar PDF
            $pdf = new PdfFile();
            $pdf->file_name = 'recibo_pago_' . Str::slug($player->name . '_' . $player->surname) . '_cuota_' . $payment->cuota;
            $pdf->templates[0] = 'pdfs.payment-receipt';
            $pdf->records = ['data' => $data];
            
            $content = $pdf->generateFromTemplate($pdf->templates[0]);

            return response()->streamDownload(
                fn () => print($content),
                $pdf->getFileName(),
                [
                    'Content-Type'        => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $pdf->getFileName() . '"',
                ]
            );

        } catch (\Exception $e) {
            session()->flash('error', 'Error al generar el recibo: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function updatePaymentState($paymentId, $newState)
    {
        // Si se marca como "Pagado" pedimos primero la forma de pago
        if ((int) $newState === 1) {
            $this->pendingPaymentId = $paymentId;
            $this->selectedPaymentType = 'transferencia';
            $this->sendReceiptEmail = true;
            $this->resetErrorBag();
            $this->showPaymentTypeModal = true;
            return;
        }

        $this->savePaymentState($paymentId, (int) $newState);
    }

    public function confirmPaymentAsPaid()
    {
        $this->validate([
            'selectedPaymentType' => 'required|in:transferencia,efectivo',
        ], [
            'selectedPaymentType.required' => 'Debes seleccionar una forma de pago.',
            'selectedPaymentType.in' => 'La forma de pago seleccionada no es válida.',
        ]);

        if (!$this->pendingPaymentId) {
            $this->closePaymentTypeModal();
            return;
        }

        $paymentId = $this->pendingPaymentId;
        $this->savePaymentState($paymentId, 1, $this->selectedPaymentType);

        if ($this->sendReceiptEmail) {
            $this->sendReceiptEmailForPayment($paymentId);
        }

        $this->closePaymentTypeModal(false);
    }

    public function closePaymentTypeModal($reload = true)
    {
        $this->showPaymentTypeModal = false;
        $this->pendingPaymentId = null;
        $this->selectedPaymentType = 'transferencia';
        $this->sendReceiptEmail = true;
        $this->resetErrorBag();

        // Recargar para revertir el select del estado en la vista si el usuario canceló
        if ($reload) {
            $this->loadPlayer();
        }
    }

    protected function savePaymentState($paymentId, $newState, $paymentType = null)
    {
        try {
            $payment = PaymentPlayer::where('id', $paymentId)
                ->where('sports_school_id', auth()->user()->sports_school_id)
                ->firstOrFail();

            $payment->state = $newState;

            if ($newState == 1) {
                if (!$payment->payment_date) {
                    $payment->payment_date = now();
                }
                if ($paymentType) {
                    $payment->payment_type = $paymentType;
                }
            } else {
                // Si se cambia de pagado a otro estado, limpiar datos de pago
                $payment->payment_date = null;
                $payment->payment_type = null;
                $payment->payment_auth = null;
            }

            $payment->updated_user = auth()->id();
            $payment->save();

            // Recargar los pagos
            $this->loadPlayer();

            $stateNames = [
                0 => 'Pendiente de pago',
                1 => 'Pagado',
                2 => 'Lesión',
                3 => 'Baja Jugador',
                4 => 'Cancelado',
                5 => 'Abonada',
                6 => 'Pendiente de validar',
            ];

            session()->flash('message', 'Estado actualizado a: ' . $stateNames[$newState]);

        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }

    public function sendPaymentLetters($paymentId)
    {
        $email_notification = true;
        $whatsapp_notification = false;
        $sms_notification = false;
        $push_notification = false;
            
            $payment = PaymentPlayer::with(['player', 'paymentTeam.team.section'])
                ->where('id', $paymentId)
                ->where('sports_school_id', auth()->user()->sports_school_id)
                ->firstOrFail();

            $school = $payment->player->sportsSchool;
            //  try {
                $pdfContent = $this->buildPaymentPdf($payment);
                
                $mailable = new PaymentPlayerLetter(
                    payment: $payment,
                    school: $school,
                    pdfContent: $pdfContent,
                    pdfFilename: 'carta_pago_' . Str::slug($payment->code ?: (string) $payment->id) . '.pdf',
                );

                SchoolMailer::forSchool($school)
                    ->to(
                        $payment->player->email,
                        trim(($payment->player->name ?? '') . ' ' . ($payment->player->surname ?? ''))
                    )
                    ->send($mailable);
            
                $payment->email_notification = $email_notification;
                $payment->whatsapp_notification = $whatsapp_notification;
                $payment->sms_notification = $sms_notification;
                $payment->push_notification = $push_notification;
                $payment->dtnotification = now();
                $payment->notification = $payment->notification +1;
                $payment->save();
                session()->flash('mail_message', " Notificación de carta enviada correctamente ");

            //   } catch (\Throwable $e) {
            //     Log::error('Error enviando carta de pago pública', [
            //         'payment_player_id' => $payment->id,
            //         'error'             => $e->getMessage(),
            //     ]);
            // }  
            // Lógica para enviar las cartas de pago al jugador
            // Por ejemplo, enviar un correo electrónico o notificación

          
    }

    protected function buildPaymentPdf(PaymentPlayer $payment): string
    {
        $data = [
            'payment'       => $payment,
            'player'        => $payment->player,
            'sportsSchool'  => $payment->player->sportsSchool,
            'generatedDate' => now()->format('d/m/Y H:i'),
        ];

        $pdf = new PdfFile();
        $pdf->file_name = 'carta_pago_' . ($payment->code ?: $payment->id);
        $pdf->templates[0] = 'pdfs.payment-card';
        $pdf->records = ['data' => $data];

        return (string) $pdf->generateFromTemplate($pdf->templates[0]);
    }

    protected function buildPaymentReceiptPdf(PaymentPlayer $payment): string
    {
        $data = [
            'payment'       => $payment,
            'player'        => $payment->player,
            'sportsSchool'  => $payment->player->sportsSchool,
            'generatedDate' => now()->format('d/m/Y H:i'),
        ];

        $pdf = new PdfFile();
        $pdf->file_name = 'recibo_pago_' . ($payment->code ?: $payment->id);
        $pdf->templates[0] = 'pdfs.payment-receipt';
        $pdf->records = ['data' => $data];

        return (string) $pdf->generateFromTemplate($pdf->templates[0]);
    }

    protected function sendReceiptEmailForPayment($paymentId): void
    {
        try {
            $payment = PaymentPlayer::with(['player', 'paymentTeam.team.section'])
                ->where('id', $paymentId)
                ->where('sports_school_id', auth()->user()->sports_school_id)
                ->first();

            if (!$payment || !$payment->player) {
                return;
            }

            $recipient = $payment->player->email;
            if (empty($recipient)) {
                session()->flash('error', 'No se pudo enviar el recibo: el jugador no tiene email registrado.');
                return;
            }

            $school = $payment->player->sportsSchool;
            $pdfContent = $this->buildPaymentReceiptPdf($payment);
            $pdfFilename = 'recibo_pago_' . Str::slug($payment->code ?: (string) $payment->id) . '.pdf';

            $mailable = new PaymentPlayerPaidConfirmation(
                payment: $payment,
                school: $school,
                pdfContent: $pdfContent,
                pdfFilename: $pdfFilename,
            );

            SchoolMailer::forSchool($school)
                ->to(
                    $recipient,
                    trim(($payment->player->name ?? '') . ' ' . ($payment->player->surname ?? ''))
                )
                ->send($mailable);

            session()->flash('mail_message', 'Recibo enviado por email a ' . $recipient);
        } catch (\Throwable $e) {
            Log::error('Error enviando recibo de pago', [
                'payment_player_id' => $paymentId,
                'error'             => $e->getMessage(),
            ]);
            session()->flash('error', 'El pago se guardó, pero no se pudo enviar el recibo por email: ' . $e->getMessage());
        }
    }

    public function render()
    {

        if ($this->isMobile()) {
            return view('livewire.payment-orders.show_mobile');
        }

        return view('livewire.payment-orders.show');


    }
}


   