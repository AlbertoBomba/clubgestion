<?php

namespace App\Livewire\SportsSchools;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SportsSchool;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showDeleteModal = false;
    public $schoolToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($schoolId)
    {
        $this->schoolToDelete = $schoolId;
        $this->showDeleteModal = true;
    }

    public function deleteSchool()
    {
        if ($this->schoolToDelete) {
            $school = SportsSchool::find($this->schoolToDelete);
            if ($school) {
                $school->delete();
                session()->flash('message', 'Escuela deportiva eliminada correctamente.');
            }
        }
        
        $this->showDeleteModal = false;
        $this->schoolToDelete = null;
    }

    public function toggleActive($schoolId)
    {
        $school = SportsSchool::find($schoolId);
        if ($school) {
            $school->is_active = !$school->is_active;
            $school->save();
            session()->flash('message', 'Estado actualizado correctamente.');
        }
    }

    public function render()
    {
        $schools = SportsSchool::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('city', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->withCount('users')
            ->latest()
            ->paginate(10);

        return view('livewire.sports-schools.index', [
            'schools' => $schools
        ]);
    }
}
