@extends('layouts.dashboard')

@section('content')
<div class="row">

    <div class="col-lg-8">
        <div class="row">
            @foreach ($categories as $category)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $category->category_name }}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Subcategoey_name</th>
                                <th>Action</th>
                            </tr>
                            @foreach (App\Models\Subcategory::where('category_id', $category->id)->get() as $subcategory )
                            <tr>
                                <td>{{ $subcategory->subcategory_name }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('sub.category.edit', $subcategory->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ route('sub.category.delete', $subcategory->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Subcategory</h3>
            </div>
            <div class="card-body">
                @if (session('exist'))
                    <div class="alert alert-warning">{{ session('exist') }}</div>
                @endif
                <form action="{{ route('sub.category.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id}}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Subctagory Name</label>
                        <input type="text" class="form-control" name="subcategory_name">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Subcategory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
