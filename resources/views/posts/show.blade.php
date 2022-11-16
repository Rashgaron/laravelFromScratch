@extends('layouts.app')

@section('title', $post['title'])

@section('content')

    <div class="row">
        <div class="col-8">

            @if ($post->image)
                <div
                    style="background-image: url('{{ $post->image->url() }}'); min-height: 500px; color: white; text-align:center; background-attachment: fixed;">
                    <h1 style="padding-top: 100px; text-shadow: 1px 2px #000;">
                    @else
                        <h1>
            @endif
            <h1>{{ $post->title }}
                <x-badge :show="now()->diffInMinutes($post->created_at) < 50" type="primary">
                    Brand New Post!
                </x-badge>
            </h1>
            @if ($post->image)
                </h1>
        </div>
    @else
        </h1>
        @endif

        <p>{{ $post->content }}</p>

        <x-updated date="{{ $post->created_at }}" name="{{ $post->user->name }}" :isTrashed="$post->trashed()" />

        <x-updated date="{{ $post->updated_at }}" name="{{ $post->user->name }}" :isTrashed="$post->trashed()">
            Updated
        </x-updated>
        <x-tags :tags="$post->tags" />
        <p>Currently read by {{ $counter }} people</p>

        <h2>Comments: </h2>
        <x-commentForm :route="route('posts.comments.store', ['post' => $post->id])" :errors="$errors" />

        <x-commentList :comments="$post->comments" />

        
    </div>
    <div class="col-4">
        @include('posts._activity');
    </div>
    </div>
@endsection
