<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use App\Models\Passreset;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\PassResetNotification;
use Illuminate\Support\Facades\Notification;

class PasswordResetController extends Controller
{
    function forgot_password(){
        return view('frontend.customer.forgot_password');
    }
    function password_req_send(Request $request){
        $user = Customerlogin::where('email', $request->email)->get();
        Passreset::where('customer_id', $user->first()->id)->delete();

        if($user->count() == 0){
            return back()->with('invalid', 'Email Does Not Exist on our system');
        }
        else{
            $passreset = Passreset::create([
                'customer_id'=> $user->first()->id,
                'token'=> uniqid(),
                'created_at'=> Carbon::now(),
            ]);

            Notification::send($user, new PassResetNotification($passreset));

            return back()->with('success', 'We Have Sent You Password Reset Link on your Email');
        }
    }

    function password_reset_form($token){
        return view('frontend.customer.pass_reset_form', [
            'token'=> $token,
        ]);
    }

    function password_reset_update(Request $request){

        $request->validate([
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',
        ]);

        $user = Passreset::where('token', $request->token)->firstOrFail();

        Customerlogin::find($user->customer_id)->update([
            'password'=>bcrypt($request->password),
        ]);

        $user->delete();
        return back()->with('success', 'Password Reset Successfully');
    }

}
