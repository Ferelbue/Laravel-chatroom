<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// GAMES
Route::post('/games', [GameController::class, 'createGame']);
Route::delete('/games/{id}', [GameController::class, 'deleteGameById']);
Route::get('/games', [GameController::class, 'getAllGames']);
Route::get('/games', [GameController::class, 'getAllGames']);
Route::get('/games/{id}', [GameController::class, 'getGameById']);


Route::post('/register', [AuthController::class, 'register']);