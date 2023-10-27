@extends('layouts.dashboard')
@section('content')
<div class="row">
    @can('show_inventory')
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h3>Inventory List of, {{ $product_info->product_name }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($inventories as $inventory)
                    <tr>
                        <td>{{ $inventory->rel_to_color->color_name }}</td>
                        <td>{{ $inventory->rel_to_size->size_name }}</td>
                        <td>{{ $inventory->quantity }}</td>
                        <td>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endcan
    <div class="col-lg-3">
        <div class="card">
            <div class="card-header">
                <h3>Add Inventory</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('inventory.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" name="product_id" value="{{ $product_info->id }}">
                        <input readonly type="text" class="form-control" value="{{ $product_info->product_name }}">
                    </div>
                    <div class="mb-3">
                        <select name="color_id" class="form-control">
                            <option value="">Select Color</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <select name="size_id" class="form-control">
                            <option value="">Select size</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control" name="quantity" placeholder="Quantity">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Inventory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
