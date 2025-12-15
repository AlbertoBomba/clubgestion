<?php

namespace App\Livewire\Trainings;

use App\Models\Training;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $confirmingDeletion = false;
    public $trainingToDelete = null;

    protected $queryString = ['search', 'categoryFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function confirmDelete($trainingId)
    {
        $this->trainingToDelete = $trainingId;
        $this->confirmingDeletion = true;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->trainingToDelete = null;
    }

    public function delete()
    {
        if ($this->trainingToDelete) {
            $training = Training::find($this->trainingToDelete);
            
            if ($training) {
                // Check authorization
                $user = auth()->user();
                if ($user->hasRole('master') || 
                    ($user->hasRole('school_admin') && $training->sports_school_id == $user->sports_school_id) ||
                    ($user->hasRole('coach') && $training->user_id == $user->id)) {
                    
                    // Delete media files
                    foreach ($training->media as $media) {
                        \Storage::disk('public')->delete($media->file_path);
                        $media->delete();
                    }
                    
                    $training->delete();
                    session()->flash('message', 'Entrenamiento eliminado correctamente.');
                } else {
                    session()->flash('error', 'No tienes permisos para eliminar este entrenamiento.');
                }
            }
        }

        $this->confirmingDeletion = false;
        $this->trainingToDelete = null;
    }

    public function render()
    {
        $user = auth()->user();
        $query = Training::with(['user', 'category', 'sportsSchool', 'media'])
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryFilter, function ($q) {
                $q->where('category_id', $this->categoryFilter);
            });

        // Filter based on role
        if ($user->hasRole('master')) {
            // Master can see all trainings
        } elseif ($user->hasRole('school_admin')) {
            // School admin can see trainings from their school
            $query->where('sports_school_id', $user->sports_school_id);
        } elseif ($user->hasRole('coach')) {
            // Coach can see their own trainings and public trainings from their school
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere(function ($q2) use ($user) {
                      $q2->where('sports_school_id', $user->sports_school_id)
                         ->where('is_public', true);
                  });
            });
        }

        $trainings = $query->latest()->paginate(12);
        $categories = Category::orderBy('category')->get();

        return view('livewire.trainings.index', [
            'trainings' => $trainings,
            'categories' => $categories,
        ]);
    }
}
