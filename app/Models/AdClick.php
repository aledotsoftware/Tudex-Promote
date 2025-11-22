<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdClick extends Model
{
    protected $fillable = [
        'placement_id',
        'creative_id',
        'site_id',
        'ad_zone_id',
        'ad_impression_id',
        'click_time',
    ];

    protected $casts = [
        'click_time' => 'datetime',
    ];

    public function placement()
    {
        return $this->belongsTo(Placement::class);
    }
}
