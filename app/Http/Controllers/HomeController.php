<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $school = currentSchool();
        
        // Si hay un tenant identificado (subdominio de club), usar Livewire
        if ($school) {
            return redirect()->route('webclubs.home');
        }
        
        // Si no hay tenant (dominio principal vaed.es), mostrar página del SaaS
        return view('home');
    }
}
