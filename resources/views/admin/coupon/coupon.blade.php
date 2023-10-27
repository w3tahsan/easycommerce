@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Coupon List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Coupon Code</th>
                        <th>Type</th>
                        <th>Discount</th>
                        <th>Validity</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->coupon_code }}</td>
                        <td>{{ $coupon->type==1?'Solid':'Percentage' }}</td>
                        <td>{{ $coupon->discount }}</td>
                        <td><span class="badge badge-primary">{{ Carbon\Carbon::now()->diffInDays($coupon->validity, false)}} days left</span></td>
                        <td>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @can('add_coupon')
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Coupon</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('coupon.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="coupon_code" class="form-control" placeholder="Coupon Name">
                    </div>
                    <div class="mb-3">
                        <select name="type" class="form-control">
                            <option value="1">Solid</option>
                            <option value="2">Percentage</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="discount" class="form-control" placeholder="Discount Amount">
                    </div>
                    <div class="mb-3">
                        <input type="date" name="validity" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection
