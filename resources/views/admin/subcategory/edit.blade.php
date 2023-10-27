@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Edit Subcategory</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('sub.category.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id}}" {{ $category->id == $subcategory->category_id?'selected':'' }}>{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="subcategory_id" value="{{ $subcategory->id }}">
                    <div class="mb-3">
                        <label for="" class="form-label">Subctagory Name</label>
                        <input type="text" class="form-control" name="subcategory_name" value="{{ $subcategory->subcategory_name }}">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Subcategory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
