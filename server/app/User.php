<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'id', 'password','email','status','grad_date','phone_number','major_minor','google_email','noti_email','dues'
    ];
    // protected $hidden = [
    //     // 'password'
    // ];
}
