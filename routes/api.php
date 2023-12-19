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
    Route::get('/rooms', [RoomController::class, 'getAllRooms'])->middleware('isAdmin');
    Route::put('/room/{id}', [RoomController::class, 'updateRoom'])->middleware('isAdmin');
    Route::delete('/room/{id}', [RoomController::class, 'deleteRoom'])->middleware('isAdmin');
});

//ROOM_USER
Route::post('/room-user', [Room_userController::class, 'createRoomUser']);
Route::get('/rooms-user', [Room_userController::class, 'getRoomsUser']);
Route::get('/members-room', [Room_userController::class, 'getMembersRoom']);
Route::put('/room-user', [Room_userController::class, 'updateRoomUser']);
Route::delete('/room-user', [Room_userController::class, 'deleteRoomUser']);

// MESSAGES
Route::post('/message', [MessageController::class, 'createMessage']);
Route::get('/message', [MessageController::class, 'getMessageById']);
Route::get('/messages', [MessageController::class, 'getAllRoomMessage']);
Route::put('/message', [MessageController::class, 'updatedMessage']);
Route::delete('/message', [MessageController::class, 'deleteMessage']);
