<?php

namespace App\Livewire\WebHomeSlides;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\WebHomeSlide;

class Create extends Component
{
    use WithFileUploads;

    public $title = '';
    public $subtitle = '';
    public $button_text = '';
    public $button_url = '';
    public $media_type = 'image';
    public $media_file = null;
    public $background_color = '#1E40AF';
    public $order = 0;
    public $active = true;

    protected function rules()
    {
        return [
            'title'            => 'nullable|string|max:255',
            'subtitle'         => 'nullable|string|max:255',
            'button_text'      => 'nullable|string|max:100',
            'button_url'       => 'nullable|string|max:500',
            'media_type'       => 'required|in:image,video',
            'media_file'       => $this->media_type === 'image'
                ? 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
                : 'nullable|file|mimes:mp4,mov,webm|max:51200',
            'background_color' => 'nullable|string|max:20',
            'order'            => 'integer|min:0',
            'active'           => 'boolean',
        ];
    }

    public function save()
    {
        $this->validate();

        $mediaPath = null;
        if ($this->media_file) {
            $folder = $this->media_type === 'image' ? 'web-home-slides/images' : 'web-home-slides/videos';
            $mediaPath = $this->media_file->store($folder, 'public');
        }

        WebHomeSlide::create([
            'sports_school_id' => auth()->user()->sports_school_id,
            'title'            => $this->title ?: null,
            'subtitle'         => $this->subtitle ?: null,
            'button_text'      => $this->button_text ?: null,
            'button_url'       => $this->button_url ?: null,
            'media_type'       => $this->media_type,
            'media_path'       => $mediaPath,
            'background_color' => $this->background_color,
            'order'            => $this->order,
            'active'           => $this->active,
            'created_user'     => auth()->id(),
        ]);

        session()->flash('message', 'Slide creado correctamente.');
        return redirect()->route('web-home-config.edit');
    }

    public function render()
    {
        return view('livewire.web-home-slides.create');
    }
}
