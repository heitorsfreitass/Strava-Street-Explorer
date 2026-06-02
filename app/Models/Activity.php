<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'strava_id',
        'name',
        'sport_type',
        'distance',
        'moving_time',
        'started_at',
    ];

    public function points()
    {
        return $this->hasMany(ActivityPoint::class);
    }
}
