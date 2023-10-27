<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    function coupon(){
        $coupons = Coupon::all();
        return view('admin.coupon.coupon', [
            'coupons'=> $coupons,
        ]);
    }
    function coupon_store(Request $request){
        Coupon::insert([
            'coupon_code'=>$request->coupon_code,
            'type'=>$request->type,
            'discount'=>$request->discount,
            'validity'=>$request->validity,
        ]);
        return back();
    }
}
