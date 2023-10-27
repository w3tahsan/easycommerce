<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerLoginController extends Controller
{
    function customer_login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        if(Auth::guard('customerlogin')->attempt(['email'=>$request->email, 'password'=>$request->password])){
            if(Auth::guard('customerlogin')->user()->email_verified_at == null){
                Auth::guard('customerlogin')->logout();
                return back()->with('verify', 'please Verify Your Email');
            }
            else{
                return redirect('/');
            }
        }
        else{
            return back()->with('error', 'invalid Email or Password');
        }
    }
    function customer_logout(){
        Auth::guard('customerlogin')->logout();
        return redirect()->route('customer.login.register');
    }
}
