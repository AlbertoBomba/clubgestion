<?php

namespace App\Livewire\Sections;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Section;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingDeletion = false;
    public $sectionToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($sectionId)
    {
        $this->sectionToDelete = $sectionId;
        $this->confirmingDeletion = true;
    }

    public function deleteSection()
    {
        $section = Section::find($this->sectionToDelete);
        
        if ($section) {
            $section->delete();
            session()->flash('message', 'Sección eliminada correctamente.');
        }
        
        $this->confirmingDeletion = false;
        $this->sectionToDelete = null;
    }

    public function render()
    {
        $sections = Section::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.sections.index', [
            'sections' => $sections
        ]);
    }
}
