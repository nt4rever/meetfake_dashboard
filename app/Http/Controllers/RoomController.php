<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomDetail;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
{

    public function AuthLogin()
    {
        $auth = Session::get('auth');
        if ($auth) {
            return Redirect::to('/');;
        }
        return Redirect::to('/login')->send();
    }

    public function list()
    {
        $this->AuthLogin();
        $userId = Session::get('id');
        $list_member = Users::find($userId)->memberOf;
        $list_host = Room::where('host', $userId)->get();
        return view('room.list', compact('list_host', 'list_member'));
    }

    public function new()
    {
        $this->AuthLogin();
        return view('room.new');
    }

    public function save(Request $request)
    {
        $userId = Session::get('id');
        $room = new Room();
        $room->host = $userId;
        $room->roomId = $this->getToken();
        $room->status = $request->status;
        $room->title = $request->title;
        $room->save();
        $list_attendance = $request->attendance;
        if (isset($list_attendance)) {
            $list  =  explode(",", $list_attendance);
            foreach ($list as $item) {
                $user = Users::where('email', trim($item))->first();
                if ($user) {
                    RoomDetail::create([
                        'room_id' => $room->id,
                        'user_id' => $user->id,
                        'auth' => 'attendance',
                    ]);
                }
            }
        }
        return Redirect::to('/room')->with('message', 'Tạo phòng thành công!');
    }

    public function show($id)
    {
        $this->AuthLogin();
        $userId = Session::get('id');
        $room = Room::findOrFail($id);
        if ($room->host != $userId)
            return redirect()->back();
        $list = RoomDetail::where('room_id', $id)->get();
        return view('room.show', compact('list', 'room'));
    }

    public function update(Request $request, $id)
    {
        $this->AuthLogin();
        $userId = Session::get('id');
        $room = Room::findOrFail($id);
        if ($room->host != $userId)
            return redirect()->back();
        $room->title = $request->title;
        $room->status = $request->status;
        $room->save();
        return Redirect::to('/room/show/' . $id);
    }

    public function add(Request $request, $id)
    {
        $this->AuthLogin();
        $userId = Session::get('id');
        $room = Room::findOrFail($id);
        $data_r = array();
        if ($room->host != $userId)
            return json_encode($data_r);
        $list_attendance = $request->attendance;
        if (isset($list_attendance)) {
            $list  =  explode(",", $list_attendance);
            foreach ($list as $item) {
                $user = Users::where('email', trim($item))->first();
                if ($user) {
                    $check = RoomDetail::where('room_id', $room->id)->where('user_id', $user->id)->first();
                    if ($check)
                        continue;
                    $room_d = RoomDetail::create([
                        'room_id' => $room->id,
                        'user_id' => $user->id,
                        'auth' => 'attendance',
                    ]);
                    array_push($data_r, [
                        $room_d->id,
                        $room_d->user->fullname,
                        $room_d->user->email,
                        $room_d->user->phone,
                        $room_d->auth,
                        '<a href="#" class="btn btn-outline-danger delete_attendance"
                        onclick="return confirm(' . "'" . 'Xóa người này khỏi phòng họp!' . "'" . ')"
                        data-id="' . $room_d->user_id . '"><i class="fa fa-trash"></i></a>',
                    ]);
                }
            }
        }
        return json_encode($data_r);
    }

    public function delete_attendance(Request $request, $id)
    {
        $this->AuthLogin();
        $userId = Session::get('id');
        $room = Room::findOrFail($id);
        if ($room->host != $userId)
            return false;
        $user_id = $request->user_id;
        $check = RoomDetail::where('room_id', $room->id)->where('user_id', $user_id)->first();
        if ($check) {
            $check->delete();
        }
        return true;
    }

    public function destroy($id)
    {
        $this->AuthLogin();
        $userId = Session::get('id');
        $room = Room::findOrFail($id);
        if ($room->host != $userId)
            return redirect()->back();
        $room->delete();
        return Redirect::to('/room');
    }

    function getToken()
    {
        $token = "";
        $codeAlphabet = "abcdefghijklmnopqrstuvwxyz";
        $max = strlen($codeAlphabet);
        for ($i = 0; $i < 11; $i++) {
            $token .= $codeAlphabet[rand(0, $max - 1)];
        }
        $token[3]  = '-';
        $token[7]  = '-';
        return $token;
    }
}
