<?php

namespace App\Livewire\Players;

use App\Classes\ExcelFile;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Models\PaymentPlayer;
use App\Models\PaymentTeam;
use App\Models\PaymentCodeSequentials;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use ZipArchive;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $dniFilter = '';
    public $matriculaFilter = '';
    public $seasonFilter = '';
    public $teamFilter = '';
    public $withoutTeam = false;
    public $highlightPlayer = null;
    public $sortField = 'surname';
    public $sortDirection = 'asc';
    public $confirmingDeletion = false;
    public $playerToDelete = null;
    public $selectedPlayers = [];
    public $confirmingDeactivation = false;
    public $showDeactivatePreview = false;
    public $showActivatePreview = false;
    public $deactivatePreviewData = [];
    public $activatePreviewData = [];
    public $teamForActivation = '';
    public $confirmingTeamChange = false;
    public $newTeamId = '';
    public $showPendingPaymentsModal = false;
    public $pendingPaymentsPlayers = [];
    public $pendingPaymentsAction = ''; // 'regenerate' o 'delete'
    public $showPreviewModal = false;
    public $paymentsToDelete = [];
    public $paymentsToCreate = [];
    public $paymentsPaid = [];
    public $selectedPaymentsToDelete = [];
    public $selectedPaymentsToCreate = [];

    protected $queryString = ['search', 'dniFilter', 'matriculaFilter', 'seasonFilter', 'teamFilter', 'withoutTeam', 'sortField', 'sortDirection'];

    public function mount()
    {
        // Check if there's a player to highlight from session
        if (session()->has('highlightPlayer')) {
            $this->highlightPlayer = session('highlightPlayer');
        }
        
        // Restore filters from session if available
        if (session()->has('players_filters')) {
            $filters = session('players_filters');
            $this->search = $filters['search'] ?? '';
            $this->dniFilter = $filters['dniFilter'] ?? '';
            $this->matriculaFilter = $filters['matriculaFilter'] ?? '';
            $this->seasonFilter = $filters['seasonFilter'] ?? '';
            $this->teamFilter = $filters['teamFilter'] ?? '';
            $this->withoutTeam = $filters['withoutTeam'] ?? false;
            $this->sortField = $filters['sortField'] ?? 'surname';
            $this->sortDirection = $filters['sortDirection'] ?? 'asc';
        } else {
            // Set default season filter to active season only if no saved filters
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
            // Save initial filters
            $this->saveFilters();
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
        $this->saveFilters();
    }

    public function updatingDniFilter()
    {
        $this->resetPage();
        $this->saveFilters();
    }

    public function updatingMatriculaFilter()
    {
        $this->resetPage();
        $this->saveFilters();
    }

    public function updatingSeasonFilter()
    {
        $this->resetPage();
        $this->saveFilters();
    }

    public function updatingTeamFilter()
    {
        $this->resetPage();
        $this->saveFilters();
    }

    public function updatingWithoutTeam()
    {
        $this->resetPage();
        $this->saveFilters();
    }

    public function saveFilters()
    {
        // Save current filters to session
        session()->put('players_filters', [
            'search' => $this->search,
            'dniFilter' => $this->dniFilter,
            'matriculaFilter' => $this->matriculaFilter,
            'seasonFilter' => $this->seasonFilter,
            'teamFilter' => $this->teamFilter,
            'withoutTeam' => $this->withoutTeam,
            'sortField' => $this->sortField,
            'sortDirection' => $this->sortDirection,
        ]);
    }

    public function clearFilter($field)
    {
        if ($field === 'search') {
            $this->search = '';
        } elseif ($field === 'dniFilter') {
            $this->dniFilter = '';
        } elseif ($field === 'matriculaFilter') {
            $this->matriculaFilter = '';
        } elseif ($field === 'seasonFilter') {
            $this->seasonFilter = '';
        } elseif ($field === 'teamFilter') {
            $this->teamFilter = '';
        } elseif ($field === 'withoutTeam') {
            $this->withoutTeam = false;
        }
        $this->resetPage();
        $this->saveFilters();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->dniFilter = '';
        $this->matriculaFilter = '';
        $this->seasonFilter = '';
        $this->teamFilter = '';
        $this->withoutTeam = false;
        $this->resetPage();
        $this->saveFilters();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
        $this->saveFilters();
    }

    public function canEditPlayer($playerId)
    {
        $player = Player::find($playerId);
        
        if (!$player) {
            return false;
        }
        
        // Obtener temporada activa
        $activeSeason = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
        
        if (!$activeSeason) {
            return false;
        }
        
        // Verificar si el jugador pertenece a la temporada activa
        $belongsToActiveSeason = $player->seasons()->where('seasons.id', $activeSeason->id)->exists();
        
        return $belongsToActiveSeason;
    }

    public function canDeletePlayer($playerId)
    {
        $player = Player::find($playerId);
        
        if (!$player) {
            return false;
        }
        
        // Obtener temporada activa
        $activeSeason = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
        
        if (!$activeSeason) {
            return false;
        }
        
        // Verificar si el jugador pertenece a la temporada activa
        $belongsToActiveSeason = $player->seasons()->where('seasons.id', $activeSeason->id)->exists();
        
        if (!$belongsToActiveSeason) {
            return false;
        }
        
        // Verificar si tiene equipo asignado
        $hasTeam = $player->teams()->exists();
        
        // Verificar si tiene pagos generados
        $hasPayments = PaymentPlayer::where('player_id', $playerId)
            ->exists();
        
        // Solo se puede eliminar si NO tiene equipo Y NO tiene pagos
        return !$hasTeam && !$hasPayments;
    }

    public function confirmDelete($playerId)
    {
        $player = Player::find($playerId);
        if ($player && $player->sports_school_id === auth()->user()->sports_school_id) {
            $this->playerToDelete = $playerId;
            $this->confirmingDeletion = true;
        }
    }

    public function deletePlayer()
    {
        $player = Player::find($this->playerToDelete);
        
        if ($player && $player->sports_school_id === auth()->user()->sports_school_id) {
            // Eliminar foto si existe
            if ($player->player_photo && \Storage::disk('public')->exists($player->player_photo)) {
                \Storage::disk('public')->delete($player->player_photo);
            }
            
            $player->delete();
            session()->flash('message', 'Jugador eliminado correctamente.');
        }
        
        $this->confirmingDeletion = false;
        $this->playerToDelete = null;
    }

    public function confirmDeactivation()
    {
        if (count($this->selectedPlayers) > 0) {
            // Preparar datos de previsualización
            $this->deactivatePreviewData = [];
            
            foreach ($this->selectedPlayers as $playerId) {
                $player = Player::with(['teams', 'paymentPlayers' => function($query) {
                    $query->whereNull('deleted_at')->where('state', 0); // Solo pagos pendientes
                }])->find($playerId);
                
                if ($player && $player->sports_school_id === auth()->user()->sports_school_id && $player->active) {
                    $playerData = [
                        'id' => $player->id,
                        'name' => $player->name.' '.$player->surname,
                        'photo' => $player->player_photo,
                        'dni' => $player->dni,
                        'teams' => $player->teams->pluck('team')->toArray(),
                        'payments' => []
                    ];
                    
                    // Obtener pagos pendientes del jugador (solo estado 0)
                    foreach ($player->paymentPlayers as $payment) {
                        $playerData['payments'][] = [
                            'id' => $payment->id,
                            'code' => $payment->code,
                            'description' => $payment->description,
                            'amount' => $payment->amount,
                            'cuota' => $payment->cuota,
                        ];
                    }
                    
                    $this->deactivatePreviewData[] = $playerData;
                }
            }
            
            $this->showDeactivatePreview = true;
        }
    }

    public function confirmActivation()
    {
        if (count($this->selectedPlayers) > 0) {
            // Preparar datos de jugadores inactivos seleccionados
            $this->activatePreviewData = [];
            
            foreach ($this->selectedPlayers as $playerId) {
                $player = Player::find($playerId);
                
                if ($player && $player->sports_school_id === auth()->user()->sports_school_id && !$player->active) {
                    $this->activatePreviewData[] = [
                        'id' => $player->id,
                        'name' => $player->full_name,
                        'photo' => $player->player_photo,
                        'dni' => $player->dni,
                    ];
                }
            }
            
            $this->teamForActivation = '';
            $this->showActivatePreview = true;
        }
    }

    public function deactivatePlayers()
    {
        $deactivated = 0;
        $paymentsDeleted = 0;
        $teamsRemoved = 0;
        
        foreach ($this->selectedPlayers as $playerId) {
            $player = Player::with(['teams'])->find($playerId);
            
            if ($player && $player->sports_school_id === auth()->user()->sports_school_id && $player->active) {
                // Eliminar pagos pendientes (soft delete) - solo estado 0 (pendiente)
                $pendingPayments = PaymentPlayer::where('player_id', $playerId)
                    ->whereNull('deleted_at')
                    ->where('state', 0)
                    ->get();
                    
                foreach ($pendingPayments as $payment) {
                    $payment->delete(); // Usa el método delete() para soft delete
                    $paymentsDeleted++;
                }
                
                // Quitar jugador de todos los equipos
                $teamCount = $player->teams->count();
                $player->teams()->detach();
                $teamsRemoved += $teamCount;
                
                // Desactivar jugador
                $player->update(['active' => false]);
                $deactivated++;
            }
        }
        
        $message = "Se desactivaron {$deactivated} jugador(es) correctamente.";
        if ($paymentsDeleted > 0) {
            $message .= " Se eliminaron {$paymentsDeleted} carta(s) de pago.";
        }
        if ($teamsRemoved > 0) {
            $message .= " Se removieron de {$teamsRemoved} equipo(s).";
        }
        
        session()->flash('message', $message);
        
        $this->showDeactivatePreview = false;
        $this->deactivatePreviewData = [];
        $this->selectedPlayers = [];
        $this->dispatch('modal-closed');
    }

    public function activatePlayers()
    {
        // Validar que se haya seleccionado un equipo
        if (empty($this->teamForActivation)) {
            session()->flash('error', 'Debes seleccionar un equipo para activar los jugadores.');
            return;
        }

        $team = Team::find($this->teamForActivation);
        if (!$team || $team->season->sports_school_id !== auth()->user()->sports_school_id) {
            session()->flash('error', 'Equipo no válido.');
            return;
        }

        $activated = 0;
        $paymentsGenerated = 0;
        $paymentsRestored = 0;
        
        foreach ($this->selectedPlayers as $playerId) {
            $player = Player::find($playerId);
            
            if ($player && $player->sports_school_id === auth()->user()->sports_school_id && !$player->active) {
                // Activar jugador
                $player->update(['active' => true]);
                $activated++;
                
                // Asignar al equipo
                $player->teams()->syncWithoutDetaching([$team->id]);
                
                // Generar pagos usando el helper
                $result = generatePlayerPayments($player, $team, auth()->user()->sports_school_id, auth()->id());
                $paymentsGenerated += $result['generated'];
                $paymentsRestored += $result['restored'];
            }
        }
        
        $message = "Se activaron {$activated} jugador(es) y se asignaron al equipo {$team->team}.";
        if ($paymentsGenerated > 0) {
            $message .= " Se generaron {$paymentsGenerated} carta(s) de pago.";
        }
        if ($paymentsRestored > 0) {
            $message .= " Se restauraron {$paymentsRestored} carta(s) de pago.";
        }
        
        session()->flash('message', $message);
        
        $this->showActivatePreview = false;
        $this->activatePreviewData = [];
        $this->teamForActivation = '';
        $this->selectedPlayers = [];
        $this->dispatch('modal-closed');
    }

    public function confirmTeamChange()
    {
        if (count($this->selectedPlayers) > 0) {
            $this->newTeamId = '';
            $this->confirmingTeamChange = true;
        }
    }

     public function exportExcel(){
        // Construir query con los mismos filtros de la vista
        $query = Player::where('sports_school_id', auth()->user()->sports_school_id)
            ->with(['seasons', 'teams', 'sections'])
            ->when($this->search, function ($query) {
                // Dividir búsqueda en palabras individuales
                $searchTerms = array_filter(explode(' ', trim($this->search)));
                
                $query->where(function ($q) use ($searchTerms) {
                    // Cada palabra debe aparecer en al menos uno de los campos
                    foreach ($searchTerms as $term) {
                        $q->where(function ($subQ) use ($term) {
                            $subQ->where('name', 'like', '%' . $term . '%')
                                ->orWhere('surname', 'like', '%' . $term . '%')
                                ->orWhere('nametutor', 'like', '%' . $term . '%')
                                ->orWhere('dni', 'like', '%' . $term . '%')
                                ->orWhere('email', 'like', '%' . $term . '%')
                                ->orWhere('dorsal', 'like', '%' . $term . '%');
                        });
                    }
                });
            })
            ->when($this->dniFilter, function ($query) {
                $query->where(function ($q) {
                    $dniTerm = $this->dniFilter;
                    $q->where('dni', 'like', '%' . $dniTerm . '%')
                      ->orWhere('dnitutor', 'like', '%' . $dniTerm . '%');
                });
            })
            ->when($this->matriculaFilter, function ($query) {
                $query->where('cod_matricula', 'like', '%' . $this->matriculaFilter . '%');
            })
            ->when($this->seasonFilter, function ($query) {
                $query->whereHas('seasons', function ($q) {
                    $q->where('seasons.id', $this->seasonFilter);
                });
            })
            ->when($this->teamFilter, function ($query) {
                $query->whereHas('teams', function ($q) {
                    $q->where('teams.id', $this->teamFilter);
                });
            })
            ->when($this->withoutTeam, function ($query) {
                $query->doesntHave('teams');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();

        $excel = new ExcelFile(
                    Player::class,
                    [], // Sin filtros, ya pasamos los registros filtrados
                    [
                        // 'id' => [
                        //     'title' => '#ID#',
                        //     'value' => '$record->id',
                        //     'type' => 'eval'
                        // ],
                        'cod_matricula' => [
                            'title' => 'Matricula',
                            'value' => '$record->cod_matricula',
                            'type' => 'eval'
                        ],
                        'dni' => [
                            'title' => 'DNI/NIE',
                            'value' => '$record->dni',
                            'type' => 'eval'
                        ],
                        'name' => [
                            'title' => 'Nombre',
                            'value' => '$record->name',
                            'type' => 'eval'
                        ],
                        'surname' => [
                            'title' => 'Apellido',
                            'value' => '$record->surname',
                            'type' => 'eval'
                        ],
                        'dbirth' => [
                            'title' => 'F. Nacimiento',
                            'value' => '$record->dbirth',
                            'type' => 'eval'
                        ],
                        'dbanio' => [
                            'title' => 'Año',
                            'value' => '$record->dbanio',
                            'type' => 'eval'
                        ],
                        'Team' => [
                            'title' => 'Equipo',
                            'value' => '$record->teams->first()->team ?? "Sin equipo"',
                            'type' => 'eval'
                        ],
                        'sections' => [
                            'title' => 'Secciones',
                            'value' => '$record->sections->pluck("name")->implode(", ")',
                            'type' => 'eval'
                        ],
                        // 'soccer' => [
                        //     'title' => 'Futbol',
                        //     'value' => '$record->soccer',
                        //     'type' => 'eval'
                        // ],
                        // 'paddle' => [
                        //     'title' => 'Pádel',
                        //     'value' => '$record->paddle',
                        //     'type' => 'eval'
                        // ],
                        'sizes' => [
                            'title' => 'Talla',
                            'value' => '$record->sizes',
                            'type' => 'eval'
                        ],
                        'dorsal' => [
                            'title' => 'Dorsal',
                            'value' => '$record->dorsal',
                            'type' => 'eval'
                        ],
                        'goalie' => [
                            'title' => 'Portero',
                            'value' => '$record->goalie',
                            'type' => 'eval'
                        ],
                        // 'file' => [
                        //     'title' => 'Ficha',
                        //     'value' => '$record->file',
                        //     'type' => 'eval'
                        // ],
                        'dnitutor' => [
                            'title' => 'DNI/NIE Tutor',
                            'value' => '$record->dnitutor',
                            'type' => 'eval'
                        ],
                        'nametutor' => [
                            'title' => 'Nombre Tutor',
                            'value' => '$record->nametutor',
                            'type' => 'eval'
                        ],
                        'address' => [
                            'title' => 'Dirección',
                            'value' => '$record->address',
                            'type' => 'eval'
                        ],
                        'zip' => [
                            'title' => 'CP',
                            'value' => '$record->zip',
                            'type' => 'eval'
                        ],
                        'town' => [
                            'title' => 'Población',
                            'value' => '$record->town',
                            'type' => 'eval'
                        ],
                        'phone1' => [
                            'title' => 'Teléfono',
                            'value' => '$record->phone1',
                            'type' => 'eval'
                        ],
                        'email' => [
                            'title' => 'eMail',
                            'value' => '$record->email',
                            'type' => 'eval'
                        ],
                        // 'created_at' => [
                        //     'title' => 'F.Incripción',
                        //     'value' => '$record->created_at',
                        //     'type' => 'eval'
                        // ],
                        'observations' => [
                            'title' => 'Observaciones',
                            'value' => '$record->observations',
                            'type' => 'eval'
                        ],
                    ],
                    'Jugadores Escuelas deportivas',
                    [], // Sin sort, ya está ordenado
                    [], // Sin with, ya están cargadas las relaciones
                    $query // Pasar los registros ya filtrados
                );
                return response()->streamDownload(
                    fn () => print($excel->generate()),
                    'Listado jugadores.xlsx'
                );
        
    }

    public function changeTeam()
    {
        $this->validate([
            'newTeamId' => 'required|exists:teams,id',
        ], [
            'newTeamId.required' => 'Debes seleccionar un equipo.',
            'newTeamId.exists' => 'El equipo seleccionado no es válido.',
        ]);

        // Verificar si algún jugador ya está en el equipo seleccionado
        $playersAlreadyInTeam = [];
        foreach ($this->selectedPlayers as $playerId) {
            $player = Player::with('teams')->find($playerId);
            if ($player && $player->sports_school_id === auth()->user()->sports_school_id) {
                // Verificar si el jugador ya está en el equipo seleccionado
                $isInTeam = $player->teams()->where('teams.id', $this->newTeamId)->exists();
                if ($isInTeam) {
                    $playersAlreadyInTeam[] = $player->name . ' ' . $player->surname;
                }
            }
        }

        // Si todos los jugadores ya están en el equipo seleccionado, mostrar error
        if (count($playersAlreadyInTeam) === count($this->selectedPlayers)) {
            $playersList = implode(', ', $playersAlreadyInTeam);
            session()->flash('error', 'El/los jugador(es) seleccionado(s) ya pertenece(n) al equipo seleccionado: ' . $playersList);
            $this->confirmingTeamChange = false;
            return;
        }

        // Si algunos jugadores ya están en el equipo, filtrarlos
        if (count($playersAlreadyInTeam) > 0) {
            $playersList = implode(', ', $playersAlreadyInTeam);
            session()->flash('warning', 'Los siguientes jugadores ya pertenecen al equipo y serán omitidos: ' . $playersList);
            
            // Filtrar los jugadores que ya están en el equipo
            $this->selectedPlayers = collect($this->selectedPlayers)->filter(function($playerId) {
                $player = Player::with('teams')->find($playerId);
                return !$player->teams()->where('teams.id', $this->newTeamId)->exists();
            })->values()->toArray();
        }

        // Obtener temporada activa
        $activeSeason = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$activeSeason) {
            session()->flash('error', 'No hay temporada activa configurada.');
            $this->confirmingTeamChange = false;
            return;
        }

        // Siempre ir a previsualización para mostrar pagos a eliminar/crear
        $this->preparePaymentsRegeneration();
    }

    public function confirmPaymentsAction()
    {
        $this->regeneratePayments();
    }

    private function preparePaymentsRegeneration()
    {
        // Obtener temporada activa
        $activeSeason = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        // Obtener el nuevo equipo
        $newTeam = Team::with(['payments'])->find($this->newTeamId);

        if (!$newTeam) {
            session()->flash('error', 'Equipo no encontrado.');
            $this->confirmingTeamChange = false;
            return;
        }

        $this->paymentsToDelete = [];
        $this->paymentsToCreate = [];
        $this->paymentsPaid = [];
        $this->selectedPaymentsToDelete = [];
        $this->selectedPaymentsToCreate = [];

        foreach ($this->selectedPlayers as $playerId) {
            $player = Player::find($playerId);
            if (!$player) continue;

            // Obtener pagos pendientes a eliminar
            $pendingPayments = PaymentPlayer::with('paymentTeam')
                ->where('player_id', $playerId)
                ->where('sports_school_id', auth()->user()->sports_school_id)
                ->where('state', 0)
                ->whereHas('paymentTeam', function($query) use ($activeSeason) {
                    $query->where('season_id', $activeSeason->id);
                })
                ->get();

            foreach ($pendingPayments as $payment) {
                $paymentId = $payment->id;
                $this->paymentsToDelete[] = [
                    'id' => $paymentId,
                    'player_id' => $player->id,
                    'player_name' => $player->name . ' ' . $player->surname,
                    'code' => $payment->code,
                    'cuota' => $payment->cuota,
                    'amount' => $payment->amount,
                    'description' => $payment->paymentTeam->description ?? 'N/A',
                ];
                $this->selectedPaymentsToDelete[] = $paymentId;
            }

            // Obtener cuotas YA PAGADAS para no generarlas de nuevo
            $paidCuotas = PaymentPlayer::where('player_id', $playerId)
                ->where('sports_school_id', auth()->user()->sports_school_id)
                ->where('state', 1) // Pagadas
                ->whereHas('paymentTeam', function($query) use ($activeSeason) {
                    $query->where('season_id', $activeSeason->id);
                })
                ->with('paymentTeam')
                ->get()
                ->pluck('cuota')
                ->toArray();

            // Mostrar pagos pagados que se mantendrán
            $paidPayments = PaymentPlayer::with('paymentTeam')
                ->where('player_id', $playerId)
                ->where('sports_school_id', auth()->user()->sports_school_id)
                ->where('state', 1)
                ->whereHas('paymentTeam', function($query) use ($activeSeason) {
                    $query->where('season_id', $activeSeason->id);
                })
                ->get();

            foreach ($paidPayments as $payment) {
                $this->paymentsPaid[] = [
                    'player_name' => $player->name . ' ' . $player->surname,
                    'code' => $payment->code,
                    'cuota' => $payment->cuota,
                    'amount' => $payment->amount,
                    'description' => $payment->paymentTeam->description ?? 'N/A',
                    'payment_date' => $payment->payment_date ? $payment->payment_date->format('d/m/Y') : 'N/A',
                ];
            }

            // Preparar nuevos pagos a crear (excluyendo cuotas ya pagadas)
            if ($newTeam->payments->isNotEmpty()) {
                $newPayments = $this->preparePlayerPaymentsForTeam($player, $newTeam, $paidCuotas);
                foreach ($newPayments as $index => $newPayment) {
                    $uniqueId = $player->id . '_' . $index;
                    $newPayment['unique_id'] = $uniqueId;
                    $this->paymentsToCreate[] = $newPayment;
                    $this->selectedPaymentsToCreate[] = $uniqueId;
                }
            }
        }

        $this->showPendingPaymentsModal = false;
        $this->confirmingTeamChange = false;
        $this->showPreviewModal = true;
    }

    private function regeneratePayments()
    {
        try {
            DB::beginTransaction();

            $deletedCount = 0;
            $generatedCount = 0;
            $restoredCount = 0;

            // Eliminar todos los pagos pendientes (todos los de paymentsToDelete)
            foreach ($this->paymentsToDelete as $paymentInfo) {
                $payment = PaymentPlayer::find($paymentInfo['id']);
                if ($payment) {
                    $payment->delete();
                    $deletedCount++;
                }
            }

            // Crear o restaurar nuevos pagos seleccionados
            foreach ($this->paymentsToCreate as $newPayment) {
                if (in_array($newPayment['unique_id'], $this->selectedPaymentsToCreate)) {
                    // Si es una restauración, restaurar el pago existente
                    if (isset($newPayment['is_restore']) && $newPayment['is_restore'] && isset($newPayment['existing_payment_id'])) {
                        $deletedPayment = PaymentPlayer::withTrashed()->find($newPayment['existing_payment_id']);
                        if ($deletedPayment) {
                            $deletedPayment->deleted_at = null;
                            $deletedPayment->state = 0; // Volver a pendiente
                            $deletedPayment->payment_date = null;
                            $deletedPayment->payment_order = null;
                            $deletedPayment->payment_auth = null;
                            $deletedPayment->payment_type = null;
                            // Actualizar descuentos por si han cambiado
                            $deletedPayment->amount_original = $newPayment['amount_original'];
                            $deletedPayment->amount = $newPayment['amount'];
                            $deletedPayment->descEnt = $newPayment['descEnt'];
                            $deletedPayment->descPerc = $newPayment['descPerc'];
                            $deletedPayment->price = $newPayment['price'];
                            $deletedPayment->updated_user = auth()->id();
                            $deletedPayment->save();
                            $restoredCount++;
                        }
                    } else {
                        // Crear nuevo pago
                        PaymentPlayer::create([
                            'player_id' => $newPayment['player_id'],
                            'payment_id' => $newPayment['payment_id'],
                            'sports_school_id' => $newPayment['sports_school_id'],
                            'code' => PaymentCodeSequentials::getCode(),
                            'state' => 0,
                            'cuota' => $newPayment['cuota'],
                            'price' => $newPayment['price'],
                            'amount_original' => $newPayment['amount_original'],
                            'amount' => $newPayment['amount'],
                            'descEnt' => $newPayment['descEnt'],
                            'descPerc' => $newPayment['descPerc'],
                            'created_user' => auth()->id(),
                        ]);
                        $generatedCount++;
                    }
                }
            }

            DB::commit();

            $message = '';
            if ($deletedCount > 0) {
                $message .= "Se eliminaron {$deletedCount} pagos pendientes. ";
            }
            if ($generatedCount > 0) {
                $message .= "Se generaron {$generatedCount} nuevas cartas de pago. ";
            }
            if ($restoredCount > 0) {
                $message .= "Se restauraron {$restoredCount} cartas de pago.";
            }
            if (empty($message)) {
                $message = "Cambio de equipo realizado correctamente.";
            }
            
            session()->flash('message', trim($message));
            
            // Proceder con el cambio de equipo
            $this->executeTeamChange();

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al regenerar los pagos: ' . $e->getMessage());
        }

        $this->showPreviewModal = false;
        $this->dispatch('modal-closed');
    }

    private function preparePlayerPaymentsForTeam($player, $team, $excludedCuotas = [])
    {
        $paymentsData = [];
        $sportsSchoolId = auth()->user()->sports_school_id;

        // Calcular descuentos del jugador
        $descuentoEuros = 0;
        $descuentoPorcentaje = 0;
        
        if ($player->descEnt) {
            $descuentoEuros = floatval($player->descEnt);
        }
        
        if ($player->descPerc) {
            $descuentoPorcentaje = floatval($player->descPerc);
        }

        // Calcular precio total del equipo
        $precioTotal = floatval($team->price);
        
        // Aplicar descuentos al precio total
        $precioTotalConDescuento = $precioTotal;
        
        // Aplicar descuento en euros
        if ($descuentoEuros > 0) {
            $precioTotalConDescuento -= $descuentoEuros;
        }
        
        // Aplicar descuento en porcentaje
        if ($descuentoPorcentaje > 0) {
            $descuentoPorcentajeImporte = ($precioTotal * $descuentoPorcentaje) / 100;
            $precioTotalConDescuento -= $descuentoPorcentajeImporte;
        }
        
        // Asegurar que no sea negativo
        $precioTotalConDescuento = max(0, $precioTotalConDescuento);
        
        // Número total de cuotas del equipo
        $totalCuotas = $team->payments->count();
        
        // Calcular importe por cuota (dividiendo el total entre TODAS las cuotas)
        $importePorCuota = $totalCuotas > 0 ? $precioTotalConDescuento / $totalCuotas : 0;

        // Procesar cada pago del equipo
        foreach ($team->payments as $payment) {
            // Saltar si esta cuota ya está pagada
            if (in_array($payment->cuota, $excludedCuotas)) {
                continue;
            }

            // Verificar que no exista ya esta combinación player_id + payment_id ACTIVA (no soft deleted)
            $existsActive = PaymentPlayer::where('player_id', $player->id)
                ->where('payment_id', $payment->id)
                ->whereNull('deleted_at')
                ->exists();

            if ($existsActive) {
                continue;
            }

            // Verificar si existe un pago soft deleted para marcarlo como "a restaurar"
            $deletedPayment = PaymentPlayer::withTrashed()
                ->where('player_id', $player->id)
                ->where('payment_id', $payment->id)
                ->whereNotNull('deleted_at')
                ->first();

            // Si existe un pago eliminado, también lo agregamos a la lista
            if ($deletedPayment) {
                $amountOriginal = floatval($payment->amount);

                $paymentsData[] = [
                    'player_id' => $player->id,
                    'player_name' => $player->name . ' ' . $player->surname,
                    'payment_id' => $payment->id,
                    'sports_school_id' => $sportsSchoolId,
                    'cuota' => $payment->cuota,
                    'price' => $precioTotalConDescuento,
                    'amount_original' => $amountOriginal,
                    'amount' => $importePorCuota,
                    'descEnt' => $descuentoEuros,
                    'descPerc' => $descuentoPorcentaje,
                    'description' => $payment->description ?? 'N/A',
                    'team_name' => $team->team,
                    'is_restore' => true,
                    'existing_payment_id' => $deletedPayment->id,
                ];
                continue;
            }

            // Crear nuevo pago
            $amountOriginal = floatval($payment->amount);

            $paymentsData[] = [
                'player_id' => $player->id,
                'player_name' => $player->name . ' ' . $player->surname,
                'payment_id' => $payment->id,
                'sports_school_id' => $sportsSchoolId,
                'cuota' => $payment->cuota,
                'price' => $precioTotalConDescuento,
                'amount_original' => $amountOriginal,
                'amount' => $importePorCuota,
                'descEnt' => $descuentoEuros,
                'descPerc' => $descuentoPorcentaje,
                'description' => $payment->description ?? 'N/A',
                'team_name' => $team->team,
            ];
        }

        return $paymentsData;
    }

    private function generatePlayerPaymentsForTeam($player, $team)
    {
        $generatedCount = 0;
        $sportsSchoolId = auth()->user()->sports_school_id;

        // Calcular descuentos totales del jugador
        $totalDiscount = 0;
        $discountPercentage = 0;
        
        if ($player->descEnt) {
            $totalDiscount += floatval($player->descEnt);
        }
        
        if ($player->descPerc) {
            $discountPercentage = floatval($player->descPerc);
        }

        // Número total de pagos para dividir el descuento
        $totalPayments = $team->payments->count();
        
        // Calcular descuento por cuota
        $discountPerPayment = $totalPayments > 0 ? $totalDiscount / $totalPayments : 0;

        // Procesar cada pago del equipo
        foreach ($team->payments as $payment) {
            // Verificar si existe un pago activo (no eliminado)
            $existsActive = PaymentPlayer::where('player_id', $player->id)
                ->where('payment_id', $payment->id)
                ->whereNull('deleted_at')
                ->exists();

            if ($existsActive) {
                continue;
            }

            // Verificar si existe un pago eliminado (soft deleted) para restaurarlo
            $deletedPayment = PaymentPlayer::where('player_id', $player->id)
                ->where('payment_id', $payment->id)
                ->whereNotNull('deleted_at')
                ->first();

            if ($deletedPayment) {
                // Restaurar el pago eliminado
                $deletedPayment->deleted_at = null;
                $deletedPayment->state = 0; // Volver a pendiente
                $deletedPayment->payment_date = null;
                $deletedPayment->payment_order = null;
                $deletedPayment->payment_auth = null;
                $deletedPayment->payment_type = null;
                $deletedPayment->updated_user = auth()->id();
                $deletedPayment->save();
                $generatedCount++;
                continue;
            }

            // Generar código de pago
            $code = PaymentCodeSequentials::getCode();

            // Calcular importe original y con descuento
            $amountOriginal = floatval($payment->amount);
            $amountWithDiscount = $amountOriginal;

            // Aplicar descuento en euros (dividido entre todas las cuotas)
            if ($discountPerPayment > 0) {
                $amountWithDiscount -= $discountPerPayment;
            }

            // Aplicar descuento en porcentaje
            if ($discountPercentage > 0) {
                $percentageDiscount = ($amountOriginal * $discountPercentage) / 100;
                $amountWithDiscount -= $percentageDiscount;
            }

            // Asegurar que el importe no sea negativo
            $amountWithDiscount = max(0, $amountWithDiscount);

            // Calcular descuentos aplicados a esta cuota
            $descEntApplied = $discountPerPayment;
            $descPercApplied = $discountPercentage;

            // Crear orden de pago para el jugador
            PaymentPlayer::create([
                'player_id' => $player->id,
                'payment_id' => $payment->id,
                'sports_school_id' => $sportsSchoolId,
                'code' => $code,
                'state' => 0, // Pendiente
                'cuota' => $payment->cuota,
                'price' => $team->price, // Precio de matrícula del equipo
                'amount_original' => $amountOriginal,
                'amount' => $amountWithDiscount,
                'descEnt' => $descEntApplied,
                'descPerc' => $descPercApplied,
                'created_user' => auth()->id(),
            ]);

            $generatedCount++;
        }

        return ['generated' => $generatedCount];
    }

    public function toggleAllPaymentsToCreate($checked)
    {
        if ($checked) {
            $this->selectedPaymentsToCreate = array_column($this->paymentsToCreate, 'unique_id');
        } else {
            $this->selectedPaymentsToCreate = [];
        }
    }

    public function highlightText($text, $searchTerms = null)
    {
        if (empty($text)) {
            return '';
        }

        // Si no se pasan términos, usar los del componente
        if ($searchTerms === null) {
            if (empty($this->search)) {
                return $text;
            }
            $searchTerms = array_filter(explode(' ', trim($this->search)));
        }

        if (empty($searchTerms)) {
            return $text;
        }

        // Escapar el texto original
        $highlightedText = e($text);

        // Resaltar cada término encontrado
        foreach ($searchTerms as $term) {
            $term = preg_quote($term, '/');
            $highlightedText = preg_replace(
                '/(' . $term . ')/iu',
                '<mark class="bg-yellow-200 font-semibold">$1</mark>',
                $highlightedText
            );
        }

        return $highlightedText;
    }

    private function executeTeamChange()
    {
        $changed = 0;
        
        foreach ($this->selectedPlayers as $playerId) {
            $player = Player::find($playerId);
            
            if ($player && $player->sports_school_id === auth()->user()->sports_school_id) {
                // Sync the player with the new team (replace existing teams)
                $player->teams()->sync([$this->newTeamId]);
                $changed++;
            }
        }
        
        session()->flash('message', "Se cambiaron {$changed} jugador(es) de equipo correctamente.");
        
        $this->confirmingTeamChange = false;
        $this->selectedPlayers = [];
        $this->newTeamId = '';
        $this->pendingPaymentsPlayers = [];
        $this->paymentsToDelete = [];
        $this->paymentsToCreate = [];
        $this->paymentsPaid = [];
    }

    public function getHasActivePlayersProperty()
    {
        if (empty($this->selectedPlayers)) {
            return false;
        }
        
        return Player::whereIn('id', $this->selectedPlayers)
            ->where('sports_school_id', auth()->user()->sports_school_id)
            ->where('active', true)
            ->exists();
    }

    public function getHasInactivePlayersProperty()
    {
        if (empty($this->selectedPlayers)) {
            return false;
        }
        
        return Player::whereIn('id', $this->selectedPlayers)
            ->where('sports_school_id', auth()->user()->sports_school_id)
            ->where('active', false)
            ->exists();
    }

    public function render()
    {
        $players = Player::where('sports_school_id', auth()->user()->sports_school_id)
            ->with(['seasons', 'teams'])
            ->withCount(['paymentPlayers as payment_players_count' => function ($query) {
                $query->whereNull('payments_players.deleted_at');
            }])
            ->when($this->search, function ($query) {
                // Dividir búsqueda en palabras individuales
                $searchTerms = array_filter(explode(' ', trim($this->search)));
                
                $query->where(function ($q) use ($searchTerms) {
                    // Cada palabra debe aparecer en al menos uno de los campos
                    foreach ($searchTerms as $term) {
                        $q->where(function ($subQ) use ($term) {
                            $subQ->where('name', 'like', '%' . $term . '%')
                                ->orWhere('surname', 'like', '%' . $term . '%')
                                ->orWhere('nametutor', 'like', '%' . $term . '%')
                                ->orWhere('dni', 'like', '%' . $term . '%')
                                ->orWhere('email', 'like', '%' . $term . '%')
                                ->orWhere('dorsal', 'like', '%' . $term . '%');
                        });
                    }
                });
            })
            ->when($this->dniFilter, function ($query) {
                $query->where(function ($q) {
                    $dniTerm = $this->dniFilter;
                    $q->where('dni', 'like', '%' . $dniTerm . '%')
                      ->orWhere('dnitutor', 'like', '%' . $dniTerm . '%');
                });
            })
            ->when($this->matriculaFilter, function ($query) {
                $query->where('cod_matricula', 'like', '%' . $this->matriculaFilter . '%');
            })
            ->when($this->seasonFilter, function ($query) {
                $query->whereHas('seasons', function ($q) {
                    $q->where('seasons.id', $this->seasonFilter);
                });
            })
            ->when($this->teamFilter, function ($query) {
                $query->whereHas('teams', function ($q) {
                    $q->where('teams.id', $this->teamFilter);
                });
            })
            ->when($this->withoutTeam, function ($query) {
                $query->doesntHave('teams');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        $seasons = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderBy('season')
            ->get();

        $activeSeason = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();

        // Obtener equipos de la temporada activa
        $teams = \App\Models\Team::whereHas('season', function ($query) {
                $query->where('sports_school_id', auth()->user()->sports_school_id);
            })
            ->when($activeSeason, function ($query) use ($activeSeason) {
                $query->where('season_id', $activeSeason->id);
            })
            ->orderBy('team')
            ->get();

        return view('livewire.players.index', [
            'players' => $players,
            'seasons' => $seasons,
            'activeSeason' => $activeSeason,
            'teams' => $teams,
            'playerToDeleteModel' => $this->playerToDelete ? Player::find($this->playerToDelete) : null,
            'selectedPlayersModels' => Player::whereIn('id', $this->selectedPlayers)->get(),
        ]);
    }

}
