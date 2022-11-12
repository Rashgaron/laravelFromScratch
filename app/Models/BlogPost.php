<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Scopes\LatestScope;

class BlogPost extends Model
{

    use SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id'];

    use HasFactory;
    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->latest();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeLatest(Builder $query){
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new LatestScope);

        static::deleting(function ($blogPost) {
            $blogPost->comments()->delete();
        });

        static::restoring(function ($blogPost) {
            $blogPost->comments()->restore();
        });
    }
}
