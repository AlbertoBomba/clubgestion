<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidIban implements ValidationRule
{
   public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 1. Limpiar espacios y pasar a mayúsculas
        $iban = strtoupper(str_replace(' ', '', $value));

        // 2. Comprobar formato español (ES + 22 dígitos)
        if (!preg_match('/^ES\d{22}$/', $iban)) {
            $fail('El IBAN debe comenzar por ES y tener 24 caracteres en total.');
            return;
        }

        // 3. Comprobar algoritmo de control IBAN (Módulo 97)
        // Convertir ES a sus valores numéricos (E = 14, S = 28)
        $parsedIban = substr($iban, 4) . '1428' . substr($iban, 2, 2);

        if (function_exists('bcmod')) {
            $isValid = bcmod($parsedIban, '97') === '1';
        } else {
            // Alternativa si bcmath no está instalado
            $checksum = 0;
            for ($i = 0; $i < strlen($parsedIban); $i++) {
                $checksum = ($checksum * 10 + (int)$parsedIban[$i]) % 97;
            }
            $isValid = ($checksum === 1);
        }

        if (!$isValid) {
            $fail('El número de cuenta bancaria (IBAN) introducido no es válido.');
        }
    }
}
