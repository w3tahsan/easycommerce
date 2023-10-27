@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Welcome, {{ Auth::user()->name }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Item Stock info</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Product</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Stock in</th>
                            <th>Stock Out</th>
                            <th>Date</th>
                        </tr>
                        @foreach ($itemlasers as $items)
                        <tr>
                            <td>{{ $items->rel_to_product->product_name }}</td>
                            <td>{{ $items->rel_to_color->color_name }}</td>
                            <td>{{ $items->rel_to_size->size_name }}</td>
                            <td>{{ $items->quantity_stockin?$items->quantity_stockin:'NA' }}</td>
                            <td>{{ $items->quantity_stockout?$items->quantity_stockout:'NA' }}</td>
                            <td>{{ $items->created_at }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
