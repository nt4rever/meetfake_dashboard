<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function view()
    {
        $auth = Session::get("auth");
        if ($auth != null) {
            return Redirect::to('/');;
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required',
        ]);
        $user = Users::where('email', $request->email)->first();
        if (isset($user)) {
            if (Hash::check($request->password, $user->password)) {
                Session::put('auth', $user->fullname);
                Session::put('email', $user->email);
                return Redirect::to('/');
            }
        }
        return redirect()->back()->with('message', 'Email hoặc mật khẩu không đúng!');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->back();
    }
}
