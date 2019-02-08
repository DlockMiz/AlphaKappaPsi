<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordToken extends Model
{
    protected $fillable = [
        'id', 'password_token','email'
    ];
}
