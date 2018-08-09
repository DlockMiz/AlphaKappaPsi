<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChapterComment extends Model
{
    protected $fillable = [
        'id', 'chapter_id', 'comment'
    ];
}
