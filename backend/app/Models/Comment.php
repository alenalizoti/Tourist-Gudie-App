<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'article_id',
        'author_name',
        'content'
    ];
    public function article(){
        $this->belongsTo(Article::class);
    }
}
