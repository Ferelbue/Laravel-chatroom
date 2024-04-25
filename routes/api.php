<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// GAMES
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/games', [GameController::class, 'createGame'])->middleware('admin');
    Route::delete('/games/{id}', [GameController::class, 'deleteGameById'])->middleware('admin');
    Route::get('/games', [GameController::class, 'getAllGames']);
    Route::put('/games/{id}', [GameController::class, 'updateGame'])->middleware('admin');
    Route::get('/games/{id}', [GameController::class, 'getGameById']);
});

// ROOM ROUTES
Route::post('/rooms', [RoomController::class, 'createRoom'])->middleware('auth:sanctum');
Route::get('/rooms', [RoomController::class, 'getRooms']);
Route::put('/rooms/{id}', [RoomController::class, 'editRoom'])->middleware('auth:sanctum');
Route::delete('/rooms/{id}', [RoomController::class, 'deleteRoom'])->middleware('auth:sanctum');
Route::get('/rooms/{id}', [RoomController::class, 'getRoom']);
Route::post('/rooms/{id}/join', [RoomController::class, 'joinRoom'])->middleware('auth:sanctum');
Route::post('/rooms/{id}/leave', [RoomController::class, 'leaveRoom'])->middleware('auth:sanctum');

// CHAT ROUTES
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/chats', [ChatController::class, 'createChat']);
    Route::delete('/chats/{id}', [ChatController::class, 'deleteChatById']);
    Route::get('/chats/{roomId}', [ChatController::class, 'getAllChats']);
});

// AUTH ROUTES
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/profile', [AuthController::class, 'getProfile'])->middleware('auth:sanctum');

// USER ROUTES
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::post('/users', [UserController::class, 'createUser']);
    Route::put('/users/{id}', [UserController::class, 'updateUserById']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUserById']);
});
