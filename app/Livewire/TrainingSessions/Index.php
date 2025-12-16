<?php

namespace App\Livewire\TrainingSessions;

use App\Models\TrainingSession;
use App\Models\Team;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedTeam = '';
    public $sortField = 'session_date';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedTeam' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedTeam()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function delete($id)
    {
        $session = TrainingSession::find($id);
        
        if ($session && $session->user_id === auth()->id()) {
            $session->delete();
            session()->flash('message', 'Sesión de entrenamiento eliminada correctamente.');
        }
    }

    public function duplicate($id)
    {
        $session = TrainingSession::with('sessionExercises')->find($id);
        
        if ($session && $session->user_id === auth()->id()) {
            $newSession = $session->replicate();
            $newSession->title = $session->title . ' (Copia)';
            $newSession->session_date = now()->addDay();
            $newSession->is_completed = false;
            $newSession->save();

            // Duplicate exercises
            foreach ($session->sessionExercises as $exercise) {
                $newExercise = $exercise->replicate();
                $newExercise->training_session_id = $newSession->id;
                $newExercise->save();
            }

            session()->flash('message', 'Sesión de entrenamiento duplicada correctamente.');
            return redirect()->route('training-sessions.edit', $newSession->id);
        }
    }

    public function render()
    {
        $user = auth()->user();
        
        // Get teams - master sees all teams, coaches see only their teams
        if ($user->hasRole('master')) {
            $teams = Team::orderBy('team')->get();
        } else {
            $teams = Team::whereHas('coaches', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->orderBy('team')->get();
        }

        $query = TrainingSession::query()
            ->with(['team', 'sessionExercises.exercise.images']);
        
        // Filter by teams based on user role
        if (!$user->hasRole('master')) {
            $query->whereHas('team.coaches', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedTeam) {
            $query->where('team_id', $this->selectedTeam);
        }

        $sessions = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.training-sessions.index', [
            'sessions' => $sessions,
            'teams' => $teams,
        ]);
    }
}
