<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveRequirement extends Model
{
    protected $fillable = [
        'id', 'absence', 'unexcused','spring_basketball','fall_basketball', 'fall_football','service','prof_dev','dues'
    ];
}
