<a class="{{ $post->trashed() ? 'text-muted' : '' }}" href="{{ route('posts.show', ['post' => $post->id]) }}">
    @if ($post->trashed())
        <del>
    @endif
    <h3>{{ $key }}.{{ $post->title }}</h3>
    @if ($post->trashed())
        </del>
    @endif
    <div>{{ $post->content }}</div>
</a>

{{-- <p class="text-muted">
    Added {{ $post->created_at->diffForHumans() }}
    by {{ $post->user->name }}
</p> --}}

<x-updated date="{{ $post->created_at }}" name="{{ $post->user->name }}" :isTrashed="$post->trashed()">
</x-updated>

@if ($post->comments_count)
    <p>{{ $post->comments_count }} comments</p>
@else
    <p>No comments yet!</p>
@endif
<div class="mb-3">
    @auth
        @can('update', $post)
            <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
        @endcan
    @endauth
    @auth
        @if (!$post->trashed())
            @can('delete', $post)
                <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Delete!" class="btn btn-danger">
                </form>
            @endcan
        @endif
    @endauth
</div>
