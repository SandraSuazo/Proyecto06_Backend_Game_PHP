<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
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
Route::get('/profile', [UserController::class, 'profile']);
Route::put('/user', [UserController::class, 'updateProfile']);
Route::delete('/user', [UserController::class, 'deleteUser']);

//ROOMS
Route::post('/room', [RoomController::class, 'createRoom']);
Route::get('/room', [RoomController::class, 'getRoomById']);
Route::put('/room', [RoomController::class, 'updateRoom']);
Route::delete('/delete', [RoomController::class, 'deleteRoom']);

// MESSAGES
Route::post('/message', [MessageController::class, 'createMessage']);
Route::get('/message', [MessageController::class, 'getMessageById']);
Route::get('/messages', [MessageController::class, 'getAllRoomMessage']);
Route::put('/message', [MessageController::class, 'updatedMessage']);
Route::delete('/message', [MessageController::class, 'deleteMessage']);
