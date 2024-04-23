<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function getAllRooms() {
        try {
            $rooms = Room::all();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Rooms retrieved successfully",
                    "data" => $rooms,
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
            [
                "success" => false,
                "message" => "Rooms cant be retrieved successfully",
                "error" => $th->getMessage()
            ],
            500
        );
        }
    }

    public function createRooms(Request $request) {

        try {
            $room = new Room;
            $room->name = $request->input('name');
            $room->user_id = $request->input('user_id');
            $room->game_id = $request->input('game_id');

            $room->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Users created successfully",
                    "data" => $room
                ],
                200
            );
            
        } catch (\Throwable $th) {
            return response()->json(
            [
                "success" => false,
                "message" => "Users cant be created successfully",
                "error" => $th->getMessage()
            ],
            500
        );
        }
    }
}
