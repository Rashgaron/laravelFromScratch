@extends('layouts.app')
@section('title', 'Contact page')
@section('content')
    <h1>Contact page</h1>

    @can('home.secret')
        <p>
            <a href="{{ route('secret') }}">
                Go to Special contact detail
            </a>
        </p>
    @endcan
@endsection
