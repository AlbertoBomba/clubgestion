<?php

namespace App\Livewire\Players;

use App\Classes\PdfFile;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Player;
use Mpdf\Mpdf;

class Edit extends Component
{
    use WithFileUploads;

    public Player $playerModel;
    
    // Datos personales
    public $name = '';
    public $surname = '';
    public $dni = '';
    public $dbirth = '';
    public $dbanio = '';
    
    // Tutor
    public $nametutor = '';
    public $surnametutor = '';
    public $dnitutor = '';
    
    // Contacto
    public $address = '';
    public $town = '';
    public $province = '';
    public $zip = '';
    public $phone1 = '';
    public $phone2 = '';
    public $email = '';
    
    // Datos deportivos
    public $dorsal = '';
    public $position = '';
    public $sizes = '';
    public $cod_matricula = '';
    
    // Booleanos
    public $active = true;
    public $soccer = false;
    public $passport = false;
    public $paddle = false;
    public $goalie = false;
    public $file = false;
    
    // Descuentos
    public $discountType = 'ninguno';
    public $descEnt = '';
    public $descPerc = '';
    
    // Modal de tallas
    public $showSizesModal = false;
    
    // Modal de equipos
    public $showTeamsModal = false;
    public $selectedTeam = null;
    public $showPreviewModal = false;
    public $showRemoveTeamModal = false;
    public $paymentsToDelete = [];
    public $paymentsToCreate = [];
    public $paymentsPaid = [];
    public $selectedPaymentsToCreate = [];
    public $newTeamId = '';
    
    // Modal de confirmación eliminar documento
    public $showDeleteModal = false;
    public $documentToDelete = null;
    
    // Otros
    public $observations = '';
    public $player_photo;
    public $currentPhoto;
    public $selectedSeasons = [];
    public $selectedSections = [];
    public $hasChanges = false;
    
    public function updatedDiscountType($value)
    {
        // Limpiar valores al cambiar el tipo
        if ($value !== 'cantidad') {
            $this->descEnt = '';
        }
        if ($value !== 'porcentaje') {
            $this->descPerc = '';
        }
    }

    public function updatedDescEnt($value)
    {
        $this->descEnt = str_replace(',', '.', $value);
    }

