<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\returnArgument;

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
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'article_activity', 'article_id', 'activity_id');
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
