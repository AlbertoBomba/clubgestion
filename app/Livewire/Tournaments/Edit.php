<?php

namespace App\Livewire\Tournaments;

use App\Models\Season;
use App\Models\Tournament;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Tournament $tournament;

    // Form fields
    public string  $name                  = '';
    public string  $description           = '';
    public string  $location              = '';
    public ?int    $season_id             = null;
    public string  $start_date            = '';
    public string  $end_date              = '';
    public string  $registration_deadline = '';
    public string  $max_teams             = '';
    public string  $status                = 'draft';
    public string  $visibility            = 'private';
    public         $logo                  = null;
    public int    $points_per_win         = 3;
    public int    $points_per_draw        = 1;
    public int    $points_per_loss        = 0;

    protected function rules(): array
    {
        return [
            'name'                  => 'required|string|max:255',
            'description'           => 'nullable|string',
            'location'              => 'nullable|string|max:255',
            'season_id'             => 'nullable|exists:seasons,id',
            'start_date'            => 'nullable|date',
            'end_date'              => 'nullable|date|after_or_equal:start_date',
            'registration_deadline' => 'nullable|date',
            'max_teams'             => 'nullable|integer|min:2|max:512',
            'status'                => 'required|in:draft,registration_open,in_progress,completed,cancelled',
            'visibility'            => 'required|in:private,public',
            'logo'                  => 'nullable|image|max:2048',
            'points_per_win'        => 'integer|min:0|max:10',
            'points_per_draw'       => 'integer|min:0|max:10',
            'points_per_loss'       => 'integer|min:0|max:10',
        ];
    }

    public function mount(Tournament $tournament): void
    {
        abort_unless($tournament->sports_school_id === auth()->user()->sports_school_id, 403);

        $this->tournament             = $tournament;
        $this->name                   = $tournament->name;
        $this->description            = $tournament->description ?? '';
        $this->location               = $tournament->location ?? '';
        $this->season_id              = $tournament->season_id;
        $this->start_date             = $tournament->start_date?->format('Y-m-d') ?? '';
        $this->end_date               = $tournament->end_date?->format('Y-m-d') ?? '';
        $this->registration_deadline  = $tournament->registration_deadline?->format('Y-m-d') ?? '';
        $this->max_teams              = $tournament->max_teams ? (string) $tournament->max_teams : '';
        $this->status                 = $tournament->status;
        $this->visibility             = $tournament->visibility;
        $this->points_per_win         = $tournament->settings['points_per_win']  ?? 3;
        $this->points_per_draw        = $tournament->settings['points_per_draw'] ?? 1;
        $this->points_per_loss        = $tournament->settings['points_per_loss'] ?? 0;
    }

    public function save(): void
    {
        $this->validate();
        $user = auth()->user();

        $logoPath = $this->tournament->logo;
        if ($this->logo) {
            $logoPath = $this->logo->store('tournaments/logos', 'public');
        }

        $this->tournament->update([
            'season_id'             => $this->season_id ?: null,
            'name'                  => $this->name,
            'description'           => $this->description ?: null,
            'location'              => $this->location ?: null,
            'start_date'            => $this->start_date ?: null,
            'end_date'              => $this->end_date ?: null,
            'registration_deadline' => $this->registration_deadline ?: null,
            'max_teams'             => $this->max_teams ?: null,
            'status'                => $this->status,
            'visibility'            => $this->visibility,
            'logo'                  => $logoPath,
            'settings'              => [
                'points_per_win'  => $this->points_per_win,
                'points_per_draw' => $this->points_per_draw,
                'points_per_loss' => $this->points_per_loss,
            ],
            'updated_user'          => $user->id,
        ]);

        session()->flash('message', 'Torneo actualizado correctamente.');
        $this->redirect(route('tournaments.show', $this->tournament), navigate: true);
    }

    public function render()
    {
        $seasons = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderByDesc('start_date')
            ->get();

        return view('livewire.tournaments.edit', compact('seasons'));
    }
}
