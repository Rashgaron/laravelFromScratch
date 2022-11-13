@extends('layouts.app')

@section('title', $post['title'])

@section('content')
    @if (now()->diffInMinutes($post->created_at) < 50)
        {{-- @badge(['type'=>'primary'])
            Brand New Post!
        @endbadge --}}
        <x-badge>
            Brand New Post!
        </x-badge>
    @endif
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <p>Added {{ $post->created_at->diffForHumans() }}</p>
    <h2>Comments: </h2>
    @forelse ($post->comments as $comment)
        <p>{{ $comment->content }}</p>
        <p>Added {{ $comment->created_at->diffForHumans() }}</p>
    @empty
        <p>No comments yet</p>
    @endforelse
@endsection
