@extends('layouts.app');
@section('content')
    <form method="POST" action="{{ 'login' }}">
        @csrf
        <div class="form-group">
            <label for="">E-mail</label>
            <input type="text" name="email" value="{{ old('email') }}" required
                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
            @if ($errors->has('email'))
                <span class='invalid-feedback'>
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" value="" required
                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
            @if ($errors->has('password'))
                <span class='invalid-feedback'>
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="from-group">
            <div class="form-check">
                <input type="checkbox" name="remember" class="form-chek-input"
                    value="{{ old('remember') ? 'checked' : '' }}">
                <label for="remember" class="form-check-label">
                    Remember Me
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
@endsection
