<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClubStory extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'sports_school_id', 'story_category_id', 'author_name', 'author_email',
        'title', 'body', 'consented_at', 'status', 'published_at',
        'reviewed_by', 'reviewed_at', 'review_note',
    ];

    protected $hidden = ['author_email', 'review_note'];

    protected function casts(): array
    {
        return ['published_at' => 'datetime', 'reviewed_at' => 'datetime', 'consented_at' => 'datetime'];
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('status', 'approved')->whereNotNull('published_at');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(StoryCategory::class, 'story_category_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(StoryMedia::class)->orderBy('position');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(StoryComment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(StoryLike::class);
    }
}
