<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'id', 'title','location','date','hours','time', 'signed_users', 'event_type', 'month', 'description', 'max_users','attended_users', 'completed', 'non_attended_users', 'censor_perms','priority','masterdoc'
    ];
}
