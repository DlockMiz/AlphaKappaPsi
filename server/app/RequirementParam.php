<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequirementParam extends Model
{
    protected $fillable = [
        'id', 'event_type','parameters'
    ];
}
