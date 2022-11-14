<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Models\BlogPost;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    // posts/{post}/comments
    // Laravel automaticamente hace el find del post por id si lo pones en el parámetro
    // Por eso, además de tener la request, también hemos puesto el $post
    // Otra opción sería coger el postId de la request y hacer el fetch a mano 

    public function store(BlogPost $post, StoreComment $request)
    {
        $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);
        $request->session()->flash('status', 'Comment was created!');
        return redirect()->back();
    }
}
