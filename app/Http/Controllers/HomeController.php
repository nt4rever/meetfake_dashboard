<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function AuthLogin()
    {
        $auth = Session::get('auth');
        if ($auth) {
            return Redirect::to('/');;
        }
        return Redirect::to('/login')->send();
    }

    public function index()
    {
        $this->AuthLogin();
        return view('index');
    }

    public function calendar()
    {
        $this->AuthLogin();
        return view('util.calendar');
    }

    public function redirect($room)
    {
        return Redirect::to(env('MEET_URL', 'http://localhost:8080') . '/room/' . $room);
    }
}
