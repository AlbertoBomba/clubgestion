<?php

namespace App\Livewire\ExerciseTypes;

use App\Models\ExerciseType;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingDeletion = false;
    public $typeToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($typeId)
    {
        $this->typeToDelete = $typeId;
        $this->confirmingDeletion = true;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->typeToDelete = null;
    }

    public function delete()
    {
        if ($this->typeToDelete) {
            $type = ExerciseType::find($this->typeToDelete);
            
            if ($type) {
                // Check if type is being used by exercises
                if ($type->exercises()->count() > 0) {
                    session()->flash('error', 'No se puede eliminar este tipo porque está siendo usado por ejercicios.');
                } else {
                    $type->delete();
                    session()->flash('message', 'Tipo de ejercicio eliminado correctamente.');
                }
            }
        }

        $this->confirmingDeletion = false;
        $this->typeToDelete = null;
    }

    public function render()
    {
        $types = ExerciseType::withCount('exercises')
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.exercise-types.index', [
            'types' => $types,
        ]);
    }
}
