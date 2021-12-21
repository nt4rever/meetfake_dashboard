<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function AuthLogin()
    {
        $auth = Session::get('auth');
        if ($auth) {
            return Redirect::to('/');
        }
        return Redirect::to('/login')->send();
    }

    public function show()
    {
        $this->AuthLogin();
        $userId = Session::get('id');
        $user = Users::findOrFail($userId);
        return view('user.show', compact('user'));
    }

    public function update(Request $request)
    {
        $this->AuthLogin();
        $this->validate($request, [
            'fullname' => "required",
            'address' => "required",
            'phone' => "required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10",
            'oldpassword' => "required",
        ]);
        $userId = Session::get('id');
        $user = Users::findOrFail($userId);
        if (Hash::check($request->oldpassword, $user->password)) {
            $user->fullname = $request->fullname;
            $user->phone = $request->phone;
            $user->address = $request->address;
            if ($request->newpassword) {
                if ($request->newpassword == $request->repeatpassword) {
                    $user->password = $request->newpassword;
                }else{
                    return redirect()->back()->with('message', 'Nhập lại mật khẩu chưa đúng!');
                }
            }
            $user->save();
            return redirect()->back()->with('message', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('message', 'Mật khẩu sai!');
        }
    }
}
