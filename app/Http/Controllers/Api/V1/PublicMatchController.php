<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SeasonMatch;
use App\Models\SportsSchool;
use App\Models\Player;
use App\Models\ApiLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PublicMatchController extends Controller
{
    /**
     * Registrar log de API de forma asíncrona
     */
    private function logApiRequest(Request $request, ?SportsSchool $sportsSchool, int $statusCode, ?string $errorMessage = null): void
    {
        try {
            $startTime = defined('LARAVEL_START') ? LARAVEL_START : microtime(true);
            $responseTime = (int)((microtime(true) - $startTime) * 1000);

            // Registrar después de enviar la respuesta
            register_shutdown_function(function () use ($request, $sportsSchool, $statusCode, $responseTime, $errorMessage) {
                try {
                    ApiLog::logRequest(
                        sportsSchoolId: $sportsSchool?->id,
                        endpoint: $request->path(),
                        method: $request->method(),
                        statusCode: $statusCode,
                        ipAddress: $request->ip(),
                        userAgent: $request->userAgent(),
                        referer: $request->headers->get('referer'),
                        requestParams: $request->query->count() > 0 ? $request->query->all() : null,
                        responseTime: $responseTime,
                        errorMessage: $errorMessage
                    );
                } catch (\Exception $e) {
                    // Silenciosamente ignorar errores de logging
                }
            });
        } catch (\Exception $e) {
            // Silenciosamente ignorar errores de logging
        }
    }

    /**
     * Obtener partidos públicos de una escuela deportiva por dominio
     */
    public function index(Request $request)
    {
        $domain = $request->input('domain');
        
        // Si no se proporciona dominio, intentar extraer del referer
        if (!$domain) {
            $referer = $request->headers->get('referer');
            if ($referer) {
                $parsedUrl = parse_url($referer);
                $domain = $parsedUrl['host'] ?? null;
            }
        }
        
        // Validar que se proporciona el dominio
        if (!$domain) {
            $this->logApiRequest($request, null, 400, 'Domain parameter is required');
            return response()->json([
                'success' => false,
                'message' => 'Domain parameter is required',
            ], 400);
        }
        
        // Limpiar dominio (eliminar www. si está presente)
        $domain = preg_replace('/^www\./', '', $domain);
        
        // Buscar escuela deportiva por dominio
        $sportsSchool = Cache::remember("sports_school_domain_{$domain}", 3600, function () use ($domain) {
            return SportsSchool::where('domain', $domain)
                ->orWhere('domain', 'www.' . $domain)
                ->first();
        });
        
        if (!$sportsSchool) {
            $this->logApiRequest($request, null, 404, 'Sports school not found for this domain');
            return response()->json([
                'success' => false,
                'message' => 'Sports school not found for this domain',
            ], 404);
        }
        
        // Validar CORS - verificar que la petición viene del dominio registrado
        $referer = $request->headers->get('referer');
        if ($referer) {
            $refererHost = parse_url($referer, PHP_URL_HOST);
            $refererHost = preg_replace('/^www\./', '', $refererHost);
            
            if ($refererHost !== $domain) {
                $this->logApiRequest($request, $sportsSchool, 403, 'Unauthorized domain');
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized domain',
                ], 403);
            }
        }
        
        // Verificar si hay una temporada activa
        $activeSeason = \App\Models\Season::where('sports_school_id', $sportsSchool->id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
        
        if (!$activeSeason) {
            $this->logApiRequest($request, $sportsSchool, 200);
            return response()->json([
                'success' => false,
                'message' => 'El club no tiene ninguna temporada activa',
                'data' => [],
                'meta' => [
                    'total' => 0,
                    'sports_school' => [
                        'name' => $sportsSchool->name,
                        'logo' => $sportsSchool->logo ? asset('storage/' . $sportsSchool->logo) : null,
                    ],
                ],
            ], 200);
        }
        
        // Obtener filtros
        $limit = $request->input('limit', 10);
        $teamId = $request->input('team_id');
        $upcoming = $request->input('upcoming', false);
        $past = $request->input('past', false);
        
        // Construir consulta
        $query = SeasonMatch::where('sports_school_id', $sportsSchool->id)
            ->where('season_id', $activeSeason->id)
            ->where('published', true)
            ->whereHas('team', function($q) {
                $q->where('published', true);
            })
            ->with(['team.category', 'season']);
        
        // Aplicar filtros
        if ($teamId) {
            $query->where('team_id', $teamId);
        }
        
        if ($upcoming) {
            $query->where('date', '>=', now());
        }
        
        if ($past) {
            $query->where('date', '<', now());
        }
        
        // Ordenar y paginar
        $query->orderBy('date', 'desc');
        
        if ($limit > 0 && $limit <= 100) {
            $query->limit($limit);
        }
        
        $matches = $query->get();
        
        // Transformar datos
        $data = $matches->map(function ($match) {
            return [
                'id' => $match->id,
                'date' => $match->date->format('Y-m-d'),
                'hour_match' => $match->hour_match ? $match->hour_match->format('H:i') : null,
                'hour_meeting' => $match->hour_meeting ? $match->hour_meeting->format('H:i') : null,
                'opponent' => $match->opponent,
                'site' => $match->site,
                'sites' => $match->sites,
                'goals_team' => $match->goals_team,
                'goals_oponent' => $match->goals_oponent,
                'escudo_team_oponent' => $match->escudo_team_oponent ? asset('storage/' . $match->escudo_team_oponent) : null,
                'matchday' => $match->matchday,
                'web_description' => $match->web_description,
                'match_images' => $match->match_images ? array_map(function($img) {
                    return asset('storage/' . $img);
                }, $match->match_images) : [],
                'team' => [
                    'id' => $match->team->id,
                    'name' => $match->team->team,
                    'category' => $match->team->category ? $match->team->category->name : null,
                ],
                'season' => [
                    'id' => $match->season->id,
                    'name' => $match->season->season,
                ],
            ];
        });
        
        $this->logApiRequest($request, $sportsSchool, 200);
        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'total' => $matches->count(),
                'sports_school' => [
                    'name' => $sportsSchool->name,
                    'logo' => $sportsSchool->logo ? asset('storage/' . $sportsSchool->logo) : null,
                ],
            ],
        ]);
    }
    
    /**
     * Obtener equipos disponibles para una escuela deportiva
     */
    public function teams(Request $request)
    {
        $domain = $request->input('domain');
        
        if (!$domain) {
            $referer = $request->headers->get('referer');
            if ($referer) {
                $parsedUrl = parse_url($referer);
                $domain = $parsedUrl['host'] ?? null;
            }
        }
        
        if (!$domain) {            $this->logApiRequest($request, null, 400, 'Domain parameter is required');            return response()->json([
                'success' => false,
                'message' => 'Domain parameter is required',
            ], 400);
        }
        
        $domain = preg_replace('/^www\./', '', $domain);
        
        $sportsSchool = SportsSchool::where('domain', $domain)
            ->orWhere('domain', 'www.' . $domain)
            ->first();
        
        if (!$sportsSchool) {
            $this->logApiRequest($request, null, 404, 'Sports school not found for this domain');
            return response()->json([
                'success' => false,
                'message' => 'Sports school not found for this domain',
            ], 404);
        }
        
        // Verificar si hay una temporada activa
        $activeSeason = \App\Models\Season::where('sports_school_id', $sportsSchool->id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
        
        if (!$activeSeason) {
            $this->logApiRequest($request, $sportsSchool, 200);
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }
        
        $teams = \App\Models\Team::where('season_id', $activeSeason->id)
            ->where('published', true)
            ->with('category')
            ->orderBy('team')
            ->get()
            ->map(function ($team) {
                return [
                    'id' => $team->id,
                    'name' => $team->team,
                    'category' => $team->category ? $team->category->name : null,
                ];
            });
        
        $this->logApiRequest($request, $sportsSchool, 200);
        return response()->json([
            'success' => true,
            'data' => $teams,
        ]);
    }
    
    /**
     * Obtener detalles del partido incluyendo alineación y jugadores
     */
    public function show(Request $request, $id)
    {
        $domain = $request->input('domain');
        
        if (!$domain) {
            $referer = $request->headers->get('referer');
            if ($referer) {
                $parsedUrl = parse_url($referer);
                $domain = $parsedUrl['host'] ?? null;
            }
        }
        
        if (!$domain) {
            $this->logApiRequest($request, null, 400, 'Domain parameter is required');
            return response()->json([
                'success' => false,
                'message' => 'Domain parameter is required',
            ], 400);
        }
        
        $domain = preg_replace('/^www\\./', '', $domain);
        
        $sportsSchool = SportsSchool::where('domain', $domain)
            ->orWhere('domain', 'www.' . $domain)
            ->first();
        
        if (!$sportsSchool) {
            $this->logApiRequest($request, null, 404, 'Sports school not found for this domain');
            return response()->json([
                'success' => false,
                'message' => 'Sports school not found for this domain',
            ], 404);
        }
        
        // Obtener partido con relaciones
        $match = SeasonMatch::where('id', $id)
            ->where('sports_school_id', $sportsSchool->id)
            ->where('published', true)
            ->whereHas('team', function($q) {
                $q->where('published', true);
            })
            ->with(['team.category', 'season', 'players'])
            ->first();
        
        if (!$match) {
            $this->logApiRequest($request, $sportsSchool, 404, 'Match not found');
            return response()->json([
                'success' => false,
                'message' => 'Match not found',
            ], 404);
        }
        
        // Preparar datos de alineación - transformar estructura de alineación a detalles de jugadores
        $startingLineup = [];
        $benchPlayers = [];
        
        try {
            if ($match->lineup && is_array($match->lineup) && !empty($match->lineup)) {
                // Obtener todos los jugadores convocados
                $calledPlayerIds = [];
                if ($match->players) {
                    $calledPlayerIds = $match->players->pluck('id')->toArray();
                }
                
                // Extraer titulares de la estructura de alineación (lineup es [lineIndex => [positionIndex => playerId]])
                $starterIds = [];
                foreach ($match->lineup as $line => $positions) {
                    if (is_array($positions)) {
                        foreach ($positions as $position => $playerId) {
                            if ($playerId) {
                                $starterIds[] = (int)$playerId;
                            }
                        }
                    }
                }
                
                // Eliminar duplicados
                $starterIds = array_unique($starterIds);
                
                // Obtener detalles de jugadores titulares
                if (!empty($starterIds)) {
                    $starterPlayers = Player::whereIn('id', $starterIds)->get();
                    foreach ($starterIds as $playerId) {
                        $player = $starterPlayers->firstWhere('id', $playerId);
                        if ($player) {
                            $startingLineup[] = [
                                'id' => $player->id,
                                'name' => trim(($player->name ?? '') . ' ' . ($player->last_name ?? '')),
                                'number' => $player->dorsal_number ?? null,
                                'player_photo' => $player->player_photo ? asset('storage/' . $player->player_photo) : null
                            ];
                        }
                    }
                }
                
                // Obtener jugadores suplentes (convocados pero no en alineación titular)
                if (!empty($calledPlayerIds)) {
                    $benchPlayerIds = array_diff($calledPlayerIds, $starterIds);
                    if (!empty($benchPlayerIds)) {
                        $benchPlayersList = Player::whereIn('id', $benchPlayerIds)->get();
                        foreach ($benchPlayersList as $player) {
                            $benchPlayers[] = [
                                'id' => $player->id,
                                'name' => trim(($player->name ?? '') . ' ' . ($player->last_name ?? '')),
                                'number' => $player->dorsal_number ?? null,
                                'player_photo' => $player->player_photo ? asset('storage/' . $player->player_photo) : null
                            ];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Registrar error pero continuar - la alineación es opcional
            Log::error('Error processing match lineup', [
                'match_id' => $id,
                'error' => $e->getMessage(),
                'lineup' => $match->lineup
            ]);
        }
        
        // Transformar datos
        $data = [
            'id' => $match->id,
            'date' => $match->date ? $match->date->format('Y-m-d') : null,
            'hour_match' => $match->hour_match ? $match->hour_match->format('H:i') : null,
            'hour_meeting' => $match->hour_meeting ? $match->hour_meeting->format('H:i') : null,
            'opponent' => $match->opponent ?? '',
            'site' => $match->site ?? '',
            'sites' => $match->sites ?? '',
            'goals_team' => $match->goals_team,
            'goals_oponent' => $match->goals_oponent,
            'escudo_team_oponent' => $match->escudo_team_oponent ? asset('storage/' . $match->escudo_team_oponent) : null,
            'matchday' => $match->matchday,
            'web_description' => $match->web_description ?? '',
            'match_images' => $match->match_images ? array_map(function($img) {
                return asset('storage/' . $img);
            }, $match->match_images) : [],
            'formation' => $match->formation ?? '',
            'lineup' => [
                'starters' => $startingLineup,
                'bench' => $benchPlayers,
            ],
            'team' => $match->team ? [
                'id' => $match->team->id,
                'name' => $match->team->team ?? '',
                'category' => $match->team->category ? $match->team->category->name : null,
            ] : null,
            'season' => $match->season ? [
                'id' => $match->season->id,
                'name' => $match->season->season ?? '',
            ] : null,
        ];
        
        $this->logApiRequest($request, $sportsSchool, 200);
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
