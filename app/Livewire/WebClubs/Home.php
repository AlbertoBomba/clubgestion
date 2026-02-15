<?php

namespace App\Livewire\WebClubs;

use App\Models\SeasonMatch;
use App\Models\Season;
use App\Models\Team;
use App\Models\Player;
use App\Models\Sponsor;
use Livewire\Component;
use Carbon\Carbon;

class Home extends Component
{
    public $school;
    public $players;
    public $teams;
    public $coaches;
    public $activeSeason;
    public $upcomingMatches;
    public $recentResults;
    public $primaryColor;
    public $secondaryColor;
    public $sponsors;
    
    // Filtros
    public $searchTeam = '';
    public $onlyHomeMatches = false;

    public function mount()
    {
        $this->school = currentSchool();
        
        if (!$this->school) {
            abort(404, 'Escuela no encontrada');
        }

        // Cargar colores de la escuela
        $this->primaryColor = $this->school->primary_color ?? '#1E40AF';
        $this->secondaryColor = $this->school->secondary_color ?? '#10B981';

        // Obtener la temporada activa
        $this->activeSeason = Season::where('sports_school_id', $this->school->id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();

        // Obtener estadísticas
        if ($this->activeSeason) {
            // Contar jugadores inscritos en la temporada activa
            $this->players = Player::where('sports_school_id', $this->school->id)
                ->whereHas('seasons', function($query) {
                    $query->where('seasons.id', $this->activeSeason->id)
                          ->whereNull('seasons_players.deleted_at');
                })
                ->count();
            
            // Contar equipos de la temporada activa
            $this->teams = Team::where('season_id', $this->activeSeason->id)
                ->count();
        } else {
            $this->players = 0;
            $this->teams = 0;
        }


        
        // Contar entrenadores activos
        $this->coaches = $this->school->users()
            ->where('role', 'coach')
            ->where('is_active', true)
            ->count();
        
        // Cargar patrocinadores publicados de la temporada actual
        if ($this->activeSeason) {
            $this->sponsors = Sponsor::where('sports_school_id', $this->school->id)
                ->where('season_id', $this->activeSeason->id)
                ->where('published', true)
                ->orderBy('order', 'asc')
                ->get();
        } else {
            $this->sponsors = collect();
        }
        
        // Cargar partidos y resultados
        $this->loadMatches();
    }

    public function loadMatches()
    {
        // Obtener próximos partidos (publicados y fecha >= hoy)
        $query = SeasonMatch::where('sports_school_id', $this->school->id)
            ->where('published', true)
            ->where('date', '>=', Carbon::today())
            ->with(['team.category', 'season']);
        
        // Aplicar filtro de búsqueda por equipo
        if ($this->searchTeam) {
            $query->where(function($q) {
                $q->where('opponent', 'like', '%' . $this->searchTeam . '%')
                  ->orWhereHas('team', function($teamQuery) {
                      $teamQuery->where('team', 'like', '%' . $this->searchTeam . '%');
                  });
            });
        }
        
        // Aplicar filtro de solo partidos en casa
        if ($this->onlyHomeMatches) {
            $query->where('sites', 'home');
        }
        
        $this->upcomingMatches = $query->orderBy('date', 'asc')
            ->orderBy('hour_match', 'asc')
            ->take(10)
            ->get();
        
        // Obtener últimos resultados (partidos finalizados con resultado)
        // Incluye partidos con resultado 0-0, 1-0, etc. (cualquier resultado >= 0)
        $this->recentResults = SeasonMatch::where('sports_school_id', $this->school->id)
            ->where('published', true)
            ->where('date', '<', Carbon::today())
            ->where('date', '>=', Carbon::today()->subDays(80))
            ->with(['team.category', 'season'])
            ->orderBy('date', 'desc')
            ->take(6)
            ->get();
        
       
            
    }
    
    public function updatedSearchTeam()
    {
        $this->loadMatches();
    }
    
    public function updatedOnlyHomeMatches()
    {
        $this->loadMatches();
    }

    public function getResultType($goalsTeam, $goalsOponent)
    {
        if ($goalsTeam > $goalsOponent) {
            return [
                'type' => 'Victoria',
                'borderColor' => 'border-gray-900',
                'teamNameClass' => 'text-gray-900',
                'opponentNameClass' => 'text-gray-400',
                'teamScoreClass' => 'text-gray-900',
                'opponentScoreClass' => 'text-gray-300',
            ];
        } elseif ($goalsTeam < $goalsOponent) {
            return [
                'type' => 'Derrota',
                'borderColor' => 'border-gray-300',
                'teamNameClass' => 'text-gray-400',
                'opponentNameClass' => 'text-gray-900',
                'teamScoreClass' => 'text-gray-300',
                'opponentScoreClass' => 'text-gray-900',
            ];
        } else {
            return [
                'type' => 'Empate',
                'borderColor' => 'border-gray-400',
                'teamNameClass' => 'text-gray-900',
                'opponentNameClass' => 'text-gray-900',
                'teamScoreClass' => 'text-gray-900',
                'opponentScoreClass' => 'text-gray-900',
            ];
        }
    }

    public function render()
    {
        // ejemplo meter etiquetas meta personalizadas para SEO
        // return view('livewire.webclubs.home')->layout('livewire.webclubs.layouts.app', [
        //      'title' => 'Inicio - ' . tenantName(),
        //      'description' => 'Bienvenido al club deportivo ' . tenantName(),
        //      'keywords' => 'fútbol, club, equipos, partidos',
        //      'ogImage' => asset('images/home-og.jpg'),
        // ]);

        return view('livewire.webclubs.home')
            ->layout('livewire.webclubs.layouts.app', [
                'title' => tenantName() . ' - Inicio'
            ]);
    }
}
