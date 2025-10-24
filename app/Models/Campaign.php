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
        'status',
    ];

    public function creatives()
    {
        return $this->hasMany(Creative::class);
    }
}
