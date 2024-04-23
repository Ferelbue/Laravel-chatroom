<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// GAME ROUTES
Route::get('/games', [GameController::class, 'getAllGames']);
Route::post('/games', [GameController::class, 'createGame']);
Route::put('/games/{id}', [GameController::class, 'updateGameById']);
Route::delete('/games/{id}', [GameController::class, 'deleteGameById']);

// USER ROUTES
Route::get('/users', [UserController::class, 'getAllUsers']);
Route::post('/users', [UserController::class, 'createUser']);
Route::put('/users/{id}', [UserController::class, 'updateUserById']);
Route::delete('/users/{id}', [UserController::class, 'deleteUserById']);

// ROOM ROUTES
Route::get('/rooms', [RoomController::class, 'getAllRooms']);
Route::post('/rooms', [RoomController::class, 'createRoom']);
Route::put('/rooms/{id}', [RoomController::class, 'updateRoomById']);
Route::delete('/rooms/{id}', [RoomController::class, 'deleteRoomById']);

// CHAT ROUTES
Route::get('/chats', [ChatController::class, 'getAllChats']);
Route::post('/chats', [ChatController::class, 'createChat']);
Route::put('/chats/{id}', [ChatController::class, 'updateChatById']);
Route::delete('/chats/{id}', [ChatController::class, 'deleteChatById']);

// ROOM_USER ROUTES
Route::get('/rooms/{room_id}/users', [RoomController::class, 'getAllUsersByRoomId']);
Route::get('/rooms/room/{user_id}', [RoomController::class, 'getAllRoomsByUserId']);

