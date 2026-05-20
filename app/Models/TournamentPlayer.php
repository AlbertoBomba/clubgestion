<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TournamentPlayer extends Model
{
    protected $fillable = [
        'tournament_team_id',
        'name',
        'surname',
        'birthdate',
        'dni',
        'doc_type',
        'position',
        'dorsal',
        'phone',
        'email',
        'photo',
        'signature',
        'doc_front',
        'doc_back',
        'status',
        'federado',
        'categoria',
        'extra_documents',
        'notes',
    ];

    protected $casts = [
        'birthdate'       => 'date',
        'dorsal'          => 'integer',
        'federado'        => 'boolean',
        'extra_documents' => 'array',
    ];

    // ──────────────────────────── Helpers

    public function fullName(): string
    {
        return trim($this->name . ' ' . ($this->surname ?? ''));
    }

    public function photoUrl(): ?string
    {
        return $this->photo ? Storage::url($this->photo) : null;
    }

    public function signatureUrl(): ?string
    {
        return $this->signature ? Storage::url($this->signature) : null;
    }

    public function docFrontUrl(): ?string
    {
        return $this->doc_front ? Storage::url($this->doc_front) : null;
    }

    public function docBackUrl(): ?string
    {
        return $this->doc_back ? Storage::url($this->doc_back) : null;
    }

    public static function docTypes(): array
    {
        return [
            'dni'      => 'DNI',
            'nie'      => 'NIE',
            'passport' => 'Pasaporte',
        ];
    }

    public static function statuses(): array
    {
        return [
            'pending'  => 'Pendiente',
            'approved' => 'Aprobado',
            'rejected' => 'Rechazado',
        ];
    }

    public static function positions(): array
    {
        return [
            'Portero', 'Defensa', 'Centrocampista', 'Delantero',
            'Lateral', 'Central', 'Pivote', 'Extremo', 'Mediapunta',
        ];
    }

    // ──────────────────────────── Relationships

    public function tournamentTeam()
    {
        return $this->belongsTo(TournamentTeam::class);
    }

    public function goals()
    {
        return $this->hasMany(TournamentMatchGoal::class);
    }

    public function cards()
    {
        return $this->hasMany(TournamentMatchCard::class);
    }

    public function sanctions()
    {
        return $this->hasMany(TournamentSanction::class);
    }
}
