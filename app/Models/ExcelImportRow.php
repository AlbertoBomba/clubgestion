<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExcelImportRow extends Model
{
    use HasFactory;

    protected $fillable = [
        'sports_school_id',
        'row_hash',
        'payment_id',
        'imported_at',
    ];

    protected $casts = [
        'imported_at' => 'datetime',
    ];

    public function sportsSchool(): BelongsTo
    {
        return $this->belongsTo(SportsSchool::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(PaymentPlayer::class, 'payment_id');
    }

    /**
     * Generar hash MD5 del contenido de una fila
     */
    public static function generateRowHash(array $row): string
    {
        // Filtrar valores vacíos y normalizar
        $cleanRow = array_map(function($value) {
            return trim(strtoupper($value ?? ''));
        }, array_filter($row, function($value) {
            return !empty(trim($value ?? ''));
        }));
        
        // Ordenar para que el orden no afecte el hash
        sort($cleanRow);
        
        return md5(implode('|', $cleanRow));
    }

    /**
     * Verificar si una fila ya fue procesada
     */
    public static function isRowProcessed(string $rowHash, int $sportsSchoolId): bool
    {
        return self::where('sports_school_id', $sportsSchoolId)
            ->where('row_hash', $rowHash)
            ->exists();
    }

    /**
     * Registrar una fila procesada
     */
    public static function registerRow(string $rowHash, int $sportsSchoolId, ?int $paymentId = null): self
    {
        return self::create([
            'sports_school_id' => $sportsSchoolId,
            'row_hash' => $rowHash,
            'payment_id' => $paymentId,
            'imported_at' => now(),
        ]);
    }
}
