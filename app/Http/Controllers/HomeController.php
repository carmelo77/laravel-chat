<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Auth;

class HomeController extends Controller
{
    public function index()
    {
    	return view('index');
    }

    public function session($id)
    {
    	$user = User::find($id);

    	Auth::login($user);

    	return redirect('/');
    }

    public function contacts()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return response()->json($users);
    }

    public function user()
    {
        return Auth::user();
    }
}
