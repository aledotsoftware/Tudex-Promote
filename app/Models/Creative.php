<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creative extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'file_url',
        'html_content',
        'click_url',
        'type',
        'is_active',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
