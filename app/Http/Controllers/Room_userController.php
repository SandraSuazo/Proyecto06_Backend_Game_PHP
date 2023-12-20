<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Room_userController extends Controller
{
    public function addUserToRoom(Request $request, $roomId, $userId)
    {
        try {
            $room = Room::find($roomId);
            $user = User::find($userId);

            if (!$room || !$user) {
                return response()->json([
                    "success" => false,
                    "message" => "Room or User not found"
                ], Response::HTTP_NOT_FOUND);
            }

            $room->users()->attach($user->id);

            return response()->json([
                "success" => true,
                "message" => "User added to room successfully"
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "User cannot be added to room",
                "error" => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
