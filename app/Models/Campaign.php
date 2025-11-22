<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'advertiser_id',
        'name',
        'budget',
        'start_at',
        'end_at',
        'model',
        'is_active',
        'title_color',
        'description_color',
        'accent_color',
        'font_family',
    ];

    public function creatives()
    {
        return $this->hasMany(Creative::class);
    }
}
