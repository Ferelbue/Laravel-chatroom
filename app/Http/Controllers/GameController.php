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
    
            return response(
                [
                    "Success" => true,
                    "Message" => "Game created successfully",
                    "Data" => $game
                ]
            );
        } catch (\Throwable $th) {
            return response(
                [
                    "Success" => false,
                    "Message" => "An error occurred",
                    "Data" => $th->getMessage()
                ]
            );
        }
    }

    public function getGames()
    {
        try {
            $games = Game::all();
    
            return response(['games' => $games]);
        } catch (\Throwable $th) {
            return response(
                [
                    "Success" => false,
                    "Message" => "An error occurred",
                    "Data" => $th->getMessage()
                ]
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
            if (!$id) {
                return response(
                    [
                        "Success" => false,
                        "Message" => "Game ID is required",
                        "Data" => null
                    ]
                );
            }
            $game = Game::find($id);
            if (!$game) {
                return response(
                    [
                        "Success" => false,
                        "Message" => "Game not found",
                        "Data" => null
                    ]
                );
            }
            
            $game->update($request->all());
    
            return response(
                [
                    "Success" => true,
                    "Message" => "Game updated successfully",
                    "Data" => $game
                ]
            );
        } catch (\Throwable $th) {
            return response(
                [
                    "Success" => false,
                    "Message" => "An error occurred",
                    "Data" => $th->getMessage()
                ]
            );
        }
    }
}
