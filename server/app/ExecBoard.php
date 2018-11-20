<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExecBoard extends Model
{
    protected $fillable = [
        'id', 'name','desc','info'
    ];
}
