<div class="mb-2 mt-2">
    @auth
        <form action="{{ route('posts.comments.store', ['post' => $post->id]) }}" method="POST">
            @csrf
            <div>
                <div class="form-group">
                    <textarea id="title" type="text" class="form-control" name="content">
                    </textarea>
                </div>
                <input class="btn btn-primary btn-block" type="submit" value="Add comment">
            </div>
        </form>
        <x-errors
            :errors="$errors"
        />
    @else
        <a href="{{ route('login') }}">Sign-in</a> to post comments!
    @endauth
    <hr>
</div>
