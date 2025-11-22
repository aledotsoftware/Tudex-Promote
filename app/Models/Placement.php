<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Placement extends Model
{
    protected $fillable = [
        'creative_id',
        'ad_zone_id',
        'site_id',
    ];

    public function creative()
    {
        return $this->belongsTo(Creative::class);
    }

    public function adZone()
    {
        return $this->belongsTo(AdZone::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
