<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SwitchRequest extends Model
{
    protected $fillable = [
        'id', 'poster_id','switcher_id','event_id'
    ];
}
