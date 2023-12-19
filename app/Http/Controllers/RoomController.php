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
}
