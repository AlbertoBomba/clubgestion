<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ImpersonateController extends Controller
{
    public function impersonate(User $user)
    {
        $originalUser = auth()->user();
        
        // Solo el master puede suplantar
        if (!$originalUser || !$originalUser->isMaster()) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        // No puede suplantarse a sí mismo
        if ($originalUser->id === $user->id) {
            return back()->with('error', 'No puedes suplantarte a ti mismo.');
        }

        // Guardar el ID del usuario master original en la sesión
        session()->put('impersonator_id', $originalUser->id);
        
        // Forzar login del usuario suplantado manualmente
        session()->put('password_hash_sanctum', $user->getAuthPassword());
        session()->migrate(true);
        Auth::guard('web')->setUser($user);

        return redirect()->route('dashboard')->with('message', "Ahora estás operando como {$user->name}");
    }

    public function leaveImpersonation()
    {
        if (!session()->has('impersonator_id')) {
            return redirect()->route('dashboard');
        }

        // Recuperar el usuario master original
        $impersonatorId = session()->pull('impersonator_id');
        $impersonator = User::findOrFail($impersonatorId);

        // Forzar login del master manualmente
        session()->put('password_hash_sanctum', $impersonator->getAuthPassword());
        session()->migrate(true);
        Auth::guard('web')->setUser($impersonator);

        return redirect()->route('school-users.index')->with('message', 'Has dejado de suplantar la identidad del usuario.');
    }
}
