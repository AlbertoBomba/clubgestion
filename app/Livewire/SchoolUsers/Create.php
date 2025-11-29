<?php

namespace App\Livewire\SchoolUsers;

use Livewire\Component;
use App\Models\User;
use App\Models\SportsSchool;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $sports_school_id = '';
    public $role = 'student';
    public $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email|max:255',
        'password' => 'required|string|min:8|confirmed',
        'sports_school_id' => 'required|exists:sports_schools,id',
        'role' => 'required|exists:roles,name',
        'is_active' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'sports_school_id' => $this->sports_school_id,
            'role' => $this->role,
            'is_active' => $this->is_active,
            'email_verified_at' => now(),
        ]);

        // Asignar rol usando Spatie
        $user->assignRole($this->role);

        session()->flash('message', 'Usuario creado correctamente.');
        
        // Redirigir a la ruta correcta según el contexto
        $route = (auth()->user()->isMaster() || session()->has('impersonator_id')) 
            ? 'school-users.index' 
            : 'my-school-users.index';
            
        return redirect()->route($route);
    }

    public function render()
    {
        $schools = SportsSchool::where('is_active', true)->orderBy('name')->get();
        $roles = Role::where('name', '!=', 'master')->get();
        
        return view('livewire.school-users.create', [
            'schools' => $schools,
            'roles' => $roles
        ]);
    }
}
