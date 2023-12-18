<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Email or password invalid',
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
            $passwordIsValid = Hash::check($password, $user->password);
            if (!$passwordIsValid) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Email or password invalid',
                    ],
                    Response::HTTP_BAD_REQUEST
                );
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
                    'success' => false,
                    'message' => 'User cant be logged',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
