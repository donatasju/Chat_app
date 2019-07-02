<?php

namespace App\Http\Controllers;

use App\ChatRoom;
use Illuminate\Http\Request;

class ChatRoomController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function join($user1_id, $user2_id) {
        $room = ChatRoom::where(function ($query) use ($user1_id, $user2_id) {
            $query->where('user1_id', $user1_id)
                ->Where('user2_id', $user2_id);
        })->orWhere(function ($query) use ($user1_id, $user2_id) {
            $query->where('user2_id', $user1_id)
                ->where('user1_id', $user2_id);
        })->get()->first();

        if (!$room) {
            $room = new ChatRoom();
            $room->user1_id = $user1_id;
            $room->user2_id = $user2_id;
            $room->save();
        }

        return response()->json($room);
    }
}
