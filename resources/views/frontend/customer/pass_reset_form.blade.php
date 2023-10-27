@extends('frontend.master')
@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-lg-6 col-md-12 col-sm-12 m-auto">
            <div class="mb-3 bg-light text-center py-2">
                <h3>Password Reset form</h3>
            </div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form class="border p-3 rounded" action="{{ route('password.reset.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="New Password*">
                    @error('password')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="confirm Password*">
                    @error('password_confirmation')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
