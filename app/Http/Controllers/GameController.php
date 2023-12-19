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
                "message" => "Error creating a game",
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getGameById(Request $request, $id)
    {
        try {
            $game = Game::query()->find($id);

            if (!$game) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Game not found",
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Game achieved succesfully",
                    "data" => $game
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error achieve the game",
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getAllGames(Request $request)
    {
        try {
            $games = Game::all();

            return $games->isEmpty()
                ? response()->json(
                    [
                        "success" => true,
                        "message" => "There are no games"
                    ],
                    Response::HTTP_OK
                )
                : response()->json([
                    "success" => true,
                    "message" => "Games obtained successfully",
                    "data" => $games
                ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining the games",
                    "error" => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
