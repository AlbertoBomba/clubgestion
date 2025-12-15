<?php

namespace App\Livewire\Exercises;

use App\Models\Exercise;
use App\Models\ExerciseMedia;
use App\Models\ExerciseType;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $recommended_players;
    public $recommended_time;
    public $difficulty;
    public $intensity;
    public $category_id;
    public $exercise_type_id;
    public $recommended_age_min;
    public $recommended_age_max;
    public $is_public = false;
    public $is_active = true;
    public $mark_as_favorite = true;

    public $images = [];
    public $videos = [];
    public $temporaryImages = [];
    public $temporaryVideos = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'recommended_players' => 'nullable|integer|min:1|max:100',
        'recommended_time' => 'nullable|integer|min:1|max:999',
        'difficulty' => 'nullable|in:Baja,Media,Alta',
        'intensity' => 'nullable|in:Baja,Media,Alta',
        'category_id' => 'nullable|exists:categories,id',
        'exercise_type_id' => 'nullable|exists:exercise_types,id',
        'recommended_age_min' => 'nullable|integer|min:1|max:99',
        'recommended_age_max' => 'nullable|integer|min:1|max:99',
        'is_public' => 'boolean',
        'is_active' => 'boolean',
        'images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240',
        'videos.*' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:102400',
    ];

    protected $messages = [
        'title.required' => 'El titulo es obligatorio.',
        'recommended_players.integer' => 'El numero de jugadores debe ser un numero entero.',
        'recommended_players.min' => 'El numero de jugadores debe ser al menos 1.',
        'recommended_age_min.integer' => 'La edad minima debe ser un numero entero.',
        'recommended_age_max.integer' => 'La edad maxima debe ser un numero entero.',
        'images.*.image' => 'El archivo debe ser una imagen.',
        'images.*.max' => 'Cada imagen no puede superar 10MB.',
        'videos.*.mimes' => 'El video debe ser de formato mp4, mov, avi o wmv.',
        'videos.*.max' => 'Cada video no puede superar 100MB.',
    ];

    public function mount()
    {
        $this->categories = Category::orderBy('category')->get();
    }

    public function updatedImages()
    {
        $this->validate([
            'images.*' => 'image|max:10240',
        ]);
    }

    public function updatedVideos()
    {
        $this->validate([
            'videos.*' => 'file|mimes:mp4,mov,avi,wmv|max:102400',
        ]);
    }

    public function removeImage($index)
    {
        array_splice($this->images, $index, 1);
    }

    public function removeVideo($index)
    {
        array_splice($this->videos, $index, 1);
    }

    public function save()
    {
        $this->validate();

        $user = auth()->user();

        $exercise = Exercise::create([
            'user_id' => $user->id,
            'sports_school_id' => $user->sports_school_id,
            'title' => $this->title,
            'description' => $this->description,
            'recommended_players' => $this->recommended_players,
            'recommended_time' => $this->recommended_time,
            'difficulty' => $this->difficulty,
            'intensity' => $this->intensity,
            'category_id' => $this->category_id,
            'exercise_type_id' => $this->exercise_type_id,
            'recommended_age_min' => $this->recommended_age_min,
            'recommended_age_max' => $this->recommended_age_max,
            'is_public' => $this->is_public,
            'is_active' => $this->is_active,
        ]);

        if ($this->images) {
            foreach ($this->images as $index => $image) {
                $path = $image->store('exercises/' . $exercise->id . '/images', 'public');
                ExerciseMedia::create([
                    'exercise_id' => $exercise->id,
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'file_type' => 'image',
                    'mime_type' => $image->getMimeType(),
                    'file_size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        if ($this->videos) {
            foreach ($this->videos as $index => $video) {
                $path = $video->store('exercises/' . $exercise->id . '/videos', 'public');
                ExerciseMedia::create([
                    'exercise_id' => $exercise->id,
                    'file_path' => $path,
                    'file_name' => $video->getClientOriginalName(),
                    'file_type' => 'video',
                    'mime_type' => $video->getMimeType(),
                    'file_size' => $video->getSize(),
                    'order' => $index,
                ]);
            }
        }

        // Mark as favorite if requested
        if ($this->mark_as_favorite) {
            $user->favoriteExercises()->attach($exercise->id);
        }

        session()->flash('message', 'Ejercicio creado correctamente.');
        return redirect()->route('exercises.index');
    }

    public function render()
    {
        $categories = Category::orderBy('category')->get();
        $exerciseTypes = ExerciseType::orderBy('name')->get();
        return view('livewire.exercises.create', [
            'categories' => $categories,
            'exerciseTypes' => $exerciseTypes,
        ]);
    }
}