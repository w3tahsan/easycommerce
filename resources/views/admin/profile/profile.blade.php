@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3>Update Profile Information</h3>
            </div>
            <div class="card-body">
                @if (session('update'))
                    <div class="alert alert-success">{{ session('update') }}</div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="current_password" placeholder="Current Password">
                        @if (session('wrong_pass'))
                            <strong class="text-danger">{{ session('wrong_pass') }}</strong>
                        @endif
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="New Password">
                        @error('password')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3>Update Profile Image</h3>
            </div>
            <div class="card-body">
                @if (session('photo_update'))
                    <div class="alert alert-success">{{ session('photo_update') }}</div>
                @endif

                <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" class="form-control" name="photo" onchange="document.getElementById('photo').src = window.URL.createObjectURL(this.files[0])">
                        <div class="mt-2">
                            <img width="200" id="photo" src="{{ asset('uploads/user') }}/{{ Auth::user()->photo }}" alt="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Photo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
