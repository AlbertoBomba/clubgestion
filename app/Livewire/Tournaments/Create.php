<?php

namespace App\Livewire\Tournaments;

use App\Models\Season;
use App\Models\Tournament;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

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

    // Settings
    public int    $points_per_win  = 3;
    public int    $points_per_draw = 1;
    public int    $points_per_loss = 0;

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

    public function save(): void
    {
        $this->validate();
        $user = auth()->user();

        $logoPath = null;
        if ($this->logo) {
            $logoPath = $this->logo->store('tournaments/logos', 'public');
        }

        Tournament::create([
            'sports_school_id'      => $user->sports_school_id,
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
            'created_user'          => $user->id,
        ]);

        session()->flash('message', 'Torneo creado correctamente.');
        $this->redirect(route('tournaments.index'), navigate: true);
    }

    public function render()
    {
        $user = auth()->user();

        $seasons = Season::where('sports_school_id', $user->sports_school_id)
            ->orderByDesc('start_date')
            ->get();

        $activeSeason = Season::where('sports_school_id', $user->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (! $this->season_id && $activeSeason) {
            $this->season_id = $activeSeason->id;
        }

        return view('livewire.tournaments.create', compact('seasons'));
    }
}
