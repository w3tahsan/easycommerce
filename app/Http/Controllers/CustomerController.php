<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class CustomerController extends Controller
{
    function customer_profile(){
        return view('frontend.customer.profile');
    }
    function customer_profile_update(Request $request){
        if($request->password == ''){
            if($request->photo == ''){
                Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'country' => $request->country,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            }
            else{
                if(Auth::guard('customerlogin')->user()->photo == null){
                    $photo = $request->photo;
                    $extension = $photo->extension();
                    $file_name = Auth::guard('customerlogin')->id() . '.' . $extension;
                    Image::make($photo)->save(public_path('uploads/customer/' . $file_name));

                    Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'country' => $request->country,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'photo' => $file_name,
                    ]);
                }
                else{
                    $photo_old = Auth::guard('customerlogin')->user()->photo;
                    $delete_from = public_path('uploads/customer/' . $photo_old);
                    unlink($delete_from);

                    $photo = $request->photo;
                    $extension = $photo->extension();
                    $file_name = Auth::guard('customerlogin')->id() . '.' . $extension;
                    Image::make($photo)->save(public_path('uploads/customer/' . $file_name));

                    Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'country' => $request->country,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'photo' => $file_name,
                    ]);
                }
            }
        }
        else{
            if($request->photo == ''){
                Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'country' => $request->country,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            }
            else{
                if(Auth::guard('customerlogin')->user()->photo == null){
                    $photo = $request->photo;
                    $extension = $photo->extension();
                    $file_name = Auth::guard('customerlogin')->id() . '.' . $extension;
                    Image::make($photo)->save(public_path('uploads/customer/' . $file_name));

                    Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'country' => $request->country,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'photo' => $file_name,
                    ]);
                }
                else{
                    $photo_old = Auth::guard('customerlogin')->user()->photo;
                    $delete_from = public_path('uploads/customer/' . $photo_old);
                    unlink($delete_from);

                    $photo = $request->photo;
                    $extension = $photo->extension();
                    $file_name = Auth::guard('customerlogin')->id() . '.' . $extension;
                    Image::make($photo)->save(public_path('uploads/customer/' . $file_name));

                    Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'country' => $request->country,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'photo' => $file_name,
                    ]);
                }
            }
        }
    }

    function my_order(){
        $myorders = Order::where('customer_id', Auth::guard('customerlogin')->id())->latest()->get();
        return view('frontend.customer.myorder', [
            'myorders'=> $myorders,
        ]);
    }


    function preoduct_review(Request $request){
        OrderProduct::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->first()->update([
            'review'=>$request->review,
            'star'=>$request->rating,
        ]);
        return back();
    }


}
