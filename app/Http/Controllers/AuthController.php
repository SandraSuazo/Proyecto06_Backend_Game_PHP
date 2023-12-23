<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'User cant be logged',
                        'error' => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::query()->where('email', $email)->first();
            if (!$user) {
                throw CustomException::createException('Email or password invalid', 400);
            }

            $passwordIsValid = Hash::check($password, $user->password);
            if (!$passwordIsValid) {
                throw CustomException::createException('Email or password invalid', 400);
            }

            $token = $user->createToken('apiToken')->plainTextToken;

            return response()->json(
                [
                    'success' => true,
                    'message' => 'User loged successfully',
                    'data' => $user,
                    'token' => $token
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

    public function logout(Request $request)
    {
        try {
            $accessToken = $request->bearerToken();
            $token = PersonalAccessToken::findToken($accessToken);

            $token->delete();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'User Logged out',
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
}
