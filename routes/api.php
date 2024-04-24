<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// GAME ROUTES
Route::post('/games', [GameController::class, 'createGame']);
Route::get('/games', [GameController::class, 'getGames']);
Route::put('/games/{id}', [GameController::class, 'editGame']);
Route::delete('/games/{id}', [GameController::class, 'deleteGame']);

// ROOM ROUTES
Route::post('/rooms', [RoomController::class, 'createRoom']);
Route::get('/rooms', [RoomController::class, 'getRooms']);
// Route::put('/rooms/{id}', [RoomController::class, 'joinLeaveRoom']);
Route::put('/rooms/{id}', [RoomController::class, 'editRoom']);
Route::delete('/rooms/{id}', [RoomController::class, 'deleteRoom']);
Route::get('/rooms/{id}', [RoomController::class, 'getRoom']);
Route::post('/rooms/{id}/join', [RoomController::class, 'joinRoom'])->middleware('auth:sanctum');


