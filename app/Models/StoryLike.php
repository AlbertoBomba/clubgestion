<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoryLike extends Model
{
    protected $fillable = ['visitor_hash', 'status', 'reviewed_by', 'reviewed_at', 'review_note'];

    protected $hidden = ['visitor_hash', 'review_note'];

    public function story(): BelongsTo
    {
        return $this->belongsTo(ClubStory::class, 'club_story_id');
    }
}
