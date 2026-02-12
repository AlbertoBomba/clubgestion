<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sports_school_id',
        'endpoint',
        'method',
        'status_code',
        'ip_address',
        'user_agent',
        'referer',
        'request_params',
        'response_time',
        'error_message',
        'created_at',
    ];

    protected $casts = [
        'request_params' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Relación con SportsSchool
     */
    public function sportsSchool(): BelongsTo
    {
        return $this->belongsTo(SportsSchool::class);
    }

    /**
     * Registrar un log de API
     */
    public static function logRequest(
        ?int $sportsSchoolId,
        string $endpoint,
        string $method,
        int $statusCode,
        ?string $ipAddress = null,
        ?string $userAgent = null,
        ?string $referer = null,
        ?array $requestParams = null,
        ?int $responseTime = null,
        ?string $errorMessage = null
    ): void {
        try {
            self::create([
                'sports_school_id' => $sportsSchoolId,
                'endpoint' => substr($endpoint, 0, 255),
                'method' => $method,
                'status_code' => $statusCode,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent ? substr($userAgent, 0, 500) : null,
                'referer' => $referer ? substr($referer, 0, 500) : null,
                'request_params' => $requestParams,
                'response_time' => $responseTime,
                'error_message' => $errorMessage ? substr($errorMessage, 0, 500) : null,
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Silenciosamente ignorar errores de logging para no afectar la API
        }
    }

    /**
     * Obtener logs recientes
     */
    public static function getRecent(int $limit = 100, ?int $sportsSchoolId = null)
    {
        $query = self::query()
            ->with('sportsSchool:id,name')
            ->orderBy('created_at', 'desc');

        if ($sportsSchoolId) {
            $query->where('sports_school_id', $sportsSchoolId);
        }

        return $query->limit($limit)->get();
    }

    /**
     * Obtener estadísticas de una escuela
     */
    public static function getStats(?int $sportsSchoolId = null, int $days = 7): array
    {
        $query = self::query()
            ->where('created_at', '>=', now()->subDays($days));

        if ($sportsSchoolId) {
            $query->where('sports_school_id', $sportsSchoolId);
        }

        $logs = $query->get();

        return [
            'total_requests' => $logs->count(),
            'successful_requests' => $logs->where('status_code', '<', 400)->count(),
            'failed_requests' => $logs->where('status_code', '>=', 400)->count(),
            'avg_response_time' => $logs->where('response_time', '>', 0)->avg('response_time'),
            'endpoints' => $logs->groupBy('endpoint')->map->count()->toArray(),
            'status_codes' => $logs->groupBy('status_code')->map->count()->toArray(),
        ];
    }

    /**
     * Limpiar logs antiguos
     */
    public static function cleanup(int $days = 90): int
    {
        return self::where('created_at', '<', now()->subDays($days))->delete();
    }
}
