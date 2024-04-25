<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Game;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function createChat(Request $request)
    {
        try {
            $chat = new Chat();
            $chat->user_id = auth()->user()->id;
            $chat->message = $request->input('message');
            $chat->room_id = $request->input('room_id');
            $chat->save();

            $validate = $request->validate([
                'message' => 'required|max:255'
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Chat created successfully",
                    "data" => $chat
                ],
                201
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Chat cant be created successfully",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }

    public function getAllChats()
    {
        try {


            //me trae solo los mios
            $chat = Chat::select('message', 'user_id')
            -> where('user_id', auth()->user()->id)
            -> get();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Chats retrieved successfully",
                    "data" => $chat
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Chats cant be retrieved successfully",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }

    public function deleteChatById($id)
    {
        try {
            $deleteChat = Chat::find($id);

            if($deleteChat == null){
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Chat not found",
                    ],
                    404
                );
            }

            if ($deleteChat->user_id !== auth()->user()->id) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Chat cannot be deleted",
                    ],
                    403
                );
            }

            $deleteChat->delete();

            if ($deleteChat) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Chats deleted successfully",
                        "data" => $deleteChat
                    ],
                    200
                );
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Chats not found",
                    "data" => $deleteChat
                ],
                404
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => true,
                    "message" => "Error deleting chat",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }
}
