<?php

namespace App\Livewire\PaymentStatistics;

use Livewire\Component;
use App\Models\PaymentPlayer;
use App\Models\Season;
use App\Models\Team;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $seasonFilter = '';
    public $categoryFilter = '';
    
    public function mount()
    {
        // Recuperar filtros de sesión
        $this->seasonFilter = session('paymentStats.seasonFilter', '');
        $this->categoryFilter = session('paymentStats.categoryFilter', '');
    }
    
    public function updated($property)
    {
        // Guardar filtros en sesión cuando cambien
        if (in_array($property, ['seasonFilter', 'categoryFilter'])) {
            session(['paymentStats.' . $property => $this->$property]);
        }
    }
    
    public function render()
    {
        // Obtener la temporada activa por defecto
        $activeSeason = Season::where('inscription_start_at', '<=', now())
            ->where('inscription_end_at', '>=', now())
            ->first();

        // Si no hay filtro de temporada, usar la activa
        if (!$this->seasonFilter && $activeSeason) {
            $this->seasonFilter = $activeSeason->id;
        }
        
        $sportsSchoolId = auth()->user()->sports_school_id;
        
        // Estadísticas generales
        $totalPayments = PaymentPlayer::where('sports_school_id', $sportsSchoolId)
            ->when($this->seasonFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('season_id', $this->seasonFilter);
                });
            })
            ->when($this->categoryFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('category_id', $this->categoryFilter);
                });
            })
            ->count();
            
        $paidPayments = PaymentPlayer::where('sports_school_id', $sportsSchoolId)
            ->where('state', 1)
            ->when($this->seasonFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('season_id', $this->seasonFilter);
                });
            })
            ->when($this->categoryFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('category_id', $this->categoryFilter);
                });
            })
            ->count();
            
        $pendingPayments = PaymentPlayer::where('sports_school_id', $sportsSchoolId)
            ->where('state', 0)
            ->when($this->seasonFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('season_id', $this->seasonFilter);
                });
            })
            ->when($this->categoryFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('category_id', $this->categoryFilter);
                });
            })
            ->count();
            
        // Total recaudado
        $totalCollected = PaymentPlayer::where('sports_school_id', $sportsSchoolId)
            ->where('state', 1)
            ->when($this->seasonFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('season_id', $this->seasonFilter);
                });
            })
            ->when($this->categoryFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('category_id', $this->categoryFilter);
                });
            })
            ->sum('amount');
            
        // Total pendiente de recaudar
        $totalPending = PaymentPlayer::where('sports_school_id', $sportsSchoolId)
            ->where('state', 0)
            ->when($this->seasonFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('season_id', $this->seasonFilter);
                });
            })
            ->when($this->categoryFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('category_id', $this->categoryFilter);
                });
            })
            ->sum('amount');
        
        // Estadísticas por cuota
        $statsByQuota = PaymentPlayer::select(
                'cuota',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN state = 1 THEN 1 ELSE 0 END) as paid'),
                DB::raw('SUM(CASE WHEN state = 0 THEN 1 ELSE 0 END) as pending'),
                DB::raw('SUM(CASE WHEN state = 2 THEN 1 ELSE 0 END) as injury'),
                DB::raw('SUM(CASE WHEN state = 3 THEN 1 ELSE 0 END) as dropout'),
                DB::raw('SUM(CASE WHEN state = 1 THEN amount ELSE 0 END) as collected'),
                DB::raw('SUM(CASE WHEN state = 0 THEN amount ELSE 0 END) as pending_amount')
            )
            ->where('sports_school_id', $sportsSchoolId)
            ->when($this->seasonFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('season_id', $this->seasonFilter);
                });
            })
            ->when($this->categoryFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('category_id', $this->categoryFilter);
                });
            })
            ->groupBy('cuota')
            ->orderBy('cuota')
            ->get();
        
        // Estadísticas por equipo
        $statsByTeam = PaymentPlayer::select(
                'teams.id as team_id',
                'teams.team',
                'categories.category',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN payments_players.state = 1 THEN 1 ELSE 0 END) as paid'),
                DB::raw('SUM(CASE WHEN payments_players.state = 0 THEN 1 ELSE 0 END) as pending'),
                DB::raw('SUM(CASE WHEN payments_players.state = 1 THEN payments_players.amount ELSE 0 END) as collected'),
                DB::raw('SUM(CASE WHEN payments_players.state = 0 THEN payments_players.amount ELSE 0 END) as pending_amount')
            )
            ->join('players', 'payments_players.player_id', '=', 'players.id')
            ->join('teams_players', 'players.id', '=', 'teams_players.player_id')
            ->join('teams', 'teams_players.team_id', '=', 'teams.id')
            ->join('categories', 'teams.category_id', '=', 'categories.id')
            ->where('payments_players.sports_school_id', $sportsSchoolId)
            ->when($this->seasonFilter, function($query) {
                $query->where('teams.season_id', $this->seasonFilter);
            })
            ->when($this->categoryFilter, function($query) {
                $query->where('teams.category_id', $this->categoryFilter);
            })
            ->groupBy('teams.id', 'teams.team', 'categories.category')
            ->orderBy('categories.category')
            ->orderBy('teams.team')
            ->get();
        
        // Estadísticas por estado
        $statsByState = PaymentPlayer::select(
                'state',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->where('sports_school_id', $sportsSchoolId)
            ->when($this->seasonFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('season_id', $this->seasonFilter);
                });
            })
            ->when($this->categoryFilter, function($query) {
                $query->whereHas('player.teams', function($q) {
                    $q->where('category_id', $this->categoryFilter);
                });
            })
            ->groupBy('state')
            ->get()
            ->keyBy('state');
        
        // Obtener temporadas y categorías para los filtros
        $seasons = Season::orderBy('from_year', 'desc')->get();
        
        $categories = Category::when($this->seasonFilter, function($query) {
                $query->whereHas('teams', function($q) {
                    $q->where('season_id', $this->seasonFilter);
                });
            })
            ->orderBy('category')
            ->get();
        
        return view('livewire.payment-statistics.index', [
            'totalPayments' => $totalPayments,
            'paidPayments' => $paidPayments,
            'pendingPayments' => $pendingPayments,
            'totalCollected' => $totalCollected,
            'totalPending' => $totalPending,
            'statsByQuota' => $statsByQuota,
            'statsByTeam' => $statsByTeam,
            'statsByState' => $statsByState,
            'seasons' => $seasons,
            'categories' => $categories,
            'activeSeason' => $activeSeason,
        ]);
    }
}
