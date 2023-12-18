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
Route::get('/users', [UserController::class, 'getAllUsers']);
Route::get('/profile', [UserController::class, 'profile']);
Route::put('/user', [UserController::class, 'updateProfile']);
Route::delete('/user', [UserController::class, 'deleteUser']);

// GAMES
Route::post('/game', [GameController::class, 'createGame']);
Route::get('/games', [GameController::class, 'getAllGames']);
Route::get('/game', [GameController::class, 'getGameById']);
Route::put('/game', [GameController::class, 'updatedGame']);
Route::delete('/game', [GameController::class, 'deleteGame']);

//ROOMS
Route::post('/room', [RoomController::class, 'createRoom']);
Route::get('/rooms', [RoomController::class, 'getAllRooms']);
Route::get('/room', [RoomController::class, 'getRoomById']);
Route::put('/room', [RoomController::class, 'updateRoom']);
Route::delete('/delete', [RoomController::class, 'deleteRoom']);

//ROOM_USER
Route::post('/room-user', [Room_userController::class, 'createRoomUser']);
Route::get('/members-room', [Room_userController::class, 'getMembersRoom']);
Route::get('/rooms-user', [Room_userController::class, 'getRoomsUser']);
Route::put('/room-user', [Room_userController::class, 'updateRoomUser']);
Route::delete('/room-user', [Room_userController::class, 'deleteRoomUser']);

// MESSAGES
Route::post('/message', [MessageController::class, 'createMessage']);
Route::get('/messages', [MessageController::class, 'getAllRoomMessage']);
Route::get('/message', [MessageController::class, 'getMessageById']);
Route::put('/message', [MessageController::class, 'updatedMessage']);
Route::delete('/message', [MessageController::class, 'deleteMessage']);
