<?php

namespace App\Livewire\WebHomeSlides;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\WebHomeSlide;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public WebHomeSlide $slide;

    public $title;
    public $subtitle;
    public $button_text;
    public $button_url;
    public $media_type;
    public $media_file = null;
    public $background_color;
    public $order;
    public $active;

    public function mount(WebHomeSlide $slide)
    {
        abort_unless($slide->sports_school_id === auth()->user()->sports_school_id, 403);

        $this->slide          = $slide;
        $this->title          = $slide->title;
        $this->subtitle       = $slide->subtitle;
        $this->button_text    = $slide->button_text;
        $this->button_url     = $slide->button_url;
        $this->media_type     = $slide->media_type;
        $this->background_color = $slide->background_color;
        $this->order          = $slide->order;
        $this->active         = $slide->active;
    }

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

        $mediaPath = $this->slide->media_path;

        if ($this->media_file) {
            // Delete old file
            if ($mediaPath) {
                Storage::disk('public')->delete($mediaPath);
            }
            $folder    = $this->media_type === 'image' ? 'web-home-slides/images' : 'web-home-slides/videos';
            $mediaPath = $this->media_file->store($folder, 'public');
        }

        $this->slide->update([
            'title'            => $this->title ?: null,
            'subtitle'         => $this->subtitle ?: null,
            'button_text'      => $this->button_text ?: null,
            'button_url'       => $this->button_url ?: null,
            'media_type'       => $this->media_type,
            'media_path'       => $mediaPath,
            'background_color' => $this->background_color,
            'order'            => $this->order,
            'active'           => $this->active,
            'updated_user'     => auth()->id(),
        ]);

        session()->flash('message', 'Slide actualizado correctamente.');
        return redirect()->route('web-home-config.edit');
    }

    public function removeMedia()
    {
        if ($this->slide->media_path) {
            Storage::disk('public')->delete($this->slide->media_path);
            $this->slide->update(['media_path' => null]);
        }
    }

    public function render()
    {
        return view('livewire.web-home-slides.edit');
    }
}
