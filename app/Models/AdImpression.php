<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdImpression extends Model
{
    protected $fillable = [
        'placement_id',
        'creative_id',
        'site_id',
        'ad_zone_id',
        'ad_impression_id',
        'click_time',
        'ip_hash',
        'impression_time',
        'page_url',
        'user_agent',
        'metadata',
    ];

    protected $casts = [
        'impression_time' => 'datetime',
        'metadata' => 'array',
    ];

    public function placement()
    {
        return $this->belongsTo(Placement::class);
    }
}
