<?php

namespace App\Livewire\Matches;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SeasonMatch;
use App\Models\Season;
use App\Models\Team;
use App\Models\Player;
use App\Classes\PdfFile;

class Edit extends Component
{
    use WithFileUploads;
    public SeasonMatch $match;
    
    public $season_id = '';
    public $team_id = '';
    public $opponent = '';
    public $date = '';
    public $hour_match = '';
    public $hour_meeting = '';
    public $site = '';
    public $observations = '';
    public $match_description = '';
    public $goals_team = '';
    public $goals_oponent = '';
    public $escudo_team_oponent = '';
    public $sites = '';
    public $published = false;
    public $matchday = '';
    public $web_description = '';
    public $newEscudoTeamOponent = null; // Archivo temporal de subida
    
    // Imágenes del partido
    public $matchImages = [];
    public $newMatchImages = [];
    
    // Convocatoria - dos columnas
    public $calledPlayers = []; // Jugadores convocados (columna derecha)
    public $notCalledPlayers = []; // Jugadores no convocados (columna izquierda)
    public $playerReasons = []; // Razones de no convocatoria [playerId => reason]
    public $notCalledPlayerReasons = []; // Razones de jugadores no convocados [playerId => reason]
    
    public $maxPlayers = 25;
    
    // Formación y alineación táctica
    public $footballType = 11; // 7, 8 u 11
    public $formation = '';
    public $lineup = [];
    public $availableFormations = [
        7 => [
            '1-2-3-1' => ['lines' => [1, 2, 3, 1], 'name' => '2-3-1 Clásico F7'],
            '1-3-2-1' => ['lines' => [1, 3, 2, 1], 'name' => '3-2-1 Defensivo F7'],
            '1-2-2-2' => ['lines' => [1, 2, 2, 2], 'name' => '2-2-2 Equilibrado F7'],
            '1-1-3-2' => ['lines' => [1, 1, 3, 2], 'name' => '1-3-2 con Pivote F7'],
        ],
        8 => [
            '1-3-3-1' => ['lines' => [1, 3, 3, 1], 'name' => '3-3-1 Equilibrado F8'],
            '1-2-3-2' => ['lines' => [1, 2, 3, 2], 'name' => '2-3-2 Ofensivo F8'],
            '1-3-2-2' => ['lines' => [1, 3, 2, 2], 'name' => '3-2-2 Clásico F8'],
            '1-2-4-1' => ['lines' => [1, 2, 4, 1], 'name' => '2-4-1 con Mediocampo F8'],
        ],
        11 => [
            '1-4-4-2' => ['lines' => [1, 4, 4, 2], 'name' => '4-4-2 Clásico'],
            '1-4-3-3' => ['lines' => [1, 4, 3, 3], 'name' => '4-3-3 Ofensivo'],
            '1-4-2-3-1' => ['lines' => [1, 4, 2, 3, 1], 'name' => '4-2-3-1 Moderno'],
            '1-3-5-2' => ['lines' => [1, 3, 5, 2], 'name' => '3-5-2 con carrileros'],
            '1-3-4-3' => ['lines' => [1, 3, 4, 3], 'name' => '3-4-3 Ultra ofensivo'],
            '1-5-3-2' => ['lines' => [1, 5, 3, 2], 'name' => '5-3-2 Defensivo'],
            '1-4-1-4-1' => ['lines' => [1, 4, 1, 4, 1], 'name' => '4-1-4-1 con pivote'],
            '1-4-5-1' => ['lines' => [1, 4, 5, 1], 'name' => '4-5-1 Muy defensivo'],
        ],
    ];
    
    // Modal para añadir jugadores de otros equipos
    public $showAddExternalPlayerModal = false;
    public $selectedExternalTeamId = '';
    public $externalPlayers = [];
    public $searchExternalPlayer = '';

