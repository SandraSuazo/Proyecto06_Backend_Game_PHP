<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class GameController extends Controller
{
    public function createGame(Request $request)
    {
        try {
            $user = auth()->user();
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3|max:25',
                'category' => 'required|in:shooter,action,arcade'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Error creating a game",
                    "error" => $validator->errors()
                ], Response::HTTP_BAD_REQUEST);
            }
            $newGame = Game::create([
                "name" => $request->input('name'),
                "category" => $request->input('category'),
                "user_id" => $user->id
            ]);
            return response()->json([
                "success" => true,
                "message" => "Game created successfully",
                "data" => $newGame
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Error creating a game"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
