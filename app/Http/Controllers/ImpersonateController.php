<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ImpersonateController extends Controller
{
    public function impersonate(Request $request, User $user)
    {
        $originalUser = Auth::user();
        
        // Solo el master puede suplantar
        if (!$originalUser || !$originalUser->isMaster()) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        // No puede suplantarse a sí mismo
        if ($originalUser->id === $user->id) {
            return back()->with('error', 'No puedes suplantarte a ti mismo.');
        }

        // Guardar el ID del master original
        $request->session()->put('impersonator_id', $originalUser->id);
        
        // Guardar el ID del usuario a suplantar
        $request->session()->put('impersonated_user_id', $user->id);

        return redirect()->route('dashboard');
    }

    public function leaveImpersonation(Request $request)
    {
        if (!$request->session()->has('impersonator_id')) {
            return redirect()->route('dashboard');
        }

        // Eliminar la suplantación
        $request->session()->forget('impersonator_id');
        $request->session()->forget('impersonated_user_id');

        return redirect()->route('dashboard');
    }
}
