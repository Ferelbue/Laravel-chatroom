<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function getAllGames()
    {
        try {
            $games = Game::all();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Games retrieved successfully",
                    "data" => $games,
                ],
                200 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Games retrieved unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }

    public function createGame(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:50',
                'description' => 'required|max:255',
            ]);

            $game = new Game();
            $game->title = $request->input('title');
            $game->description = $request->input('description');
            $game->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Game created successfully",
                    "data" => $game,
                ],
                201 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Game created unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }
    
    public function updateGameById($id, Request $request)
    {
        try {
            $game = Game::find($id);
            $title = $request->input('title');
            $description = $request->input('description');
            
            if ($title){
                $game->title = $title;
            }

            if ($description){
                $game->description = $description;
            }
            $game->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Game updated successfully",
                    "data" => $game,
                ],
                200 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Game updated unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }

    }

    public function deleteGameById($id)
    {
        try {
            $game = Game::find($id);
            $game->delete();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Game deleted successfully",
                    "data" => $game,
                ],
                200 // HTTP Status Code
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Game deleted unsuccessfully",
                    "error" => $th->getMessage(),
                ],
                500 // HTTP Status Code
            );
        }
    }
}
