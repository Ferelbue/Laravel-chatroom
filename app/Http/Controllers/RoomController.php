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

    public function getRooms()
    {
        try {
            $rooms = Room::all();
    
            return response()->json(
                [
                    "Success" => true,
                    "Message" => "Rooms retrieved successfully",
                    "Data" => $rooms
                ],
                200
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

    // NYI
    public function joinLeaveRoom(Request $request, $id)
    {
        try {
            $room = Room::find($id);
            $user = $request->user();
    
            if ($room->users->contains($user)) {
                $room->users()->detach($user->id);
                $message = "User left room";
            } else {
                $room->users()->attach($user->id);
                $message = "User joined room";
            }
    
            return response()->json(
                [
                    "Success" => true,
                    "Message" => $message,
                    "Data" => $room
                ],
                200
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

    public function deleteRoom($id)
    {
        try {
            $room = Room::find($id);
            if (!$room) {
                return response()->json(
                    [
                        "Success" => false,
                        "Message" => "Room not found",
                    ],
                    404
                );
            }
            
            $room->delete();
    
            return response()->json(
                [
                    "Success" => true,
                    "Message" => "Room deleted successfully",
                ],
                200
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
