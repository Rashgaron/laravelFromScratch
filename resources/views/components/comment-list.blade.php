@if ($comments)
    @foreach ($comments as $comment)
        <p>{{ $comment->content }}</p>
        {{-- {{dd($comment->tags)  }} --}}
        <x-tags :tags="$comment->tags" />
        @updated(['date' => $comment->created_at, 'name' => $comment->user->name, 'userId'=>$comment->user->id])
        @endupdated
    @endforeach
@else
    <p>No comments yet</p>
@endif
