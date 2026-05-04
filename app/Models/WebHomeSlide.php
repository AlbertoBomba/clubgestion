<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BelongsToSportsSchool;

class WebHomeSlide extends Model
{
    use SoftDeletes, BelongsToSportsSchool;

    protected $fillable = [
        'sports_school_id',
        'title',
        'subtitle',
        'button_text',
        'button_url',
        'media_type',
        'media_path',
        'background_color',
        'order',
        'active',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'active' => 'boolean',
        'order'  => 'integer',
    ];

    public function sportsSchool()
    {
        return $this->belongsTo(SportsSchool::class);
    }
}
