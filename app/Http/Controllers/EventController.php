<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Http\Resources\RoomResource;
use App\Models\Event;
use App\Models\Room;
use App\Models\RoomDetail;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{

    public function getEvent()
    {
        $auth = Session::get('auth');
        if (!$auth)
            return;
        $userId = Session::get('id');
        $list = Event::where('user_id', $userId)->get();
        return response()->json(EventResource::collection($list));
    }

    public function getRoomEvent()
    {
        $auth = Session::get('auth');
        if (!$auth)
            return;
        $userId = Session::get('id');
        $list = array();
        $room_host = Room::where('host', $userId)->get();
        foreach ($room_host as $item)
            if ($item->start)
                array_push($list, $item);

        $list_member = Users::find($userId)->memberOf;
        foreach ($list_member as $item) {
            $v = $item->room;
            if ($v->start)
                array_push($list, $v);
        }
        return response()->json(RoomResource::collection($list));
    }

    public function saveEvent(Request $request)
    {
        $auth = Session::get('auth');
        if (!$auth)
            return false;
        $userId = Session::get('id');
        if ($request->user_id == $userId) {
            Event::where('user_id', $userId)->where('edit', 'true')->delete();
            foreach ($request->events as $item) {
                Event::create($item);
            }
            return true;
        }
        return false;
    }
}
