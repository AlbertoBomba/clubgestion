<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoryCategory extends Model
{
    use BelongsToTenant;

    protected $fillable = ['sports_school_id', 'name', 'slug'];

    public function stories(): HasMany
    {
        return $this->hasMany(ClubStory::class);
    }
}
