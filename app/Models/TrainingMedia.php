<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingMedia extends Model
{
    use HasFactory;

    protected $table = 'training_media';

    protected $fillable = [
        'training_id',
        'file_path',
        'file_name',
        'file_type',
        'mime_type',
        'file_size',
        'order',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the training that owns the media.
     */
    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    /**
     * Get the full URL of the media file.
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Check if the media is an image.
     */
    public function isImage(): bool
    {
        return $this->file_type === 'image';
    }

    /**
     * Check if the media is a video.
     */
    public function isVideo(): bool
    {
        return $this->file_type === 'video';
    }
}
