@extends('frontend.master')
@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-lg-6 col-md-12 col-sm-12 m-auto">
            <div class="mb-3 bg-light text-center py-2">
                <h3>Request For Password Reset</h3>
            </div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form class="border p-3 rounded" action="{{ route('password.req.send') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Email*">
                    @if (session('invalid'))
                        <strong class="text-danger">{{ session('invalid') }}</strong>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Send Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
