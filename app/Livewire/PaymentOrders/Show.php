<?php

namespace App\Livewire\PaymentOrders;

use Livewire\Component;
use App\Models\Player;
use App\Models\PaymentPlayer;
use App\Classes\PdfFile;
use Illuminate\Support\Facades\Log;
use App\Mail\PaymentPlayerLetter;
use App\Services\SchoolMailer;
use Illuminate\Support\Str;

class Show extends Component
{
    public $playerId;
    public $player;
    public $payments;

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
            $payment = PaymentPlayer::with(['player', 'paymentTeam'])
                ->where('id', $paymentId)
                ->where('sports_school_id', auth()->user()->sports_school_id)
                ->firstOrFail();

            // Verificar que el pago esté pendiente
            if ($payment->state == 1) {
                session()->flash('error', 'Esta cuota ya ha sido pagada.');
                return;
            }

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
            $pdf->file_name = 'carta_pago_' . $player->name . '_' . $player->surname . '_cuota_' . $payment->cuota;
            $pdf->templates[0] = 'pdfs.payment-card';
            $pdf->records = ['data' => $data];
            
            $content = $pdf->generateFromTemplate($pdf->templates[0]);
            
            return response()->streamDownload(
                fn () => print($content),
                $pdf->getFileName()
            );

        } catch (\Exception $e) {
            session()->flash('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    public function downloadPaymentReceipt($paymentId)
    {
        try {
            $payment = PaymentPlayer::with(['player', 'paymentTeam'])
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
            $pdf->file_name = 'recibo_pago_' . $player->name . '_' . $player->surname . '_cuota_' . $payment->cuota;
            $pdf->templates[0] = 'pdfs.payment-receipt';
            $pdf->records = ['data' => $data];
            
            $content = $pdf->generateFromTemplate($pdf->templates[0]);
            
            return response()->streamDownload(
                fn () => print($content),
                $pdf->getFileName()
            );

        } catch (\Exception $e) {
            session()->flash('error', 'Error al generar el recibo: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function updatePaymentState($paymentId, $newState)
    {
        try {
            $payment = PaymentPlayer::where('id', $paymentId)
                ->where('sports_school_id', auth()->user()->sports_school_id)
                ->firstOrFail();

            $payment->state = $newState;
            
            // Si se marca como pagado, guardar fecha de pago
            if ($newState == 1 && !$payment->payment_date) {
                $payment->payment_date = now();
            }
            
            // Si se cambia de pagado a otro estado, limpiar fecha de pago
            if ($newState != 1) {
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
            
            $payment = PaymentPlayer::where('id', $paymentId)
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

    public function render()
    {
        return view('livewire.payment-orders.show');
    }
}


   