<?php

namespace App\Livewire\Teams;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Team;
use App\Models\Category;
use App\Models\Season;
use App\Models\Section;
use App\Models\User;
use App\Models\Player;
use App\Classes\PdfFile;
use App\Classes\ExcelFile;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;
    
    public Team $team;
    
    public $teamName = '';
    public $description = '';
    public $category_id = '';
    public $season_id = '';
    public $section_id = '';
    public $selectedCoaches = [];
    public $teamImage;
    public $gender = 'mixto';
    public $price = null;
    public $federate = false;
    public $published = false;
    public $hasChanges = false;
    
    // Gestión de jugadores
    public $searchPlayer = '';
    public $showMovePlayerModal = false;
    public $playerToMove = null;
    public $playerToMoveName = '';
    public $targetTeamId = null;
    public $confirmingPlayerRemoval = false;
    public $playerToRemove = null;
    public $paymentsToDeleteRemove = [];
    public $paymentsPaidRemove = [];
    
    // Edición de jugador
    public $showEditPlayerModal = false;
    public $editingPlayerId = null;
    public $editPlayerName = '';
    public $editPlayerSurname = '';
    public $editPlayerDni = '';
    public $editPlayerDbirth = '';
    public $editPlayerDbanio = '';
    public $editPlayerShirtNumber = '';
    public $editPlayerSize = '';
    public $file = false; // Nueva propiedad para la ficha completa
    public $observations = '';
    public $showSizesModal = false;
    
    // Previsualización de pagos al mover jugador
    public $showPreviewModal = false;
    public $paymentsToDelete = [];
    public $paymentsToCreate = [];
    public $paymentsPaid = [];
    public $selectedPaymentsToDelete = [];
    public $selectedPaymentsToCreate = [];
    
    // Agregar jugadores
    public $showAddPlayerModal = false;
    public $searchAvailablePlayer = '';
    public $selectedPlayersToAdd = [];
    public $filterByCategory = true;
    
    // Gestión de entrenadores
    public $showAddCoachModal = false;
    public $searchCoach = '';
    public $confirmingCoachRemoval = false;
    public $coachToRemove = null;
    
    // Eliminar equipo
    public $confirmingDeletion = false;
    
    // PDF Generation
    public $showPdfModal = false;
    public $selectedColumns = [];
    public $availableColumns = [
        'name' => 'Nombre',
        'surname' => 'Apellidos',
        'dni' => 'DNI',
        'phone1' => 'Teléfono jugador',
        'dbirth' => 'Fecha Nacimiento',
        'dbanio' => 'Año Nacimiento',
        'position' => 'Posición',
        'shirt_number' => 'Dorsal',
        'sizes' => 'Tallas',
        'nametutor' => 'Nombre Tutor',
        'surnametutor' => 'Apellidos Tutor',
        'phone2' => 'Teléfono tutor',
        'dnitutor' => 'DNI Tutor',
        'address' => 'Dirección',
        'town' => 'Localidad',
        'province' => 'Provincia',
        'zip' => 'Código Postal',
        'email' => 'Email',
    ];
    
    // Valores originales para detectar cambios
    private $originalTeamName;
    private $originalDescription;
    private $originalGender;
    private $originalPrice;
    private $originalFederate;
    private $originalPublished;
    private $originalCategoryId;
    private $originalSeasonId;
    private $originalSectionId;
    private $originalSelectedCoaches = [];

    protected function rules()
    {
        return [
            'teamName' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'federate' => 'boolean',
            'published' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'season_id' => 'required|exists:seasons,id',
            'section_id' => 'required|exists:sections,id',
        ];
    }

    protected $messages = [
        'teamName.required' => 'El nombre del equipo es obligatorio.',
        'category_id.required' => 'La categoría es obligatoria.',
        'season_id.required' => 'La temporada es obligatoria.',
        'section_id.required' => 'La sección es obligatoria.',
    ];

    public function mount(Team $team)
    {
        $this->team = $team;
        $this->teamName = $team->team;
        $this->description = $team->description;
        $this->category_id = $team->category_id;
        $this->season_id = $team->season_id;
        $this->section_id = $team->section_id;
        $this->gender = $team->gender;
        $this->price = $team->price;
        $this->federate = $team->federate;
        $this->published = $team->published;
        
        // Cargar entrenadores actuales del equipo
        $this->selectedCoaches = $team->coaches->pluck('id')->toArray();
        
        // Guardar valores originales para detectar cambios
        $this->originalTeamName = $this->teamName;
        $this->originalDescription = $this->description ?? '';
        $this->originalGender = $this->gender;
        $this->originalPrice = $this->price;
        $this->originalFederate = $this->federate;
        $this->originalPublished = $this->published;
        $this->originalCategoryId = $this->category_id;
        $this->originalSeasonId = $this->season_id;
        $this->originalSectionId = $this->section_id;
        $this->originalSelectedCoaches = $this->selectedCoaches;
    }
    
    public function updated($propertyName)
    {
        // Detectar cambios en cualquier propiedad
        $this->checkForChanges();
    }
    
    public function updatedPrice($value)
    {
        // Handle different decimal separator formats
        if ($value) {
            // Remove spaces
            $cleanValue = str_replace(' ', '', $value);
            
            // Detect format: if there's both dot and comma, determine which is decimal separator
            if (strpos($cleanValue, '.') !== false && strpos($cleanValue, ',') !== false) {
                // If comma comes after dot, comma is decimal separator (1.502,65)
                if (strrpos($cleanValue, ',') > strrpos($cleanValue, '.')) {
                    $cleanValue = str_replace('.', '', $cleanValue); // Remove thousands separator
                    $cleanValue = str_replace(',', '.', $cleanValue); // Convert comma to dot
                } else {
                    // If dot comes after comma, dot is decimal separator (1,502.65)
                    $cleanValue = str_replace(',', '', $cleanValue); // Remove thousands separator
                }
            } elseif (strpos($cleanValue, ',') !== false) {
                // Only comma present
                $parts = explode(',', $cleanValue);
                // If exactly 3 digits after comma, it's a thousands separator (1,500 = 1500)
                if (count($parts) == 2 && strlen($parts[1]) == 3 && ctype_digit($parts[1])) {
                    $cleanValue = str_replace(',', '', $cleanValue);
                } else {
                    // Otherwise it's a decimal separator (156,9)
                    $cleanValue = str_replace(',', '.', $cleanValue);
                }
            } elseif (strpos($cleanValue, '.') !== false) {
                // Only dot present
                $parts = explode('.', $cleanValue);
                // If exactly 3 digits after dot, it's a thousands separator (1.500 = 1500)
                if (count($parts) == 2 && strlen($parts[1]) == 3 && ctype_digit($parts[1])) {
                    $cleanValue = str_replace('.', '', $cleanValue);
                }
                // Otherwise it's already in correct format (156.9)
            }
            
            // Clean any remaining non-numeric characters except dot
            $cleanValue = preg_replace('/[^0-9.]/', '', $cleanValue);
            
            // Ensure only one decimal point remains
            $parts = explode('.', $cleanValue);
            if (count($parts) > 2) {
                $cleanValue = $parts[0] . '.' . implode('', array_slice($parts, 1));
            }
            
            $this->price = $cleanValue;
        }
        
        $this->checkForChanges();
    }
    
    private function checkForChanges()
    {
        $this->hasChanges = 
            $this->teamName !== $this->originalTeamName ||
            ($this->description ?? '') !== $this->originalDescription ||
            $this->gender !== $this->originalGender ||
            $this->price !== $this->originalPrice ||
            $this->federate !== $this->originalFederate ||
            $this->published !== $this->originalPublished ||
            $this->category_id !== $this->originalCategoryId ||
            $this->season_id !== $this->originalSeasonId ||
            $this->section_id !== $this->originalSectionId;
    }

    public function save()
    {
        $this->validate();

        $dataToUpdate = [
            'team' => $this->teamName,
            'description' => $this->description,
            'gender' => $this->gender,
            'price' => $this->price,
            'federate' => $this->federate,
            'published' => $this->published,
            'category_id' => $this->category_id,
            'season_id' => $this->season_id,
            'section_id' => $this->section_id,
            'updated_user' => auth()->id(),
        ];

        // Manejar la subida de la imagen si hay una nueva
        if ($this->teamImage) {
            // Eliminar la imagen anterior si existe
            if ($this->team->team_image) {
                Storage::disk('public')->delete($this->team->team_image);
            }
            
            // Guardar la nueva imagen
            $path = $this->teamImage->store('team-images', 'public');
            $dataToUpdate['team_image'] = $path;
        }

        $this->team->update($dataToUpdate);

        // Ya no sincronizamos entrenadores aquí porque se gestionan individualmente
        // con los métodos addCoach() y removeCoach()

        // Actualizar valores originales después de guardar
        $this->originalTeamName = $this->teamName;
        $this->originalDescription = $this->description ?? '';
        $this->originalGender = $this->gender;
        $this->originalPrice = $this->price;
        $this->originalFederate = $this->federate;
        $this->originalPublished = $this->published;
        $this->originalCategoryId = $this->category_id;
        $this->originalSeasonId = $this->season_id;
        $this->originalSectionId = $this->section_id;

        // Resetear flag de cambios
        $this->hasChanges = false;

        session()->flash('message', 'Equipo actualizado correctamente.');
    }

    public function confirmRemovePlayer($playerId)
    {
        $this->playerToRemove = $playerId;
        
        // Obtener temporada activa
        $activeSeason = \App\Models\Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('inscription_start_at', '<=', now())
            ->where('inscription_end_at', '>=', now())
            ->first();

        if (!$activeSeason) {
            session()->flash('error', 'No hay temporada activa configurada.');
            return;
        }

        $player = \App\Models\Player::find($playerId);
        if (!$player) {
            session()->flash('error', 'Jugador no encontrado.');
            return;
        }

        $this->paymentsToDeleteRemove = [];
        $this->paymentsPaidRemove = [];

        // Obtener pagos pendientes del jugador en la temporada activa
        $pendingPayments = \App\Models\PaymentPlayer::with('paymentTeam')
            ->where('player_id', $playerId)
            ->where('sports_school_id', auth()->user()->sports_school_id)
            ->where('state', 0)
            ->whereHas('paymentTeam', function($query) use ($activeSeason) {
                $query->where('season_id', $activeSeason->id);
            })
            ->get();

        foreach ($pendingPayments as $payment) {
            $this->paymentsToDeleteRemove[] = [
                'id' => $payment->id,
                'player_id' => $player->id,
                'player_name' => $player->name . ' ' . $player->surname,
                'code' => $payment->code,
                'cuota' => $payment->cuota,
                'amount' => $payment->amount,
                'description' => $payment->paymentTeam->description ?? 'N/A',
            ];
        }

        // Obtener pagos pagados para mostrarlos
        $paidPayments = \App\Models\PaymentPlayer::with('paymentTeam')
            ->where('player_id', $playerId)
            ->where('sports_school_id', auth()->user()->sports_school_id)
            ->where('state', 1)
            ->whereHas('paymentTeam', function($query) use ($activeSeason) {
                $query->where('season_id', $activeSeason->id);
            })
            ->get();

        foreach ($paidPayments as $payment) {
            $this->paymentsPaidRemove[] = [
                'player_name' => $player->name . ' ' . $player->surname,
                'code' => $payment->code,
                'cuota' => $payment->cuota,
                'amount' => $payment->amount,
                'description' => $payment->paymentTeam->description ?? 'N/A',
                'payment_date' => $payment->payment_date ? $payment->payment_date->format('d/m/Y') : 'N/A',
            ];
        }
        
        $this->confirmingPlayerRemoval = true;
    }

    public function removePlayer()
    {
        if ($this->playerToRemove) {
            try {
                \DB::beginTransaction();

                $deletedCount = 0;

                // Eliminar todos los pagos pendientes
                foreach ($this->paymentsToDeleteRemove as $paymentInfo) {
                    $payment = \App\Models\PaymentPlayer::find($paymentInfo['id']);
                    if ($payment) {
                        $payment->delete();
                        $deletedCount++;
                    }
                }

                // Eliminar la relación (soft delete en la tabla pivote)
                $this->team->players()->updateExistingPivot($this->playerToRemove, [
                    'deleted_at' => now(),
                    'updated_user' => auth()->id()
                ]);

                \DB::commit();

                $message = 'Jugador eliminado del equipo correctamente.';
                if ($deletedCount > 0) {
                    $message .= " Se eliminaron {$deletedCount} cartas de pago pendientes.";
                }
                if (count($this->paymentsPaidRemove) > 0) {
                    $message .= " Se mantienen " . count($this->paymentsPaidRemove) . " cartas de pago ya abonadas.";
                }
                
                session()->flash('message', $message);

            } catch (\Exception $e) {
                \DB::rollBack();
                session()->flash('error', 'Error al eliminar el jugador: ' . $e->getMessage());
            }
        }
        
        $this->confirmingPlayerRemoval = false;
        $this->playerToRemove = null;
        $this->paymentsToDeleteRemove = [];
        $this->paymentsPaidRemove = [];
    }

    public function openMovePlayerModal($playerId)
    {
        $this->playerToMove = $playerId;
        $player = \App\Models\Player::find($playerId);
        $this->playerToMoveName = $player ? $player->name . ' ' . $player->surname : '';
        $this->targetTeamId = null;
        $this->showMovePlayerModal = true;
    }

    public function movePlayer()
    {
        if (!$this->playerToMove || !$this->targetTeamId) {
            session()->flash('error', 'Debe seleccionar un equipo de destino.');
            return;
        }

        if ($this->targetTeamId == $this->team->id) {
            session()->flash('error', 'No puede mover el jugador al mismo equipo.');
            return;
        }

        // Obtener temporada activa
        $activeSeason = \App\Models\Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$activeSeason) {
            session()->flash('error', 'No hay temporada activa configurada.');
            return;
        }

        // Preparar previsualización de pagos
        $this->preparePaymentsRegeneration();
    }
    
    private function preparePaymentsRegeneration()
    {
        // Obtener temporada activa
        $activeSeason = \App\Models\Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        // Obtener el nuevo equipo
        $newTeam = Team::with(['payments'])->find($this->targetTeamId);

        if (!$newTeam) {
            session()->flash('error', 'Equipo no encontrado.');
            return;
        }

        $this->paymentsToDelete = [];
        $this->paymentsToCreate = [];
        $this->paymentsPaid = [];
        $this->selectedPaymentsToDelete = [];
        $this->selectedPaymentsToCreate = [];

        $player = \App\Models\Player::find($this->playerToMove);
        if (!$player) return;

        // Obtener pagos pendientes a eliminar
        $pendingPayments = \App\Models\PaymentPlayer::with('paymentTeam')
            ->where('player_id', $this->playerToMove)
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
        $paidCuotas = \App\Models\PaymentPlayer::where('player_id', $this->playerToMove)
            ->where('sports_school_id', auth()->user()->sports_school_id)
            ->where('state', 1)
            ->whereHas('paymentTeam', function($query) use ($activeSeason) {
                $query->where('season_id', $activeSeason->id);
            })
            ->with('paymentTeam')
            ->get()
            ->pluck('cuota')
            ->toArray();

        // Mostrar pagos pagados que se mantendrán
        $paidPayments = \App\Models\PaymentPlayer::with('paymentTeam')
            ->where('player_id', $this->playerToMove)
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

        $this->showMovePlayerModal = false;
        $this->showPreviewModal = true;
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

            // Verificar que no exista ya esta combinación player_id + payment_id ACTIVA
            $existsActive = \App\Models\PaymentPlayer::where('player_id', $player->id)
                ->where('payment_id', $payment->id)
                ->whereNull('deleted_at')
                ->exists();

            if ($existsActive) {
                continue;
            }

            // Verificar si existe un pago soft deleted para marcarlo como "a restaurar"
            $deletedPayment = \App\Models\PaymentPlayer::withTrashed()
                ->where('player_id', $player->id)
                ->where('payment_id', $payment->id)
                ->whereNotNull('deleted_at')
                ->first();

            // Si existe un pago eliminado, lo agregamos a la lista
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
    
    public function confirmPaymentsAction()
    {
        $this->regeneratePayments();
    }
    
    private function regeneratePayments()
    {
        try {
            \DB::beginTransaction();

            $deletedCount = 0;
            $generatedCount = 0;
            $restoredCount = 0;

            // Eliminar todos los pagos pendientes
            foreach ($this->paymentsToDelete as $paymentInfo) {
                $payment = \App\Models\PaymentPlayer::find($paymentInfo['id']);
                if ($payment) {
                    $payment->delete();
                    $deletedCount++;
                }
            }

            // Crear o restaurar nuevos pagos seleccionados
            foreach ($this->paymentsToCreate as $newPayment) {
                if (in_array($newPayment['unique_id'], $this->selectedPaymentsToCreate)) {
                    // Si es una restauración
                    if (isset($newPayment['is_restore']) && $newPayment['is_restore'] && isset($newPayment['existing_payment_id'])) {
                        $deletedPayment = \App\Models\PaymentPlayer::withTrashed()->find($newPayment['existing_payment_id']);
                        if ($deletedPayment) {
                            $deletedPayment->deleted_at = null;
                            $deletedPayment->state = 0;
                            $deletedPayment->payment_date = null;
                            $deletedPayment->payment_order = null;
                            $deletedPayment->payment_auth = null;
                            $deletedPayment->payment_type = null;
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
                        \App\Models\PaymentPlayer::create([
                            'player_id' => $newPayment['player_id'],
                            'payment_id' => $newPayment['payment_id'],
                            'sports_school_id' => $newPayment['sports_school_id'],
                            'code' => \App\Models\PaymentCodeSequentials::getCode(),
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

            \DB::commit();

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
                $message = "Jugador movido al nuevo equipo correctamente.";
            }
            
            session()->flash('message', trim($message));
            
            // Ejecutar el cambio de equipo
            $this->executePlayerMove();

        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('error', 'Error al regenerar los pagos: ' . $e->getMessage());
        }

        $this->showPreviewModal = false;
        $this->dispatch('modal-closed');
    }
    
    private function executePlayerMove()
    {
        $player = \App\Models\Player::find($this->playerToMove);
        
        if ($player && $player->sports_school_id === auth()->user()->sports_school_id) {
            // Solo desvinculamos el equipo origen (esta sección) para preservar pertenencias a equipos de otras secciones.
            $player->teams()->updateExistingPivot($this->team->id, [
                'deleted_at' => now(),
                'updated_user' => auth()->id(),
            ]);

            // Restaurar si existe un pivote soft-deleted con el equipo destino, si no, adjuntar.
            $existingPivot = \DB::table('teams_players')
                ->where('team_id', $this->targetTeamId)
                ->where('player_id', $player->id)
                ->first();

            if ($existingPivot) {
                \DB::table('teams_players')
                    ->where('id', $existingPivot->id)
                    ->update([
                        'deleted_at' => null,
                        'updated_user' => auth()->id(),
                        'updated_at' => now(),
                    ]);
            } else {
                $player->teams()->attach($this->targetTeamId, [
                    'created_user' => auth()->id(),
                    'updated_user' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        $this->playerToMove = null;
        $this->playerToMoveName = '';
        $this->targetTeamId = null;
        $this->paymentsToDelete = [];
        $this->paymentsToCreate = [];
        $this->paymentsPaid = [];
    }
    
    public function toggleAllPaymentsToCreate($checked)
    {
        if ($checked) {
            $this->selectedPaymentsToCreate = array_column($this->paymentsToCreate, 'unique_id');
        } else {
            $this->selectedPaymentsToCreate = [];
        }
    }

    public function cancelMovePlayer()
    {
        $this->showMovePlayerModal = false;
        $this->playerToMove = null;
        $this->playerToMoveName = '';
        $this->targetTeamId = null;
    }
    
    public function openAddPlayerModal()
    {
        $this->showAddPlayerModal = true;
        $this->searchAvailablePlayer = '';
        $this->selectedPlayersToAdd = [];
    }
    
    public function toggleSelectAllPlayers()
    {
        $availablePlayers = $this->getAvailablePlayersForModal();
        
        if (count($this->selectedPlayersToAdd) === $availablePlayers->count()) {
            // Si todos están seleccionados, deseleccionar todos
            $this->selectedPlayersToAdd = [];
        } else {
            // Si no todos están seleccionados, seleccionar todos
            $this->selectedPlayersToAdd = $availablePlayers->pluck('id')->toArray();
        }
    }
    
    // Gestión de entrenadores
    public function openAddCoachModal()
    {
        $this->showAddCoachModal = true;
        $this->searchCoach = '';
    }
    
    public function closeAddCoachModal()
    {
        $this->showAddCoachModal = false;
        $this->searchCoach = '';
    }
    
    public function addCoach($coachId)
    {
        if (!in_array($coachId, $this->selectedCoaches)) {
            $this->selectedCoaches[] = $coachId;
            $this->team->coaches()->syncWithoutDetaching([$coachId]);
            
            // Actualizar valores originales
            $this->originalSelectedCoaches = $this->selectedCoaches;
            $this->checkForChanges();
            
            session()->flash('message', 'Entrenador añadido correctamente.');
            
            // Cerrar el modal
            $this->closeAddCoachModal();
        }
    }
    
    public function confirmRemoveCoach($coachId)
    {
        $this->coachToRemove = $coachId;
        $this->confirmingCoachRemoval = true;
    }
    
    public function cancelRemoveCoach()
    {
        $this->coachToRemove = null;
        $this->confirmingCoachRemoval = false;
    }
    
    public function removeCoach()
    {
        if ($this->coachToRemove) {
            $this->selectedCoaches = array_diff($this->selectedCoaches, [$this->coachToRemove]);
            $this->team->coaches()->detach($this->coachToRemove);
            
            // Actualizar valores originales
            $this->originalSelectedCoaches = $this->selectedCoaches;
            $this->checkForChanges();
            
            session()->flash('message', 'Entrenador eliminado del equipo correctamente.');
        }
        
        $this->cancelRemoveCoach();
    }
    
    public function addPlayersToTeam()
    {
        if (empty($this->selectedPlayersToAdd)) {
            session()->flash('error', 'Debe seleccionar al menos un jugador.');
            return;
        }
        
        $totalGenerated = 0;
        $totalRestored = 0;
        
        foreach ($this->selectedPlayersToAdd as $playerId) {
            // Verificar si existe un registro eliminado (soft deleted)
            $deletedRecord = \DB::table('teams_players')
                ->where('team_id', $this->team->id)
                ->where('player_id', $playerId)
                ->whereNotNull('deleted_at')
                ->first();
            
            if ($deletedRecord) {
                // Restaurar el registro eliminado
                \DB::table('teams_players')
                    ->where('id', $deletedRecord->id)
                    ->update([
                        'deleted_at' => null,
                        'updated_user' => auth()->id(),
                        'updated_at' => now()
                    ]);
            } else {
                // Verificar si el jugador ya está en el equipo (no eliminado)
                $existsInTeam = $this->team->players()->where('player_id', $playerId)->exists();
                
                if (!$existsInTeam) {
                    $this->team->players()->attach($playerId, [
                        'created_user' => auth()->id(),
                        'updated_user' => auth()->id(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
            
            // Generar pagos para el jugador
            $player = \App\Models\Player::find($playerId);
            if ($player) {
                $result = generatePlayerPayments(
                    $player,
                    $this->team,
                    auth()->user()->sports_school_id,
                    auth()->user()->id
                );
                $totalGenerated += $result['generated'];
                $totalRestored += $result['restored'];
            }
        }
        
        $message = 'Jugador(es) agregado(s) al equipo correctamente.';
        if ($totalGenerated > 0) {
            $message .= " Se generaron {$totalGenerated} cartas de pago.";
        }
        if ($totalRestored > 0) {
            $message .= " Se restauraron {$totalRestored} cartas de pago.";
        }
        
        session()->flash('message', $message);
        
        $this->showAddPlayerModal = false;
        $this->searchAvailablePlayer = '';
        $this->selectedPlayersToAdd = [];
    }
    
    public function cancelAddPlayer()
    {
        $this->showAddPlayerModal = false;
        $this->searchAvailablePlayer = '';
        $this->selectedPlayersToAdd = [];
    }

    public function cancelRemovePlayer()
    {
        $this->confirmingPlayerRemoval = false;
        $this->playerToRemove = null;
        $this->paymentsToDeleteRemove = [];
        $this->paymentsPaidRemove = [];
    }
    
    public function openEditPlayerModal($playerId)
    {
        $player = \App\Models\Player::find($playerId);
        
        if (!$player) {
            session()->flash('error', 'Jugador no encontrado.');
            return;
        }
        
        $this->editingPlayerId = $player->id;
        $this->editPlayerName = $player->name;
        $this->editPlayerSurname = $player->surname;
        $this->editPlayerDni = $player->dni ?? '';
        $this->editPlayerDbirth = $player->dbirth ? $player->dbirth->format('Y-m-d') : '';
        $this->editPlayerDbanio = $player->dbanio ?? '';
        $this->editPlayerShirtNumber = $player->dorsal ?? '';
        $this->observations = $player->observations ?? '';
        $this->editPlayerSize = $player->sizes ?? '';
        $this->file = $player->file ?? false;
        
        $this->showEditPlayerModal = true;
    }
    
    public function closeEditPlayerModal()
    {
        $this->showEditPlayerModal = false;
        $this->editingPlayerId = null;
        $this->editPlayerName = '';
        $this->editPlayerSurname = '';
        $this->editPlayerDni = '';
        $this->editPlayerDbirth = '';
        $this->editPlayerDbanio = '';
        $this->editPlayerShirtNumber = '';
        $this->editPlayerSize = '';
        $this->file = false;
    }
    
    public function openSizesModal()
    {
        $this->showSizesModal = true;
    }
    
    public function closeSizesModal()
    {
        $this->showSizesModal = false;
    }
    
    public function selectSize($sizeId)
    {
        $size = \App\Models\Size::find($sizeId);
        if ($size) {
            $this->editPlayerSize = $size->size;
            $this->closeSizesModal();
        }
    }
    
    public function updatePlayer()
    {
        $this->validate([
            'editPlayerName' => 'required|string|max:255',
            'editPlayerSurname' => 'required|string|max:255',
            'editPlayerDni' => 'nullable|string|max:20',
            'editPlayerDbirth' => 'nullable|date',
            'editPlayerDbanio' => 'nullable|integer|min:1900|max:' . date('Y'),
            'editPlayerShirtNumber' => 'nullable|integer|min:0|max:99',
            'editPlayerSize' => 'nullable|string|max:50',
            'file' => 'nullable|boolean',
            'observations' => 'nullable|string|max:1000',
        ], [
            'editPlayerName.required' => 'El nombre es obligatorio.',
            'editPlayerSurname.required' => 'Los apellidos son obligatorios.',
            'editPlayerDbirth.date' => 'La fecha de nacimiento no es válida.',
            'editPlayerDbanio.integer' => 'El año de nacimiento debe ser un número.',
            'editPlayerDbanio.min' => 'El año de nacimiento no es válido.',
            'editPlayerDbanio.max' => 'El año de nacimiento no puede ser mayor al año actual.',
            'editPlayerShirtNumber.integer' => 'El dorsal debe ser un número.',
        ]);
        
        try {
            $player = \App\Models\Player::find($this->editingPlayerId);
            
            if (!$player) {
                session()->flash('error', 'Jugador no encontrado.');
                return;
            }
            
            $player->name = $this->editPlayerName;
            $player->surname = $this->editPlayerSurname;
            $player->dni = $this->editPlayerDni ?: null;
            $player->dbirth = $this->editPlayerDbirth ?: null;
            $player->dbanio = $this->editPlayerDbanio ?: null;
            $player->dorsal = $this->editPlayerShirtNumber ?: null;
            $player->sizes = $this->editPlayerSize ?: null;
            $player->file = $this->file ?: false;
            $player->observations = $this->observations ?: null;
            $player->save();
            
            $this->closeEditPlayerModal();
            
            session()->flash('message', 'Jugador actualizado correctamente.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el jugador: ' . $e->getMessage());
        }
    }
    
    public function confirmDelete()
    {
        // Verificar si el equipo tiene pagos generados o jugadores
        $team = Team::withCount(['payments', 'players'])->find($this->team->id);
        
        if ($team && $team->payments_count > 0) {
            session()->flash('error', 'No se puede eliminar este equipo porque tiene pagos generados. Debe eliminar los pagos primero desde la sección de Generar Pagos.');
            return;
        }
        
        if ($team && $team->players_count > 0) {
            session()->flash('error', 'No se puede eliminar este equipo porque tiene jugadores asignados. Debe reasignar o eliminar los jugadores primero.');
            return;
        }
        
        $this->confirmingDeletion = true;
    }
    
    public function deleteTeam()
    {
        // Eliminar imagen del equipo si existe
        if ($this->team->team_image) {
            Storage::disk('public')->delete($this->team->team_image);
        }
        
        // Eliminar el equipo
        $this->team->delete();
        
        session()->flash('message', 'Equipo eliminado correctamente.');
        
        return redirect()->route('teams.index');
    }

    protected function getAvailablePlayersForModal()
    {
        $availablePlayers = collect();
        
        if (!$this->showAddPlayerModal) {
            return $availablePlayers;
        }
        
        // Obtener sports_school_id
        $sportsSchoolId = null;
        if ($this->season_id) {
            $season = Season::find($this->season_id);
            if ($season) {
                $sportsSchoolId = $season->sports_school_id;
            }
        }
        
        if (!$sportsSchoolId || !$this->season_id) {
            return $availablePlayers;
        }

        // dd($this->season_id, $this->section_id);

        // Un jugador puede pertenecer a varios equipos siempre que sean de secciones distintas.
        // Por eso solo lo excluimos si ya está en un equipo de la MISMA sección y temporada.
        $query = \App\Models\Player::where('active', true)
            ->where('sports_school_id', $sportsSchoolId)
            ->whereDoesntHave('teams', function($q) {
                $q->where('teams.section_id', $this->section_id)
                  ->where('teams.season_id', $this->season_id);
            })
            ->whereHas('seasons', function($q) {
                $q->where('seasons.id', $this->season_id);
            })
            ->whereHas('sections', function($q) {
                $q->where('sections.id', $this->section_id);
            });


            
        // Aplicar búsqueda si existe
        if ($this->searchAvailablePlayer) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchAvailablePlayer . '%')
                  ->orWhere('surname', 'like', '%' . $this->searchAvailablePlayer . '%')
                  ->orWhere('dni', 'like', '%' . $this->searchAvailablePlayer . '%');
            });
        }
        
        $availablePlayers = $query->orderBy('name')
            ->orderBy('surname')
            ->get();
        
        // Filtrar por categoría si está activado
        if ($this->filterByCategory && $this->category_id) {
            $category = Category::find($this->category_id);
            $season = Season::find($this->season_id);
            
            if ($category && $season && $season->from_year) {
                $availablePlayers = $availablePlayers->filter(function($player) use ($category, $season) {
                    if (!$player->dbirth) {
                        return false;
                    }
                    
                    // Calcular la edad del jugador al inicio de la temporada
                    $birthYear = $player->dbirth->year;
                    $ageAtSeasonStart = $season->from_year - $birthYear;
                    
                    // Verificar si la edad está dentro del rango de la categoría
                    return $ageAtSeasonStart >= $category->from_age && $ageAtSeasonStart <= $category->to_age;
                });
            }
        }
        
        return $availablePlayers;
    }

    public function render()
    {
        $categories = Category::orderBy('category')->get();
        $seasons = Season::orderBy('from_year', 'desc')->get();
        
        // Cargar el equipo con contadores de pagos y jugadores para la vista
        $this->team->loadCount(['payments', 'players']);
        
        // Obtener secciones de la temporada seleccionada
        $sections = collect();
        if ($this->season_id) {
            $sections = Section::whereHas('seasons', function($query) {
                $query->where('seasons.id', $this->season_id);
            })->orderBy('name')->get();
        }

        // Obtener la escuela del equipo a través de la temporada
        $sportsSchoolId = null;
        if ($this->season_id) {
            $season = Season::find($this->season_id);
            if ($season) {
                $sportsSchoolId = $season->sports_school_id;
            }
        }
        

        // Obtener entrenadores asignados al equipo
        $assignedCoaches = $this->team->coaches;
        
        // Obtener entrenadores disponibles (coaches + school_admins) de la misma escuela
        // que NO están asignados al equipo
        $availableCoaches = collect();
        if ($sportsSchoolId) {
            $query = User::where('is_active', true)
                ->where('sports_school_id', $sportsSchoolId)
                ->where(function($q) {
                    $q->role('coach')
                      ->orWhere(function($subQ) {
                          $subQ->role('school_admin');
                      });
                })
                ->whereNotIn('id', $this->selectedCoaches);
                
            // Aplicar búsqueda si existe
            if ($this->searchCoach) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->searchCoach . '%')
                      ->orWhere('email', 'like', '%' . $this->searchCoach . '%');
                });
            }
            
            $availableCoaches = $query->orderBy('name')->get();
        }

        // Obtener jugadores disponibles para agregar (no están en el equipo)
        $availablePlayers = $this->getAvailablePlayersForModal();

       

        return view('livewire.teams.edit', [
            'categories' => $categories,
            'seasons' => $seasons,
            'sections' => $sections,
            'assignedCoaches' => $assignedCoaches,
            'availableCoaches' => $availableCoaches,
            'teamPlayers' => $this->team->players()
                ->when($this->searchPlayer, function($query) {
                    $query->where(function($q) {
                        $q->where('name', 'like', '%' . $this->searchPlayer . '%')
                          ->orWhere('surname', 'like', '%' . $this->searchPlayer . '%')
                          ->orWhere('dni', 'like', '%' . $this->searchPlayer . '%');
                    });
                })
                ->orderBy('name')
                ->orderBy('surname')
                ->get(),
            'availableTeams' => Team::where('season_id', $this->team->season_id)
                ->where('section_id', $this->team->section_id)
                ->where('id', '!=', $this->team->id)
                ->orderBy('team')
                ->get(),
            'availablePlayers' => $availablePlayers,
            'availableSizes' => \App\Models\Size::whereHas('brand.sportsSchools', function($query) {
                $query->where('sports_schools.id', auth()->user()->sports_school_id);
            })->with('brand')->orderBy('brand_id')->orderBy('order')->orderBy('size')->get(),
        ]);
    }
    
    public function downloadPlayerDocuments($playerId)
    {
        $player = Player::where('id', $playerId)
            ->where('sports_school_id', auth()->user()->sports_school_id)
            ->first();

        if (!$player) {
            session()->flash('error', 'Jugador no encontrado.');
            return;
        }

        // Verificar que el jugador pertenece a este equipo
        if (!$this->team->players()->where('players.id', $player->id)->exists()) {
            session()->flash('error', 'El jugador no pertenece a este equipo.');
            return;
        }

        $disk = Storage::disk('public');
        $filesToZip = [];

        // Foto del jugador
        if ($player->player_photo && $disk->exists($player->player_photo)) {
            $ext = pathinfo($player->player_photo, PATHINFO_EXTENSION) ?: 'jpg';
            $filesToZip[] = [
                'source' => $disk->path($player->player_photo),
                'name'   => 'foto_jugador.' . $ext,
            ];
        }

        // Documentos adjuntos
        $documents = $player->documents ?? [];
        $usedNames = [];
        foreach ($documents as $index => $doc) {
            if (empty($doc['path']) || !$disk->exists($doc['path'])) {
                continue;
            }

            $ext = pathinfo($doc['path'], PATHINFO_EXTENSION);
            $label = $doc['label'] ?? ('documento_' . ($index + 1));
            $safeLabel = preg_replace('/[^A-Za-z0-9_\- ]/u', '', $label);
            $safeLabel = trim($safeLabel) !== '' ? trim($safeLabel) : 'documento_' . ($index + 1);
            $baseName = $safeLabel . ($ext ? '.' . $ext : '');

            // Evitar nombres duplicados dentro del ZIP
            $finalName = $baseName;
            $counter = 1;
            while (isset($usedNames[$finalName])) {
                $finalName = $safeLabel . '_' . $counter . ($ext ? '.' . $ext : '');
                $counter++;
            }
            $usedNames[$finalName] = true;

            $filesToZip[] = [
                'source' => $disk->path($doc['path']),
                'name'   => $finalName,
            ];
        }

        if (empty($filesToZip)) {
            session()->flash('error', 'Este jugador no tiene documentación para descargar.');
            return;
        }

        $zipName = 'documentacion_' . preg_replace('/[^A-Za-z0-9_\-]/u', '_', $player->surname . '_' . $player->name) . '.zip';
        $tmpPath = tempnam(sys_get_temp_dir(), 'playerdocs_') . '.zip';

        $zip = new \ZipArchive();
        if ($zip->open($tmpPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            session()->flash('error', 'No se pudo generar el archivo ZIP.');
            return;
        }

        foreach ($filesToZip as $file) {
            $zip->addFile($file['source'], $file['name']);
        }
        $zip->close();

        return response()->streamDownload(function () use ($tmpPath) {
            readfile($tmpPath);
            @unlink($tmpPath);
        }, $zipName, [
            'Content-Type' => 'application/zip',
        ]);
    }

    public function openPdfModal()
    {
        // Seleccionar columnas básicas por defecto
        $this->selectedColumns = ['name', 'surname', 'dni', 'dbirth', 'phone1', 'phone2'];
        $this->showPdfModal = true;
    }
    
    public function closePdfModal()
    {
        $this->showPdfModal = false;
        $this->selectedColumns = [];
    }
    
    public function generatePdf()
    {
        if (empty($this->selectedColumns)) {
            session()->flash('error', 'Debes seleccionar al menos una columna.');
            return;
        }
        
        // Obtener jugadores del equipo
        $players = $this->team->players()
            ->orderBy('surname')
            ->orderBy('name')
            ->get();
        
        if ($players->isEmpty()) {
            session()->flash('error', 'No hay jugadores en este equipo para generar el PDF.');
            $this->closePdfModal();
            return;
        }
        
        $pdf = new PdfFile();
        $pdf->file_name = 'listado_jugadores_' . str_replace(' ', '_', $this->team->team);
        $pdf->templates[0] = 'pdfs.team-players-list';
        
        // Preparar datos para el PDF
        $data = [
            'team' => $this->team,
            'players' => $players,
            'selectedColumns' => $this->selectedColumns,
            'availableColumns' => $this->availableColumns,
            'season' => $this->team->season,
            'category' => $this->team->category,
        ];
        
        $pdf->records = ['data' => $data];
        

        
        $content = $pdf->generateFromTemplate($pdf->templates[0]);
        
        $this->closePdfModal();
        
        // return response()->streamDownload(
        //     fn () => print($content),
        //     $pdf->getFileName()
        // );
         // Abre el PDF en el visor del navegador (nueva pestaña) en vez de descargarlo.
        $base64 = base64_encode($content);
        $fileName = $pdf->getFileName();

        $this->js(<<<JS
            (() => {
                const bin = atob('{$base64}');
                const bytes = new Uint8Array(bin.length);
                for (let i = 0; i < bin.length; i++) bytes[i] = bin.charCodeAt(i);
                const blob = new Blob([bytes], { type: 'application/pdf' });
                const url = URL.createObjectURL(blob);
                const win = window.open(url, '_blank');
                if (!win) {
                    const a = document.createElement('a');
                    a.href = url;
                    a.target = '_blank';
                    a.rel = 'noopener';
                    a.download = '{$fileName}';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                }
                setTimeout(() => URL.revokeObjectURL(url), 60000);
            })();
        JS);

    }
    
    public function generateExcel()
    {
        if (empty($this->selectedColumns)) {
            session()->flash('error', 'Debes seleccionar al menos una columna.');
            return;
        }
        
        // Obtener jugadores del equipo
        $players = $this->team->players()
            ->orderBy('surname')
            ->orderBy('name')
            ->get();
        
        if ($players->isEmpty()) {
            session()->flash('error', 'No hay jugadores en este equipo para generar el Excel.');
            $this->closePdfModal();
            return;
        }
        
        // Preparar columnas para Excel en el formato requerido
        $columns = [];
        foreach ($this->selectedColumns as $columnKey) {
            if (isset($this->availableColumns[$columnKey])) {
                $valueExpression = '';
                
                switch ($columnKey) {
                    case 'name':
                        $valueExpression = '$record->name';
                        break;
                    case 'surname':
                        $valueExpression = '$record->surname';
                        break;
                    case 'phone':
                        $valueExpression = '$record->phone1 ?? ""';
                        break;
                    case 'dni':
                        $valueExpression = '$record->dni';
                        break;
                    case 'dbirth':
                        $valueExpression = '$record->dbirth ? $record->dbirth->format("d/m/Y") : ""';
                        break;
                    case 'dbanio':
                        $valueExpression = '$record->dbanio';
                        break;
                    case 'position':
                        $valueExpression = '$record->position ?? ""';
                        break;
                    case 'shirt_number':
                        $valueExpression = '$record->dorsal ?? ""';
                        break;
                    case 'sizes':
                        // $valueExpression = '(function($p) { $s = []; if ($p->size_shirt) $s[] = "Cam: ".$p->size_shirt; if ($p->size_pants) $s[] = "Pan: ".$p->size_pants; if ($p->size_shoes) $s[] = "Cal: ".$p->size_shoes; return implode(", ", $s); })($record)';
                        $valueExpression = '$record->sizes ?? ""';
                        break;
                    case 'nametutor':
                        $valueExpression = '$record->nametutor ?? ""';
                        break;
                    case 'surnametutor':
                        $valueExpression = '$record->surnametutor ?? ""';
                        break;
                    case 'dnitutor':
                        $valueExpression = '$record->dnitutor ?? ""';
                        break;
                    case 'phone2':
                        $valueExpression = '$record->phone2 ?? ""';
                        break;
                    case 'address':
                        $valueExpression = '$record->address ?? ""';
                        break;
                    case 'town':
                        $valueExpression = '$record->town ?? ""';
                        break;
                    case 'province':
                        $valueExpression = '$record->province ?? ""';
                        break;
                    case 'cp':
                        $valueExpression = '$record->zip ?? ""';
                        break;
                    case 'phone':
                        $valueExpression = '$record->phone1 ?? ""';
                        break;
                    case 'email':
                        $valueExpression = '$record->email ?? ""';
                        break;
                }
                
                $columns[$columnKey] = [
                    'title' => $this->availableColumns[$columnKey],
                    'value' => $valueExpression,
                    'type' => 'eval'
                ];
            }
        }
        
        // Generar Excel usando ExcelFile
        $excel = new ExcelFile(
            \App\Models\Player::class,
            [],
            $columns,
            'listado_jugadores_' . str_replace(' ', '_', $this->team->team),
            [],
            [],
            $players
        );
        
        $this->closePdfModal();
        
        return response()->streamDownload(
            fn () => print($excel->generate()),
            'listado_jugadores_' . str_replace(' ', '_', $this->team->team) . '.xlsx'
        );
    }}