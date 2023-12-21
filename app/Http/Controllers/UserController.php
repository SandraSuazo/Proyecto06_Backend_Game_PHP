<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
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
                        'success' => false,
                        'message' => 'User cant be registered',
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
                    "success" => false,
                    "message" => $th->getMessage(),
                    "error" => $th->getCode()
                ],
                $th->getCode()
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
            if (!$user) {
                throw CustomException::createException('User not found', 404);
            }
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
                    "message" => $th->getMessage(),
                    "error" => $th->getCode()
                ],
                $th->getCode()
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
                    "message" => $th->getMessage(),
                    "error" => $th->getCode()
                ],
                $th->getCode()
            );
        }
    }

    public function getAllUsers(Request $request)
    {
        try {
            $count = $request->query('count', 10);
            $users = User::paginate($count);
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
                    "success" => false,
                    "message" => $th->getMessage(),
                    "error" => $th->getCode()
                ],
                $th->getCode()
            );
        }
    }

    public function deleteUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->role === 'admin') {
                throw CustomException::createException('Cannot delete an admin user', 400);
            }
            $user->delete();
            return response()->json(
                [
                    "success" => true,
                    "message" => "User deleted successfully",
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
