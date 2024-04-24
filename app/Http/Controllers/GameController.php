<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function createGame(Request $request)
    {
        try {
            $game = new Game;
            $game->title = $request->input('title');
            $game->description = $request->input('description');

            $game->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Games created successfully",
                    "data" => $game
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => true,
                    "message" => "Error creating game",
                    "data" => $game
                ],
                500
            );
        }
    }
}
