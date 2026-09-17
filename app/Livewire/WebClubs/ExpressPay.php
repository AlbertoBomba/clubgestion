<?php

namespace App\Livewire\WebClubs;

use App\Models\SportsSchool;
use App\Services\PaymentGatewayService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ExpressPay extends Component
{
    public ?SportsSchool $school = null;
    public string $error = '';

    /** When Redsys is used, holds the params for the auto-submit form. */
    public ?array $redsysForm = null;

    public function mount(): void
    {
        $this->school = currentSchool();

        if (! $this->school) {
            abort(404, 'Escuela no encontrada');
        }
    }
    /**
     * Inicia un pago de prueba de 1€.
     * $method: 'card' o 'bizum'.
     */
    public function pay(string $method = 'card')
    {
        $this->error      = '';
        $this->redsysForm = null;

        if (! in_array($method, ['card', 'bizum'], true)) {
            $method = 'card';
        }

        if (! $this->school || ! $this->school->hasActivePayment()) {
            $this->error = 'La escuela no tiene una pasarela de pago configurada o está deshabilitada.';
            return null;
        }

        $service = new PaymentGatewayService($this->school);
        $order   = $this->buildOrderNumber();

        try {
            if ($service->isStripe()) {
                return $this->startStripe($service, $order, $method);
            }

            if ($service->isRedsys()) {
                $this->redsysForm = $service->redsysFormParams([
                    'order'        => $order,
                    'amount'       => 0.20,
                    'description'  => 'Pago de prueba 0.20€ - ' . $this->school->name,
                    'url_ok'       => route('webclubs.express-pay.ok'),
                    'url_ko'       => route('webclubs.express-pay.ko'),
                    'merchant_url' => route('webclubs.express-pay.redsys-notify'),
                    'use_bizum'    => $method === 'bizum',
                ]);
                return null;
            }
        } catch (\Throwable $e) {
            Log::error('ExpressPay error', [
                'school' => $this->school->id,
                'error'  => $e->getMessage(),
            ]);
            $this->error = 'Error al iniciar el pago: ' . $e->getMessage();
            return null;
        }

        $this->error = 'Pasarela no soportada.';
        return null;
    }

    /**
     * Crea un Checkout Session en Stripe y redirige al usuario a Stripe.
     */
    protected function startStripe(PaymentGatewayService $service, string $order, string $method)
    {
        $stripe = $service->stripeClient(); // lanza excepción si stripe/stripe-php no está instalado

        $session = $stripe->checkout->sessions->create([
            'mode'                 => 'payment',
            'payment_method_types' => [$method], // 'card' | 'bizum'
            'line_items'           => [[
                'quantity'   => 1,
                'price_data' => [
                    'currency'     => 'eur',
                    'unit_amount'  => 100, // céntimos
                    'product_data' => [
                        'name'        => 'Pago de prueba - ' . $this->school->name,
                        'description' => 'Test 1€ (' . $method . ')',
                    ],
                ],
            ]],
            'metadata' => [
                'sports_school_id' => (string) $this->school->id,
                'order'            => $order,
                'purpose'          => 'express-pay-test',
            ],
            'success_url' => route('webclubs.express-pay.ok') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('webclubs.express-pay.ko'),
        ]);

        return redirect()->away($session->url);
    }

    /**
     * Genera un número de pedido válido para Redsys (4 dígitos + 8 alfanuméricos).
     */
    protected function buildOrderNumber(): string
    {
        return substr((string) date('YmdHis'), -4) . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
    }

    public function render()
    {
        return view('livewire.webclubs.express-pay')
            ->layout('livewire.webclubs.layouts.app', [
                'title' => tenantName() . ' - Pago exprés',
            ]);
    }
}
