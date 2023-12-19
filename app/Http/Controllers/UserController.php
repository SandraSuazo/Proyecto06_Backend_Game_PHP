<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = $this->validateRegisterDataUser($request);
            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'User registered successfully',
                        'error' => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');


            $encryptedPassword = bcrypt($password);
            $newUser = User::create(
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => $encryptedPassword,
                ]
            );

            return response()->json(
                [
                    'success' => true,
                    'message' => 'User registered successfully',
                    'data' => $newUser
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {

            return response()->json(
                [
                    'success' => false,
                    'message' => 'User cant be registered',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function validateRegisterDataUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:100',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6|max:100'
        ]);

        return $validator;
    }

    public function profile(Request $request)
    {
        try {
            $user = auth()->user();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User",
                    "data" => $user
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting profile user",
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
