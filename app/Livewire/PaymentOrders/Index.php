<?php

namespace App\Livewire\PaymentOrders;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Models\PaymentTeam;
use App\Models\PaymentPlayer;
use App\Models\PaymentCodeSequentials;
use Illuminate\Support\Facades\DB;
use App\Classes\ExcelFile;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $seasonFilter = '';
    public $teamFilter = '';
    public $cuotaFilter = '';
    public $pendingPaymentsOnly = true;
    public $showDeleteModal = false;
    public $playerToDeleteId = null;
    public $playerToDelete = null;
    
    // Selección múltiple
    public $selectedPlayers = [];
    public $selectAll = false;
    
    // Modal de cambio de estado
    public $showStateChangeModal = false;
    public $stateChangeCuota = '';
    public $stateChangeNewState = '';

    protected $queryString = ['search'];

    public function mount()
    {
        // Obtener la temporada activa
        $activeSeason = Season::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
            
        // Recuperar filtros de sesión
        $this->search = session('paymentOrders.search', '');
        $this->seasonFilter = session('paymentOrders.seasonFilter', $activeSeason ? $activeSeason->id : '');
        $this->teamFilter = session('paymentOrders.teamFilter', '');
        $this->cuotaFilter = session('paymentOrders.cuotaFilter', '');
        $this->pendingPaymentsOnly = session('paymentOrders.pendingPaymentsOnly', true);
    }

    public function updated($property)
    {
        // Guardar filtros en sesión cuando cambien
        if (in_array($property, ['search', 'seasonFilter', 'teamFilter', 'cuotaFilter', 'pendingPaymentsOnly'])) {
            session(['paymentOrders.' . $property => $this->$property]);
        }
        
        // Manejar selección de todos
        if ($property === 'selectAll') {
            $this->handleSelectAll();
        }
    }
    
    public function handleSelectAll()
    {
        if ($this->selectAll) {
            // Seleccionar todos los jugadores de la página actual
            $players = $this->getPlayersQuery()->get();
            $this->selectedPlayers = $players->pluck('id')->toArray();
        } else {
            $this->selectedPlayers = [];
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

    public function updatingTeamFilter()
    {
        $this->resetPage();
    }

    public function updatingCuotaFilter()
    {
        $this->resetPage();
    }

    public function generatePaymentOrders()
    {
        try {
            DB::beginTransaction();

            // Obtener temporada activa
            $activeSeason = Season::where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();

            if (!$activeSeason) {
                session()->flash('error', 'No hay temporada activa configurada.');
                return;
            }

            $sportsSchoolId = auth()->user()->sports_school_id;
            $generatedCount = 0;
            $skippedCount = 0;

            // Obtener equipos de la temporada activa con pagos configurados
            // La verificación de sports_school_id se hace a través de la temporada
            $teams = Team::where('season_id', $activeSeason->id)
                ->whereHas('season', function ($query) use ($sportsSchoolId) {
                    $query->where('sports_school_id', $sportsSchoolId);
                })
                ->with(['players', 'payments'])
                ->get();

            foreach ($teams as $team) {
                // Verificar que el equipo tenga pagos configurados
                if ($team->payments->isEmpty()) {
                    continue;
                }

                // Obtener jugadores del equipo
                foreach ($team->players as $player) {
                    $result = $this->generatePlayerPayments($player, $team, $sportsSchoolId);
                    $generatedCount += $result['generated'];
                    $skippedCount += $result['skipped'];
                }
            }

            DB::commit();

            if ($generatedCount > 0) {
                session()->flash('message', "Se generaron correctamente {$generatedCount} cartas de pago." . 
                    ($skippedCount > 0 ? " Se omitieron {$skippedCount} registros duplicados." : ''));
            } else {
                session()->flash('error', 'No se generaron cartas de pago. Verifica que los equipos tengan pagos configurados y jugadores asignados.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al generar las cartas de pago: ' . $e->getMessage());
        }
    }

    public function generateSinglePlayerPayments($playerId)
    {
        try {
            DB::beginTransaction();

            $sportsSchoolId = auth()->user()->sports_school_id;
            
            // Obtener el jugador con sus equipos
            $player = Player::with(['teams' => function($query) {
                $query->with(['payments', 'season']);
            }])->find($playerId);

            if (!$player) {
                session()->flash('error', 'Jugador no encontrado.');
                return;
            }

            // Obtener temporada activa
            $activeSeason = Season::where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();

            if (!$activeSeason) {
                session()->flash('error', 'No hay temporada activa configurada.');
                return;
            }

            $generatedCount = 0;
            $skippedCount = 0;

            // Obtener el equipo del jugador en la temporada activa
            $team = $player->teams->where('season_id', $activeSeason->id)->first();

            if (!$team) {
                session()->flash('error', 'El jugador no pertenece a ningún equipo de la temporada activa.');
                return;
            }

            if ($team->payments->isEmpty()) {
                session()->flash('error', 'El equipo no tiene pagos configurados.');
                return;
            }

            $result = $this->generatePlayerPayments($player, $team, $sportsSchoolId);
            $generatedCount = $result['generated'];
            $skippedCount = $result['skipped'];

            DB::commit();

            if ($generatedCount > 0) {
                session()->flash('message', "Se generaron correctamente {$generatedCount} " . 
                    ($generatedCount == 1 ? 'carta de pago' : 'cartas de pago') . " para {$player->name} {$player->surname}." . 
                    ($skippedCount > 0 ? " Se omitieron {$skippedCount} registros duplicados." : ''));
            } else {
                session()->flash('error', 'No se generaron cartas de pago. Es posible que ya existan.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al generar las cartas de pago: ' . $e->getMessage());
        }
    }

    public function confirmDeletePlayerPayments($playerId)
    {
        $this->playerToDeleteId = $playerId;
        $this->playerToDelete = Player::find($playerId);
        $this->showDeleteModal = true;
    }

    public function deletePlayerPayments()
    {
        try {
            DB::beginTransaction();

            $deleted = PaymentPlayer::where('player_id', $this->playerToDeleteId)
                ->where('sports_school_id', auth()->user()->sports_school_id)
                ->delete();

            DB::commit();

            $this->showDeleteModal = false;
            $this->playerToDeleteId = null;
            $this->playerToDelete = null;

            if ($deleted > 0) {
                session()->flash('message', "Se eliminaron correctamente {$deleted} " . 
                    ($deleted == 1 ? 'carta de pago' : 'cartas de pago') . " del jugador.");
            } else {
                session()->flash('error', 'No se encontraron cartas de pago para eliminar.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al eliminar las cartas de pago: ' . $e->getMessage());
        }
    }
    
    public function openStateChangeModal()
    {
        if (empty($this->selectedPlayers)) {
            session()->flash('error', 'Debes seleccionar al menos un jugador.');
            return;
        }
        
        $this->stateChangeCuota = '';
        $this->stateChangeNewState = '';
        $this->showStateChangeModal = true;
    }
    
    public function closeStateChangeModal()
    {
        $this->showStateChangeModal = false;
        $this->stateChangeCuota = '';
        $this->stateChangeNewState = '';
    }
    
    public function bulkUpdateState()
    {
        if (empty($this->selectedPlayers)) {
            session()->flash('error', 'Debes seleccionar al menos un jugador.');
            $this->closeStateChangeModal();
            return;
        }
        
        if ($this->stateChangeCuota === '' || $this->stateChangeNewState === '') {
            session()->flash('error', 'Debes seleccionar una cuota y un estado.');
            return;
        }
        
        try {
            DB::beginTransaction();
            
            // Actualizar el estado de la cuota para los jugadores seleccionados
            $updated = PaymentPlayer::whereIn('player_id', $this->selectedPlayers)
                ->where('cuota', $this->stateChangeCuota)
                ->where('sports_school_id', auth()->user()->sports_school_id)
                ->update([
                    'state' => $this->stateChangeNewState,
                    'payment_date' => $this->stateChangeNewState == 1 ? now() : null,
                    'updated_user' => auth()->user()->id,
                ]);
            
            DB::commit();
            
            // Limpiar selección y resetear página
            $this->selectedPlayers = [];
            $this->selectAll = false;
            $this->closeStateChangeModal();
            $this->resetPage();
            
            if ($updated > 0) {
                $cuotaName = $this->getCuotaName($this->stateChangeCuota);
                $stateName = $this->getStateName($this->stateChangeNewState);
                session()->flash('message', "Se actualizaron correctamente {$updated} " . 
                    ($updated == 1 ? 'pago' : 'pagos') . " de la {$cuotaName} al estado: {$stateName}.");
            } else {
                session()->flash('error', 'No se encontraron pagos para actualizar con los criterios seleccionados.');
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al actualizar los estados: ' . $e->getMessage());
            $this->closeStateChangeModal();
        }
    }
    
    private function getCuotaName($cuota)
    {
        $cuotas = [
            1 => 'Primera cuota',
            2 => 'Segunda cuota',
            3 => 'Tercera cuota',
            4 => 'Cuarta cuota',
            5 => 'Quinta cuota',
            6 => 'Sexta cuota',
            7 => 'Séptima cuota',
            8 => 'Octava cuota',
            9 => 'Novena cuota',
            10 => 'Décima cuota',
            11 => 'Undécima cuota',
            12 => 'Duodécima cuota',
        ];
        return $cuotas[$cuota] ?? "Cuota {$cuota}";
    }
    
    private function getStateName($state)
    {
        $states = [
            0 => 'Pendiente de pago',
            1 => 'Pagado',
            2 => 'Lesión',
            3 => 'Baja Jugador',
        ];
        return $states[$state] ?? 'Desconocido';
    }

    private function generatePlayerPayments($player, $team, $sportsSchoolId)
    {
        $generatedCount = 0;
        $skippedCount = 0;

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
                $skippedCount++;
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
                'amount_original' => $amountOriginal, // Importe original sin descuento
                'amount' => $amountWithDiscount, // Importe con descuento aplicado
                'descEnt' => $descEntApplied, // Descuento en euros aplicado a esta cuota
                'descPerc' => $descPercApplied, // Descuento en porcentaje aplicado
                'created_user' => auth()->id(),
            ]);

            $generatedCount++;
        }

        return [
            'generated' => $generatedCount,
            'skipped' => $skippedCount,
        ];
    }

    public function render()
    {
        // Obtener la temporada activa por defecto
        $activeSeason = Season::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        // Si no hay filtro de temporada, usar la activa
        if (!$this->seasonFilter && $activeSeason) {
            $this->seasonFilter = $activeSeason->id;
        }

        // Obtener jugadores con sus pagos
        $players = $this->getPlayersQuery()->paginate(20);

        // Obtener temporadas y equipos para los filtros
        $seasons = Season::orderBy('from_year', 'desc')->get();
        
        $sportsSchoolId = auth()->user()->sports_school_id;
        $teams = Team::whereHas('season', function($query) use ($sportsSchoolId) {
                $query->where('sports_school_id', $sportsSchoolId);
            })
            ->when($this->seasonFilter, function($query) {
                $query->where('season_id', $this->seasonFilter);
            })
            ->with('category')
            ->orderBy('team')
            ->get();

        // Verificar si hay jugadores sin cartas de pago en la temporada activa
        $hasPlayersWithoutPayments = false;
        if ($activeSeason) {
            $sportsSchoolId = auth()->user()->sports_school_id;
            $hasPlayersWithoutPayments = Player::whereHas('teams', function($query) use ($activeSeason, $sportsSchoolId) {
                    $query->where('season_id', $activeSeason->id)
                        ->whereHas('season', function ($q) use ($sportsSchoolId) {
                            $q->where('sports_school_id', $sportsSchoolId);
                        })
                        ->whereHas('payments'); // Solo equipos con pagos configurados
                })
                ->whereDoesntHave('paymentPlayers', function($query) use ($activeSeason) {
                    $query->whereHas('paymentTeam', function($q) use ($activeSeason) {
                        $q->whereHas('team', function($teamQuery) use ($activeSeason) {
                            $teamQuery->where('season_id', $activeSeason->id);
                        });
                    });
                })
                ->exists();
        }

        // Obtener el número máximo de cuotas de la temporada seleccionada
        $maxCuotas = 12; // Por defecto
        if ($this->seasonFilter) {
            $selectedSeason = Season::find($this->seasonFilter);
            $maxCuotas = $selectedSeason && $selectedSeason->cuota ? $selectedSeason->cuota : 12;
        } elseif ($activeSeason && $activeSeason->cuota) {
            $maxCuotas = $activeSeason->cuota;
        }

        return view('livewire.payment-orders.index', [
            'players' => $players,
            'seasons' => $seasons,
            'teams' => $teams,
            'activeSeason' => $activeSeason,
            'hasPlayersWithoutPayments' => $hasPlayersWithoutPayments,
            'maxCuotas' => $maxCuotas,
        ]);
    }
    
    private function getPlayersQuery()
    {
        // Construir el eager loading condicional para paymentPlayers
        $paymentPlayersQuery = function($query) {
            if ($this->cuotaFilter) {
                $query->where('cuota', $this->cuotaFilter);
            }
            if ($this->pendingPaymentsOnly) {
                $query->where('state', 0);
            }
        };

        return Player::with([
                'paymentPlayers' => $paymentPlayersQuery, 
                'paymentPlayers.paymentTeam', 
                'teams.category', 
                'teams.season'
            ])
            ->when($this->search, function($query) {
                // Dividir la búsqueda en términos individuales
                $searchTerms = array_filter(explode(' ', trim($this->search)));
                
                $query->where(function($q) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $q->orWhere(function($subQ) use ($term) {
                            $subQ->where('name', 'like', '%' . $term . '%')
                                 ->orWhere('surname', 'like', '%' . $term . '%')
                                 ->orWhere('nametutor', 'like', '%' . $term . '%')
                                 ->orWhere('surnametutor', 'like', '%' . $term . '%')
                                 ->orWhere('dni', 'like', '%' . $term . '%')
                                 ->orWhere('dnitutor', 'like', '%' . $term . '%')
                                 ->orWhereHas('paymentPlayers', function($paymentQ) use ($term) {
                                     $paymentQ->where('code', 'like', '%' . $term . '%');
                                 });
                        });
                    }
                });
            })
            ->when($this->seasonFilter, function($query) {
                $query->whereHas('teams', function($q) {
                    $q->where('season_id', $this->seasonFilter);
                });
            })
            ->when($this->teamFilter, function($query) {
                $query->whereHas('teams', function($q) {
                    $q->where('teams.id', $this->teamFilter);
                });
            })
            // Aplicar filtros de pagos: si hay cuotaFilter o pendingPaymentsOnly, aplicarlos juntos
            ->when($this->pendingPaymentsOnly || $this->cuotaFilter, function($query) {
                $query->whereHas('paymentPlayers', function($q) {
                    if ($this->pendingPaymentsOnly) {
                        $q->where('state', 0);
                    }
                    if ($this->cuotaFilter) {
                        $q->where('cuota', $this->cuotaFilter);
                    }
                });
            })
            ->orderBy('name')
            ->orderBy('surname');
    }

    public function highlightText($text, $searchTerms = null)
    {
        if (empty($text)) {
            return '';
        }

        // Si no se pasan términos, usar los del componente
        if ($searchTerms === null) {
            if (empty($this->search)) {
                return e($text);
            }
            $searchTerms = array_filter(explode(' ', trim($this->search)));
        }

        if (empty($searchTerms)) {
            return e($text);
        }

        // Escapar el texto original
        $highlightedText = e($text);

        // Crear un patrón único para todos los términos a la vez
        $patterns = array_map(function($term) {
            return preg_quote($term, '/');
        }, $searchTerms);
        
        $pattern = '/\b(' . implode('|', $patterns) . ')/iu';

        // Resaltar todos los términos en una sola pasada
        $highlightedText = preg_replace(
            $pattern,
            '<mark class="bg-yellow-200 font-semibold">$1</mark>',
            $highlightedText
        );

        return $highlightedText;
    }

    public function exportExcel()
    {
        // Obtener los jugadores con sus pagos usando la misma query que la vista
        $query = $this->getPlayersQuery()->get();

        // Preparar los datos para exportar
        $records = [];
        foreach ($query as $player) {
            foreach ($player->paymentPlayers->sortBy('cuota') as $payment) {
                $dateStart = $payment->paymentTeam ? \Carbon\Carbon::parse($payment->paymentTeam->date_start) : null;
                $dateEnd = $payment->paymentTeam ? \Carbon\Carbon::parse($payment->paymentTeam->date_end) : null;
                
                // Determinar el estado de la cuota
                $now = now();
                if ($payment->state == 1) {
                    $status = 'Pagada';
                } elseif ($payment->state == 2) {
                    $status = 'Lesión';
                } elseif ($payment->state == 3) {
                    $status = 'Baja Jugador';
                } elseif ($dateEnd && $now->isAfter($dateEnd)) {
                    $status = 'Impagada';
                } elseif ($dateStart && $dateEnd && $now->between($dateStart, $dateEnd)) {
                    $status = 'En plazo';
                } elseif ($dateStart && $now->isBefore($dateStart)) {
                    $status = 'No ejecutada';
                } else {
                    $status = 'Pendiente';
                }

                $records[] = (object)[
                    'player_name' => trim(($player->name ?? '') . ' ' . ($player->surname ?? '')),
                    'player_dni' => $player->dni,
                    'tutor_name' => trim(($player->nametutor ?? '') . ' ' . ($player->surnametutor ?? '')),
                    'tutor_dni' => $player->dnitutor,
                    'phone' => $player->phone1 ?? $player->phone2 ?? '',
                    'team' => $player->teams->first()->team ?? '-',
                    'season' => $player->teams->first()->season->season ?? '-',
                    'code' => $payment->code,
                    'cuota' => 'Cuota ' . $payment->cuota,
                    'status' => $status,
                    'amount_original' => number_format($payment->amount_original, 2, ',', '.') . ' €',
                    'amount' => number_format($payment->amount, 2, ',', '.') . ' €',
                    'descEnt' => $payment->descEnt ? number_format($payment->descEnt, 2, ',', '.') . ' €' : '-',
                    'descPerc' => $payment->descPerc ? $payment->descPerc . '%' : '-',
                    'date_start' => $dateStart ? $dateStart->format('d/m/Y') : '-',
                    'date_end' => $dateEnd ? $dateEnd->format('d/m/Y') : '-',
                    'payment_date' => $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') : '-',
                ];
            }
        }

        // Crear el archivo Excel manualmente
        $excel = new ExcelFile(
            Player::class,
            [],
            [
                'player_name' => [
                    'title' => 'Jugador',
                    'value' => '$record->player_name',
                    'type' => 'eval'
                ],
                'player_dni' => [
                    'title' => 'DNI Jugador',
                    'value' => '$record->player_dni',
                    'type' => 'eval'
                ],
                'tutor_name' => [
                    'title' => 'Tutor',
                    'value' => '$record->tutor_name',
                    'type' => 'eval'
                ],
                'tutor_dni' => [
                    'title' => 'DNI Tutor',
                    'value' => '$record->tutor_dni',
                    'type' => 'eval'
                ],
                'phone' => [
                    'title' => 'Teléfono',
                    'value' => '$record->phone',
                    'type' => 'eval'
                ],
                'team' => [
                    'title' => 'Equipo',
                    'value' => '$record->team',
                    'type' => 'eval'
                ],
                'season' => [
                    'title' => 'Temporada',
                    'value' => '$record->season',
                    'type' => 'eval'
                ],
                'code' => [
                    'title' => 'Código de Pago',
                    'value' => '$record->code',
                    'type' => 'eval'
                ],
                'cuota' => [
                    'title' => 'Cuota',
                    'value' => '$record->cuota',
                    'type' => 'eval'
                ],
                'status' => [
                    'title' => 'Estado',
                    'value' => '$record->status',
                    'type' => 'eval'
                ],
                'amount_original' => [
                    'title' => 'Importe Original',
                    'value' => '$record->amount_original',
                    'type' => 'eval'
                ],
                'amount' => [
                    'title' => 'Importe con Descuento',
                    'value' => '$record->amount',
                    'type' => 'eval'
                ],
                'descEnt' => [
                    'title' => 'Descuento (€)',
                    'value' => '$record->descEnt',
                    'type' => 'eval'
                ],
                'descPerc' => [
                    'title' => 'Descuento (%)',
                    'value' => '$record->descPerc',
                    'type' => 'eval'
                ],
                'date_start' => [
                    'title' => 'Fecha Inicio',
                    'value' => '$record->date_start',
                    'type' => 'eval'
                ],
                'date_end' => [
                    'title' => 'Fecha Fin',
                    'value' => '$record->date_end',
                    'type' => 'eval'
                ],
                'payment_date' => [
                    'title' => 'Fecha de Pago',
                    'value' => '$record->payment_date',
                    'type' => 'eval'
                ],
            ],
            'Cartas de Pago',
            [],
            [],
            collect($records)
        );

        return response()->streamDownload(
            fn () => print($excel->generate()),
            'Cartas_de_Pago_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }
}
