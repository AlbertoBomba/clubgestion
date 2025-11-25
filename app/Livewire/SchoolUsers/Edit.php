<?php

namespace App\Livewire\SchoolUsers;

use Livewire\Component;
use App\Models\User;
use App\Models\SportsSchool;
use Illuminate\Support\Facades\Hash;

class Edit extends Component
{
    public User $user;
    
    public $name;
    public $email;
    public $password = '';
    public $password_confirmation = '';
    public $sports_school_id;
    public $role;
    public $is_active;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'sports_school_id' => 'required|exists:sports_schools,id',
            'role' => 'required|in:school_admin,coach,student',
            'is_active' => 'boolean',
        ];
    }

    public function mount(User $user)
    {
        if ($user->isMaster()) {
            abort(403, 'No se puede editar el usuario master.');
        }
        
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->sports_school_id = $user->sports_school_id;
        $this->role = $user->role;
        $this->is_active = $user->is_active;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'sports_school_id' => $this->sports_school_id,
            'role' => $this->role,
            'is_active' => $this->is_active,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);

        session()->flash('message', 'Usuario actualizado correctamente.');
        
        // Redirigir a la ruta correcta según el contexto
        $route = (auth()->user()->isMaster() || session()->has('impersonator_id')) 
            ? 'school-users.index' 
            : 'my-school-users.index';
            
        return redirect()->route($route);
    }

    public function render()
    {
        $schools = SportsSchool::where('is_active', true)->orderBy('name')->get();
        
        return view('livewire.school-users.edit', [
            'schools' => $schools
        ]);
    }
}
