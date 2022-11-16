<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Models\User;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    // posts/{post}/comments
    // Laravel automaticamente hace el find del post por id si lo pones en el parámetro
    // Por eso, además de tener la request, también hemos puesto el $post
    // Otra opción sería coger el postId de la request y hacer el fetch a mano 

    public function store(User $user, StoreComment $request)
    {
        $user->commentsOn()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        return redirect()->back()
            ->withStatus('Comment was created!');
    }
}
