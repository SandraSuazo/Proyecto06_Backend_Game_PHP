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
                'name' => 'required|min:5|max:60',
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
                    "message" => "Game archieved succesfully",
                    "data" => $game
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error archieve the game",
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
                : response()->json(
                    [
                        "success" => true,
                        "message" => "Games achieved successfully",
                        "data" => $games
                    ],
                    Response::HTTP_OK
                );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error achieving the games",
                    "error" => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function updateGame(Request $request, $id)
    {
        try {
            $game = Game::findOrFail($id);
            if (!$game) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Game not found",
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:5|max:60',
                'category' => 'in:shooter,action,arcade',
            ]);
            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Validation Error: " . $validator->errors()->first(),
                        "errors" => $validator->errors(),
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
            $game->name = $request->input('name', $game->name);
            $game->category = $request->input('category', $game->category);
            $game->save();
            return response()->json(
                [
                    "success" => true,
                    "message" => "Game updated successfully",
                    "data" => $game,
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Game cant be updated",
                    'error' => $th->getMessage()

                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteGame(Request $request, $id)
    {
        try {
            $game = Game::find($id);

            if ($game) {
                $game->delete();
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Game deleted successfully"
                    ],
                    Response::HTTP_OK
                );
            }

            return response()->json(
                [
                    "success" => false,
                    "message" => "Game not found"
                ],
                Response::HTTP_NOT_FOUND
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Game could not be deleted",
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
