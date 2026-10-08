<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\AuthUserResource;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            return DB::transaction(function () use ($data): JsonResponse {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role' => 'web',
                    'sports_school_id' => null,
                    'is_active' => true,
                ]);
                $user->assignRole('web');

                return $this->tokenResponse($user, $data['device_name'], 201);
            });
        } catch (UniqueConstraintViolationException $exception) {
            if (! User::query()->whereRaw('LOWER(email) = ?', [$data['email']])->exists()) {
                throw $exception;
            }

            throw ValidationException::withMessages([
                'email' => ['Este correo ya está registrado.'],
            ]);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::query()->without('sportsSchool')
            ->whereRaw('LOWER(email) = ?', [$data['email']])->first();

        if (! $user) {
            // Keep the password hashing cost even when the email does not exist.
            Hash::make('unregistered-user');
        }

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return $this->json([
                'message' => 'El correo o la contraseña no son correctos.',
                'code' => 'invalid_credentials',
            ], 401);
        }

        if (! $user->is_active) {
            return $this->json([
                'message' => 'La cuenta está desactivada.',
                'code' => 'account_inactive',
            ], 403);
        }

        if ($user->hasEnabledTwoFactorAuthentication()) {
            return $this->json([
                'message' => 'Esta cuenta requiere doble factor. Utiliza el acceso web.',
                'code' => 'two_factor_required',
            ], 403);
        }

        return $this->tokenResponse($user, $data['device_name']);
    }

    public function me(Request $request): JsonResponse
    {
        return $this->json([
            'user' => (new AuthUserResource($request->user()))->resolve(),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->json(['message' => 'Sesión cerrada correctamente.']);
    }

    private function tokenResponse(User $user, string $deviceName, int $status = 200): JsonResponse
    {
        $expiresAt = now()->addDays(30);
        $token = $user->createToken($deviceName, ['mobile:profile'], $expiresAt);

        return $this->json([
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt->toISOString(),
            'user' => (new AuthUserResource($user))->resolve(),
        ], $status);
    }

    private function json(array $data, int $status = 200): JsonResponse
    {
        return response()->json($data, $status)->header('Cache-Control', 'no-store');
    }
}
