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

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $seasonFilter = '';
    public $categoryFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSeasonFilter()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
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
                    // Procesar cada pago del equipo
                    foreach ($team->payments as $payment) {
                        // Verificar que no exista ya esta combinación player_id + payment_id
                        $exists = PaymentPlayer::where('player_id', $player->id)
                            ->where('payment_id', $payment->id)
                            ->exists();

                        if ($exists) {
                            $skippedCount++;
                            continue;
                        }

                        // Generar código de pago
                        $code = PaymentCodeSequentials::getCode();

                        // Crear orden de pago para el jugador
                        PaymentPlayer::create([
                            'player_id' => $player->id,
                            'payment_id' => $payment->id,
                            'sports_school_id' => $sportsSchoolId,
                            'code' => $code,
                            'state' => 0, // Pendiente
                            'cuota' => $payment->cuota,
                            'price' => $team->price, // Precio de matrícula del equipo
                            'amount' => $payment->amount, // Importe de la cuota
                            'created_user' => auth()->id(),
                        ]);

                        $generatedCount++;
                    }
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
        $players = Player::with(['paymentPlayers.paymentTeam', 'teams.category', 'teams.season'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('surname', 'like', '%' . $this->search . '%')
                      ->orWhere('dni', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->seasonFilter, function($query) {
                $query->whereHas('teams', function($q) {
                    $q->where('season_id', $this->seasonFilter);
                });
            })
            ->when($this->categoryFilter, function($query) {
                $query->whereHas('teams', function($q) {
                    $q->where('category_id', $this->categoryFilter);
                });
            })
            ->orderBy('name')
            ->orderBy('surname')
            ->paginate(20);

        // Obtener temporadas y categorías para los filtros
        $seasons = Season::orderBy('from_year', 'desc')->get();
        
        $categories = \App\Models\Category::when($this->seasonFilter, function($query) {
                $query->whereHas('teams', function($q) {
                    $q->where('season_id', $this->seasonFilter);
                });
            })
            ->orderBy('category')
            ->get();

        return view('livewire.payment-orders.index', [
            'players' => $players,
            'seasons' => $seasons,
            'categories' => $categories,
            'activeSeason' => $activeSeason,
        ]);
    }
}
