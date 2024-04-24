<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// GAMES
Route::post('/games', [GameController::class, 'createGame'])->middleware('auth:sanctum');
Route::delete('/games/{id}', [GameController::class, 'deleteGameById'])->middleware('auth:sanctum');
Route::get('/games', [GameController::class, 'getAllGames'])->middleware('auth:sanctum');
Route::get('/games/{id}', [GameController::class, 'getGameById'])->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
