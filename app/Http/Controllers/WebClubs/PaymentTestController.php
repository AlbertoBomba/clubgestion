<?php

namespace App\Http\Controllers\WebClubs;

use App\Http\Controllers\Controller;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentTestController extends Controller
{
    /** Return page for Stripe success_url / Redsys URL_OK. */
    public function success(Request $request)
    {
        $school = currentSchool();

        // Metadatos de contexto que puedas mostrar al usuario (no hay que fiarse de esto para dar el pago por bueno).
        $context = [];
        if ($request->filled('session_id')) {
            $context['stripe_session_id'] = $request->query('session_id');
        }
        if ($request->filled('Ds_MerchantParameters')) {
            $decoded = json_decode(base64_decode(strtr($request->input('Ds_MerchantParameters'), '-_', '+/')), true);
            if (is_array($decoded)) {
                $context['redsys'] = $decoded;
            }
        }

        return view('webclubs.payment-result', [
            'status'  => 'success',
            'title'   => 'Pago realizado correctamente',
            'message' => 'Tu pago de prueba de 1€ se ha procesado con éxito.',
            'school'  => $school,
            'context' => $context,
        ]);
    }

    /** Return page for Stripe cancel_url / Redsys URL_KO. */
    public function cancel(Request $request)
    {
        $school = currentSchool();

        return view('webclubs.payment-result', [
            'status'  => 'error',
            'title'   => 'Pago cancelado o rechazado',
            'message' => 'El pago no se ha completado. Puedes volver a intentarlo.',
            'school'  => $school,
            'context' => [],
        ]);
    }

    /**
     * Notificación backend (server-to-server) de Redsys.
     * Verifica la firma HMAC-SHA256 y responde 200 OK / 400.
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

        $svc = new PaymentGatewayService($school);

        if (! $svc->redsysVerifyNotification($params, $signature)) {
            Log::warning('Redsys notification with invalid signature', [
                'school_id' => $school->id,
                'params'    => $params,
            ]);
            return response('Invalid signature', 400);
        }

        $decoded = json_decode(base64_decode(strtr($params, '-_', '+/')), true) ?: [];

        Log::info('Redsys notification OK', [
            'school_id' => $school->id,
            'order'     => $decoded['Ds_Order'] ?? null,
            'response'  => $decoded['Ds_Response'] ?? null,
            'amount'    => $decoded['Ds_Amount'] ?? null,
        ]);

        return response('OK', 200);
    }
}
