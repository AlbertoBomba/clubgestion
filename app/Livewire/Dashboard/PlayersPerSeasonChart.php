<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Season;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlayersPerSeasonChart extends Component
{
    public $chartData;
    public $ageChartData;

    public function mount()
    {
        $this->loadChartData();
    }

    public function loadChartData()
    {
        $sportsSchoolId = auth()->user()->sports_school_id;

        // Get seasons for the user's sports school with player count
        $seasons = Season::where('sports_school_id', $sportsSchoolId)
            ->withCount('players')
            ->orderBy('from_year', 'asc')
            ->get();

        $this->chartData = [
            'labels' => $seasons->pluck('season')->toArray(),
            'data' => $seasons->pluck('players_count')->toArray(),
        ];

        // Calculate age distribution
        $ageDistribution = [];
        
        foreach ($seasons as $season) {
            // Get players for this season with their birth dates
            $players = $season->players()->whereNotNull('dbirth')->get();
            
            $ages = [];
            foreach ($players as $player) {
                $age = Carbon::parse($player->dbirth)->age;
                if (!isset($ages[$age])) {
                    $ages[$age] = 0;
                }
                $ages[$age]++;
            }
            
            $ageDistribution[$season->season] = $ages;
        }

        // Get all unique ages across all seasons
        $allAges = [];
        foreach ($ageDistribution as $ages) {
            $allAges = array_merge($allAges, array_keys($ages));
        }
        $allAges = array_unique($allAges);
        sort($allAges);

        // Prepare data for stacked bar chart
        $datasets = [];
        foreach ($allAges as $age) {
            $data = [];
            foreach ($seasons as $season) {
                $data[] = $ageDistribution[$season->season][$age] ?? 0;
            }
            
            $datasets[] = [
                'label' => $age . ' años',
                'data' => $data,
                'age' => $age,
            ];
        }

        $this->ageChartData = [
            'labels' => $seasons->pluck('season')->toArray(),
            'datasets' => $datasets,
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.players-per-season-chart');
    }
}
