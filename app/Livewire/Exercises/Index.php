<?php

namespace App\Livewire\Exercises;

use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $exerciseTypeFilter = '';
    public $favoritesOnly = false;
    public $confirmingDeletion = false;
    public $exerciseToDelete = null;

    protected $queryString = ['search', 'categoryFilter', 'exerciseTypeFilter', 'favoritesOnly'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingExerciseTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingFavoritesOnly()
    {
        $this->resetPage();
    }

    public function confirmDelete($exerciseId)
    {
        $this->exerciseToDelete = $exerciseId;
        $this->confirmingDeletion = true;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->exerciseToDelete = null;
    }

    public function delete()
    {
        if ($this->exerciseToDelete) {
            $exercise = Exercise::find($this->exerciseToDelete);
            
            if ($exercise) {
                // Check authorization
                $user = auth()->user();
                if ($user->hasRole('master') || 
                    ($user->hasRole('school_admin') && $exercise->sports_school_id == $user->sports_school_id) ||
                    ($user->hasRole('coach') && $exercise->user_id == $user->id)) {
                    
                    // Delete media files
                    foreach ($exercise->media as $media) {
                        \Storage::disk('public')->delete($media->file_path);
                        $media->delete();
                    }
                    
                    $exercise->delete();
                    session()->flash('message', 'Ejercicio eliminado correctamente.');
                } else {
                    session()->flash('error', 'No tienes permisos para eliminar este ejercicio.');
                }
            }
        }

        $this->confirmingDeletion = false;
        $this->exerciseToDelete = null;
    }

    public function toggleFavorite($exerciseId)
    {
        $user = auth()->user();
        $exercise = Exercise::find($exerciseId);

        if (!$exercise) {
            session()->flash('error', 'Ejercicio no encontrado.');
            return;
        }

        // Check if already favorited
        if ($user->favoriteExercises()->where('exercise_id', $exerciseId)->exists()) {
            // Remove from favorites
            $user->favoriteExercises()->detach($exerciseId);
            session()->flash('message', 'Ejercicio eliminado de favoritos.');
        } else {
            // Add to favorites
            $user->favoriteExercises()->attach($exerciseId);
            session()->flash('message', 'Ejercicio agregado a favoritos.');
        }
    }

    public function render()
    {
        $user = auth()->user();
        $query = Exercise::with(['user', 'category', 'sportsSchool', 'exerciseType', 'media', 'favoritedBy'])
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryFilter, function ($q) {
                $q->where('category_id', $this->categoryFilter);
            })
            ->when($this->exerciseTypeFilter, function ($q) {
                $q->where('exercise_type_id', $this->exerciseTypeFilter);
            })
            ->when($this->favoritesOnly, function ($q) use ($user) {
                $q->whereHas('favoritedBy', function ($q2) use ($user) {
                    $q2->where('user_id', $user->id);
                });
            });

        // Filter based on role
        if ($user->hasRole('master')) {
            // Master can see all exercises
        } elseif ($user->hasRole('school_admin')) {
            // School admin can see exercises from their school
            $query->where('sports_school_id', $user->sports_school_id);
        } elseif ($user->hasRole('coach')) {
            // Coach can see their own exercises and public exercises from their school
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere(function ($q2) use ($user) {
                      $q2->where('sports_school_id', $user->sports_school_id)
                         ->where('is_public', true);
                  });
            });
        }

        $exercises = $query->latest()->paginate(12);
        $categories = Category::orderBy('category')->get();
        $exerciseTypes = ExerciseType::orderBy('name')->get();

        return view('livewire.exercises.index', [
            'exercises' => $exercises,
            'categories' => $categories,
            'exerciseTypes' => $exerciseTypes,
        ]);
    }
}
