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
                'game_id' => 'required|exists:games,id',
            ]);
            $userId = auth()->user()->id;

            $room = new Room();
            $room->name = $request->name;
            $room->game_id = $request->game_id;
            $room->user_id = $userId;
    
            $room->save();
    
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
            $rooms = Room::with([
                'game',
                'user:id,nickname',
                'users:id,nickname'
            ])->get();
    
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
            $userId = auth()->user()->id;
            if ($room->user_id !== $userId) {
                return response()->json(
                    [
                        "Success" => false,
                        "Message" => "You are not authorized to delete this room",
                    ],
                    403
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

    public function editRoom(Request $request, $id)
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

            $userId = auth()->user()->id;
            $validatedData = $request->validate([
                'name' => 'max:55',
                'game_id' => 'exists:games,id',
            ]);
            $roomToUpdate = Room::find($id);
            if (!$roomToUpdate) {
                return response()->json(
                    [
                        "Success" => false,
                        "Message" => "Room not found",
                    ],
                    404
                );
            }
            
            if ($roomToUpdate->user_id !== $userId) {
                return response()->json(
                    [
                        "Success" => false,
                        "Message" => "You are not authorized to edit this room",
                    ],
                    403
                );
            }

            $roomToUpdate->update($request->only(array_keys($validatedData)));
    
            return response()->json(
                [
                    "Success" => true,
                    "Message" => "Room updated successfully",
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

    public function getRoom($id)
    {
        try {
            $room = Room::with([
                'game',
                'user:id,nickname',
                'users:id,nickname'
            ])->find($id);
            if (!$room) {
                return response()->json(
                    [
                        "Success" => false,
                        "Message" => "Room not found",
                    ],
                    404
                );
            }
    
            return response()->json(
                [
                    "Success" => true,
                    "Message" => "Room retrieved successfully",
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

    public function joinRoom(Request $request, $id)
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
            $userId = auth()->user()->id;
            
            $room->users()->attach($userId);
    
            return response()->json(
                [
                    "Success" => true,
                    "Message" => "User joined room successfully",
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

    public function leaveRoom(Request $request, $id)
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
            $userId = auth()->user()->id;
            
            $room->users()->detach($userId);
    
            return response()->json(
                [
                    "Success" => true,
                    "Message" => "User left room successfully",
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
}
