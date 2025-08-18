<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($post) {
            if (empty($post->slug)) {
                $post->slug = \Str::slug($post->title);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function scopeWithUser($query)
    {
        return $query->with('user');
    }

    public function scopeWithComments($query)
    {
        return $query->with(['comments.user', 'comments' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }]);
    }
}
