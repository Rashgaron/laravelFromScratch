<?php

namespace App\Jobs;

use App\Mail\CommentPostedMarkdown;
use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCommentEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $comment;
    private $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(BlogPost $post, Comment $comment)
    {
        //
        $this->post = $post;
        $this->comment = $comment;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->post->user)->send(new CommentPostedMarkdown($this->comment));
    }
}
