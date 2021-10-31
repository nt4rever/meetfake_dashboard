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
                Session::put('id', $user->id);
                return Redirect::to('/');
            }
        }
        return redirect()->back()->with('message', 'Email hoặc mật khẩu không đúng!');
    }

    public function login_api()
    {
        if (isset($_GET['token']) && $_GET['id']) {
            $token = $_GET['token'];
            $userId = $_GET['id'];
            $user = Users::findOrFail($userId);
            if ($user->token == trim($token)) {
                Session::flush();
                $user->token = "";
                $user->save();
                Session::put('auth', $user->fullname);
                Session::put('email', $user->email);
                Session::put('id', $user->id);
                return Redirect::to('/');
            }
        }
        return Redirect::to('/');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->back();
    }
}
