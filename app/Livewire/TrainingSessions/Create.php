<?php

namespace App\Livewire\TrainingSessions;

use App\Models\TrainingSession;
use App\Models\TrainingSessionExercise;
use App\Models\Team;
use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $team_id;
    public $title;
    public $description;
    public $session_date;
    public $start_time;
    public $duration_minutes;
    public $day_of_week;
    public $notes;

    // Exercise management
    public $exercises = [];
    public $showExerciseSearch = false;
    public $exerciseSearch = '';
    public $selectedExerciseType = '';
    public $selectedCategory = '';
    public $selectedDifficulty = '';
    public $favoritesOnly = false;
    
    // Custom exercise form
    public $showCustomForm = false;
    public $customTitle = '';
    public $customDescription = '';
    public $customDuration = '';
    public $customPlayers = '';
    public $customNotes = '';
    public $customImage;
    public $customIntensity = '';
    public $customDifficulty = '';
    
    // Preview exercise
    public $previewExercise = null;

    protected $rules = [
        'team_id' => 'required|exists:teams,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'session_date' => 'required|date',
        'start_time' => 'nullable',
        'duration_minutes' => 'nullable|integer|min:1|max:999',
        'day_of_week' => 'nullable|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
        'notes' => 'nullable|string',
    ];

    protected $messages = [
        'team_id.required' => 'Debe seleccionar un equipo.',
        'title.required' => 'El título es obligatorio.',
        'session_date.required' => 'La fecha de la sesión es obligatoria.',
    ];

    public function mount()
    {
        $this->session_date = now()->format('Y-m-d');
        $this->start_time = '17:00';
    }

    public function toggleExerciseSearch()
    {
        $this->showExerciseSearch = !$this->showExerciseSearch;
        $this->showCustomForm = false;
    }

    public function toggleCustomForm()
    {
        $this->showCustomForm = !$this->showCustomForm;
        $this->showExerciseSearch = false;
        $this->resetCustomForm();
    }

    public function resetCustomForm()
    {
        $this->customTitle = '';
        $this->customDescription = '';
        $this->customDuration = '';
        $this->customPlayers = '';
        $this->customNotes = '';
        $this->customImage = null;
        $this->customIntensity = '';
        $this->customDifficulty = '';
    }

    public function addExercise($exerciseId)
    {
        $exercise = Exercise::with(['exerciseType', 'category', 'images'])->find($exerciseId);
        
        if ($exercise) {
            $this->exercises[] = [
                'id' => uniqid(),
                'exercise_id' => $exercise->id,
                'title' => $exercise->title,
                'description' => $exercise->description,
                'duration_minutes' => $exercise->recommended_time,
                'recommended_players' => $exercise->recommended_players,
                'difficulty' => $exercise->difficulty,
                'intensity' => $exercise->intensity,
                'exercise_type' => $exercise->exerciseType?->name,
                'category' => $exercise->category?->category,
                'image_url' => $exercise->images->isNotEmpty() ? $exercise->images->first()->file_path : null,
                'is_custom' => false,
                'notes' => '',
            ];

            $this->dispatch('exercise-added');
            $this->previewExercise = null;
        }
    }

    public function showPreview($exerciseId)
    {
        $this->previewExercise = Exercise::with(['exerciseType', 'category', 'images'])->find($exerciseId);
    }

    public function closePreview()
    {
        $this->previewExercise = null;
    }

    public function addCustomExercise()
    {
        $this->validate([
            'customTitle' => 'required|string|max:255',
            'customImage' => 'nullable|image|max:2048',
        ], [
            'customTitle.required' => 'El título del ejercicio es obligatorio.',
            'customImage.image' => 'El archivo debe ser una imagen.',
            'customImage.max' => 'La imagen no puede superar los 2MB.',
        ]);

        $imagePath = null;
        if ($this->customImage) {
            $imagePath = $this->customImage->store('training-exercises', 'public');
        }

        $this->exercises[] = [
            'id' => uniqid(),
            'exercise_id' => null,
            'title' => $this->customTitle,
            'description' => $this->customDescription,
            'duration_minutes' => $this->customDuration,
            'recommended_players' => $this->customPlayers,
            'is_custom' => true,
            'notes' => $this->customNotes,
            'custom_image' => $imagePath,
            'intensity' => $this->customIntensity,
            'difficulty' => $this->customDifficulty,
        ];

        $this->resetCustomForm();
        $this->showCustomForm = false;
        $this->dispatch('exercise-added');
    }

    public function removeExercise($index)
    {
        unset($this->exercises[$index]);
        $this->exercises = array_values($this->exercises);
    }

    public function moveUp($index)
    {
        if ($index > 0) {
            $temp = $this->exercises[$index];
            $this->exercises[$index] = $this->exercises[$index - 1];
            $this->exercises[$index - 1] = $temp;
        }
    }

    public function moveDown($index)
    {
        if ($index < count($this->exercises) - 1) {
            $temp = $this->exercises[$index];
            $this->exercises[$index] = $this->exercises[$index + 1];
            $this->exercises[$index + 1] = $temp;
        }
    }

    public function updateExerciseOrder($orderedIds)
    {
        $orderedExercises = [];
        foreach ($orderedIds as $id) {
            $exercise = collect($this->exercises)->firstWhere('id', $id);
            if ($exercise) {
                $orderedExercises[] = $exercise;
            }
        }
        $this->exercises = $orderedExercises;
    }

    public function updateExerciseNotes($index, $notes)
    {
        if (isset($this->exercises[$index])) {
            $this->exercises[$index]['notes'] = $notes;
        }
    }

    public function updateExerciseDuration($index, $duration)
    {
        if (isset($this->exercises[$index])) {
            $this->exercises[$index]['duration_minutes'] = $duration;
        }
    }

    public function save()
    {
        $this->validate();

        $session = TrainingSession::create([
            'team_id' => $this->team_id,
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'session_date' => $this->session_date,
            'start_time' => $this->start_time,
            'duration_minutes' => $this->duration_minutes,
            'day_of_week' => $this->day_of_week,
            'notes' => $this->notes,
        ]);

        // Save exercises
        foreach ($this->exercises as $index => $exercise) {
            TrainingSessionExercise::create([
                'training_session_id' => $session->id,
                'exercise_id' => $exercise['exercise_id'],
                'order' => $index,
                'custom_title' => $exercise['is_custom'] ? $exercise['title'] : null,
                'custom_description' => $exercise['is_custom'] ? $exercise['description'] : null,
                'custom_image' => $exercise['custom_image'] ?? null,
                'custom_intensity' => $exercise['intensity'] ?? null,
                'custom_difficulty' => $exercise['difficulty'] ?? null,
                'duration_minutes' => $exercise['duration_minutes'],
                'recommended_players' => $exercise['recommended_players'] ?? null,
                'notes' => $exercise['notes'] ?? null,
            ]);
        }

        session()->flash('message', 'Sesión de entrenamiento creada correctamente.');
        return redirect()->route('training-sessions.index');
    }

    public function getTotalDurationProperty()
    {
        return collect($this->exercises)->sum('duration_minutes');
    }

    public function render()
    {
        $user = auth()->user();
        
        // Get teams - master sees all teams, coaches see only their teams
        if ($user->hasRole('master')) {
            $teams = Team::orderBy('team')->get();
        } else {
            $teams = Team::whereHas('coaches', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->orderBy('team')->get();
        }

        // Search exercises
        $searchExercises = collect();
        $hasFilters = $this->selectedExerciseType || $this->selectedCategory || $this->selectedDifficulty || $this->favoritesOnly;
        $hasSearchText = strlen($this->exerciseSearch) >= 2;
        
        if ($this->showExerciseSearch && ($hasSearchText || $hasFilters)) {
            // Get IDs of exercises already added (excluding custom exercises)
            $addedExerciseIds = collect($this->exercises)
                ->whereNotNull('exercise_id')
                ->pluck('exercise_id')
                ->toArray();

            $query = Exercise::query()
                ->with(['exerciseType', 'category', 'images'])
                ->where('is_active', true)
                ->where('is_public', true)
                ->where(function($q) use ($user) {
                    // Ejercicios sin escuela (globales del sistema, disponibles para todas las escuelas)
                    $q->whereNull('sports_school_id');
                    
                    // O ejercicios de la misma escuela del usuario (si el usuario tiene escuela)
                    if ($user->sports_school_id) {
                        $q->orWhere('sports_school_id', $user->sports_school_id);
                    }
                });

            // Exclude already added exercises
            if (!empty($addedExerciseIds)) {
                $query->whereNotIn('id', $addedExerciseIds);
            }

            if ($this->exerciseSearch) {
                $query->where(function($q) {
                    $q->where('title', 'like', '%' . $this->exerciseSearch . '%')
                      ->orWhere('description', 'like', '%' . $this->exerciseSearch . '%');
                });
            }

            if ($this->selectedExerciseType) {
                $query->where('exercise_type_id', $this->selectedExerciseType);
            }

            if ($this->selectedCategory) {
                $query->where('category_id', $this->selectedCategory);
            }

            if ($this->selectedDifficulty) {
                $query->where('difficulty', $this->selectedDifficulty);
            }

            if ($this->favoritesOnly) {
                $query->whereHas('favoritedBy', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }

            $searchExercises = $query->limit(20)->get();
        }

        return view('livewire.training-sessions.create', [
            'teams' => $teams,
            'searchExercises' => $searchExercises,
            'exerciseTypes' => ExerciseType::orderBy('name')->get(),
            'categories' => Category::orderBy('category')->get(),
        ]);
    }
}
