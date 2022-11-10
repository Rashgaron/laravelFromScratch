<div>{{$key}}.{{$post->title}}</div>
<div style="background-color: silver">{{$post->content}}</div>
<div>
    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
        @csrf
        @method("DELETE")
        <input type="submit" value="Delete!">
    </form>
</div>