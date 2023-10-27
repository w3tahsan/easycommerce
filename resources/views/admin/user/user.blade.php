@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>User List</h3>
            </div>
            <div class="card-body">
                @if (session('delete_success'))
                    <div class="alert alert-success">{{ session('delete_success') }}</div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($users as $sl=>$user)
                    <tr>
                        <td>{{ $users->firstitem()+$sl }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @can('del_user')
                            <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger">Delete</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
    @can('add_user')
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New User</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('add.user') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" type="text" name="name" class="form-control">
                        @error('name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                        @error('email')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                        @error('password')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection
