<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';

    protected $fillable = [
        'title',
        'content',
        'visit_count',
        'user_id',
        'destination_id',
    ];
}
