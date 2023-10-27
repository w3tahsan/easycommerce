@extends('layouts.dashboard')
@section('content')
<div class="row">
    @can('show_inventory')
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Category List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Category Name</th>
                        <th>Category Image</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($categories as $sl=>$category)
                    <tr>
                        <td>{{ $sl+1 }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td><img width="62" src="{{ asset('uploads/category') }}/{{ $category->category_image }}" alt=""></td>
                        <td>
                            <div class="d-flex">
                                @can('edit_category')
                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                @endcan
                                @can('del_category')
                                <a href="{{ route('category.soft.delete', $category->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endcan
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Category</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control">
                        @error('category_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category Image</label>
                        <input type="file" name="category_image" class="form-control">
                         @error('category_image')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
