<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $fillable = [
        'id','grad_date','phone_number','major_minor'
    ];
}
