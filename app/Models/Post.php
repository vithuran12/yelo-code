<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'slug',
        'color',
        'category_id',
        'content',
        'thumbnail',
        'tags',
        'published',
        
    ]; 

    protected $casts=[
        'tags'=>'array',
    ];//if send json format data should add this for tab 

    public function category(){
        return $this->belongsTo(Category::class);
    }//for connect category table data


    public function authors(){//for many to many relation ship
        return $this->belongsToMany(User::class,'post_users')->withPivot(['order'])->withTimestamps();
    }//for connect post_user table data

    public function comments()//polymorpic relationship
    {
        return $this->morphMany(Comment::class, 'commentable');//one to many relationship
    }
}
