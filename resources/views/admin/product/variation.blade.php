@extends('layouts.dashboard')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Color</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Color Name</th>
                        <th>Color</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($colors as $color)

                    <tr>
                        <th>{{ $color->color_name }}</th>
                        <th>
                            @if ($color->color_code == '')
                                NA
                            @else
                            <span class="badge" style="background: {{ $color->color_code}}; color:transparent;">adadd</span>
                            @endif
                        </th>
                        <th>
                            <a href="{{ route('color.delete', $color->id) }}" class="btn btn-danger">Delete</a>
                        </th>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Size List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Size Name</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($sizes as $size)

                    <tr>
                        <td>{{ $size->size_name }}</td>
                        <td>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Color</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('color.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="">Color Name</label>
                        <input type="text" class="form-control" name="color_name">
                    </div>
                    <div class="mb-3">
                        <label for="">Color code</label>
                        <input type="text" class="form-control" name="color_code">
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary">Add Color</button>
                    </div>
                </form>
            </div>
        </div>
         <div class="card">
            <div class="card-header">
                <h3>Add New Size</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('size.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="">Size Name</label>
                        <input type="text" class="form-control" name="size_name">
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary">Add Size</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
