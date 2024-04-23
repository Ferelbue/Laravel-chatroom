<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function createRoom(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:55',
                'user_id' => 'required|exists:users,id',
                'game_id' => 'required|exists:games,id',
            ]);
    
            $room = Room::create($validatedData);
    
            return response()->json(
                [
                    "Success" => true,
                    "Message" => "Room created successfully",
                    "Data" => $room
                ],
                201
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "Success" => false,
                    "Message" => "An error occurred",
                    "Data" => $th->getMessage()
                ],
                500
            );
        }
    }
}