    public function updatedDescPerc($value)
    {
        $this->descPerc = str_replace(',', '.', $value);
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
            $this->sizes = $size->size;
            $this->closeSizesModal();
        }
    }
    
    // Métodos para el modal de equipos
    public function openTeamsModal()
    {
        $this->showTeamsModal = true;
    }
    
    public function closeTeamsModal()
    {
        $this->showTeamsModal = false;
    }
    
    public function assignTeam($teamId)
    {
        $this->newTeamId = $teamId;
        $this->showTeamsModal = false;
        
        // Verificar si el jugador ya pertenece a este equipo
        if ($this->playerModel->teams()->where('teams.id', $teamId)->exists()) {
            session()->flash('info', 'El jugador ya pertenece a este equipo.');
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

        // Obtener el nuevo equipo
        $newTeam = \App\Models\Team::with(['payments'])->find($teamId);

        if (!$newTeam) {
            session()->flash('error', 'Equipo no encontrado.');
            return;
        }

        $this->paymentsToDelete = [];
        $this->paymentsToCreate = [];
        $this->paymentsPaid = [];
        $this->selectedPaymentsToCreate = [];

        // Obtener pagos pendientes a eliminar
        $pendingPayments = \App\Models\PaymentPlayer::with('paymentTeam')
            ->where('player_id', $this->playerModel->id)
            ->where('sports_school_id', auth()->user()->sports_school_id)
            ->where('state', 0)
            ->whereHas('paymentTeam', function($query) use ($activeSeason) {
                $query->where('season_id', $activeSeason->id);
            })
            ->get();

        foreach ($pendingPayments as $payment) {
            $this->paymentsToDelete[] = [
                'id' => $payment->id,
                'player_id' => $this->playerModel->id,
                'player_name' => $this->playerModel->name . ' ' . $this->playerModel->surname,
                'code' => $payment->code,
                'cuota' => $payment->cuota,
                'amount' => $payment->amount,
                'description' => $payment->paymentTeam->description ?? 'N/A',
            ];
        }

        // Obtener cuotas YA PAGADAS para no generarlas de nuevo
        $paidCuotas = \App\Models\PaymentPlayer::where('player_id', $this->playerModel->id)
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
        $paidPayments = \App\Models\PaymentPlayer::with('paymentTeam')
            ->where('player_id', $this->playerModel->id)
            ->where('sports_school_id', auth()->user()->sports_school_id)
            ->where('state', 1)
            ->whereHas('paymentTeam', function($query) use ($activeSeason) {
                $query->where('season_id', $activeSeason->id);
            })
            ->get();

        foreach ($paidPayments as $payment) {
            $this->paymentsPaid[] = [
                'player_name' => $this->playerModel->name . ' ' . $this->playerModel->surname,
                'code' => $payment->code,
                'cuota' => $payment->cuota,
                'amount' => $payment->amount,
                'description' => $payment->paymentTeam->description ?? 'N/A',
                'payment_date' => $payment->payment_date ? $payment->payment_date->format('d/m/Y') : 'N/A',
            ];
        }

        // Preparar nuevos pagos a crear (excluyendo cuotas ya pagadas)
        if ($newTeam->payments->isNotEmpty()) {
            $newPayments = $this->preparePlayerPaymentsForTeam($this->playerModel, $newTeam, $paidCuotas);
            foreach ($newPayments as $index => $newPayment) {
                $uniqueId = $this->playerModel->id . '_' . $index;
                $newPayment['unique_id'] = $uniqueId;
                $this->paymentsToCreate[] = $newPayment;
                $this->selectedPaymentsToCreate[] = $uniqueId;
            }
        }

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

            // Verificar que no exista ya esta combinación player_id + payment_id ACTIVA (no soft deleted)
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

    public function confirmPaymentsAction()
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

            // Sincronizar equipo
            $this->playerModel->teams()->sync([$this->newTeamId]);

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
                $message = "Equipo cambiado correctamente.";
            }
            
            session()->flash('message', trim($message));

        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('error', 'Error al cambiar el equipo: ' . $e->getMessage());
        }

        $this->showPreviewModal = false;
        $this->paymentsToDelete = [];
        $this->paymentsToCreate = [];
        $this->paymentsPaid = [];
        $this->selectedPaymentsToCreate = [];
        $this->newTeamId = '';
    }

    public function toggleAllPaymentsToCreate($checked)
    {
        if ($checked) {
            $this->selectedPaymentsToCreate = array_column($this->paymentsToCreate, 'unique_id');
        } else {
            $this->selectedPaymentsToCreate = [];
        }
    }
    
    public function removeTeam()
    {
        // Obtener temporada activa
        $activeSeason = \App\Models\Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$activeSeason) {
            session()->flash('error', 'No hay temporada activa configurada.');
            return;
        }

        $this->paymentsToDelete = [];
        $this->paymentsPaid = [];

        // Obtener pagos pendientes del jugador en la temporada activa
        $pendingPayments = \App\Models\PaymentPlayer::with('paymentTeam')
            ->where('player_id', $this->playerModel->id)
            ->where('sports_school_id', auth()->user()->sports_school_id)
            ->where('state', 0)
            ->whereHas('paymentTeam', function($query) use ($activeSeason) {
                $query->where('season_id', $activeSeason->id);
            })
            ->get();

        foreach ($pendingPayments as $payment) {
            $this->paymentsToDelete[] = [
                'id' => $payment->id,
                'player_id' => $this->playerModel->id,
                'player_name' => $this->playerModel->name . ' ' . $this->playerModel->surname,
                'code' => $payment->code,
                'cuota' => $payment->cuota,
                'amount' => $payment->amount,
                'description' => $payment->paymentTeam->description ?? 'N/A',
            ];
        }

        // Obtener pagos pagados para mostrarlos
        $paidPayments = \App\Models\PaymentPlayer::with('paymentTeam')
            ->where('player_id', $this->playerModel->id)
            ->where('sports_school_id', auth()->user()->sports_school_id)
            ->where('state', 1)
            ->whereHas('paymentTeam', function($query) use ($activeSeason) {
                $query->where('season_id', $activeSeason->id);
            })
            ->get();

        foreach ($paidPayments as $payment) {
            $this->paymentsPaid[] = [
                'player_name' => $this->playerModel->name . ' ' . $this->playerModel->surname,
                'code' => $payment->code,
                'cuota' => $payment->cuota,
                'amount' => $payment->amount,
                'description' => $payment->paymentTeam->description ?? 'N/A',
                'payment_date' => $payment->payment_date ? $payment->payment_date->format('d/m/Y') : 'N/A',
            ];
        }

        $this->showRemoveTeamModal = true;
    }

    public function confirmRemoveTeam()
    {
        try {
            \DB::beginTransaction();

            $deletedCount = 0;

            // Eliminar todos los pagos pendientes
            foreach ($this->paymentsToDelete as $paymentInfo) {
                $payment = \App\Models\PaymentPlayer::find($paymentInfo['id']);
                if ($payment) {
                    $payment->delete();
                    $deletedCount++;
                }
            }

            // Quitar el jugador del equipo
            $this->playerModel->teams()->detach();

            \DB::commit();

            $message = 'Jugador removido del equipo correctamente.';
            if ($deletedCount > 0) {
                $message .= " Se eliminaron {$deletedCount} cartas de pago pendientes.";
            }
            if (count($this->paymentsPaid) > 0) {
                $message .= " Se mantienen " . count($this->paymentsPaid) . " cartas de pago ya abonadas.";
            }
            
            session()->flash('message', $message);

        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('error', 'Error al remover el equipo: ' . $e->getMessage());
        }

        $this->showRemoveTeamModal = false;
        $this->paymentsToDelete = [];
        $this->paymentsPaid = [];
    }
    
    // Documentos
    public $document;
    public $documentType = '';
    public $documentLabel = '';
    public $existingDocuments = [];
    public $captureMode = false;
    
    // Valores originales para detectar cambios
    private $originalName;
    private $originalSurname;
    private $originalDni;
    private $originalDbirth;
    private $originalDbanio;
    private $originalNametutor;
    private $originalSurnametutor;
    private $originalDnitutor;
    private $originalAddress;
    private $originalTown;
    private $originalProvince;
    private $originalZip;
    private $originalPhone1;
    private $originalPhone2;
    private $originalEmail;
    private $originalDorsal;
    private $originalPosition;
    private $originalSizes;
    private $originalCodMatricula;
    private $originalActive;
    private $originalSoccer;
    private $originalPassport;
    private $originalPaddle;
    private $originalGoalie;
    private $originalFile;
    private $originalObservations;
    private $originalSelectedSeasons = [];
    private $originalSelectedSections = [];

    public function updated($propertyName)
    {
        // Detectar cambios en cualquier propiedad
        $this->checkForChanges();
    }

    public function getIsAdultProperty()
    {
        if (empty($this->dbirth)) {
            return false;
        }

        try {
            $birthDate = new \DateTime($this->dbirth);
            $today = new \DateTime();
            $age = $today->diff($birthDate)->y;
            return $age >= 18;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function checkForChanges()
    {
        $this->hasChanges = 
            $this->name !== $this->originalName ||
            $this->surname !== $this->originalSurname ||
            $this->dni !== $this->originalDni ||
            $this->dbirth !== $this->originalDbirth ||
            $this->dbanio !== $this->originalDbanio ||
            $this->nametutor !== $this->originalNametutor ||
            $this->surnametutor !== $this->originalSurnametutor ||
            $this->dnitutor !== $this->originalDnitutor ||
            $this->address !== $this->originalAddress ||
            $this->town !== $this->originalTown ||
            $this->province !== $this->originalProvince ||
            $this->zip !== $this->originalZip ||
            $this->phone1 !== $this->originalPhone1 ||
            $this->phone2 !== $this->originalPhone2 ||
            $this->email !== $this->originalEmail ||
            $this->dorsal !== $this->originalDorsal ||
            $this->position !== $this->originalPosition ||
            $this->sizes !== $this->originalSizes ||
            $this->cod_matricula !== $this->originalCodMatricula ||
            $this->active !== $this->originalActive ||
            $this->soccer !== $this->originalSoccer ||
            $this->passport !== $this->originalPassport ||
            $this->paddle !== $this->originalPaddle ||
            $this->goalie !== $this->originalGoalie ||
            $this->file !== $this->originalFile ||
            $this->observations !== $this->originalObservations ||
            count(array_diff($this->selectedSeasons, $this->originalSelectedSeasons)) > 0 ||
            count(array_diff($this->originalSelectedSeasons, $this->selectedSeasons)) > 0 ||
            count(array_diff($this->selectedSections, $this->originalSelectedSections)) > 0 ||
            count(array_diff($this->originalSelectedSections, $this->selectedSections)) > 0;
    }

    protected $rules = [
        'selectedSeasons' => 'required|array|min:1',
        'selectedSeasons.*' => 'exists:seasons,id',
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'dni' => 'nullable|string|max:20',
        'dbirth' => 'nullable|date',
        'dbanio' => 'nullable|integer|min:1900|max:2100',
        'nametutor' => 'nullable|string|max:255',
        'surnametutor' => 'nullable|string|max:255',
        'dnitutor' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'town' => 'nullable|string|max:100',
        'province' => 'nullable|string|max:100',
        'zip' => 'nullable|string|max:10',
        'phone1' => 'nullable|string|max:20',
        'phone2' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'dorsal' => 'nullable|integer|min:0|max:999',
        'position' => 'nullable|string|max:50',
        'sizes' => 'nullable|string|max:50',
        'cod_matricula' => 'nullable|string|max:50',
        'observations' => 'nullable|string',
        'player_photo' => 'nullable|image|max:2048',
        'selectedSections' => 'nullable|array',
        'selectedSections.*' => 'exists:sections,id',
        'discountType' => 'nullable|in:ninguno,cantidad,porcentaje',
        'descEnt' => 'nullable|numeric|min:0',
        'descPerc' => 'nullable|numeric|min:0|max:100',
    ];

    public function mount(Player $player)
    {
        // Verificar que el jugador pertenece a la escuela del usuario
        if ($player->sports_school_id !== auth()->user()->sports_school_id) {
            abort(403, 'No tienes permisos para editar este jugador.');
        }

        $this->playerModel = $player;
        $this->name = $player->name;
        $this->surname = $player->surname;
        $this->dni = $player->dni;
        $this->dbirth = $player->dbirth ? $player->dbirth->format('Y-m-d') : '';
        $this->dbanio = $player->dbanio;
        $this->nametutor = $player->nametutor;
        $this->surnametutor = $player->surnametutor;
        $this->dnitutor = $player->dnitutor;
        $this->address = $player->address;
        $this->town = $player->town;
        $this->province = $player->province;
        $this->zip = $player->zip;
        $this->phone1 = $player->phone1;
        $this->phone2 = $player->phone2;
        $this->email = $player->email;
        $this->dorsal = $player->dorsal;
        $this->position = $player->position;
        $this->sizes = $player->sizes;
        $this->cod_matricula = $player->cod_matricula;
        $this->active = $player->active;
        $this->soccer = $player->soccer;
        $this->passport = $player->passport;
        $this->paddle = $player->paddle;
        $this->goalie = $player->goalie;
        $this->file = $player->file;
        $this->observations = $player->observations;
        $this->descEnt = $player->descEnt;
        $this->descPerc = $player->descPerc;
        
        // Detectar tipo de descuento
        if ($player->descEnt && $player->descEnt > 0) {
            $this->discountType = 'cantidad';
        } elseif ($player->descPerc && $player->descPerc > 0) {
            $this->discountType = 'porcentaje';
        } else {
            $this->discountType = 'ninguno';
        }
        
        $this->currentPhoto = $player->player_photo;
        $this->selectedSeasons = $player->seasons->pluck('id')->toArray();
        $this->selectedSections = $player->sections->pluck('id')->toArray();
        $this->existingDocuments = $player->documents ?? [];
        
        // Guardar valores originales para detectar cambios
        $this->originalName = $this->name;
        $this->originalSurname = $this->surname;
        $this->originalDni = $this->dni ?? '';
        $this->originalDbirth = $this->dbirth ?? '';
        $this->originalDbanio = $this->dbanio ?? '';
        $this->originalNametutor = $this->nametutor ?? '';
        $this->originalSurnametutor = $this->surnametutor ?? '';
        $this->originalDnitutor = $this->dnitutor ?? '';
        $this->originalAddress = $this->address ?? '';
        $this->originalTown = $this->town ?? '';
        $this->originalProvince = $this->province ?? '';
        $this->originalZip = $this->zip ?? '';
        $this->originalPhone1 = $this->phone1 ?? '';
        $this->originalPhone2 = $this->phone2 ?? '';
        $this->originalEmail = $this->email ?? '';
        $this->originalDorsal = $this->dorsal ?? '';
        $this->originalPosition = $this->position ?? '';
        $this->originalSizes = $this->sizes ?? '';
        $this->originalCodMatricula = $this->cod_matricula ?? '';
        $this->originalActive = $this->active;
        $this->originalSoccer = $this->soccer;
        $this->originalPassport = $this->passport;
        $this->originalPaddle = $this->paddle;
        $this->originalGoalie = $this->goalie;
        $this->originalFile = $this->file;
        $this->originalObservations = $this->observations ?? '';
        $this->originalSelectedSeasons = $this->selectedSeasons;
        $this->originalSelectedSections = $this->selectedSections;
    }

    public function deletePhoto()
    {
        if ($this->currentPhoto && \Storage::disk('public')->exists($this->currentPhoto)) {
            \Storage::disk('public')->delete($this->currentPhoto);
        }
        
        $this->playerModel->update(['player_photo' => null]);
        $this->currentPhoto = null;
        
        session()->flash('message', 'Foto eliminada correctamente.');
    }

    

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'surname' => $this->surname,
            'dni' => $this->dni,
            'dbirth' => $this->dbirth,
            'dbanio' => $this->dbanio,
            'nametutor' => $this->nametutor,
            'surnametutor' => $this->surnametutor,
            'dnitutor' => $this->dnitutor,
            'address' => $this->address,
            'town' => $this->town,
            'province' => $this->province,
            'zip' => $this->zip,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'email' => $this->email,
            'dorsal' => $this->dorsal ?: null,
            'position' => $this->position,
            'sizes' => $this->sizes,
            'cod_matricula' => $this->cod_matricula,
            'active' => $this->active,
            'soccer' => $this->soccer,
            'passport' => $this->passport,
            'paddle' => $this->paddle,
            'goalie' => $this->goalie,
            'file' => $this->file,
            'observations' => $this->observations,
            'descEnt' => $this->descEnt ? floatval(str_replace(',', '.', $this->descEnt)) : null,
            'descPerc' => $this->descPerc ? floatval(str_replace(',', '.', $this->descPerc)) : null,
            'updated_user' => auth()->id(),
        ];

        // Handle new photo upload
        if ($this->player_photo) {
            // Delete old photo
            if ($this->currentPhoto && \Storage::disk('public')->exists($this->currentPhoto)) {
                \Storage::disk('public')->delete($this->currentPhoto);
            }
            
            $photoPath = $this->player_photo->store('players/photos', 'public');
            $data['player_photo'] = $photoPath;
        }

        $this->playerModel->update($data);

        // Sync seasons
        $this->playerModel->seasons()->sync(
            collect($this->selectedSeasons)->mapWithKeys(function ($seasonId) {
                return [$seasonId => [
                    'updated_user' => auth()->id(),
                    'updated_at' => now(),
                ]];
            })->toArray()
        );

        // Sync sections
        $this->playerModel->sections()->sync(
            collect($this->selectedSections)->mapWithKeys(function ($sectionId) {
                return [$sectionId => [
                    'updated_user' => auth()->id(),
                    'updated_at' => now(),
                ]];
            })->toArray()
        );

        // Resetear indicador de cambios
        $this->hasChanges = false;
        
        // Actualizar valores originales después de guardar
        $this->originalName = $this->name;
        $this->originalSurname = $this->surname;
        $this->originalDni = $this->dni ?? '';
        $this->originalDbirth = $this->dbirth ?? '';
        $this->originalDbanio = $this->dbanio ?? '';
        $this->originalNametutor = $this->nametutor ?? '';
        $this->originalSurnametutor = $this->surnametutor ?? '';
        $this->originalDnitutor = $this->dnitutor ?? '';
        $this->originalAddress = $this->address ?? '';
        $this->originalTown = $this->town ?? '';
        $this->originalProvince = $this->province ?? '';
        $this->originalZip = $this->zip ?? '';
        $this->originalPhone1 = $this->phone1 ?? '';
        $this->originalPhone2 = $this->phone2 ?? '';
        $this->originalEmail = $this->email ?? '';
        $this->originalDorsal = $this->dorsal ?? '';
        $this->originalPosition = $this->position ?? '';
        $this->originalSizes = $this->sizes ?? '';
        $this->originalCodMatricula = $this->cod_matricula ?? '';
        $this->originalActive = $this->active;
        $this->originalSoccer = $this->soccer;
        $this->originalPassport = $this->passport;
        $this->originalPaddle = $this->paddle;
        $this->originalGoalie = $this->goalie;
        $this->originalFile = $this->file;
        $this->originalObservations = $this->observations ?? '';
        $this->originalSelectedSeasons = $this->selectedSeasons;
        $this->originalSelectedSections = $this->selectedSections;

        session()->flash('message', 'Jugador actualizado correctamente.');
    }

    public function confirmDeleteDocument($index)
    {
        $this->documentToDelete = $index;
        $this->showDeleteModal = true;
    }

    public function cancelDeleteDocument()
    {
        $this->showDeleteModal = false;
        $this->documentToDelete = null;
    }

    public function deleteDocument()
    {
        if ($this->documentToDelete !== null && isset($this->existingDocuments[$this->documentToDelete])) {
            $docPath = $this->existingDocuments[$this->documentToDelete]['path'];
            
            // Eliminar el archivo físicamente del servidor
            if (\Storage::disk('public')->exists($docPath)) {
                \Storage::disk('public')->delete($docPath);
            }
            
            // Eliminar del array de documentos existentes
            unset($this->existingDocuments[$this->documentToDelete]);
            $this->existingDocuments = array_values($this->existingDocuments);
            
            // Actualizar inmediatamente en la base de datos
            $this->playerModel->update(['documents' => $this->existingDocuments]);
            
            session()->flash('message', 'Documento eliminado exitosamente.');
        }
        
        $this->showDeleteModal = false;
        $this->documentToDelete = null;
    }

    public function printPlayerCard()
    {
        $pdf = new PdfFile();
        $pdf->file_name = 'player_card_' . $this->playerModel->id . '.pdf';
        $pdf->templates[0] = 'pdfs.playercard';
        $pdf->records = [
            'player' => $this->playerModel,
        ];

        $content = $pdf->generateFromTemplate($pdf->templates[0] );

         return response()->streamDownload(
            fn () => print(
                $content
            ),
            $pdf->getFileName()
        );
        
    }

    public function uploadDocument()
    {
        // Validar documento
        if (!$this->document) {
            $this->addError('document', 'Debes seleccionar un archivo.');
            return;
        }

        if (empty($this->documentType)) {
            $this->addError('documentType', 'Debes seleccionar un tipo de documento.');
            return;
        }

        if ($this->documentType === 'otros' && empty($this->documentLabel)) {
            $this->addError('documentLabel', 'Debes proporcionar una descripción para el documento.');
            return;
        }

        // Validar el archivo
        $this->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Obtener documentos actuales del jugador
        $savedDocuments = $this->playerModel->documents ?? [];

        // Determinar la etiqueta según el tipo de documento
        $label = match($this->documentType) {
            'dni_frontal' => 'DNI Frontal',
            'dni_trasero' => 'DNI Trasero',
            'ficha_medica' => 'Ficha Médica',
            'autorizacion' => 'Autorización',
            'otros' => $this->documentLabel ?: 'Documento ' . (count($savedDocuments) + 1),
            default => 'Documento ' . (count($savedDocuments) + 1)
        };

        // Guardar el documento
        $path = $this->document->store('player-documents/' . $this->playerModel->id, 'public');

        $savedDocuments[] = [
            'path' => $path,
            'label' => $label,
            'original_name' => $this->document->getClientOriginalName(),
            'uploaded_at' => now()->toDateTimeString(),
        ];

        // Actualizar solo los documentos del jugador
        $this->playerModel->update(['documents' => $savedDocuments]);

        // Resetear campos de documento
        $this->document = null;
        $this->documentType = '';
        $this->documentLabel = '';
        $this->captureMode = false;

        // Actualizar la lista de documentos existentes
        $this->existingDocuments = $savedDocuments;

        session()->flash('message', 'Documento subido exitosamente.');
    }

    public function render()
    {
        // Obtener temporadas de la escuela
        $seasons = \App\Models\Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderBy('from_year', 'desc')
            ->get();

        // Obtener las secciones de todas las temporadas seleccionadas
        $sections = collect();
        if (!empty($this->selectedSeasons)) {
            $sections = \App\Models\Section::whereHas('seasons', function($query) {
                $query->whereIn('seasons.id', $this->selectedSeasons)
                      ->where('active', true);
            })->distinct()->orderBy('name')->get();
        }

        // Obtener el equipo del jugador (si tiene) con su categoría
        // Refrescar desde la BD para obtener la última información
        $playerTeam = \App\Models\Team::whereHas('players', function($query) {
            $query->where('players.id', $this->playerModel->id);
        })->with('category')->first();

        // Obtener tallas asociadas a la escuela
        $availableSizes = \App\Models\Size::whereHas('brand.sportsSchools', function($query) {
            $query->where('sports_schools.id', auth()->user()->sports_school_id);
        })->with('brand')->orderBy('brand_id')->orderBy('order')->orderBy('size')->get();

        return view('livewire.players.edit', [
            'seasons' => $seasons,
            'sections' => $sections,
            'playerTeam' => $playerTeam,
            'availableSizes' => $availableSizes
        ]);
    }
}
