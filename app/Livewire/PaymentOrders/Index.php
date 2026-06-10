<?php

namespace App\Livewire\PaymentOrders;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Models\PaymentTeam;
use App\Models\PaymentPlayer;
use App\Models\PaymentCodeSequentials;
use App\Models\ExcelImportRow;
use Illuminate\Support\Facades\DB;
use App\Classes\ExcelFile;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

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
    
    // Modal de transferencias
    public $showTransferModal = false;
    public $transferSearch = '';
    public $transferResults = [];
    public $selectedTransferPayments = []; // Para importación Excel (múltiples)
    public $selectedQuickSearchPayment = null; // Para búsqueda rápida (único)
    public $excelFile = null;
    public $transferCuotaFilter = ''; // Filtro de cuota para importación Excel
    
    // Modal de confirmación de transferencias
    public $showTransferConfirmModal = false;
    public $paymentsToMarkPreview = [];
    
    // Modal de confirmación de generación de cartas de pago
    public $showGenerateConfirmModal = false;
    public $previewGenerateCount = 0;
    public $previewTeamsCount = 0;
    public $previewPlayersCount = 0;

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

    public function prepareGeneratePaymentOrders()
    {
        try {
            // Obtener temporada activa
            $activeSeason = Season::where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();

            if (!$activeSeason) {
                session()->flash('error', 'No hay temporada activa configurada.');
                return;
            }

            $sportsSchoolId = auth()->user()->sports_school_id;
            $totalPaymentsToGenerate = 0;
            $teamsWithPayments = 0;
            $playersToGenerate = [];

            // Obtener equipos de la temporada activa con pagos configurados
            $teams = Team::where('season_id', $activeSeason->id)
                ->whereHas('season', function ($query) use ($sportsSchoolId) {
                    $query->where('sports_school_id', $sportsSchoolId);
                })
                ->with(['players', 'payments'])
                ->get();

            $teamsWithInvalidPayments = [];

            foreach ($teams as $team) {
                // Verificar que el equipo tenga pagos configurados
                if ($team->payments->isEmpty()) {
                    continue;
                }

                $teamHasPlayers = false;

                // Verificar que los pagos tengan cuotas configuradas
                foreach ($team->payments as $payment) {
                    if (empty($payment->cuota) || $payment->cuota <= 0) {
                        $teamsWithInvalidPayments[] = $team->team ?? 'Sin nombre';
                        continue 2; // Saltar al siguiente equipo
                    }
                }

                // Contar jugadores del equipo que necesitan pagos
                foreach ($team->players as $player) {
                    // Verificar cuántas cuotas del equipo no están generadas para este jugador
                    foreach ($team->payments as $payment) {
                        // Verificar si ya existe este pago para el jugador
                        $exists = PaymentPlayer::where('player_id', $player->id)
                            ->where('payment_id', $payment->id)
                            ->where('sports_school_id', $sportsSchoolId)
                            ->exists();
                        
                        if (!$exists) {
                            $totalPaymentsToGenerate++;
                            if (!in_array($player->id, $playersToGenerate)) {
                                $playersToGenerate[] = $player->id;
                            }
                            $teamHasPlayers = true;
                        }
                    }
                }

                if ($teamHasPlayers) {
                    $teamsWithPayments++;
                }
            }
            
            if (!empty($teamsWithInvalidPayments)) {
                $teamsList = implode(', ', array_unique($teamsWithInvalidPayments));
                session()->flash('error', "Los siguientes equipos tienen pagos sin número de cuotas configurado: {$teamsList}. Por favor, configura el número de cuotas en cada pago del equipo.");
                return;
            }
            
            if ($totalPaymentsToGenerate === 0) {
                session()->flash('error', 'No hay cartas de pago nuevas para generar. Todas las cartas ya están generadas para los equipos con pagos configurados.');
                return;
            }
            
            // Guardar datos de preview
            $this->previewGenerateCount = $totalPaymentsToGenerate;
            $this->previewTeamsCount = $teamsWithPayments;
            $this->previewPlayersCount = count($playersToGenerate);
            
            // Mostrar modal de confirmación
            $this->showGenerateConfirmModal = true;

        } catch (\Exception $e) {
            session()->flash('error', 'Error al calcular las cartas de pago: ' . $e->getMessage());
        }
    }

    public function confirmGeneratePaymentOrders()
    {
        $this->showGenerateConfirmModal = false;
        $this->generatePaymentOrders();
    }

    public function closeGenerateConfirmModal()
    {
        $this->showGenerateConfirmModal = false;
        $this->previewGenerateCount = 0;
        $this->previewTeamsCount = 0;
        $this->previewPlayersCount = 0;
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

            $result = $this->generatePlayerPayments($player, $team, $sportsSchoolId, auth()->id());
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
    
    public function openTransferModal()
    {
        $this->transferSearch = '';
        $this->transferResults = [];
        $this->selectedTransferPayments = [];
        $this->selectedQuickSearchPayment = null;
        $this->excelFile = null;
        $this->transferCuotaFilter = '';
        $this->showTransferModal = true;
    }
    
    public function closeTransferModal()
    {
        $this->showTransferModal = false;
        $this->transferSearch = '';
        $this->transferResults = [];
        $this->selectedTransferPayments = [];
        $this->selectedQuickSearchPayment = null;
        $this->excelFile = null;
        $this->transferCuotaFilter = '';
    }
    
    public function clearTransferResults()
    {
        $this->transferSearch = '';
        $this->transferResults = [];
        $this->selectedTransferPayments = [];
        $this->selectedQuickSearchPayment = null;
        $this->excelFile = null;
        $this->transferCuotaFilter = '';
    }

    public function toggleSelectAllTransferPayments()
    {
        $validIds = collect($this->transferResults)
            ->filter(fn($r) => empty($r['no_match']) && isset($r['id']) && $r['id'] !== null && empty($r['from_quick_search']))
            ->pluck('id')
            ->values()
            ->toArray();

        if (count($this->selectedTransferPayments) === count($validIds) && count($validIds) > 0) {
            $this->selectedTransferPayments = [];
        } else {
            $this->selectedTransferPayments = $validIds;
        }
    }
    
    public function searchTransfers()
    {
        $this->transferResults = [];
        
        if (empty($this->transferSearch)) {
            return;
        }
        
        $sportsSchoolId = auth()->user()->sports_school_id;
        $searchTerm = trim($this->transferSearch);
        
        // Dividir el término de búsqueda en palabras individuales
        $searchWords = array_filter(explode(' ', $searchTerm));
        
        // Buscar pagos pendientes por código, nombre jugador, apellido jugador y nombre tutor
        $payments = PaymentPlayer::with(['player', 'paymentTeam'])
            ->where('sports_school_id', $sportsSchoolId)
            ->where('state', 0) // Solo pendientes
            ->where(function($query) use ($searchTerm, $searchWords) {
                // Buscar por código (cadena completa)
                $query->where('code', 'like', '%' . $searchTerm . '%')
                    // Buscar por palabras individuales en jugador/tutor
                    ->orWhereHas('player', function($q) use ($searchWords, $searchTerm) {
                        $q->where(function($subQ) use ($searchWords) {
                            // Buscar cada palabra en los campos individuales
                            foreach ($searchWords as $word) {
                                $subQ->orWhere('name', 'like', '%' . $word . '%')
                                     ->orWhere('surname', 'like', '%' . $word . '%')
                                     ->orWhere('nametutor', 'like', '%' . $word . '%')
                                     ->orWhere('surnametutor', 'like', '%' . $word . '%');
                            }
                        })->orWhere(function($concatQ) use ($searchTerm) {
                            // También buscar la cadena completa en concatenaciones
                            $concatQ->orWhereRaw("CONCAT(name, ' ', surname) LIKE ?", ['%' . $searchTerm . '%'])
                                    ->orWhereRaw("CONCAT(nametutor, ' ', surnametutor) LIKE ?", ['%' . $searchTerm . '%']);
                        });
                    });
            })
            ->orderBy('cuota')
            ->get();
        
        $this->transferResults = $payments->map(function($payment) {
            return [
                'id' => $payment->id,
                'code' => $payment->code,
                'player_name' => $payment->player ? trim(trim($payment->player->name) . ' ' . trim($payment->player->surname)) : '-',
                'player_dni' => $payment->player->dni ?? '-',
                'tutor_name' => $payment->player ? trim(trim($payment->player->nametutor) . ' ' . trim($payment->player->surnametutor)) : '-',
                'cuota' => $payment->cuota,
                'amount' => $payment->amount,
                'team' => $payment->player->teams->first()->team ?? '-',
                'search_term' => $this->transferSearch,
                'from_quick_search' => true, // Marcar que viene de búsqueda rápida
            ];
        })->toArray();
    }
    
    public function highlightTransferText($text, $searchTerm)
    {
        if (empty($text) || empty($searchTerm)) {
            return e($text);
        }
        
        // Escapar el texto primero
        $escapedText = e($text);
        
        // Dividir términos de búsqueda por comas O espacios
        $searchTerms = [];
        if (strpos($searchTerm, ',') !== false) {
            // Si hay comas, dividir por comas
            $searchTerms = array_map('trim', explode(',', $searchTerm));
        } else {
            // Si no hay comas, dividir por espacios (para búsqueda rápida)
            $searchTerms = array_filter(explode(' ', trim($searchTerm)));
        }
        
        if (empty($searchTerms)) {
            return $escapedText;
        }
        
        // Crear un patrón regex con todas las palabras usando alternancia (|)
        // Esto evita que las etiquetas HTML de un reemplazo interfieran con otro
        $patterns = array_map(function($term) {
            return preg_quote($term, '/');
        }, $searchTerms);
        
        $pattern = '/(' . implode('|', $patterns) . ')/iu';
        
        // Hacer todos los reemplazos en una sola pasada
        $escapedText = preg_replace(
            $pattern,
            '<mark class="bg-yellow-200 font-semibold px-1 rounded">$1</mark>',
            $escapedText
        );
        
        return $escapedText;
    }
    
    public function markTransfersAsPaid()
    {
        // Determinar si viene de búsqueda rápida o Excel
        $paymentIds = [];
        if (!empty($this->selectedQuickSearchPayment)) {
            $paymentIds = [$this->selectedQuickSearchPayment];
        } elseif (!empty($this->selectedTransferPayments)) {
            $paymentIds = $this->selectedTransferPayments;
        }
        
        if (empty($paymentIds)) {
            session()->flash('error', 'Debes seleccionar al menos un pago.');
            return;
        }
        
        // Cargar los datos de los pagos seleccionados para previsualización
        $this->paymentsToMarkPreview = PaymentPlayer::with(['player.teams'])
            ->whereIn('id', $paymentIds)
            ->where('sports_school_id', auth()->user()->sports_school_id)
            ->where('state', 0) // Solo los pendientes
            ->get()
            ->map(function($payment) {
                return [
                    'id' => $payment->id,
                    'code' => $payment->code,
                    'player_name' => $payment->player ? trim(trim($payment->player->name) . ' ' . trim($payment->player->surname)) : '-',
                    'tutor_name' => $payment->player ? trim(trim($payment->player->nametutor) . ' ' . trim($payment->player->surnametutor)) : '-',
                    'team' => $payment->player->teams->first()->team ?? '-',
                    'cuota' => $payment->cuota,
                    'amount' => $payment->amount,
                    'descEnt' => $payment->descEnt ?? 0,
                    'descPerc' => $payment->descPerc ?? 0,
                ];
            })
            ->toArray();
        
        if (empty($this->paymentsToMarkPreview)) {
            session()->flash('error', 'No se encontraron pagos pendientes para actualizar.');
            return;
        }
        
        // Mostrar modal de confirmación
        $this->showTransferConfirmModal = true;
    }
    
    public function confirmMarkTransfersAsPaid()
    {
        // Determinar si viene de búsqueda rápida o Excel
        $paymentIds = [];
        if (!empty($this->selectedQuickSearchPayment)) {
            $paymentIds = [$this->selectedQuickSearchPayment];
        } elseif (!empty($this->selectedTransferPayments)) {
            $paymentIds = $this->selectedTransferPayments;
        }
        
        if (empty($paymentIds)) {
            session()->flash('error', 'Debes seleccionar al menos un pago.');
            $this->closeTransferConfirmModal();
            return;
        }
        
        try {
            DB::beginTransaction();
            
            $sportsSchoolId = auth()->user()->sports_school_id;
            
            $updated = PaymentPlayer::whereIn('id', $paymentIds)
                ->where('sports_school_id', $sportsSchoolId)
                ->where('state', 0) // Solo actualizar los que están pendientes
                ->update([
                    'state' => 1, // Pagado
                    'payment_date' => now(),
                    'payment_type' => 'Transferencia',
                    'updated_user' => auth()->user()->id,
                ]);
            
            // Registrar las filas procesadas exitosamente (solo para importación Excel)
            if ($updated > 0 && !empty($this->selectedTransferPayments)) {
                foreach ($this->transferResults as $result) {
                    // Solo registrar los que fueron seleccionados y no tienen errores
                    if (in_array($result['id'], $paymentIds) && 
                        isset($result['row_hash']) && 
                        !isset($result['no_match'])) {
                        
                        // Verificar si no existe ya el registro (por si acaso)
                        if (!ExcelImportRow::isRowProcessed($result['row_hash'], $sportsSchoolId)) {
                            ExcelImportRow::registerRow($result['row_hash'], $sportsSchoolId, $result['id']);
                        }
                    }
                }
            }
            
            DB::commit();
            
            $this->closeTransferConfirmModal();
            $this->closeTransferModal();
            $this->resetPage();
            
            if ($updated > 0) {
                session()->flash('message', "Se marcaron correctamente {$updated} " . 
                    ($updated == 1 ? 'pago' : 'pagos') . " como pagado(s) por transferencia.");
            } else {
                session()->flash('error', 'No se encontraron pagos pendientes para actualizar.');
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al marcar los pagos: ' . $e->getMessage());
            $this->closeTransferConfirmModal();
            $this->closeTransferModal();
        }
    }
    
    public function closeTransferConfirmModal()
    {
        $this->showTransferConfirmModal = false;
        $this->paymentsToMarkPreview = [];
    }
    
    public function importExcelTransfers()
    {
        // Limpiar selección de búsqueda rápida
        $this->selectedQuickSearchPayment = null;
        
        $this->validate([
            'excelFile' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ], [
            'excelFile.required' => 'Debes seleccionar un archivo Excel.',
            'excelFile.mimes' => 'El archivo debe ser de tipo Excel (xlsx, xls o csv).',
            'excelFile.max' => 'El archivo no debe superar los 10MB.',
        ]);
        
        try {
            $sportsSchoolId = auth()->user()->sports_school_id;
            $filePath = $this->excelFile->getRealPath();
            
            // Leer el archivo Excel
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            $results = [];
            $processedCount = 0;
            $foundPaymentIds = []; // Para evitar duplicados
            $skippedRows = 0; // Contador de filas ya procesadas
            
            // Procesar cada fila
            foreach ($rows as $rowIndex => $row) {
                // Saltar filas vacías
                if (empty(array_filter($row))) {
                    continue;
                }
                
                // Calcular hash de la fila para verificar si ya fue procesada
                $rowHash = ExcelImportRow::generateRowHash($row);
                
                // Verificar si esta fila ya fue procesada anteriormente
                if (ExcelImportRow::isRowProcessed($rowHash, $sportsSchoolId)) {
                    $skippedRows++;
                    continue;
                }
                
                // Concatenar toda la fila para análisis
                $rowText = implode(' ', array_filter($row, function($value) {
                    return !empty(trim($value));
                }));
                
                // Concatenar fila separada por "/" para mostrar si no hay coincidencia
                $rowDescription = implode(' / ', array_filter(array_map('trim', $row), function($value) {
                    return !empty($value);
                }));
                
                $foundInThisRow = false;
                
                // ===== PASO 1: BUSCAR POR CÓDIGO (PRIORIDAD MÁXIMA) =====
                // Extraer códigos de pago (7-10 dígitos + letra opcional)
                // Permite códigos pegados a palabras (ej: "PAGO2612244P")
                preg_match_all('/(?<!\d)\d{7,10}[A-Z]?(?!\d)/i', $rowText, $codeMatches);
                $extractedCodes = array_unique(array_map('strtoupper', $codeMatches[0]));
                
                if (!empty($extractedCodes)) {
                    foreach ($extractedCodes as $code) {
                        // Buscar pagos por código EXACTO (solo pendientes)
                        $payments = PaymentPlayer::with(['player.teams'])
                            ->where('sports_school_id', $sportsSchoolId)
                            ->where('code', $code)
                            ->where('state', 0)
                            ->when(!empty($this->transferCuotaFilter), fn($q) => $q->where('cuota', $this->transferCuotaFilter))
                            ->get();
                        
                        if ($payments->count() > 0) {
                            $foundInThisRow = true;
                            
                            // Encontrar la celda que contiene este código
                            $cellReference = 'A' . ($rowIndex + 1);
                            $cellContent = $rowText;
                            
                            foreach ($row as $colIndex => $cellValue) {
                                if (empty($cellValue)) continue;
                                $cellValue = trim($cellValue);
                                
                                if (stripos($cellValue, $code) !== false) {
                                    $cellReference = $this->getColumnLetter($colIndex) . ($rowIndex + 1);
                                    $cellContent = $cellValue;
                                    break;
                                }
                            }
                            
                            // Agregar cada pago encontrado
                            foreach ($payments as $payment) {
                                if (!in_array($payment->id, $foundPaymentIds)) {
                                    $foundPaymentIds[] = $payment->id;
                                    
                                    $results[] = [
                                        'id' => $payment->id,
                                        'code' => $payment->code,
                                        'player_name' => $payment->player ? trim(trim($payment->player->name) . ' ' . trim($payment->player->surname)) : '-',
                                        'player_dni' => $payment->player->dni ?? '-',
                                        'tutor_name' => $payment->player ? trim(trim($payment->player->nametutor) . ' ' . trim($payment->player->surnametutor)) : '-',
                                        'cuota' => $payment->cuota,
                                        'amount' => $payment->amount,
                                        'team' => $payment->player->teams->first()->team ?? '-',
                                        'search_term' => $code,
                                        'excel_cell' => $cellReference,
                                        'excel_cell_content' => $cellContent,
                                        'no_match' => false,
                                        'row_hash' => $rowHash,
                                    ];
                                    $processedCount++;
                                }
                            }
                            
                            break; // Solo procesar el primer código encontrado en la fila
                        }
                    }
                }
                
                // ===== PASO 2: BUSCAR POR NOMBRE/APELLIDO (si no se encontró por código) =====
                if (!$foundInThisRow) {
                    // Extraer palabras del texto de la fila (ignorar números y palabras muy cortas)
                    $nameWords = array_values(array_unique(array_filter(
                        preg_split('/[\s,;\/\-\.]+/u', $rowText),
                        function($w) { return mb_strlen(trim($w)) >= 3 && !is_numeric(trim($w)); }
                    )));
                    
                    if (!empty($nameWords)) {
                        // Buscar pagos pendientes donde nombre Y apellido del jugador aparezcan en la fila
                        $matchedPayments = PaymentPlayer::with(['player.teams'])
                            ->where('sports_school_id', $sportsSchoolId)
                            ->where('state', 0)
                            ->when(!empty($this->transferCuotaFilter), fn($q) => $q->where('cuota', $this->transferCuotaFilter))
                            ->whereHas('player', function($q) use ($nameWords) {
                                $q->where(function($subQ) use ($nameWords) {
                                    foreach ($nameWords as $word) {
                                        $subQ->orWhere('name', 'like', '%' . $word . '%')
                                             ->orWhere('surname', 'like', '%' . $word . '%');
                                    }
                                });
                            })
                            ->get()
                            ->filter(function($payment) use ($rowText) {
                                // Verificar que TANTO nombre COMO apellido estén presentes en la fila
                                $player = $payment->player;
                                if (!$player) return false;
                                $nameInRow = !empty($player->name) && mb_stripos($rowText, trim($player->name)) !== false;
                                $surnameInRow = !empty($player->surname) && mb_stripos($rowText, trim($player->surname)) !== false;
                                return $nameInRow && $surnameInRow;
                            });
                        
                        if ($matchedPayments->count() > 0) {
                            $foundInThisRow = true;
                            
                            // Encontrar la primera celda no vacía
                            $cellReference = 'A' . ($rowIndex + 1);
                            $cellContent = $rowText;
                            foreach ($row as $colIndex => $cellValue) {
                                if (!empty(trim($cellValue))) {
                                    $cellReference = $this->getColumnLetter($colIndex) . ($rowIndex + 1);
                                    $cellContent = trim($cellValue);
                                    break;
                                }
                            }
                            
                            foreach ($matchedPayments as $payment) {
                                if (!in_array($payment->id, $foundPaymentIds)) {
                                    $foundPaymentIds[] = $payment->id;
                                    $playerSearchTerm = trim(($payment->player->name ?? '') . ' ' . ($payment->player->surname ?? ''));
                                    
                                    $results[] = [
                                        'id' => $payment->id,
                                        'code' => $payment->code,
                                        'player_name' => trim(trim($payment->player->name ?? '') . ' ' . trim($payment->player->surname ?? '')),
                                        'player_dni' => $payment->player->dni ?? '-',
                                        'tutor_name' => trim(trim($payment->player->nametutor ?? '') . ' ' . trim($payment->player->surnametutor ?? '')),
                                        'cuota' => $payment->cuota,
                                        'amount' => $payment->amount,
                                        'team' => $payment->player->teams->first()->team ?? '-',
                                        'search_term' => $playerSearchTerm,
                                        'excel_cell' => $cellReference,
                                        'excel_cell_content' => $cellContent,
                                        'no_match' => false,
                                        'row_hash' => $rowHash,
                                        'matched_by' => 'name',
                                    ];
                                    $processedCount++;
                                }
                            }
                        }
                    }
                }
                
                // Si no se encontró ninguna coincidencia en esta fila, registrarla como "sin coincidencia"
                if (!$foundInThisRow) {
                    // Encontrar la primera celda no vacía
                    $firstCellRef = 'A' . ($rowIndex + 1);
                    $firstCellContent = $rowDescription;
                    
                    foreach ($row as $colIndex => $cellValue) {
                        if (!empty(trim($cellValue))) {
                            $firstCellRef = $this->getColumnLetter($colIndex) . ($rowIndex + 1);
                            break;
                        }
                    }
                    
                    $results[] = [
                        'id' => null,
                        'code' => '-',
                        'player_name' => '-',
                        'player_dni' => '-',
                        'tutor_name' => '-',
                        'cuota' => '-',
                        'amount' => '-',
                        'team' => '-',
                        'search_term' => '',
                        'excel_cell' => $firstCellRef,
                        'excel_cell_content' => $firstCellContent,
                        'no_match' => true,
                        'row_hash' => $rowHash,
                    ];
                }
            }
            
            // ===== DETECTAR DUPLICADOS POR CELDA EXCEL =====
            // Agrupar resultados por celda Excel (solo los que tienen coincidencia)
            $resultsByCell = [];
            foreach ($results as $index => $result) {
                if (!isset($result['no_match']) || !$result['no_match']) {
                    $cell = $result['excel_cell'];
                    if (!isset($resultsByCell[$cell])) {
                        $resultsByCell[$cell] = [];
                    }
                    $resultsByCell[$cell][] = $index;
                }
            }
            
            // Marcar como duplicados las celdas con múltiples pagos
            $duplicateCount = 0;
            foreach ($resultsByCell as $cell => $indices) {
                if (count($indices) > 1) {
                    // Esta celda tiene múltiples pagos
                    foreach ($indices as $index) {
                        $results[$index]['duplicate_cell'] = true;
                        $results[$index]['duplicate_count'] = count($indices);
                    }
                    $duplicateCount += count($indices);
                }
            }
            
            // Contar filas sin coincidencia
            $withoutMatch = 0;
            foreach ($results as $result) {
                if (isset($result['no_match']) && $result['no_match']) {
                    $withoutMatch++;
                }
            }
            
            // Limpiar el archivo
            $this->excelFile = null;
            
            if (count($results) > 0) {
                $this->transferResults = $results;
                
                // Construir mensaje
                $message = "";
                
                if ($processedCount > 0) {
                    $message = "Se encontraron {$processedCount} códigos de pago pendientes en el archivo Excel.";
                }
                
                if ($withoutMatch > 0) {
                    if (!empty($message)) $message .= " ";
                    $message .= "⚠ {$withoutMatch} " . ($withoutMatch === 1 ? 'fila sin coincidencia' : 'filas sin coincidencias') . " (marcadas en rojo).";
                }
                
                if ($skippedRows > 0) {
                    $message .= " Se omitieron {$skippedRows} " . ($skippedRows == 1 ? 'fila ya procesada' : 'filas ya procesadas') . ".";
                }
                
                if ($duplicateCount > 0) {
                    session()->flash('warning', $message . " ADVERTENCIA: {$duplicateCount} códigos tienen la misma celda Excel (marcados en naranja). Selecciona manualmente solo uno de cada grupo.");
                } elseif ($processedCount > 0) {
                    session()->flash('message', $message);
                } else {
                    // Solo hay filas sin coincidencia
                    session()->flash('info', $message);
                }
            } else {
                if ($skippedRows > 0) {
                    session()->flash('message', "Todas las filas del archivo Excel ya fueron procesadas anteriormente ({$skippedRows} " . ($skippedRows == 1 ? 'fila omitida' : 'filas omitidas') . "). Solo se buscan códigos de pago en el Excel.");
                } else {
                    session()->flash('info', 'No se encontraron códigos de pago pendientes en el archivo Excel. NOTA: La búsqueda detecta códigos de 7-10 dígitos (ej: "2612244P") incluso si están pegados a palabras (ej: "PAGO2612244P").');
                }
            }
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al procesar el archivo Excel: ' . $e->getMessage());
            $this->excelFile = null;
        }
    }
    
    public function downloadTransferTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Transferencias');

        // Cabeceras
        $headers = [
            'A' => 'Código de Pago',
            'B' => 'Nombre Jugador',
            'C' => 'Apellido Jugador',
            'D' => 'Nombre Tutor',
            'E' => 'Apellido Tutor',
        ];

        foreach ($headers as $col => $title) {
            $sheet->setCellValue($col . '1', $title);
            $sheet->getStyle($col . '1')->applyFromArray([
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF7C3AED']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ]);
            $sheet->getColumnDimension($col)->setWidth(25);
        }

        // Filas de ejemplo
        $examples = [
            ['2612244', 'Juan', 'García', 'Pedro', 'García'],
            ['2612245', 'María', 'López', '', ''],
            ['', 'Carlos', 'Martínez', 'Ana', 'Martínez'],
        ];
        foreach ($examples as $rowIdx => $example) {
            $cols = ['A', 'B', 'C', 'D', 'E'];
            foreach ($cols as $i => $col) {
                $sheet->setCellValue($col . ($rowIdx + 2), $example[$i]);
            }
            $sheet->getStyle('A' . ($rowIdx + 2) . ':E' . ($rowIdx + 2))->applyFromArray([
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF5F3FF']],
            ]);
        }

        // Nota informativa (sin mergeCells para evitar el error "celda combinada" al pegar datos)
        $noteRow = count($examples) + 3;
        $sheet->setCellValue('A' . $noteRow, 'NOTA: Puedes rellenar código de pago Y/O nombre+apellido del jugador. El sistema buscará por ambos criterios.');
        $sheet->getStyle('A' . $noteRow)->applyFromArray([
            'font' => ['italic' => true, 'color' => ['argb' => 'FF6B7280']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFFBEB']],
        ]);
        $sheet->getColumnDimension('A')->setWidth(70);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        return response()->streamDownload(
            fn () => $writer->save('php://output'),
            'Plantilla_Transferencias.xlsx'
        );
    }

    private function getColumnLetter($colIndex)
    {
        $letter = '';
        while ($colIndex >= 0) {
            $letter = chr($colIndex % 26 + 65) . $letter;
            $colIndex = floor($colIndex / 26) - 1;
        }
        return $letter;
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
        $result = generatePlayerPayments($player, $team, $sportsSchoolId, auth()->id());
        
        return [
            'generated' => $result['generated'] + $result['restored'],
            'skipped' => $result['skipped'],
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
            // Excluir explícitamente los pagos soft deleted
            $query->whereNull('deleted_at');
            
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
                // Mostrar jugadores que TENGAN EQUIPO en la temporada O que TENGAN CARTAS DE PAGO de esa temporada
                // Esto permite ver jugadores con pagos aunque no tengan equipo actualmente
                $query->where(function($q) {
                    $q->whereHas('teams', function($teamQ) {
                        $teamQ->where('season_id', $this->seasonFilter);
                    })
                    ->orWhereHas('paymentPlayers', function($paymentQ) {
                        $paymentQ->whereHas('paymentTeam', function($teamPaymentQ) {
                            $teamPaymentQ->whereHas('team', function($teamQ) {
                                $teamQ->where('season_id', $this->seasonFilter);
                            });
                        });
                    });
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
                    // Excluir pagos soft deleted
                    $q->whereNull('deleted_at');
                    if ($this->pendingPaymentsOnly) {
                        $q->where('state', 0);
                    }
                    if ($this->cuotaFilter) {
                        $q->where('cuota', $this->cuotaFilter);
                    }
                });
            })
            // Asegurar que se muestren TODOS los jugadores con cartas de pago, independientemente de active
            // (no aplicar filtro por active para permitir ver jugadores inactivos con pagos)
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
