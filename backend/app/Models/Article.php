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

    public function destination(){
        return $this->belongsTo(Destination::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
