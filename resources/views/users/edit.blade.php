@extends('layouts.app')

@section('content')
    <form class="form-horizontal" action="{{ route('users.update', ['user' => $user->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-4">
                <img src="" alt="" class="img-thumbnail avatar">
                <div class="card mt-4">
                    <div class="card-body">
                        <h6>Upload a different photo</h6>
                        <input type="file" name="avatar" class="form-control-file">
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="form-group">
                    <label for="">Name:</label>
                    <input type="text" name="name" value="" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" value="Save Changes" class="btn btn-primary">

                </div>
            </div>
        </div>
    </form>
@endsection
