<?php

namespace App\Http\Controllers\WebClubs;

use App\Http\Controllers\Controller;
use App\Classes\PdfFile;
use App\Mail\PaymentPlayerPaidConfirmation;
use App\Models\PaymentPlayer;
use App\Models\SportsSchool;
use App\Services\PaymentGatewayService;
use App\Services\SchoolMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentSearchController extends Controller
{
    /**
     * Retorno tras un pago con tarjeta correcto.
     * Para Stripe verifica la sesión y actualiza el recibo.
     * Para Redsys la actualización real ocurre en redsysNotify (server-to-server).
     */
    public function paymentOk(Request $request)
    {
        $school = currentSchool();
        if (! $school) {
            abort(404, 'Escuela no encontrada');
        }

        $code = strtoupper((string) $request->query('code', ''));

        // Stripe: verificamos la sesión con la API para no fiarnos del navegador
        if ($request->filled('session_id') && $school->hasActivePayment()) {
            try {
                $service = new PaymentGatewayService($school);
                if ($service->isStripe()) {
                    $stripe  = $service->stripeClient();
                    $session = $stripe->checkout->sessions->retrieve($request->query('session_id'), []);

                    $paymentPlayerId = $session->metadata['payment_player_id'] ?? null;
                    if ($paymentPlayerId && ($session->payment_status ?? null) === 'paid') {
                        $payment = PaymentPlayer::where('id', $paymentPlayerId)
                            ->where('sports_school_id', $school->id)
                            ->first();

                        if ($payment && (int) $payment->state !== (int) config('constants.states_payment_orders.Pagado')) {
                            $payment->state        = (int) config('constants.states_payment_orders.Pagado');
                            $payment->payment_date = now();
                            $payment->payment_type = 'tarjeta';
                            $payment->payment_auth = (string) ($session->payment_intent ?? '');
                            $payment->save();

                            $this->sendPaidConfirmation($payment, $school);
                        }
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('PaymentSearch Stripe verification failed', [
                    'school_id' => $school->id,
                    'error'     => $e->getMessage(),
                ]);
            }
        }

        return redirect()->route('webclubs.payment', ['code' => $code, 'status' => 'ok']);
    }

    /**
     * Retorno tras un pago cancelado o rechazado.
     */
    public function paymentKo(Request $request)
    {
        $code = strtoupper((string) $request->query('code', ''));
        return redirect()->route('webclubs.payment', ['code' => $code, 'status' => 'ko']);
    }

    /**
     * Notificación server-to-server de Redsys.
     * Verifica firma y, si el pago es correcto, actualiza el recibo.
     */
    public function redsysNotify(Request $request)
    {
        $school = currentSchool();
        if (! $school) {
            return response('School not found', 404);
        }

        $params    = (string) $request->input('Ds_MerchantParameters', '');
        $signature = (string) $request->input('Ds_Signature', '');

        if ($params === '' || $signature === '') {
            return response('Missing params', 400);
        }

        $service = new PaymentGatewayService($school);

        if (! $service->redsysVerifyNotification($params, $signature)) {
            Log::warning('PaymentSearch Redsys notification invalid signature', [
                'school_id' => $school->id,
            ]);
            return response('Invalid signature', 400);
        }

        $decoded = json_decode(base64_decode(strtr($params, '-_', '+/')), true) ?: [];

        $order        = $decoded['Ds_Order']              ?? $decoded['DS_ORDER']              ?? null;
        $responseCode = $decoded['Ds_Response']           ?? $decoded['DS_RESPONSE']           ?? null;
        $authCode     = $decoded['Ds_AuthorisationCode']  ?? $decoded['DS_AUTHORISATIONCODE']  ?? null;

        if (! $order) {
            return response('Missing order', 400);
        }

        // Redsys: códigos 0-99 → autorización aprobada
        $responseCodeInt = is_numeric($responseCode) ? (int) $responseCode : -1;
        $isApproved      = $responseCodeInt >= 0 && $responseCodeInt <= 99;

        $payment = PaymentPlayer::where('payment_order', $order)
            ->where('sports_school_id', $school->id)
            ->first();

        if ($payment && $isApproved
            && (int) $payment->state !== (int) config('constants.states_payment_orders.Pagado')
        ) {
            $payment->state        = (int) config('constants.states_payment_orders.Pagado');
            $payment->payment_date = now();
            $payment->payment_type = 'tarjeta';
            $payment->payment_auth = (string) ($authCode ?: '');
            $payment->save();

            $this->sendPaidConfirmation($payment, $school);
        }

        Log::info('PaymentSearch Redsys notification processed', [
            'school_id'   => $school->id,
            'order'       => $order,
            'response'    => $responseCode,
            'approved'    => $isApproved,
            'payment_id'  => $payment?->id,
        ]);

        return response('OK', 200);
    }

    /**
     * Envía al jugador el email de confirmación de pago con el recibo en PDF adjunto.
     */
    protected function sendPaidConfirmation(PaymentPlayer $payment, SportsSchool $school): void
    {
        try {
            $payment->loadMissing(['player', 'paymentTeam.team.section']);

            if (! $payment->player || empty($payment->player->email)) {
                return;
            }

            $pdfData = [
                'payment'       => $payment,
                'player'        => $payment->player,
                'sportsSchool'  => $school,
                'generatedDate' => now()->format('d/m/Y H:i'),
            ];

            $pdf = new PdfFile();
            $pdf->file_name = 'recibo_pago_' . ($payment->code ?: $payment->id);
            $pdf->templates[0] = 'pdfs.payment-receipt';
            $pdf->records = ['data' => $pdfData];

            $pdfContent = (string) $pdf->generateFromTemplate($pdf->templates[0]);

            $mailable = new PaymentPlayerPaidConfirmation(
                payment: $payment,
                school: $school,
                pdfContent: $pdfContent,
                pdfFilename: 'recibo_' . Str::slug($payment->code ?: (string) $payment->id) . '.pdf',
            );

            SchoolMailer::forSchool($school)
                ->to(
                    $payment->player->email,
                    trim(($payment->player->name ?? '') . ' ' . ($payment->player->surname ?? ''))
                )
                ->send($mailable);
        } catch (\Throwable $e) {
            Log::error('Error enviando confirmación de pago con tarjeta', [
                'payment_player_id' => $payment->id,
                'error'             => $e->getMessage(),
            ]);
        }
    }
}
