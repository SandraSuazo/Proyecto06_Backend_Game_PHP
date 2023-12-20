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

    public function updateProfile(Request $request)
    {

        try {
            $token = auth()->user();
            $user = User::query()->find($token->id);

            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            if ($request->has('name')) {
                $user->name = $name;
            }

            if ($request->has('email')) {
                $user->email = $email;
            }

            if ($request->has('password')) {
                $user->password = bcrypt($password);
            }

            $user->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User updated",
                    "data" => $user
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Profile user cant be updated",
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getAllUsers(Request $request)
    {
        try {
            $count = $request->query('count', 10);
            $activeUser = $request->query('is_active', true);

            $users = User::where('is_active', $activeUser)->paginate($count);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'retrieve users',
                    'data' => $users
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Users cant be retrieved',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->role === 'admin') {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Cannot delete an admin user.",
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $user->update(['isActive' => false]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "User deactivated successfully",
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "User cant be deactivated.",
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
