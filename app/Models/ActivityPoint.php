<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityPoint extends Model
{
    protected $fillable = [
        'activty_id',
        'latitude',
        'longitude',
        'sequence',
    ];
}
