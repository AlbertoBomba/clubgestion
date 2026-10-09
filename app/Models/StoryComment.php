<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoryComment extends Model
{
    protected $fillable = [
        'author_name', 'author_email', 'body', 'consented_at', 'status',
        'reviewed_by', 'reviewed_at', 'review_note',
    ];

    protected $hidden = ['author_email', 'review_note'];

    public function story(): BelongsTo
    {
        return $this->belongsTo(ClubStory::class, 'club_story_id');
    }
}
