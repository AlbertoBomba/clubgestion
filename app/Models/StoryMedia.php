<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoryMedia extends Model
{
    protected $table = 'story_media';

    protected $fillable = ['path', 'mime_type', 'size', 'position'];

    protected $hidden = ['path'];

    public function story(): BelongsTo
    {
        return $this->belongsTo(ClubStory::class, 'club_story_id');
    }

    public function views(): HasMany
    {
        return $this->hasMany(StoryMediaView::class);
    }

    public function isVideo(): bool
    {
        return str_starts_with($this->mime_type, 'video/');
    }
}
