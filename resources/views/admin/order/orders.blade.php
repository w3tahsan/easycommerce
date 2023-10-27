@extends('layouts.dashboard')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Order List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Order Id</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Discount</th>
                        <th>Charge</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->rel_to_customer->name }}</td>
                        <td>{{ $order->total }}</td>
                        <td>{{ $order->discount }}</td>
                        <td>{{ $order->charge}}</td>
                        <td>
                            @if ($order->order_status == 0)
                                <span class="badge badge-light">Placed</span>
                            @elseif ($order->order_status == 1)
                                <span class="badge badge-secondary">Processing</span>
                            @elseif ($order->order_status == 2)
                                <span class="badge badge-warning">On Hold</span>
                            @elseif ($order->order_status == 3)
                                <span class="badge badge-info">Shipped</span>
                            @elseif ($order->order_status == 4)
                                <span class="badge badge-primary">Ready to Deliver</span>
                            @elseif ($order->order_status == 5)
                                <span class="badge badge-success">Delivered</span>
                            @else
                                <span class="badge badge-danger">Cancel</span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown" aria-expanded="false">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);">
                                    <form action="{{ route('order.status.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <button name="order_status" value="0" class="dropdown-item {{ $order->order_status==0?'bg-info text-white':'' }}" href="#">Placed</button>
                                        <button name="order_status" value="1" class="dropdown-item {{ $order->order_status==1?'bg-info text-white':'' }}" href="#">Processing</button>
                                        <button name="order_status" value="2" class="dropdown-item {{ $order->order_status==2?'bg-info text-white':'' }}" href="#">On Hold</button>
                                        <button name="order_status" value="3" class="dropdown-item {{ $order->order_status==3?'bg-info text-white':'' }}" href="#">Shipped</button>
                                        <button name="order_status" value="4" class="dropdown-item {{ $order->order_status==4?'bg-info text-white':'' }}" href="#">Ready to Deliver</button>
                                        <button name="order_status" value="5" class="dropdown-item {{ $order->order_status==5?'bg-info text-white':'' }}" href="#">Delivered</button>
                                        <button name="order_status" value="6" class="dropdown-item {{ $order->order_status==6?'bg-info text-white':'' }}" href="#">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