    protected $rules = [
        'season_id' => 'required|exists:seasons,id',
        'team_id' => 'required|exists:teams,id',
        'opponent' => 'required|string|max:255',
        'date' => 'required|date',
        'hour_match' => 'nullable|date_format:H:i',
        'hour_meeting' => 'nullable|date_format:H:i',
        'site' => 'nullable|string|max:255',
        'observations' => 'nullable|string',
        'match_description' => 'nullable|string',
        'goals_team' => 'nullable|integer|min:0',
        'goals_oponent' => 'nullable|integer|min:0',
        'escudo_team_oponent' => 'nullable|string|max:255',
        'sites' => 'nullable|in:home,away',
        'published' => 'boolean',
        'matchday' => 'nullable|integer|min:1',
        'web_description' => 'nullable|string',
        'newEscudoTeamOponent' => 'nullable|image|max:2048',
        'footballType' => 'required|in:7,8,11',
        'newMatchImages.*' => 'nullable|image|max:5120',
    ];

    public function mount(SeasonMatch $match)
    {
        // Verificar que el partido pertenece a la escuela deportiva del usuario
        if ($match->sports_school_id != auth()->user()->sports_school_id) {
            abort(403);
        }

        $this->match = $match;
        $this->season_id = $match->season_id;
        $this->team_id = $match->team_id;
        $this->opponent = $match->opponent;
        $this->date = $match->date->format('Y-m-d');
        $this->hour_match = $match->hour_match ? $match->hour_match->format('H:i') : '';
        $this->hour_meeting = $match->hour_meeting ? $match->hour_meeting->format('H:i') : '';
        $this->site = $match->site ?? '';
        $this->observations = $match->observations ?? '';
        $this->match_description = $match->match_description ?? '';
        $this->goals_team = $match->goals_team ?? '';
        $this->goals_oponent = $match->goals_oponent ?? '';
        $this->escudo_team_oponent = $match->escudo_team_oponent ?? '';
        $this->sites = $match->sites ?? '';
        $this->formation = $match->formation ?? '';
        $this->lineup = $match->lineup ?? [];
        $this->footballType = $match->football_type ?? 11;
        $this->published = $match->published ?? false;
        $this->matchday = $match->matchday ?? '';
        $this->web_description = $match->web_description ?? '';
        $this->matchImages = $match->match_images ?? [];
        
        // Cargar jugadores convocados con sus razones
        $calledPlayerIds = [];
        foreach ($match->players as $player) {
            $calledPlayerIds[] = $player->id;
            if ($player->pivot->reason_not_called) {
                $this->playerReasons[$player->id] = $player->pivot->reason_not_called;
            }
        }
        $this->calledPlayers = $calledPlayerIds;
        
        // Cargar jugadores no convocados con sus razones
        foreach ($match->notCalledPlayers as $player) {
            $this->notCalledPlayerReasons[$player->id] = $player->pivot->reason ?? '';
        }
        
        // Cargar todos los jugadores del equipo para separar convocados/no convocados
        $this->loadTeamPlayers();
    }

    public function loadTeamPlayers()
    {
        if ($this->team_id) {
            $team = Team::find($this->team_id);
            if ($team) {
                $allPlayers = $team->players()->pluck('players.id')->toArray();
                $notCalledPlayerIds = array_keys($this->notCalledPlayerReasons);
                $excludedPlayers = array_merge($this->calledPlayers, $notCalledPlayerIds);
                $this->notCalledPlayers = array_diff($allPlayers, $excludedPlayers);
            }
        }
    }

    public function updatedSeasonId()
    {
        // Reiniciar equipo cuando cambia la temporada
        $this->team_id = '';
        $this->calledPlayers = [];
        $this->notCalledPlayers = [];
        $this->playerReasons = [];
    }

    public function updatedTeamId()
    {
        $this->loadTeamPlayers();
    }

    public function addPlayer($playerId)
    {
        if (count($this->calledPlayers) >= $this->maxPlayers) {
            session()->flash('error', 'No se pueden convocar más de ' . $this->maxPlayers . ' jugadores.');
            return;
        }

        if (!in_array($playerId, $this->calledPlayers)) {
            // Añadir al inicio del array para que aparezca primero (LIFO)
            array_unshift($this->calledPlayers, $playerId);
            $this->notCalledPlayers = array_diff($this->notCalledPlayers, [$playerId]);
            
            // Clear reason when adding player
            if (isset($this->playerReasons[$playerId])) {
                unset($this->playerReasons[$playerId]);
            }
            
            // Limpiar razón de no convocado al añadir jugador
            if (isset($this->notCalledPlayerReasons[$playerId])) {
                unset($this->notCalledPlayerReasons[$playerId]);
            }
            
            // Guardar inmediatamente en la base de datos
            $this->match->players()->attach($playerId, [
                'created_user' => auth()->user()->id,
                'updated_user' => auth()->user()->id,
                'reason_not_called' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Refrescar partido para obtener datos actualizados
            $this->match = $this->match->fresh(['players', 'notCalledPlayers']);
        }
    }

    public function removePlayer($playerId)
    {
        // Verificar si el jugador ha confirmado su convocatoria
        $player = $this->match->players()->where('player_id', $playerId)->first();
        
        if ($player && $player->pivot->confirmed) {
            session()->flash('error', 'No se puede quitar de la convocatoria a un jugador que ya ha confirmado su asistencia.');
            return;
        }
        
        $this->calledPlayers = array_diff($this->calledPlayers, [$playerId]);
        if (!in_array($playerId, $this->notCalledPlayers)) {
            $this->notCalledPlayers[] = $playerId;
        }
        
        // Eliminar de la base de datos inmediatamente
        $this->match->players()->detach($playerId);
        
        // Refrescar partido
        $this->match = $this->match->fresh(['players', 'notCalledPlayers']);
    }
    
    public function markAsNotCalled($playerId, $reason = '')
    {
        // Verificar si el jugador ha confirmado su convocatoria
        $player = $this->match->players()->where('player_id', $playerId)->first();
        
        if ($player && $player->pivot->confirmed) {
            session()->flash('error', 'No se puede marcar como no convocado a un jugador que ya ha confirmado su asistencia.');
            return;
        }
        
        // Eliminar de jugadores convocados si existe
        $this->calledPlayers = array_diff($this->calledPlayers, [$playerId]);
        
        // Eliminar de jugadores disponibles
        $this->notCalledPlayers = array_diff($this->notCalledPlayers, [$playerId]);
        
        // Siempre añadir a razones de no convocados (incluso con razón vacía)
        $this->notCalledPlayerReasons[$playerId] = $reason;
        
        // Eliminar de jugadores convocados si existe
        $this->match->players()->detach($playerId);
        
        // Guardar en jugadores no convocados
        $this->match->notCalledPlayers()->syncWithoutDetaching([
            $playerId => [
                'reason' => $reason ?: null,
                'created_user' => auth()->user()->id,
                'updated_user' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        
        // Refrescar partido
        $this->match = $this->match->fresh(['players', 'notCalledPlayers']);
    }
    
    public function removeFromNotCalled($playerId)
    {
        // Eliminar razón
        if (isset($this->notCalledPlayerReasons[$playerId])) {
            unset($this->notCalledPlayerReasons[$playerId]);
        }
        
        // Añadir de vuelta a jugadores disponibles
        if (!in_array($playerId, $this->notCalledPlayers)) {
            $this->notCalledPlayers[] = $playerId;
        }
        
        // Eliminar de jugadores no convocados en la base de datos
        $this->match->notCalledPlayers()->detach($playerId);
        
        // Refrescar partido
        $this->match = $this->match->fresh(['players', 'notCalledPlayers']);
    }
    
    public function toggleCard($playerId, $cardType)
    {
        // Cargar estado actual de tarjetas desde la base de datos
        $player = $this->match->players()->where('player_id', $playerId)->first();
        
        if (!$player) {
            return;
        }
        
        $currentValue = $player->pivot->$cardType ?? false;
        
        // Si se activa tarjeta roja, eliminar tarjetas amarillas
        if ($cardType === 'card_red' && !$currentValue) {
            $this->match->players()->updateExistingPivot($playerId, [
                'card_yellow1' => false,
                'card_yellow2' => false,
                'card_red' => true,
                'updated_at' => now(),
            ]);
        }
        // Si se activa segunda amarilla, añadir automáticamente tarjeta roja
        elseif ($cardType === 'card_yellow2' && !$currentValue) {
            $this->match->players()->updateExistingPivot($playerId, [
                'card_yellow2' => true,
                'card_red' => true,
                'updated_at' => now(),
            ]);
        }
        // Alternar normal
        else {
            $this->match->players()->updateExistingPivot($playerId, [
                $cardType => !$currentValue,
                'updated_at' => now(),
            ]);
        }
        
        // Refrescar partido para obtener datos actualizados del pivot
        $this->match->refresh();
    }
    
    public function updatedFootballType()
    {
        // Reiniciar formación y alineación cuando cambia el tipo de fútbol
        $this->formation = '';
        $this->lineup = [];
    }
    
    public function updatedFormation()
    {
        // Reiniciar alineación cuando cambia la formación
        $this->lineup = [];
    }
    
    public function addToLineup($playerId, $lineIndex, $positionIndex)
    {
        // Inicializar estructura de alineación si está vacía
        if (empty($this->lineup)) {
            $this->lineup = [];
        }
        
        // Eliminar jugador de cualquier posición anterior
        foreach ($this->lineup as $line => $positions) {
            foreach ($positions as $pos => $pid) {
                if ($pid == $playerId) {
                    unset($this->lineup[$line][$pos]);
                }
            }
        }
        
        // Añadir jugador a nueva posición
        if (!isset($this->lineup[$lineIndex])) {
            $this->lineup[$lineIndex] = [];
        }
        $this->lineup[$lineIndex][$positionIndex] = $playerId;
    }
    
    public function removeFromLineup($playerId)
    {
        foreach ($this->lineup as $line => $positions) {
            foreach ($positions as $pos => $pid) {
                if ($pid == $playerId) {
                    unset($this->lineup[$line][$pos]);
                }
            }
        }
    }
    
    public function openAddExternalPlayerModal()
    {
        $this->showAddExternalPlayerModal = true;
        $this->selectedExternalTeamId = '';
        $this->externalPlayers = [];
        $this->searchExternalPlayer = '';
    }
    
    public function closeAddExternalPlayerModal()
    {
        $this->showAddExternalPlayerModal = false;
        $this->selectedExternalTeamId = '';
        $this->externalPlayers = [];
        $this->searchExternalPlayer = '';
    }
    
    public function updatedSelectedExternalTeamId()
    {
        if ($this->selectedExternalTeamId) {
            $this->loadExternalPlayers();
        } else {
            $this->externalPlayers = [];
        }
    }
    
    public function loadExternalPlayers()
    {
        if (!$this->selectedExternalTeamId) {
            $this->externalPlayers = [];
            return;
        }
        
        $team = Team::find($this->selectedExternalTeamId);
        if ($team) {
            $this->externalPlayers = $team->players()
                ->select('players.id', 'players.name', 'players.surname', 'players.player_photo', 'players.position', 'players.dni')
                ->orderBy('surname')
                ->orderBy('name')
                ->get()
                ->toArray();
        }
    }
    
    public function addExternalPlayer($playerId)
    {
        if (count($this->calledPlayers) >= $this->maxPlayers) {
            session()->flash('error', 'No se pueden convocar más de ' . $this->maxPlayers . ' jugadores.');
            return;
        }
        
        if (!in_array($playerId, $this->calledPlayers)) {
            $this->calledPlayers[] = $playerId;
            
            // Remove from notCalledPlayers if it was there
            $this->notCalledPlayers = array_diff($this->notCalledPlayers, [$playerId]);
            
            // Clear reason when adding player
            if (isset($this->playerReasons[$playerId])) {
                unset($this->playerReasons[$playerId]);
            }
            
            $this->closeAddExternalPlayerModal();
            session()->flash('message', 'Jugador añadido correctamente a la convocatoria.');
        }
    }

    public function update()
    {
        $this->validate();

        // Manejar subida de archivo para escudo
        $escudoPath = $this->escudo_team_oponent;
        if ($this->newEscudoTeamOponent) {
            // Eliminar archivo antiguo si existe
            if ($this->escudo_team_oponent && \Storage::disk('public')->exists($this->escudo_team_oponent)) {
                \Storage::disk('public')->delete($this->escudo_team_oponent);
            }
            // Guardar nuevo archivo
            $escudoPath = $this->newEscudoTeamOponent->store('escudos', 'public');
        }
        
        // Manejar subida de imágenes del partido
        if ($this->newMatchImages) {
            foreach ($this->newMatchImages as $image) {
                $path = $image->store('match-images', 'public');
                $this->matchImages[] = $path;
            }
            $this->newMatchImages = [];
        }

        $this->match->update([
            'season_id' => $this->season_id,
            'team_id' => $this->team_id,
            'opponent' => $this->opponent,
            'date' => $this->date,
            'hour_match' => $this->hour_match,
            'hour_meeting' => $this->hour_meeting,
            'site' => $this->site,
            'observations' => $this->observations,
            'match_description' => $this->match_description,
            'goals_team' => $this->goals_team ?: null,
            'goals_oponent' => $this->goals_oponent ?: null,
            'escudo_team_oponent' => $escudoPath,
            'sites' => $this->sites ?: null,
            'formation' => $this->formation ?: null,
            'lineup' => $this->lineup ?: null,
            'football_type' => $this->footballType,
            'published' => $this->published,
            'matchday' => $this->matchday ?: null,
            'web_description' => $this->web_description ?: null,
            'match_images' => $this->matchImages ?: null,
            'updated_user' => auth()->user()->id,
        ]);

        // Si se publica el partido, asegurar que el equipo también está publicado
        if ($this->published) {
            $team = Team::find($this->team_id);
            if ($team && !$team->published) {
                $team->update([
                    'published' => true,
                    'updated_user' => auth()->user()->id,
                ]);
            }
        }

        // Sincronizar SOLO jugadores convocados
        $syncData = [];
        foreach ($this->calledPlayers as $playerId) {
            $syncData[$playerId] = [
                'created_user' => auth()->user()->id,
                'updated_user' => auth()->user()->id,
                'reason_not_called' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        $this->match->players()->sync($syncData);

        // Sincronizar jugadores no convocados con sus razones
        $notCalledSyncData = [];
        foreach ($this->notCalledPlayerReasons as $playerId => $reason) {
            $notCalledSyncData[$playerId] = [
                'reason' => $reason ?: null,
                'created_user' => auth()->user()->id,
                'updated_user' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        $this->match->notCalledPlayers()->sync($notCalledSyncData);

        session()->flash('message', 'Partido modificado con éxito.');
        
        // Refrescar datos del partido
        $this->match = $this->match->fresh(['players', 'notCalledPlayers']);
        
        // Recargar jugadores convocados
        $calledPlayerIds = [];
        foreach ($this->match->players as $player) {
            $calledPlayerIds[] = $player->id;
            if ($player->pivot->reason_not_called) {
                $this->playerReasons[$player->id] = $player->pivot->reason_not_called;
            }
        }
        $this->calledPlayers = $calledPlayerIds;
        
        // Recargar jugadores no convocados con sus razones
        $this->notCalledPlayerReasons = [];
        foreach ($this->match->notCalledPlayers as $player) {
            $this->notCalledPlayerReasons[$player->id] = $player->pivot->reason ?? '';
        }
        
        // Recargar jugadores del equipo
        $this->loadTeamPlayers();
        
        // Despachar evento para notificar que los cambios fueron guardados
        $this->dispatch('changes-saved');
    }
    
    public function deleteMatchImage($index)
    {
        if (isset($this->matchImages[$index])) {
            $imagePath = $this->matchImages[$index];
            
            // Eliminar archivo del almacenamiento
            if (\Storage::disk('public')->exists($imagePath)) {
                \Storage::disk('public')->delete($imagePath);
            }
            
            // Eliminar del array
            unset($this->matchImages[$index]);
            $this->matchImages = array_values($this->matchImages); // Reindexar array
            
            // Actualizar base de datos
            $this->match->update([
                'match_images' => $this->matchImages ?: null,
                'updated_user' => auth()->user()->id,
            ]);
            
            session()->flash('message', 'Imagen eliminada con éxito.');
        }
    }

    public function printPDF()
    {
        // Recargar partido para asegurar datos actualizados
        $match = SeasonMatch::findOrFail($this->match->id);
        
        $pdf = new PdfFile();
        $pdf->file_name = 'convocatoria_' . $match->opponent;
        $pdf->templates[0] = 'pdfs.match-convocatoria';
        
        // Obtener jugadores convocados con detalles completos
        $calledPlayers = Player::whereIn('id', $this->calledPlayers)
            ->orderBy('surname')
            ->orderBy('name')
            ->get();
        
        $team = Team::find($this->team_id);
        
        // Usar clave única 'data' para que length() devuelva 1
        $pdf->records = ['data' => compact('match', 'calledPlayers', 'team')];

        $content = $pdf->generateFromTemplate($pdf->templates[0]);

        return response()->streamDownload(
            fn () => print($content),
            $pdf->getFileName()
        );
    }

    public function generateShareLink()
    {
        // Siempre generar un nuevo token con 48 horas de validez
        $this->match->generateShareToken();
        
        session()->flash('share_link', $this->match->getPublicUrl());
        session()->flash('message', 'Enlace generado correctamente. Este enlace será válido durante 48 horas.');
    }

    public function viewPublicConvocatoria()
    {
        if (!$this->match->share_token) {
            $this->match->generateShareToken();
        }
        
        return redirect()->route('public.convocatoria', ['token' => $this->match->share_token]);
    }

    public function render()
    {
        $seasons = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderBy('from_year', 'desc')
            ->get();

        $teams = Team::whereHas('season', function ($query) {
                $query->where('sports_school_id', auth()->user()->sports_school_id);
            })
            ->when($this->season_id, function ($query) {
                $query->where('season_id', $this->season_id);
            })
            ->with('category')
            ->orderBy('team')
            ->get();
        
        // Obtener todos los equipos para modal de jugador externo (excluyendo equipo actual)
        $allTeams = Team::whereHas('season', function ($query) {
                $query->where('sports_school_id', auth()->user()->sports_school_id);
            })
            ->where('id', '!=', $this->team_id)
            ->with('category', 'season')
            ->orderBy('team')
            ->get();

        // Obtener jugadores para columna de convocados con datos pivot
        $calledPlayersData = $this->match->players()
            ->whereIn('player_id', $this->calledPlayers)
            ->wherePivot('reason_not_called', null)
            ->orderBy('surname')
            ->orderBy('name')
            ->get();
            
        // Obtener jugadores para columna de disponibles (notCalledPlayers)
        $availablePlayersData = Player::whereIn('id', $this->notCalledPlayers)
            ->select('id', 'name', 'surname', 'player_photo', 'position', 'sports_school_id')
            ->orderBy('surname')
            ->orderBy('name')
            ->get();
        
        // Obtener jugadores para columna de no convocados con razón
        $notCalledWithReasonIds = array_keys($this->notCalledPlayerReasons);
        $notCalledPlayersData = Player::whereIn('id', $notCalledWithReasonIds)
            ->select('id', 'name', 'surname', 'player_photo', 'position', 'sports_school_id')
            ->orderBy('surname')
            ->orderBy('name')
            ->get();

        return view('livewire.matches.edit', [
            'seasons' => $seasons,
            'teams' => $teams,
            'calledPlayersData' => $calledPlayersData,
            'availablePlayersData' => $availablePlayersData,
            'notCalledPlayersData' => $notCalledPlayersData,
            'allTeams' => $allTeams,
        ]);
    }
}
