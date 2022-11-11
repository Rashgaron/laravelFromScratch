@extends('layout');
@section('content')
    <form action="POST" action="{{ 'register' }}">
        @csrf
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="form-control">
        </div>
        <div class="form-group">
            <label for="">E-mail</label>
            <input type="text" name="email" value="{{ old('email') }}" required class="form-control">
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="text" name="password" value="" required class="form-control">
        </div>
        <div class="form-group">
            <label for="">Retyped Password</label>
            <input type="text" name="password_confirmation" value="" required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form>
@endsection
