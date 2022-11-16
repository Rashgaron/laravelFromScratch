@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-4">
            <img src="{{ $user->image ? $user->image->url() : '' }}" alt="" class="img-thumbnail avatar">
        </div>
        <div class="col-8">
            <h3>{{ $user->name }}</h3>
        </div>
        <x-commentForm :route="route('users.comments.store', ['user' => $user->id])" :errors="$errors" />
        <x-commentList :comments="$user->commentsOn" />
    </div>
@endsection
