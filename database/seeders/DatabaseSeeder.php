<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\Comment;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $doe = User::factory()->johnDoe()->create();
        $else = User::factory(20)->create();
        
        $users = $else->concat([$doe]);

        $posts = BlogPost::factory(50)->make()->each(function($post) use ($users){
            $post->user_id = $users->random()->id;
            $post->save();
        });

        $comments = Comment::factory(150)->make()->each(function($comment) use ($posts){
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        });
    }
}
