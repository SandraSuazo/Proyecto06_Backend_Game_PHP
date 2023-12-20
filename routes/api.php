<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Room_userController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/healthcheck', function (Request $request) {
    return 'Healthcheck ok';
});

// AUTH
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//USERS
Route::post('/register', [UserController::class, 'register']);
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/user', [UserController::class, 'updateProfile']);
    Route::get('/users', [UserController::class, 'getAllUsers'])->middleware('isAdmin');
    Route::delete('/user/{id}', [UserController::class, 'deleteUser'])->middleware('isAdmin');
});

// GAMES
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::post('/game', [GameController::class, 'createGame']);
    Route::get('/game/{id}', [GameController::class, 'getGameById']);
    Route::get('/games', [GameController::class, 'getAllGames']);
    Route::put('/game/{id}', [GameController::class, 'updateGame'])->middleware('isAdmin');
    Route::delete('/game/{id}', [GameController::class, 'deleteGame'])->middleware('isAdmin');
});

//ROOMS
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::post('/room', [RoomController::class, 'createRoom']);
    Route::get('/room/{id}', [RoomController::class, 'getRoomById']);
    Route::get('/rooms/{game_id}', [RoomController::class, 'getAllRoomsByGame']);
    Route::get('/rooms', [RoomController::class, 'getAllRooms'])->middleware('isAdmin');
    Route::put('/room/{id}', [RoomController::class, 'updateRoom'])->middleware('isAdmin');
    Route::delete('/room/{id}', [RoomController::class, 'deleteRoom'])->middleware('isAdmin');
});

// MESSAGES
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::post('/message', [MessageController::class, 'createMessage']);
    Route::get('/message/{id}', [MessageController::class, 'getMessageById']);
    Route::get('/messages/{room_id}', [MessageController::class, 'getAllRoomMessage']);
    Route::put('/message/{id}', [MessageController::class, 'updateMessage']);
    Route::delete('/message/{id}', [MessageController::class, 'deleteMessage']);
});

//ROOM_USER
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
Route::post('/room/{room_id}/user/{user_id}', [Room_userController::class, 'addUserToRoom']);
Route::delete('/room/{room_id}/user/{user_id}', [Room_userController::class, 'removeUserFromRoom']);
});


