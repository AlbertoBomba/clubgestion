<?php

namespace App\Livewire\WebHomeSlides;

use Livewire\Component;
use Livewire\Attributes\Renderless;
use App\Models\WebHomeSlide;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    public $confirmingDeletion = false;
    public $slideToDelete = null;

    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->slideToDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->slideToDelete = null;
    }

    public function delete()
    {
        $slide = WebHomeSlide::find($this->slideToDelete);

        if ($slide && $slide->sports_school_id === auth()->user()->sports_school_id) {
            if ($slide->media_path) {
                Storage::disk('public')->delete($slide->media_path);
            }
            $slide->delete();
            session()->flash('message', 'Slide eliminado correctamente.');
        }

        $this->confirmingDeletion = false;
        $this->slideToDelete = null;
    }

    public function toggleActive($id)
    {
        $slide = WebHomeSlide::find($id);
        if ($slide && $slide->sports_school_id === auth()->user()->sports_school_id) {
            $slide->update(['active' => !$slide->active]);
        }
    }

    #[Renderless]
    public function updateOrder(array $ids): void
    {
        $schoolId = auth()->user()->sports_school_id;
        foreach ($ids as $position => $id) {
            WebHomeSlide::where('id', (int) $id)
                ->where('sports_school_id', $schoolId)
                ->update(['order' => $position + 1]);
        }
    }

    public function render()
    {
        $slides = WebHomeSlide::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderBy('order')
            ->orderBy('created_at')
            ->get();

        return view('livewire.web-home-slides.index', compact('slides'));
    }
}
