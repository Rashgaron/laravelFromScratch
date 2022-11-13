@extends('layouts.app')

@section('title', $post['title'])

@section('content')
    <h1>{{ $post->title }}
        <x-badge :show="now()->diffInMinutes($post->created_at) < 50" type="primary">
            Brand New Post!
        </x-badge>
    </h1>

    <p>{{ $post->content }}</p>

    <x-updated date="{{ $post->created_at }}" name="{{ $post->user->name }}" :isTrashed="$post->trashed()" />

    <x-updated date="{{ $post->updated_at }}" name="{{ $post->user->name }}" :isTrashed="$post->trashed()">
        Updated
    </x-updated>

    <p>Currently read by {{ $counter }} people</p>

    <h2>Comments: </h2>
    @forelse ($post->comments as $comment)
        <p>{{ $comment->content }}</p>
        <x-updated date="{{ $comment->created_at }}" />
    @empty
        <p>No comments yet</p>
    @endforelse
@endsection
