<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function createGame(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:55',
            'description' => 'required',
        ]);

        $game = Game::create($validatedData);

        return response(['game' => $game]);
    }
}
