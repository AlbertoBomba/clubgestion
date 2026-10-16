<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoryMediaView extends Model
{
    protected $fillable = ['visitor_hash', 'viewed_on'];

    protected $hidden = ['visitor_hash'];

    public function media(): BelongsTo
    {
        return $this->belongsTo(StoryMedia::class, 'story_media_id');
    }
}
