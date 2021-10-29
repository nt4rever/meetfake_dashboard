<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Event;
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

    public function saveEvent(Request $request)
    {
        $auth = Session::get('auth');
        if (!$auth)
            return false;
        $userId = Session::get('id');
        if ($request->user_id == $userId) {
            Event::create($request->all());
            return true;
        }
        return false;
    }

    public function dropEvent(Request $request)
    {
        $auth = Session::get('auth');
        if (!$auth)
            return false;
        $userId = Session::get('id');
        if ($request->user_id == $userId) {
            Event::where('user_id', $userId)->where('edit', 'true')->delete();
            return true;
        }
        return false;
    }
}
