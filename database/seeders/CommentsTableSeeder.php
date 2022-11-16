<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\BlogPost;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $posts = BlogPost::all();

        if($posts->count() === 0)
        {
            $this->command->info("There are no blog posts, so no comments will we added");
            return;
        }

        $commentsCount= (int)$this->command->ask('How many comments would you like?', 150);
        $users = User::all();

        Comment::factory($commentsCount)->make()->each(function($comment) use ($posts, $users){
            $comment->commentable_id = $posts->random()->id;
            $comment->commentable_type = BlogPost::class;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });

        Comment::factory($commentsCount)->make()->each(function($comment) use ($users){
            $comment->commentable_id = $users->random()->id;
            $comment->commentable_type = User::class;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });

        // Comment::factory($commentsCount)->make()->each(function($comment) use ($posts, $users){
        //     $comment->blog_post_id = $posts->random()->id;
        //     $comment->user_id = $users->random()->id;
        //     // dd($comment);
        //     $comment->save();
        // });
    }
}
