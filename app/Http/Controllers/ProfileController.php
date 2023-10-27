<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Image;

class ProfileController extends Controller
{
    function profile(){
        return view('admin.profile.profile');
    }

    function profile_update(Request $request){

        $request->validate([
            'password'=> Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
        ]);

        if($request->password == ''){
            User::find(Auth::id())->update([
                'name'=>$request->name,
                'email'=>$request->email,
            ]);
            return back()->with('update', 'Profile Updated');
        }
        else{
            if(Hash::check($request->current_password, Auth::user()->password)){
                User::find(Auth::id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]);
                return back()->with('update', 'Profile Updated');
            }
            else{
                return back()->with('wrong_pass', 'Current Password Not Correct');
            }
        }
    }

    function profile_photo_update(Request $request){

        if(Auth::user()->photo == null){
            $photo = $request->photo;
            $extension = $photo->extension();
            $photo_name = Auth::id() . '.' . $extension;
            Image::make($photo)->save(public_path('uploads/user/' . $photo_name));

            User::find(Auth::id())->update([
                'photo' => $photo_name,
            ]);
            return back()->with('photo_update', 'Profile Photo Updated');
        }
        else{
            $prev_image = public_path('uploads/user/'.Auth::user()->photo);
            unlink($prev_image);

            $photo = $request->photo;
            $extension = $photo->extension();
            $photo_name = Auth::id() . '.' . $extension;
            Image::make($photo)->save(public_path('uploads/user/' . $photo_name));

            User::find(Auth::id())->update([
                'photo' => $photo_name,
            ]);
            return back()->with('photo_update', 'Profile Photo Updated');

        }

    }
}
