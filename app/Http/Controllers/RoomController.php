<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function getAllRooms()
    {
        try {
            $room = Room::all();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Rooms retrieved successfully",
                    "data" => $room,
                ],
                200 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Rooms retrieved unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }

    public function createRoom(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|max:50'
            ]);

            $room = new Room();
            $room->name = $request->input('name');
            $room->user_id = $request->input('user_id');
            $room->game_id = $request->input('game_id');
            $room->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Room created successfully",
                    "data" => $room,
                ],
                201 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Room created unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }   
    
    public function updateRoomById(Request $request, $id)
    {
        try {
            $room = Room::find($id);
            $name = $request->input('name');
            $user_id = $request->input('user_id');
            $room_id = $request->input('romm_id');
            
            if ($name){
                $room->name = $name;
            }
            if ($user_id){
                $room->user_id = $user_id;
            }
            if ($room_id){
                $room->room_id = $room_id;
            }
            $room->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Room updated successfully",
                    "data" => $room,
                ],
                200 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Room updated unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }

    public function deleteRoomById($id)
    {
        try {
            $room = Room::find($id);
            $room->delete();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Room deleted successfully",
                    "data" => $room,
                ],
                200 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Room deleted unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }
}
