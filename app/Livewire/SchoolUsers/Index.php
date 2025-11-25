<?php

namespace App\Livewire\SchoolUsers;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\SportsSchool;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $schoolFilter = '';
    public $confirmingDeletion = false;
    public $userIdToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
        'schoolFilter' => ['except' => '']
    ];

    public function mount()
    {
        // Si viene el parámetro filterSchool de la URL, usarlo
        if (request()->has('filterSchool')) {
            $this->schoolFilter = request('filterSchool');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingSchoolFilter()
    {
        $this->resetPage();
    }

    public function confirmDelete($userId)
    {
        $this->userIdToDelete = $userId;
        $this->confirmingDeletion = true;
    }

    public function deleteUser()
    {
        if ($this->userIdToDelete) {
            $user = User::find($this->userIdToDelete);
            if ($user && !$user->isMaster()) {
                $user->delete();
                session()->flash('message', 'Usuario eliminado correctamente.');
            }
        }
        
        $this->confirmingDeletion = false;
        $this->userIdToDelete = null;
    }

    public function toggleActive($userId)
    {
        $user = User::find($userId);
        if ($user && !$user->isMaster()) {
            $user->is_active = !$user->is_active;
            $user->save();
            session()->flash('message', 'Estado actualizado correctamente.');
        }
    }

    public function render()
    {
        $users = User::query()
            ->where('role', '!=', 'master')
            ->with('sportsSchool')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->when($this->schoolFilter, function ($query) {
                $query->where('sports_school_id', $this->schoolFilter);
            })
            ->latest()
            ->paginate(10);

        $schools = SportsSchool::orderBy('name')->get();

        return view('livewire.school-users.index', [
            'users' => $users,
            'schools' => $schools
        ]);
    }
}
