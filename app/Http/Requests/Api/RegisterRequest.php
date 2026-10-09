<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (is_string($this->input('email'))) {
            $this->merge(['email' => Str::lower(trim($this->input('email')))]);
        }

        if (is_string($this->input('name'))) {
            $this->merge(['name' => trim($this->input('name'))]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'bail', 'required', 'string', 'email', 'max:255',
                function (string $attribute, string $value, Closure $fail): void {
                    if (User::query()->whereRaw('LOWER(email) = ?', [$value])->exists()) {
                        $fail('Este correo ya está registrado.');
                    }
                },
            ],
            'password' => [
                'bail', 'required', 'string', 'min:12', 'max:72', 'confirmed',
                function (string $attribute, string $value, Closure $fail): void {
                    if (strlen($value) > 72) {
                        $fail('La contraseña no puede superar los 72 bytes.');
                    }
                },
            ],
            'password_confirmation' => ['required', 'string'],
            'device_name' => ['required', 'string', 'max:100'],
            'role' => ['prohibited'],
            'sports_school_id' => ['prohibited'],
            'is_active' => ['prohibited'],
            'email_verified_at' => ['prohibited'],
        ];
    }
}
