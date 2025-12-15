<?php

namespace App\Livewire\Trainings;

use App\Models\Training;
use App\Models\TrainingMedia;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public Training $training;

    public $title;
    public $description;
    public $recommended_players;
    public $recommended_time;
    public $category_id;
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
        'category_id' => 'nullable|exists:categories,id',
        'recommended_age_min' => 'nullable|integer|min:1|max:99',
        'recommended_age_max' => 'nullable|integer|min:1|max:99',
        'is_public' => 'boolean',
        'is_active' => 'boolean',
        'newImages.*' => 'nullable|image|max:10240',
        'newVideos.*' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:102400',
    ];

    protected $messages = [
        'title.required' => 'El título es obligatorio.',
        'recommended_players.integer' => 'El número de jugadores debe ser un número entero.',
        'newImages.*.image' => 'El archivo debe ser una imagen.',
        'newImages.*.max' => 'Cada imagen no puede superar 10MB.',
        'newVideos.*.mimes' => 'El video debe ser de formato mp4, mov, avi o wmv.',
        'newVideos.*.max' => 'Cada video no puede superar 100MB.',
    ];

    public function mount(Training $training)
    {
        // Check authorization
        $user = auth()->user();
        if (!$user->hasRole('master') && 
            !($user->hasRole('school_admin') && $training->sports_school_id == $user->sports_school_id) &&
            !($user->hasRole('coach') && $training->user_id == $user->id)) {
            abort(403, 'No autorizado.');
        }

        $this->training = $training;
        $this->title = $training->title;
        $this->description = $training->description;
        $this->recommended_players = $training->recommended_players;
        $this->recommended_time = $training->recommended_time;
        $this->category_id = $training->category_id;
        $this->recommended_age_min = $training->recommended_age_min;
        $this->recommended_age_max = $training->recommended_age_max;
        $this->is_public = $training->is_public;
        $this->is_active = $training->is_active;
        $this->existingMedia = $training->media->toArray();

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
        $media = TrainingMedia::find($mediaId);
        
        if ($media && $media->training_id == $this->training->id) {
            // Delete file from storage
            Storage::disk('public')->delete($media->file_path);
            
            // Delete record
            $media->delete();
            
            // Update existing media list
            $this->existingMedia = $this->training->fresh()->media->toArray();
            
            session()->flash('message', 'Archivo eliminado correctamente.');
        }
    }

    public function save()
    {
        $this->validate();

        $this->training->update([
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

        // Get the current max order for existing media
        $maxOrder = $this->training->media()->max('order') ?? -1;

        // Save new images
        if ($this->newImages) {
            foreach ($this->newImages as $index => $image) {
                $path = $image->store('trainings/' . $this->training->id . '/images', 'public');
                
                TrainingMedia::create([
                    'training_id' => $this->training->id,
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
                $path = $video->store('trainings/' . $this->training->id . '/videos', 'public');
                
                TrainingMedia::create([
                    'training_id' => $this->training->id,
                    'file_path' => $path,
                    'file_name' => $video->getClientOriginalName(),
                    'file_type' => 'video',
                    'mime_type' => $video->getMimeType(),
                    'file_size' => $video->getSize(),
                    'order' => $maxOrder + $imageCount + $index + 1,
                ]);
            }
        }

        session()->flash('message', 'Entrenamiento actualizado correctamente.');

        return redirect()->route('trainings.index');
    }

    public function render()
    {
        $categories = Category::orderBy('category')->get();

        return view('livewire.trainings.edit', [
            'categories' => $categories,
        ]);
    }
}
