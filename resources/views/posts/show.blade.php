@extends('layouts.app')

@section('title', $post['title'])

@section('content')

    <div class="row">
        <div class="col-8">
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
            <x-tags :tags="$post->tags" />
            <p>Currently read by {{ $counter }} people</p>

            <h2>Comments: </h2>
            @forelse ($post->comments as $comment)
                <p>{{ $comment->content }}</p>
                <x-updated date="{{ $comment->created_at }}" />
            @empty
                <p>No comments yet</p>
            @endforelse
        </div>
        <div class="col-4">
            @include('posts._activity');
        </div>
    </div>
@endsection
