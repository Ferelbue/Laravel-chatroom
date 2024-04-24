<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RoomController;
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

// // GAME ROUTES
// Route::post('/games', [GameController::class, 'createGame']);
// Route::get('/games', [GameController::class, 'getGames']);
// Route::put('/games/{id}', [GameController::class, 'editGame']);
// Route::delete('/games/{id}', [GameController::class, 'deleteGame']);

// ROOM ROUTES
Route::post('/rooms', [RoomController::class, 'createRoom']);
Route::get('/rooms', [RoomController::class, 'getRooms']);
// Route::put('/rooms/{id}', [RoomController::class, 'joinLeaveRoom']);
Route::put('/rooms/{id}', [RoomController::class, 'editRoom']);
Route::delete('/rooms/{id}', [RoomController::class, 'deleteRoom']);
Route::get('/rooms/{id}', [RoomController::class, 'getRoom']);
Route::post('/rooms/{id}/join', [RoomController::class, 'joinRoom'])->middleware('auth:sanctum');
Route::post('/rooms/{id}/leave', [RoomController::class, 'leaveRoom'])->middleware('auth:sanctum');

// AUTH ROUTES
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
