<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return view('welcome');
});

Route::get('/games', [GameController:: class, 'getAllGames']);
Route::post('/games', [GameController:: class, 'createGames']);
Route::put('/games/{id}', [GameController:: class,'updateGamesById']);
Route::delete('/games/{id}', [GameController:: class,'deleteGamesById']);

Route::get('/users', [UserController:: class, 'getAllUsers']);
Route::post('/users', [UserController:: class, 'createUsers']);
Route::put('/users/{id}', [UserController:: class,'updateUsersById']);
Route::delete('/users/{id}', [UserController:: class,'deleteUsersById']);