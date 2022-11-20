<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted as EventsCommentPosted;
use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\SendCommentEmail;
use App\Mail\CommentPosted;
use App\Models\BlogPost;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function index(BlogPost $post)
    {
        return $post->comments()->with('user')->get();
    }

    // posts/{post}/comments
    // Laravel automaticamente hace el find del post por id si lo pones en el parámetro
    // Por eso, además de tener la request, también hemos puesto el $post
    // Otra opción sería coger el postId de la request y hacer el fetch a mano 

    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        $this->dispatch(new SendCommentEmail($post, $comment));

        NotifyUsersPostWasCommented::dispatch($comment);

        event(new CommentPosted($comment));

        return redirect()->back()
            ->withStatus('Comment was created!');
    }
}
