@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Product List</h3>
            </div>
            <div class="card-body">
                <table class="table table-border">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Preview</th>
                        <th>Category</th>
                        <th>subcatrgory</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->discount }}%</td>
                        <td><img width="100" src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}" alt=""></td>
                        <td>{{ $product->rel_to_cat->category_name }}</td>
                        <td>{{ $product->rel_to_subcat->subcategory_name }}</td>
                        <td>
                            <a href="{{ route('product.inventory', $product->id) }}" class="btn btn-info shadow btn-xs sharp"><i class="fa fa-archive"></i></a>
                            <a href="{{ route('product.delete', $product->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
