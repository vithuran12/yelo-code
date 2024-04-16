<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $guarded=[];

    public function commentable()//define polymorphic relationship
    {
        return $this->morphTo();
    }

    public function user()//relate with user table
    {
        return $this->belongsTo(User::class);
    }

    public function comments()//polymorpic relationship
    {
        return $this->morphMany(Comment::class, 'commentable');//one to many relationship
    }
}
