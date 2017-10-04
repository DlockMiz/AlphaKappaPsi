<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CalendarEvent extends Model
{
    protected $fillable = [
        'id', 'description','event_date','location'
    ];
}
