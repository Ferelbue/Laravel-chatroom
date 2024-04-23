<?php

namespace App\Http\Controllers;

use App\Models\Game;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function createGame(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|max:55',
                'description' => 'required',
            ]);
    
            $game = Game::create($validatedData);
    
            return response()->json(
                [
                    "Success" => true,
                    "Message" => "Game created successfully",
                    "Data" => $game
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

    public function getGames()
    {
        try {
            $games = Game::all();
    
            return response()->json(
                [
                    "Success" => true,
                    "Message" => "Games retrieved successfully",
                    "Data" => $games
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

    public function editGame(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|max:55',
                'description' => 'required',
            ]);
            $game = Game::find($id);
            if (!$game) {
                return response()->json(
                    [
                        "Success" => false,
                        "Message" => "Game not found",
                        "Data" => null
                    ],
                    404
                );
            }
            
            $game->update($request->all());
    
            return response()->json(
                [
                    "Success" => true,
                    "Message" => "Game updated successfully",
                    "Data" => $game
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

    public function deleteGame($id)
    {
        try {
            $game = Game::find($id);
            if (!$game) {
                return response()->json(
                    [
                        "Success" => false,
                        "Message" => "Game not found",
                    ],
                    404
                );
            }
            
            $game->delete();
    
            return response()->json(
                [
                    "Success" => true,
                    "Message" => "Game deleted successfully",
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
