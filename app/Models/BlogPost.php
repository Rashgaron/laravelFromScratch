<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{

    use SoftDeletes;

    protected $fillable = ['title', 'content'];

    use HasFactory;
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($blogPost) {
            $blogPost->comments()->delete();
        });

        static::restoring(function ($blogPost) {
            $blogPost->comments()->restore();
        });
    }
}
