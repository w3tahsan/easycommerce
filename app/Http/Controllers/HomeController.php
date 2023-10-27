<?php

namespace App\Http\Controllers;

use App\Models\ItemLeser;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $itemlasers = ItemLeser::all();
        return view('home', [
            'itemlasers'=> $itemlasers,
        ]);
    }

    function users(){
        $users = User::Paginate(5);
        return view('admin.user.user', compact('users'));
    }

    function user_delete($user_id){
        User::find($user_id)->delete();
        return back()->with('delete_success', 'User Deleted Successfully');
    }
}
