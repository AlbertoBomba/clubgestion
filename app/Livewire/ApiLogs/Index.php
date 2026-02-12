<?php

namespace App\Livewire\ApiLogs;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ApiLog;
use App\Models\SportsSchool;

class Index extends Component
{
    use WithPagination;

    public $sports_school_id = '';
    public $status_code = '';
    public $endpoint = '';
    public $date_from = '';
    public $date_to = '';
    public $perPage = 50;

    protected $queryString = [
        'sports_school_id' => ['except' => ''],
        'status_code' => ['except' => ''],
        'endpoint' => ['except' => ''],
        'date_from' => ['except' => ''],
        'date_to' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->sports_school_id = '';
        $this->status_code = '';
        $this->endpoint = '';
        $this->date_from = '';
        $this->date_to = '';
        $this->resetPage();
    }

    public function cleanupOldLogs($days = 90)
    {
        $deleted = ApiLog::cleanup($days);
        session()->flash('message', "Se eliminaron {$deleted} registros antiguos.");
    }

    public function render()
    {
        $query = ApiLog::query()->with('sportsSchool:id,name');

        // Aplicar filtros
        if ($this->sports_school_id) {
            $query->where('sports_school_id', $this->sports_school_id);
        }

        if ($this->status_code) {
            $query->where('status_code', $this->status_code);
        }

        if ($this->endpoint) {
            $query->where('endpoint', 'like', '%' . $this->endpoint . '%');
        }

        if ($this->date_from) {
            $query->whereDate('created_at', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $query->whereDate('created_at', '<=', $this->date_to);
        }

        $logs = $query->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        // Obtener estadísticas
        $stats = [
            'total_today' => ApiLog::whereDate('created_at', today())->count(),
            'errors_today' => ApiLog::whereDate('created_at', today())
                ->where('status_code', '>=', 400)->count(),
            'total_week' => ApiLog::where('created_at', '>=', now()->subDays(7))->count(),
            'avg_response_time' => ApiLog::where('created_at', '>=', now()->subDays(7))
                ->where('response_time', '>', 0)
                ->avg('response_time'),
        ];

        // Obtener escuelas para filtro
        $schools = SportsSchool::orderBy('name')->get(['id', 'name']);

        // Endpoints únicos
        $endpoints = ApiLog::select('endpoint')
            ->distinct()
            ->orderBy('endpoint')
            ->pluck('endpoint');

        // Códigos de estado comunes
        $statusCodes = [
            200 => 'Éxito (200)',
            400 => 'Bad Request (400)',
            403 => 'Forbidden (403)',
            404 => 'Not Found (404)',
            429 => 'Too Many Requests (429)',
            500 => 'Server Error (500)',
        ];

        return view('livewire.api-logs.index', [
            'logs' => $logs,
            'stats' => $stats,
            'schools' => $schools,
            'endpoints' => $endpoints,
            'statusCodes' => $statusCodes,
        ]);
    }
}
