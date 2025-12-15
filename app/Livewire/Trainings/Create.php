<?php

namespace App\Livewire\Trainings;

use App\Models\Training;
use App\Models\TrainingMedia;
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
    public $category_id;
    public $recommended_age_min;
    public $recommended_age_max;
    public $is_public = false;
    public $is_active = true;

    public $images = [];
    public $videos = [];
    public $temporaryImages = [];
    public $temporaryVideos = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'recommended_players' => 'nullable|integer|min:1|max:100',
        'recommended_time' => 'nullable|integer|min:1|max:999',
        'category_id' => 'nullable|exists:categories,id',
        'recommended_age_min' => 'nullable|integer|min:1|max:99',
        'recommended_age_max' => 'nullable|integer|min:1|max:99',
        'is_public' => 'boolean',
        'is_active' => 'boolean',
        'images.*' => 'nullable|image|max:10240', // 10MB max per image
        'videos.*' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:102400', // 100MB max per video
    ];

    protected $messages = [
        'title.required' => 'El título es obligatorio.',
        'recommended_players.integer' => 'El número de jugadores debe ser un número entero.',
        'recommended_players.min' => 'El número de jugadores debe ser al menos 1.',
        'recommended_age_min.integer' => 'La edad mínima debe ser un número entero.',
        'recommended_age_max.integer' => 'La edad máxima debe ser un número entero.',
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

        $training = Training::create([
            'user_id' => $user->id,
            'sports_school_id' => $user->sports_school_id,
            'title' => $this->title,
            'description' => $this->description,
            'recommended_players' => $this->recommended_players,
            'recommended_time' => $this->recommended_time,
            'category_id' => $this->category_id,
            'recommended_age_min' => $this->recommended_age_min,
            'recommended_age_max' => $this->recommended_age_max,
            'is_public' => $this->is_public,
            'is_active' => $this->is_active,
        ]);

        // Save images
        if ($this->images) {
            foreach ($this->images as $index => $image) {
                $path = $image->store('trainings/' . $training->id . '/images', 'public');
                
                TrainingMedia::create([
                    'training_id' => $training->id,
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'file_type' => 'image',
                    'mime_type' => $image->getMimeType(),
                    'file_size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        // Save videos
        if ($this->videos) {
            foreach ($this->videos as $index => $video) {
                $path = $video->store('trainings/' . $training->id . '/videos', 'public');
                
                TrainingMedia::create([
                    'training_id' => $training->id,
                    'file_path' => $path,
                    'file_name' => $video->getClientOriginalName(),
                    'file_type' => 'video',
                    'mime_type' => $video->getMimeType(),
                    'file_size' => $video->getSize(),
                    'order' => $index,
                ]);
            }
        }

        session()->flash('message', 'Entrenamiento creado correctamente.');

        return redirect()->route('trainings.index');
    }

    public function render()
    {
        $categories = Category::orderBy('category')->get();

        return view('livewire.trainings.create', [
            'categories' => $categories,
        ]);
    }
}
