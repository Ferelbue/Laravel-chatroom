<?php

use App\Http\Controllers\GameController;
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