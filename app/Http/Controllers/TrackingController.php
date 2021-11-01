<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TrackingController extends Controller
{
    public function AuthLogin()
    {
        $auth = Session::get('auth');
        if ($auth) {
            return Redirect::to('/');;
        }
        return Redirect::to('/login')->send();
    }

    public function log($id)
    {
        $this->AuthLogin();
        $userId = Session::get('id');
        $room = Room::findOrFail($id);
        if ($room->host != $userId)
            return redirect()->back();
        $list = Tracking::where('room_id', $id)->get();
        return view('util.log', compact('list', 'room'));
    }
}
