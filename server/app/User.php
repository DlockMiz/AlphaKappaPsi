<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'id', 'password','email','status'
    ];
    // protected $hidden = [
    //     // 'password'
    // ];
}
