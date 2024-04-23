<?php

namespace App\Http\Controllers;

use App\Models\RoomUser;
use Illuminate\Http\Request;

class RoomUserController extends Controller
{
    public function getAllUsersByRoomId($room_id)
    {
        $room = RoomUser::all()
            ->where('room_id', $room_id);

        return response()->json([
            'message' => 'Get all users by room id',
            'room_id' => $room
        ]);
    }

    public function getAllRoomsByUserId($user_id)
    {
        $user = RoomUser::all()
            ->where('user_id', $user_id);

        return response()->json([
            'message' => 'Get all rooms by user id',
            'user_id' => $user
        ]);
    }
}
