@extends('layouts.app')

@section('title', $post['title'])

@section('content')
    @if($post['is_new'])
        <div class="alert alert-success">
            New post!
        </div>
    @else
        <div class="alert alert-warning">
            Old post! 
        </div>
    @endif

    @unless($post['is_new'])
        <div class="alert alert-warning">
            It is an old post ... using unless
        </div>
    @endunless

    @isset($post['has_comments'])
        <div class="alert alert-info">
            This post has comments
        </div>
    @endisset
    <h1>{{ $post['title'] }}</h1>
    <p>{{ $post['content'] }}</p>
@endsection