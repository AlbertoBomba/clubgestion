<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDniNie implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dni = strtoupper(trim($value));

        // 1. Comprobar formato estándar (DNI: 8 números + letra | NIE: X/Y/Z + 7 números + letra)
        if (!preg_match('/^[XYZ\d]\d{7}[A-Z]$/', $dni)) {
            $fail('El formato del DNI/NIE no es válido.');
            return;
        }

        // 2. Extraer número y letra de control
        $letter = substr($dni, -1);
        $number = substr($dni, 0, -1);

        // 3. Convertir la letra inicial del NIE a su equivalente numérico
        if (str_starts_with($number, 'X')) {
            $number = str_replace('X', '0', $number);
        } elseif (str_starts_with($number, 'Y')) {
            $number = str_replace('Y', '1', $number);
        } elseif (str_starts_with($number, 'Z')) {
            $number = str_replace('Z', '2', $number);
        }

        // 4. Calcular la letra de control mediante el algoritmo del Módulo 23
        $validLetters = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $expectedLetter = $validLetters[(int)$number % 23];

        if ($letter !== $expectedLetter) {
            $fail('El DNI/NIE introducido no es válido.');
        }
    }
}
