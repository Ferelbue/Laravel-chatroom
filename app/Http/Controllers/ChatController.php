<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getAllChats()
    {
        try {
            $chat = Chat::all();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Chats retrieved successfully",
                    "data" => $chat,
                ],
                200 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Chats retrieved unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }

    public function createChat(Request $request)
    {
        try {
            $validated = $request->validate([
                'message' => 'required|max:255'
            ]);

            $chat = new Chat();
            $chat->message = $request->input('message');
            $chat->user_id = $request->input('user_id');
            $chat->room_id = $request->input('room_id');
            $chat->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Chat created successfully",
                    "data" => $chat,
                ],
                201 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Chat created unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }

    public function updateChatById(Request $request, $id)
    {
        try {
            $chat = Chat::find($id);
            $message = $request->input('message');
            $user_id = $request->input('user_id');
            $room_id = $request->input('room_id');
            
            if ($message){
                $chat->message = $message;
            }
            if ($user_id){
                $chat->user_id = $user_id;
            }
            if ($room_id){
                $chat->room_id = $room_id;
            }
            $chat->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Chat updated successfully",
                    "data" => $chat,
                ],
                200 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Chat updated unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }

    public function deleteChatById($id)
    {
        try {
            $chat = Chat::find($id);

            if ($chat == null) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Chat not found",
                    ],
                    404 // HTTP Status Code
                );
            }

            $chat->delete();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Chat deleted successfully",
                ],
                200 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Chat deleted unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }
}
