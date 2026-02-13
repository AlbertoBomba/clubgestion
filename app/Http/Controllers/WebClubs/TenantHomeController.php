<?php

namespace App\Http\Controllers\WebClubs;

use App\Http\Controllers\Controller;
use Livewire\Livewire;

class TenantHomeController extends Controller
{
    /**
     * Mostrar la home personalizada del tenant
     */
    public function index()
    {
        // Verificar que exista una escuela
        $school = currentSchool();
        
        // Si hay un tenant identificado (subdominio de club), usar Livewire
        if ($school) {
            return redirect()->route('webclubs.home');
        }
        
        // Si no hay tenant (dominio principal vaed.es), mostrar página del SaaS
        return view('home');
    }

    /**
     * Página "Sobre Nosotros" personalizada
     */
    public function about()
    {
        $school = currentSchool();
        
        if (!$school) {
            return view('home');
        }
        
        return view('livewire.webclubs.about', compact('school'));
    }

    /**
     * Contacto personalizado
     */
    public function contact()
    {
        $school = currentSchool();
        
        if (!$school) {
            return view('home');
        }
        
        return view('livewire.webclubs.contact', compact('school'));
    }

    /**
     * Registro público de jugadores
     */
    public function playerRegistration()
    {
        $school = currentSchool();
        
        if (!$school) {
            return view('home');
        }
        
        return view('livewire.webclubs.player-registration', compact('school'));
    }
}
