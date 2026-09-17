<?php

namespace App\Services;

use App\Models\SportsSchool;
use InvalidArgumentException;
use RuntimeException;

/**
 * Fábrica de configuraciones/clientes de pasarela por escuela (multi-tenant).
 *
 * Uso típico:
 *   $svc = new PaymentGatewayService($school);
 *   if ($svc->isStripe()) {
 *       $stripe = $svc->stripeClient();
 *       // ...crear PaymentIntent con tarjeta o Bizum
 *   } elseif ($svc->isRedsys()) {
 *       $form = $svc->redsysFormParams([
 *           'order'       => '000000001234',
 *           'amount'      => 25.50,            // euros
 *           'description' => 'Cuota temporada',
 *           'url_ok'      => route('payments.ok'),
 *           'url_ko'      => route('payments.ko'),
 *           'merchant_url'=> route('payments.redsys.notify'),
 *           'use_bizum'   => true,
 *       ]);
 *   }
 */
class PaymentGatewayService
{
    public const REDSYS_URL_TEST       = 'https://sis-t.redsys.es:25443/sis/realizarPago';
    public const REDSYS_URL_PRODUCTION = 'https://sis.redsys.es/sis/realizarPago';

    /** Redsys "moneda" según ISO-4217 numérico. 978 = EUR */
    public const REDSYS_CURRENCY_EUR = '978';

    /** Redsys "tipo de transacción". 0 = autorización estándar */
    public const REDSYS_TX_TYPE_AUTH = '0';

    /** Redsys "método de pago". C = Tarjeta, z = Bizum */
    public const REDSYS_PAYMETHOD_CARD  = 'C';
    public const REDSYS_PAYMETHOD_BIZUM = 'z';

    public function __construct(protected SportsSchool $school)
    {
    }

    public function school(): SportsSchool
    {
        return $this->school;
    }

    public function gateway(): string
    {
        return $this->school->payment_gateway ?: 'none';
    }

    public function isStripe(): bool
    {
        return $this->gateway() === 'stripe';
    }

    public function isRedsys(): bool
    {
        return $this->gateway() === 'redsys';
    }

    public function isActive(): bool
    {
        return $this->school->hasActivePayment();
    }

    /**
     * Devuelve un cliente Stripe autenticado con la Secret Key de la escuela.
     *
     * Requiere el paquete `stripe/stripe-php`.
     *
     * @return \Stripe\StripeClient
     */
    public function stripeClient(): object
    {
        if (! $this->isStripe()) {
            throw new InvalidArgumentException('La escuela no tiene Stripe como pasarela activa.');
        }

        if (! class_exists('\Stripe\StripeClient')) {
            throw new RuntimeException(
                'El paquete stripe/stripe-php no está instalado. Ejecuta: composer require stripe/stripe-php'
            );
        }

        $settings = $this->school->paymentSettings();
        $secret   = $settings['stripe_secret'] ?? null;

        if (empty($secret)) {
            throw new RuntimeException('Stripe Secret Key no configurada para esta escuela.');
        }

        $class = '\Stripe\StripeClient';
        return new $class($secret);
    }

    /**
     * Métodos de pago soportados en Stripe para esta escuela.
     * Bizum requiere estar habilitado desde el dashboard de Stripe.
     *
     * @return array<int,string>
     */
    public function stripeSupportedPaymentMethods(): array
    {
        return ['card', 'bizum'];
    }

    /**
     * Devuelve la Publishable Key de Stripe (usable en el frontend con Stripe.js).
     */
    public function stripePublicKey(): ?string
    {
        return $this->school->paymentSettings()['stripe_key'] ?? null;
    }

    /**
     * Devuelve el Webhook Secret configurado para verificar eventos entrantes.
     */
    public function stripeWebhookSecret(): ?string
    {
        return $this->school->paymentSettings()['stripe_webhook_secret'] ?? null;
    }

    // ── Redsys ────────────────────────────────────────────────────────────────

