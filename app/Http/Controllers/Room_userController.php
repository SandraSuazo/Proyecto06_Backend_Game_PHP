<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
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
                throw CustomException::createException('Room or User not found', 404);
            }

            $room->users()->attach($user->id);

            return response()->json([
                "success" => true,
                "message" => "User added to room successfully"
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => $th->getMessage(),
                    "error" => $th->getCode()
                ],
                $th->getCode()
            );
        }
    }

    public function removeUserFromRoom(Request $request, $roomId, $userId)
    {
        try {
            $room = Room::find($roomId);
            $user = User::find($userId);
            if (!$room || !$user) {
                throw CustomException::createException('Room or User not found', 404);
            }

            $room->users()->detach($user->id);

            return response()->json([
                "success" => true,
                "message" => "User removed from room successfully"
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => $th->getMessage(),
                    "error" => $th->getCode()
                ],
                $th->getCode()
            );
        }
    }
}
