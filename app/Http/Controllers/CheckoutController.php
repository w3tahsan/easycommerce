<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use App\Models\ItemLeser;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    function checkout(){
        $countries = Country::all();
        $countries = Country::all();
        $cities = City::all();
        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.checkout', [
            'carts'=> $carts,
            'countries'=> $countries,
            'cities'=> $cities,
        ]);
    }

    function getCity(Request $request){
        $str = '<option value="">-- Select City --</option>';
        $cities = City::where('country_id', $request->country_id)->get();
        foreach($cities as $city){
           $str .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        echo $str;
    }

    function checkout_store(Request $request){
        $order_id = '#' . random_int(10000000, 90000000);

        if($request->payment_method == 1){
            Order::insert([
                'order_id'=> $order_id,
                'customer_id'=> Auth::guard('customerlogin')->id(),
                'sub_total'=> $request->sub_total,
                'discount'=> $request->discount,
                'charge'=> $request->charge,
                'total'=> $request->sub_total+$request->charge - ($request->discount),
                'payment_method'=> $request->payment_method,
                'created_at'=>Carbon::now(),
            ]);

            Billing::insert([
                'order_id'=> $order_id,
                'customer_id'=>Auth::guard('customerlogin')->id(),
                'name'=> $request->name,
                'email'=> $request->email,
                'company'=> $request->company,
                'mobile'=> $request->mobile,
                'country_id'=> $request->country_id,
                'city_id'=> $request->city_id,
                'address'=> $request->address,
                'zip'=> $request->zip,
                'notes'=> $request->notes,
                'created_at' => Carbon::now(),
            ]);

            $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
            foreach($carts as $cart){
                OrderProduct::insert([
                    'order_id'=> $order_id,
                    'customer_id' => Auth::guard('customerlogin')->id(),
                    'product_id'=> $cart->product_id,
                    'price'=> $cart->rel_to_product->after_discount,
                    'color_id'=> $cart->color_id,
                    'size_id'=> $cart->size_id,
                    'quantity'=> $cart->quantity,
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
            Mail::to($request->email)->send(new InvoiceMail($order_id));

            return redirect()->route('order.success')->with('order_id', $order_id);
        }



        else if($request->payment_method == 2){
            $data = $request->all();
            return redirect('/pay')->with('data', $data);
        }
        else{
            $data = $request->all();
            return redirect('/stripe')->with('data', $data);
        }
    }

    function order_success(){
        if(session('order_id')){
            return view('frontend.order_success');
        }
        else{
            abort('404');
        }

    }
}
