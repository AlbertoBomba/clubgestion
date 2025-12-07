<?php

namespace App\Livewire\PaymentsTeams;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PaymentTeam;
use App\Models\Season;
use App\Models\Team;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $seasonFilter = '';
    public $showModal = false;
    public $showPreview = false;
    public $showDeleteModal = false;
    public $showDeleteConfirm = false;
    public $showEditModal = false;
    public $showEditPreview = false;
    public $selectedSeasonId = '';
    public $modalTeams = [];
    public $selectedTeamIds = [];
    public $selectedTeamsToDelete = [];
    public $deletePreviewData = [];
    public $editingTeamId = null;
    public $editingTeam = null;
    public $editingPayments = [];
    public $editPreviewData = [];
    public $editNumPlazos = 1;
    public $editPlazos = [];
    public $numPlazos = 1;
    public $plazos = [];
    public $previewData = [];
    public $plazoErrors = [];

    protected $queryString = ['search', 'seasonFilter'];

    public function mount()
    {
        // Set default season filter to active season
        if (empty($this->seasonFilter)) {
            $activeSeason = Season::where('sports_school_id', auth()->user()->sports_school_id)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($activeSeason) {
                $this->seasonFilter = $activeSeason->id;
            }
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSeasonFilter()
    {
        $this->resetPage();
    }

    public function openGenerateModal()
    {
        // Get active season
        $activeSeason = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();

        if ($activeSeason) {
            $this->selectedSeasonId = $activeSeason->id;
            $this->loadTeams();
            $this->numPlazos = 1;
            $this->initializePlazos();
            $this->showModal = true;
            $this->dispatch('modal-opened');
        } else {
            session()->flash('error', 'No hay temporada activa.');
        }
    }

    public function initializePlazos()
    {
        $oldPlazos = $this->plazos;
        $this->plazos = [];
        for ($i = 1; $i <= $this->numPlazos; $i++) {
            $this->plazos[$i] = [
                'date_start' => $oldPlazos[$i]['date_start'] ?? '',
                'date_end' => $oldPlazos[$i]['date_end'] ?? '',
            ];
        }
    }

    public function updatedNumPlazos()
    {
        $this->initializePlazos();
    }

    public function loadTeams()
    {
        if ($this->selectedSeasonId) {
            $this->modalTeams = Team::with(['category', 'section', 'season'])
                ->where('season_id', $this->selectedSeasonId)
                ->whereHas('season', function ($query) {
                    $query->where('sports_school_id', auth()->user()->sports_school_id);
                })
                ->doesntHave('payments')
                ->orderBy('team')
                ->get();
            
            // Seleccionar por defecto todos los equipos con precio válido
            $this->selectedTeamIds = $this->modalTeams
                ->filter(fn($team) => $team->price > 0)
                ->pluck('id')
                ->toArray();
        }
    }

    public function updatedSelectedSeasonId()
    {
        $this->loadTeams();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showPreview = false;
        $this->modalTeams = [];
        $this->selectedSeasonId = '';
        $this->numPlazos = 1;
        $this->plazos = [];
        $this->previewData = [];
        $this->plazoErrors = [];
    }

    public function generatePreview()
    {
        // Limpiar errores previos
        $this->plazoErrors = [];

        // Validar que haya equipos seleccionados
        if (empty($this->selectedTeamIds)) {
            session()->flash('error', 'Por favor, seleccione al menos un equipo.');
            return;
        }

        // Validar que todos los plazos tengan fechas configuradas
        $hasErrors = false;
        foreach ($this->plazos as $index => $plazo) {
            if (empty($plazo['date_start']) || empty($plazo['date_end'])) {
                $this->plazoErrors[$index] = 'Debe introducir la fecha del plazo ' . ($index + 1);
                $hasErrors = true;
            }
        }

        if ($hasErrors) {
            session()->flash('error', 'Por favor, configure todas las fechas de los plazos.');
            return;
        }

        // Generar previsualización solo para equipos seleccionados
        $this->previewData = [];
        
        foreach ($this->modalTeams as $team) {
            // Solo procesar equipos seleccionados
            if (!in_array($team->id, $this->selectedTeamIds)) {
                continue;
            }
            if (!$team->price || $team->price == 0) {
                continue; // Saltar equipos sin precio
            }

            $teamPayments = [];
            $pricePerInstallment = $team->price / $this->numPlazos;

            for ($i = 1; $i <= $this->numPlazos; $i++) {
                $teamPayments[] = [
                    'cuota' => $i,
                    'description' => "Matrícula {$team->team} - Cuota {$i}/{$this->numPlazos}",
                    'amount' => round($pricePerInstallment, 2),
                    'price' => $team->price,
                    'date_start' => $this->plazos[$i]['date_start'],
                    'date_end' => $this->plazos[$i]['date_end'],
                ];
            }

            $this->previewData[] = [
                'team' => $team,
                'payments' => $teamPayments,
            ];
        }

        $this->showPreview = true;
    }

    public function backToConfig()
    {
        $this->showPreview = false;
    }

    public function openDeleteModal()
    {
        if (empty($this->selectedTeamsToDelete)) {
            session()->flash('error', 'Por favor, seleccione al menos un equipo.');
            return;
        }

        $userSchoolId = auth()->user()->sports_school_id;
        $this->deletePreviewData = [];

        // Obtener los equipos seleccionados con sus pagos
        $teams = Team::with(['payments' => function($query) use ($userSchoolId) {
                $query->where('sports_school_id', $userSchoolId);
            }])
            ->whereIn('id', $this->selectedTeamsToDelete)
            ->get();

        foreach ($teams as $team) {
            if ($team->payments->count() > 0) {
                $this->deletePreviewData[] = [
                    'team' => $team,
                    'payments' => $team->payments,
                    'total' => $team->payments->sum('amount')
                ];
            }
        }

        $this->showDeleteModal = true;
        $this->showDeleteConfirm = false;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->showDeleteConfirm = false;
        $this->deletePreviewData = [];
    }

    public function showConfirmStep()
    {
        $this->showDeleteConfirm = true;
    }

    public function confirmDelete()
    {
        try {
            $userSchoolId = auth()->user()->sports_school_id;
            $deletedCount = 0;

            foreach ($this->selectedTeamsToDelete as $teamId) {
                $deleted = PaymentTeam::where('team_id', $teamId)
                    ->where('sports_school_id', $userSchoolId)
                    ->delete();
                
                $deletedCount += $deleted;
            }

            $teamsCount = count($this->selectedTeamsToDelete);
            session()->flash('message', "Se eliminaron correctamente {$deletedCount} pagos de {$teamsCount} " . ($teamsCount == 1 ? 'equipo' : 'equipos') . ".");
            
            $this->selectedTeamsToDelete = [];
            $this->closeDeleteModal();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar los pagos: ' . $e->getMessage());
        }
    }

    public function openEditModal($teamId)
    {
        $userSchoolId = auth()->user()->sports_school_id;
        
        $team = Team::with(['payments' => function($query) use ($userSchoolId) {
                $query->where('sports_school_id', $userSchoolId)->orderBy('cuota');
            }])
            ->find($teamId);

        if (!$team || $team->payments->count() === 0) {
            session()->flash('error', 'No hay pagos para editar.');
            return;
        }

        $this->editingTeamId = $teamId;
        $this->editingTeam = $team;
        $this->editNumPlazos = $team->payments->count();
        
        // Inicializar editPlazos con los datos de los pagos existentes
        $this->editPlazos = [];
        foreach ($team->payments as $index => $payment) {
            $plazoNumber = $index + 1;
            $this->editPlazos[$plazoNumber] = [
                'payment_id' => $payment->id,
                'date_start' => $payment->date_start->format('d/m/Y'),
                'date_end' => $payment->date_end->format('d/m/Y'),
            ];
        }

        $this->showEditModal = true;
        $this->dispatch('edit-modal-opened');
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->showEditPreview = false;
        $this->editingTeamId = null;
        $this->editingTeam = null;
        $this->editingPayments = [];
        $this->editPreviewData = [];
        $this->editNumPlazos = 1;
        $this->editPlazos = [];
    }

    public function updatedEditNumPlazos()
    {
        $oldPlazos = $this->editPlazos;
        $this->editPlazos = [];
        
        for ($i = 1; $i <= $this->editNumPlazos; $i++) {
            $this->editPlazos[$i] = [
                'payment_id' => $oldPlazos[$i]['payment_id'] ?? null,
                'date_start' => $oldPlazos[$i]['date_start'] ?? '',
                'date_end' => $oldPlazos[$i]['date_end'] ?? '',
            ];
        }
    }

    public function generateEditPreview()
    {
        // Validar que todas las fechas estén configuradas
        foreach ($this->editPlazos as $plazo) {
            if (empty($plazo['date_start']) || empty($plazo['date_end'])) {
                session()->flash('error', 'Por favor, configure todas las fechas de los plazos.');
                return;
            }
        }

        $team = $this->editingTeam;
        $pricePerInstallment = $team->price / $this->editNumPlazos;
        $this->editPreviewData = [];

        for ($i = 1; $i <= $this->editNumPlazos; $i++) {
            $this->editPreviewData[] = [
                'cuota' => $i,
                'description' => "Matrícula {$team->team} - Cuota {$i}/{$this->editNumPlazos}",
                'amount' => round($pricePerInstallment, 2),
                'price' => $team->price,
                'date_start' => $this->editPlazos[$i]['date_start'],
                'date_end' => $this->editPlazos[$i]['date_end'],
            ];
        }

        $this->showEditPreview = true;
    }

    public function backToEditConfig()
    {
        $this->showEditPreview = false;
    }

    public function updatePayments()
    {
        try {
            $userSchoolId = auth()->user()->sports_school_id;
            $userId = auth()->user()->id;
            
            // Validar que todas las fechas estén configuradas
            foreach ($this->editPlazos as $plazo) {
                if (empty($plazo['date_start']) || empty($plazo['date_end'])) {
                    session()->flash('error', 'Por favor, configure todas las fechas de los plazos.');
                    return;
                }
            }

            // Eliminar todos los pagos anteriores del equipo
            PaymentTeam::where('team_id', $this->editingTeamId)
                ->where('sports_school_id', $userSchoolId)
                ->delete();

            // Crear los nuevos pagos con el nuevo número de plazos
            $team = $this->editingTeam;
            $pricePerInstallment = $team->price / $this->editNumPlazos;
            $totalSaved = 0;

            for ($i = 1; $i <= $this->editNumPlazos; $i++) {
                // Convertir fechas de dd/mm/YYYY a Y-m-d
                $dateStart = $this->editPlazos[$i]['date_start'];
                $dateEnd = $this->editPlazos[$i]['date_end'];
                
                // Convertir formato
                $dateStartParts = explode('/', $dateStart);
                $dateEndParts = explode('/', $dateEnd);
                
                $formattedDateStart = $dateStartParts[2] . '-' . $dateStartParts[1] . '-' . $dateStartParts[0];
                $formattedDateEnd = $dateEndParts[2] . '-' . $dateEndParts[1] . '-' . $dateEndParts[0];

                PaymentTeam::create([
                    'team_id' => $team->id,
                    'season_id' => $team->season_id,
                    'sports_school_id' => $userSchoolId,
                    'description' => "Matrícula {$team->team} - Cuota {$i}/{$this->editNumPlazos}",
                    'price' => $team->price,
                    'cuota' => $i,
                    'amount' => round($pricePerInstallment, 2),
                    'date_start' => $formattedDateStart,
                    'date_end' => $formattedDateEnd,
                    'created_user' => $userId,
                    'updated_user' => $userId,
                ]);
                $totalSaved++;
            }

            session()->flash('message', "Se actualizaron correctamente {$totalSaved} pagos del equipo.");
            $this->closeEditModal();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar los pagos: ' . $e->getMessage());
        }
    }


    public function confirmAndSave()
    {
        try {
            $userSchoolId = auth()->user()->sports_school_id;
            $userId = auth()->user()->id;
            $totalSaved = 0;
            $teamsProcessed = 0;

            // Recorrer los datos de previsualización y guardar en la BD
            foreach ($this->previewData as $data) {
                $team = $data['team'];
                
                // Eliminar todos los pagos existentes de este equipo en esta temporada
                PaymentTeam::where('team_id', $team->id)
                    ->where('season_id', $this->selectedSeasonId)
                    ->delete();
                
                // Crear los nuevos pagos
                foreach ($data['payments'] as $payment) {
                    PaymentTeam::create([
                        'team_id' => $team->id,
                        'season_id' => $this->selectedSeasonId,
                        'sports_school_id' => $userSchoolId,
                        'description' => $payment['description'],
                        'price' => $payment['price'],
                        'cuota' => $payment['cuota'],
                        'amount' => $payment['amount'],
                        'date_start' => $payment['date_start'],
                        'date_end' => $payment['date_end'],
                        'created_user' => $userId,
                        'updated_user' => $userId,
                    ]);
                    
                    $totalSaved++;
                }
                
                $teamsProcessed++;
            }

            session()->flash('message', "Se generaron correctamente {$totalSaved} pagos para {$teamsProcessed} equipos.");
            
            $this->closeModal();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al generar los pagos: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $userSchoolId = auth()->user()->sports_school_id;
        
        // Get teams with payment info
        $teams = Team::with(['category', 'season', 'section', 'payments'])
            ->whereHas('season', function ($query) use ($userSchoolId) {
                $query->where('sports_school_id', $userSchoolId);
            })
            ->when($this->search, function ($query) {
                $query->where('team', 'like', '%' . $this->search . '%');
            })
            ->when($this->seasonFilter, function ($query) {
                $query->where('season_id', $this->seasonFilter);
            })
            ->withCount('payments')
            ->orderBy('team')
            ->get();

        $seasons = Season::where('sports_school_id', $userSchoolId)
            ->orderBy('from_year', 'desc')
            ->get();

        return view('livewire.payments-teams.index', [
            'teams' => $teams,
            'seasons' => $seasons,
        ]);
    }
}
