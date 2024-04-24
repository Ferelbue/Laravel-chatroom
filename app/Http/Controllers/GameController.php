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

///////////////////
        //   $game -> user_id = auth()->user()->id;
////////////////////

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
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }

    public function deleteGameById($id)
    {
        try {
            $deleteGame = Game::destroy($id);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Games deleted successfully",
                    "data" => $deleteGame
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => true,
                    "message" => "Error deleting game",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }

    public function getAllGames()
    {
        try {
            $games = Game:: all();
            
            // $games = Game:: query()
            // -> select('id', 'title', 'description', 'user_id')
            // -> where('user_id', auth())->user()->id)
            // ->get();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Games retrieved successfully",
                    "data" => $games
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => true,
                    "message" => "Error retrieving games",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }

    public function updateGame(Request $request, $id)
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

            $toUpdate = $request->only(['title', 'description']);

            $game->update($toUpdate);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Game updated",
                    "data" => $game
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => true,
                    "message" => "Error updating games",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }

    public function getGameById($id) {
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

            return response()->json(
                [
                    "success" => true,
                    "message" => "Game updated",
                    "data" => $game
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => true,
                    "message" => "Error retrieving game by id",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }
}
