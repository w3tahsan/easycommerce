@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Update Category</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('category.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="hidden" name="category_id" class="form-control" value="{{ $category_info->id }}">
                        <input type="text" name="category_name" class="form-control" value="{{ $category_info->category_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category Image</label>
                        <input type="file" name="category_image" class="form-control" onchange="document.getElementById('photo').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                    <div class="mb-2">
                        <img id="photo" width="100" src="{{ asset('uploads/category') }}/{{ $category_info->category_image }}" alt="">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
