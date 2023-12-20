<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function createMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|max:200',
            'room_id' => 'required|exists:rooms,id',
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
            $newMessage = Message::create([
                "message" => $request->input('message'),
                "user_id" => $user->id,
                "room_id" => $request->input('room_id')
            ]);
            return response()->json([
                "success" => true,
                "message" => "Message created successfully",
                "data" => $newMessage
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Message cannot be created",
                "error" => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