    /**
     * Genera los parámetros firmados para el formulario de redirección de Redsys.
     *
     * @param array{
     *   order: string,
     *   amount: float|int|string,
     *   description?: string,
     *   url_ok?: string,
     *   url_ko?: string,
     *   merchant_url?: string,
     *   use_bizum?: bool,
     *   consumer_language?: string
     * } $data
     *
     * @return array{
     *   endpoint: string,
     *   Ds_SignatureVersion: string,
     *   Ds_MerchantParameters: string,
     *   Ds_Signature: string
     * }
     */
    public function redsysFormParams(array $data): array
    {
        if (! $this->isRedsys()) {
            throw new InvalidArgumentException('La escuela no tiene Redsys como pasarela activa.');
        }

        $settings = $this->school->paymentSettings();

        $merchantCode = $settings['merchant_code']   ?? null;
        $terminal     = $settings['terminal']        ?? null;
        $secretKey    = $settings['secret_key']      ?? null;
        $environment  = $settings['environment']     ?? 'test';

        if (empty($merchantCode) || empty($terminal) || empty($secretKey)) {
            throw new RuntimeException('Redsys no está completamente configurado para esta escuela.');
        }

        $order = $this->normalizeRedsysOrder((string) $data['order']);

        $params = [
            'DS_MERCHANT_AMOUNT'           => $this->toRedsysAmount($data['amount']),
            'DS_MERCHANT_ORDER'            => $order,
            'DS_MERCHANT_MERCHANTCODE'     => $merchantCode,
            'DS_MERCHANT_CURRENCY'         => self::REDSYS_CURRENCY_EUR,
            'DS_MERCHANT_TRANSACTIONTYPE'  => self::REDSYS_TX_TYPE_AUTH,
            'DS_MERCHANT_TERMINAL'         => $terminal,
            'DS_MERCHANT_CONSUMERLANGUAGE' => $data['consumer_language'] ?? '001',
            'DS_MERCHANT_PAYMETHODS'       => ! empty($data['use_bizum'])
                ? self::REDSYS_PAYMETHOD_BIZUM
                : self::REDSYS_PAYMETHOD_CARD,
        ];

        if (! empty($data['description'])) {
            $params['DS_MERCHANT_PRODUCTDESCRIPTION'] = mb_substr($data['description'], 0, 125);
        }
        if (! empty($data['url_ok'])) {
            $params['DS_MERCHANT_URLOK'] = $data['url_ok'];
        }
        if (! empty($data['url_ko'])) {
            $params['DS_MERCHANT_URLKO'] = $data['url_ko'];
        }
        if (! empty($data['merchant_url'])) {
            $params['DS_MERCHANT_MERCHANTURL'] = $data['merchant_url'];
        }

        $merchantParametersB64 = base64_encode(json_encode($params, JSON_UNESCAPED_SLASHES));
        $signature             = $this->redsysSign($order, $secretKey, $merchantParametersB64);

        return [
            'endpoint'              => $environment === 'production'
                ? self::REDSYS_URL_PRODUCTION
                : self::REDSYS_URL_TEST,
            'Ds_SignatureVersion'   => 'HMAC_SHA256_V1',
            'Ds_MerchantParameters' => $merchantParametersB64,
            'Ds_Signature'          => $signature,
        ];
    }

    /**
     * Verifica la firma HMAC-SHA256 de una notificación entrante de Redsys.
     */
    public function redsysVerifyNotification(string $merchantParametersB64, string $receivedSignature): bool
    {
        if (! $this->isRedsys()) {
            return false;
        }

        $settings  = $this->school->paymentSettings();
        $secretKey = $settings['secret_key'] ?? null;
        if (empty($secretKey)) {
            return false;
        }

        $decoded = json_decode(base64_decode(strtr($merchantParametersB64, '-_', '+/')), true);
        if (! is_array($decoded)) {
            return false;
        }

        $order = $decoded['Ds_Order'] ?? $decoded['DS_ORDER'] ?? null;
        if (! $order) {
            return false;
        }

        $expected          = $this->redsysSign((string) $order, $secretKey, $merchantParametersB64);
        $receivedNormalized = strtr($receivedSignature, '-_', '+/');

        return hash_equals($expected, $receivedNormalized);
    }

    /**
     * Convierte un importe en euros a la representación exigida por Redsys (céntimos, entero).
     */
    protected function toRedsysAmount(float|int|string $amount): string
    {
        $cents = (int) round(((float) $amount) * 100);

        if ($cents <= 0) {
            throw new InvalidArgumentException('El importe debe ser mayor que 0.');
        }

        return (string) $cents;
    }

    /**
     * Redsys exige un order entre 4 y 12 caracteres alfanuméricos,
     * empezando con 4 dígitos numéricos.
     */
    protected function normalizeRedsysOrder(string $order): string
    {
        $order = preg_replace('/[^A-Za-z0-9]/', '', $order) ?? '';

        if (strlen($order) < 4) {
            $order = str_pad($order, 4, '0', STR_PAD_LEFT);
        }

        return substr($order, 0, 12);
    }

    /**
     * Firma HMAC-SHA256 estándar de Redsys.
     * 1) Deriva una clave por-operación con 3DES sobre la secret_key (base64) usando el order como IV=0.
     * 2) HMAC-SHA256 de los merchant_parameters con esa clave derivada.
     * 3) base64 del resultado.
     */
    protected function redsysSign(string $order, string $secretKeyBase64, string $merchantParametersB64): string
    {
        $key       = base64_decode(strtr($secretKeyBase64, '-_', '+/'));
        $derivedKey = $this->tripleDesEncrypt($order, $key);

        $mac = hash_hmac('sha256', $merchantParametersB64, $derivedKey, true);

        return base64_encode($mac);
    }

    /**
     * 3DES-CBC con IV cero y padding zero-byte, tal como espera la firma de Redsys.
     */
    protected function tripleDesEncrypt(string $data, string $key): string
    {
        // Padding a múltiplo de 8 bytes con \0
        $blockSize = 8;
        $pad       = $blockSize - (strlen($data) % $blockSize);
        if ($pad !== $blockSize) {
            $data .= str_repeat("\0", $pad);
        }

        $iv = str_repeat("\0", 8);

        $encrypted = openssl_encrypt(
            $data,
            'des-ede3-cbc',
            $key,
            OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
            $iv
        );

        if ($encrypted === false) {
            throw new RuntimeException('No se pudo derivar la clave 3DES para la firma de Redsys.');
        }

        return $encrypted;
    }
}
