<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// GAMES
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/games', [GameController::class, 'createGame'])->middleware('admin');
    Route::delete('/games/{id}', [GameController::class, 'deleteGameById'])->middleware('admin');
    Route::get('/games', [GameController::class, 'getAllGames']);
    Route::put('/games/{id}', [GameController::class, 'updateGame'])->middleware('admin');
    Route::get('/games/{id}', [GameController::class, 'getGameById']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/profile', [AuthController::class, 'getProfile'])->middleware('auth:sanctum');