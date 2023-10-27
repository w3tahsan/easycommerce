<?php

namespace App\Http\Controllers;

use App\Models\Stripeorder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use App\Models\ItemLeser;
use Illuminate\Support\Facades\Auth;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $all_data = session('data');
        $amount = $all_data['sub_total'] + $all_data['charge'] - round($all_data['discount']);
        $stripe_id = Stripeorder::insertGetId([
            'name'=> $all_data['name'],
            'email'=> $all_data['email'],
            'phone'=> $all_data['mobile'],
            'address'=> $all_data['address'],
            'company'=> $all_data['company'],
            'zip'=> $all_data['zip'],
            'country_id'=> $all_data['country_id'],
            'city_id'=> $all_data['city_id'],
            'notes'=> $all_data['notes'],
            'charge'=> $all_data['charge'],
            'discount'=> $all_data['discount'],
            'sub_total'=> $all_data['sub_total'],
            'customer_id'=> $all_data['customer_id'],
            'total'=> $amount,
            'created_at'=> Carbon::now(),
        ]);
        return view('stripe', [
            'amount'=> $amount,
            'stripe_id'=> $stripe_id,
        ]);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {

       $data = Stripeorder::find($request->stripe_id);
       $order_id = '#' . random_int(10000000, 90000000);



        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create([
            "amount" => $data['total'] * 100,
            "currency" => "bdt",
            "source" => $request->stripeToken,
            "description" => "Test payment from itsolutionstuff.com."
        ]);

        Order::insert([
            'order_id' => $order_id,
            'customer_id' => $data['customer_id'],
            'sub_total' => $data['sub_total'],
            'discount' => $data['discount'],
            'charge' => $data['charge'],
            'total' => $data['total'],
            'payment_method' =>3,
            'created_at' => Carbon::now(),
        ]);

        Billing::insert([
            'order_id' => $order_id,
            'customer_id' => $data['customer_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'company' => $data['company'],
            'mobile' => $data['phone'],
            'country_id' => $data['country_id'],
            'city_id' => $data['city_id'],
            'address' => $data['address'],
            'zip' => $data['zip'],
            'notes' => $data['notes'],
            'created_at' => Carbon::now(),
        ]);

        $carts = Cart::where('customer_id', $data['customer_id'])->get();
        foreach ($carts as $cart) {
            OrderProduct::insert([
                'order_id' => $order_id,
                'customer_id' => $data['customer_id'],
                'product_id' => $cart->product_id,
                'price' => $cart->rel_to_product->after_discount,
                'color_id' => $cart->color_id,
                'size_id' => $cart->size_id,
                'quantity' => $cart->quantity,
                'created_at' => Carbon::now(),
            ]);

            ItemLeser::insert([
                'product_id' => $cart->product_id,
                'color_id' => $cart->color_id,
                'size_id' => $cart->size_id,
                'quantity_stockout' => $cart->quantity,
                'created_at' => Carbon::now(),
            ]);

            //inventory decrement
            Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);

            //clearing cart
            // Cart::find($cart->id)->delete();
        }

        //invoice mail send to customer
        Mail::to($data['email'])->send(new InvoiceMail($order_id));

        return redirect()->route('order.success')->with('order_id', $order_id);
    }
}
