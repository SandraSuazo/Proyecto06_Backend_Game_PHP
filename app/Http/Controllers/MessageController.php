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

    public function getMessageById(Request $request, $id)
    {
        try {
            $message = Message::find($id);
            if (!$message) {
                return response()->json([
                    "success" => false,
                    "message" => "Message not found"
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                "success" => true,
                "message" => "Message retrieved successfully",
                "data" => $message
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Message cannot be retrieved",
                "error" => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllRoomMessage(Request $request, $room_id)
    {
        try {
            $messages = Message::where('room_id', $room_id)->get();
            return response()->json([
                "success" => true,
                "message" => "Messages retrieved successfully",
                "data" => $messages
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Messages cannot be retrieved",
                "error" => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateMessage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|max:200',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validation Error",
                "errors" => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $message = Message::find($id);
            if (!$message) {
                return response()->json([
                    "success" => false,
                    "message" => "Message not found"
                ], Response::HTTP_NOT_FOUND);
            }
            $message->update([
                'message' => $request->input('message', $message->message),
            ]);
            return response()->json([
                "success" => true,
                "message" => "Message updated successfully",
                "data" => $message
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Message cannot be updated",
                "error" => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteMessage(Request $request, $id)
    {
        try {
            $message = Message::find($id);
            if (!$message) {
                return response()->json([
                    "success" => false,
                    "message" => "Message not found"
                ], Response::HTTP_NOT_FOUND);
            }
            $message->delete();
            return response()->json([
                "success" => true,
                "message" => "Message deleted successfully"
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Message cannot be deleted",
                "error" => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
