<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PDF;

class OrderController extends Controller
{
    function orders(){
        $orders = Order::all();
        return view('admin.order.orders', [
            'orders'=> $orders,
        ]);
    }

    function order_status_update(Request $request){
        Order::find($request->order_id)->update([
            'order_status'=>$request->order_status,
        ]);
        return back();
    }

    function invoice_download($order_id){
        $order = Order::find($order_id);
        $order_id = [
            'order_id'=> $order->order_id,
        ];

        $pdf = PDF::loadView('invoice.invoice_download', $order_id);

        return $pdf->stream('invoice.pdf');
    }
}
