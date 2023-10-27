<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function cart_store(Request $request){
        if(Auth::guard('customerlogin')->user()){
            if(Cart::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){
                Cart::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
            }
            else{
                Cart::insert([
                    'customer_id' => Auth::guard('customerlogin')->id(),
                    'product_id' => $request->product_id,
                    'color_id' => $request->color_id,
                    'size_id' => $request->size_id,
                    'quantity' => $request->quantity,
                    'created_at' => Carbon::now(),
                ]);
                return back()->with('cart_added', 'Cart Added Successfully');
            }
        }
        else{
            return redirect()->route('customer.login.register')->with('login', 'Please Login to Add Cart');
        }
    }

    function cart_remove($cart_id){
        Cart::find($cart_id)->delete();
        return back();
    }

    function cart(Request $request){
        $coupon_code = $request->coupon_code;
        $mesg = '';
        $discount = 0;
        $type = '';

        if(isset($coupon_code)){
            if (Coupon::where('coupon_code', $coupon_code)->exists()) {
                if(Carbon::now()->format('Y-m-d') <= Coupon::where('coupon_code', $coupon_code)->first()->validity){
                    $discount = Coupon::where('coupon_code', $coupon_code)->first()->discount;
                    $type = Coupon::where('coupon_code', $coupon_code)->first()->type;
                }
                else{
                    $mesg = 'Coupon Code Expired';
                    $discount = 0;
                }
            }
            else {
                $mesg = 'Invalid Coupon Code';
                $discount = 0;
            }
        }

        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.cart', [
            'carts'=>$carts,
            'mesg'=>$mesg,
            'discount'=> $discount,
            'type'=> $type,
        ]);
    }

    function cart_update(Request $request){
        foreach($request->quantity as $cart_id=>$quantity){
           Cart::find($cart_id)->update([
                'quantity'=>$quantity,
           ]);
        }
        return back();
    }
}
