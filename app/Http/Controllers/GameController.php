<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
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

    public function getGameById(Request $request, $id)
    {
        try {
            $game = Game::query()->find($id);
            if (!$game) {
                throw CustomException::createException('Game not found', 404);
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
                    "message" => $th->getMessage(),
                    "error" => $th->getCode()
                ],
                $th->getCode()
            );
        }
    }

    public function getAllGames(Request $request)
    {
        try {
            $games = Game::all();
            return $games->isEmpty()
                ? response()->json(
                    throw CustomException::createException('Game not found', 404)
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
                    "message" => $th->getMessage(),
                    "error" => $th->getCode()
                ],
                $th->getCode()
            );
        }
    }

    public function updateGame(Request $request, $id)
    {
        try {
            $game = Game::findOrFail($id);
            if (!$game) {
                throw CustomException::createException('Game not found', 404);
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
                    "message" => $th->getMessage(),
                    "error" => $th->getCode()
                ],
                $th->getCode()
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

            throw CustomException::createException('Game not found', 404);
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
