<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use App\Models\Emailverify;
use App\Models\Passreset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EmailVerifyNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class CustomerRegisterController extends Controller
{
    function customer_register(Request $request){
        $customer = Customerlogin::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);

        Emailverify::where('customer_id', $customer->id)->delete();

        $user_info = Emailverify::create([
            'customer_id'=> $customer->id,
            'token'=> uniqid(),
            'created_at'=> Carbon::now(),
        ]);

        Notification::send($customer, new EmailVerifyNotification($user_info));

        // if (Auth::guard('customerlogin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        //     return redirect('/');
        // }
        return back()->with('success', 'Customer Registered Successfull! Please Verify Your Email');
    }

    function email_verify($token){
        $user = Emailverify::where('token', $token)->firstOrFail();
        Customerlogin::find($user->customer_id)->update([
            'email_verified_at'=>Carbon::now(),
        ]);
        $user->delete();
        return redirect()->route('customer.login.register')->with('success', 'Customer Verified');
    }

    function email_verify_req(){
        return view('frontend.customer.email_verify_req');
    }

    function email_verify_req_send(Request $request){

        $user = Customerlogin::where('email', $request->email)->firstOrFail();
        Emailverify::where('customer_id', $user->id)->delete();
        $user_info = Emailverify::create([
            'customer_id' => $user->id,
            'token' => uniqid(),
            'created_at' => Carbon::now(),
        ]);
        Notification::send($user, new EmailVerifyNotification($user_info));
        return back()->with('success', 'We Have sent you email verification link on your email');
    }
}
