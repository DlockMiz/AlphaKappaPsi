<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestedUser extends Model
{
    protected $fillable = [
        'id', 'password','email'
    ];
}
