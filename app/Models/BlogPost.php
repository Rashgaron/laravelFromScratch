<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

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

    public function scopeMostCommented(Builder $query)
    {
        //comments_count
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope);

        parent::boot();

        static::deleting(function ($blogPost) {
            $blogPost->comments()->delete();
        });

        static::restoring(function ($blogPost) {
            $blogPost->comments()->restore();
        });
    }
}
