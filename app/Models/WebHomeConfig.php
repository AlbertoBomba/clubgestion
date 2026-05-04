<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BelongsToSportsSchool;

class WebHomeConfig extends Model
{
    use SoftDeletes, BelongsToSportsSchool;

    protected $table = 'web_home_config';

    protected $fillable = [
        'sports_school_id',
        'stats_years',
        'membership_show',
        'membership_title',
        'membership_subtitle',
        'benefit_1_title',
        'benefit_1_description',
        'benefit_2_title',
        'benefit_2_description',
        'benefit_3_title',
        'benefit_3_description',
        'membership_button_text',
        'membership_button_url',
        'contact_show',
        'contact_title',
        'contact_email',
        'contact_phone',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'stats_years'       => 'integer',
        'membership_show'   => 'boolean',
        'contact_show'      => 'boolean',
    ];

    public function sportsSchool()
    {
        return $this->belongsTo(SportsSchool::class);
    }
}
