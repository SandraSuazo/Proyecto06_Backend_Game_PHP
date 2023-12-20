<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends Controller
{
    public function createRoom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:100',
            'game_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Game::where('id', $value)->exists()) {
                        $fail("The selected game doesn't exist.");
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validation Error",
                "errors" => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $user = auth()->user();

            $newRoom = Room::create([
                "name" => $request->input('name'),
                "game_id" => $request->input('game_id')
            ]);

            return response()->json([
                "success" => true,
                "message" => "Room created successfully",
                "data" => $newRoom
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Room cant be created",
                "error" => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getRoomById(Request $request, $id)
    {
        try {
            $room = Room::query()->find($id);

            if (!$room) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Room not found"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }
            return response()->json(
                [
                    "success" => true,
                    "message" => "Room archieved succesfully",
                    "data" => $room
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {

            return response()->json(
                [
                    "success" => false,
                    "message" => "Room cant be archieved",
                    "error" => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getAllRooms(Request $request)
    {
        try {

            $rooms = Room::query()->get();

            if (count($rooms) === 0) {
                return response()->json([
                    "success" => false,
                    "message" => "No rooms found",
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Rooms obtained succesfully",
                    "data" => $rooms
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Rooms cant be archieved",
                    "error" => $th->getMessage()

                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getAllRoomsByGame(Request $request, $game_id)
    {
        try {
            $rooms = Room::where('game_id', $game_id)->get();

            if (count($rooms) === 0) {
                return response()->json([
                    "success" => false,
                    "message" => "No rooms found for the specified game",
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Rooms obtained successfully",
                    "data" => $rooms
                ],
                Response::HTTP_OK
            );

        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Rooms cannot be retrieved",
                    "error" => $th->getMessage()

                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function updateRoom(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'min:3|max:100',
            'game_id' => [
                function ($attribute, $value, $fail) {
                    if (!Game::where('id', $value)->exists()) {
                        $fail("The selected game doesn't exist.");
                    }
                },
            ],
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validation Error",
                "errors" => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $room = Room::find($id);
            if (!$room) {
                return response()->json([
                    "success" => false,
                    "message" => "Room not found",
                ], Response::HTTP_NOT_FOUND);
            }
            $room->update([
                'name' => $request->input('name', $room->name),
                'game_id' => $request->input('game_id', $room->game_id),
            ]);

            return response()->json([
                "success" => true,
                "message" => "Room updated successfully",
                "data" => $room
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Room cannot be updated",
                "error" => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteRoom(Request $request, $id)
    {
        try {
            $room = Room::find($id);
            if (!$room) {
                return response()->json([
                    "success" => false,
                    "message" => "Room not found",
                ], Response::HTTP_NOT_FOUND);
            }
            $room->update(['is_active' => false]);
            return response()->json([
                "success" => true,
                "message" => "Room soft deleted successfully",
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Room cannot be soft deleted",
                "error" => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
