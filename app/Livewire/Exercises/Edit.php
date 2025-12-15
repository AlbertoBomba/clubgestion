<?php

namespace App\Livewire\Exercises;

use App\Models\Exercise;
use App\Models\ExerciseMedia;
use App\Models\ExerciseType;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public Exercise $exercise;

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
    public $is_public;
    public $is_active;

    public $newImages = [];
    public $newVideos = [];
    public $existingMedia = [];

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
        'newImages.*' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240',
        'newVideos.*' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:102400',
    ];

    protected $messages = [
        'title.required' => 'El tÃ­tulo es obligatorio.',
        'recommended_players.integer' => 'El nÃºmero de jugadores debe ser un nÃºmero entero.',
        'newImages.*.image' => 'El archivo debe ser una imagen.',
        'newImages.*.max' => 'Cada imagen no puede superar 10MB.',
        'newVideos.*.mimes' => 'El video debe ser de formato mp4, mov, avi o wmv.',
        'newVideos.*.max' => 'Cada video no puede superar 100MB.',
    ];

    public function mount(Exercise $exercise)
    {
        // Check authorization
        $user = auth()->user();
        if (!$user->hasRole('master') && 
            !($user->hasRole('school_admin') && $exercise->sports_school_id == $user->sports_school_id) &&
            !($user->hasRole('coach') && $exercise->user_id == $user->id)) {
            abort(403, 'No autorizado.');
        }

        $this->exercise = $exercise;
        $this->title = $exercise->title;
        $this->description = $exercise->description;
        $this->recommended_players = $exercise->recommended_players;
        $this->recommended_time = $exercise->recommended_time;
        $this->difficulty = $exercise->difficulty;
        $this->intensity = $exercise->intensity;
        $this->category_id = $exercise->category_id;
        $this->exercise_type_id = $exercise->exercise_type_id;
        $this->recommended_age_min = $exercise->recommended_age_min;
        $this->recommended_age_max = $exercise->recommended_age_max;
        $this->is_public = $exercise->is_public;
        $this->is_active = $exercise->is_active;
        $this->existingMedia = $exercise->media->toArray();

        $this->categories = Category::orderBy('category')->get();
    }

    public function updatedNewImages()
    {
        $this->validate([
            'newImages.*' => 'image|max:10240',
        ]);
    }

    public function updatedNewVideos()
    {
        $this->validate([
            'newVideos.*' => 'file|mimes:mp4,mov,avi,wmv|max:102400',
        ]);
    }

    public function removeNewImage($index)
    {
        array_splice($this->newImages, $index, 1);
    }

    public function removeNewVideo($index)
    {
        array_splice($this->newVideos, $index, 1);
    }

    public function deleteExistingMedia($mediaId)
    {
        $media = ExerciseMedia::find($mediaId);
        
        if ($media && $media->exercise_id == $this->exercise->id) {
            // Delete file from storage
            Storage::disk('public')->delete($media->file_path);
            
            // Delete record
            $media->delete();
            
            // Update existing media list
            $this->existingMedia = $this->exercise->fresh()->media->toArray();
            
            session()->flash('message', 'Archivo eliminado correctamente.');
        }
    }

    public function save()
    {
        $this->validate();

        $this->exercise->update([
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

        // Get the current max order for existing media
        $maxOrder = $this->exercise->media()->max('order') ?? -1;

        // Save new images
        if ($this->newImages) {
            foreach ($this->newImages as $index => $image) {
                $path = $image->store('exercises/' . $this->exercise->id . '/images', 'public');
                
                ExerciseMedia::create([
                    'exercise_id' => $this->exercise->id,
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'file_type' => 'image',
                    'mime_type' => $image->getMimeType(),
                    'file_size' => $image->getSize(),
                    'order' => $maxOrder + $index + 1,
                ]);
            }
        }

        // Save new videos
        if ($this->newVideos) {
            $imageCount = count($this->newImages ?? []);
            foreach ($this->newVideos as $index => $video) {
                $path = $video->store('exercises/' . $this->exercise->id . '/videos', 'public');
                
                ExerciseMedia::create([
                    'exercise_id' => $this->exercise->id,
                    'file_path' => $path,
                    'file_name' => $video->getClientOriginalName(),
                    'file_type' => 'video',
                    'mime_type' => $video->getMimeType(),
                    'file_size' => $video->getSize(),
                    'order' => $maxOrder + $imageCount + $index + 1,
                ]);
            }
        }

        session()->flash('message', 'Ejercicio actualizado correctamente.');

        return redirect()->route('exercises.index');
    }

    public function render()
    {
        $categories = Category::orderBy('category')->get();
        $exerciseTypes = ExerciseType::orderBy('name')->get();

        return view('livewire.exercises.edit', [
            'categories' => $categories,
            'exerciseTypes' => $exerciseTypes,
        ]);
    }
}
