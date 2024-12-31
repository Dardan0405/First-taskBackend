<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Thread;
use App\Models\Reply;

class ThreadController extends Controller
{
    public function postThread(Request $request)
    {
        try {
            // Extract the token from the Authorization header
            $authHeader = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $authHeader);

            // Check if the token starts with prefix `1`
            if (!str_starts_with($token, '1')) {
                return response()->json(['error' => 'Unauthorized: Only tokens with prefix "1" can post threads'], 403);
            }

            // Remove the prefix before decoding the token
            $strippedToken = substr($token, 1);
            JWTAuth::setToken($strippedToken);
            $user = JWTAuth::authenticate();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Validate the request
            $validatedData = $request->validate([
                'thread_title' => 'required|string|max:255',
                'thread_description' => 'required|string',
            ]);

            // Create the thread
            $thread = Thread::create([
                'thread_title' => $validatedData['thread_title'],
                'thread_description' => $validatedData['thread_description'],
            ]);

            return response()->json(['message' => 'Thread posted successfully!', 'thread' => $thread], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred', 'details' => $e->getMessage()], 500);
        }
    }
    public function replyToThread(Request $request)
    {
        try {
            // Extract the token from the Authorization header
            $authHeader = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $authHeader);

            // Check if the token starts with prefix `2`
            if (!str_starts_with($token, '2')) {
                return response()->json(['error' => 'Unauthorized: Only tokens with prefix "2" can reply to threads'], 403);
            }

            // Remove the prefix before decoding the token
            $strippedToken = substr($token, 1);
            JWTAuth::setToken($strippedToken);
            $user = JWTAuth::authenticate();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Validate the request
            $validatedData = $request->validate([
                'thread_id' => 'required|exists:thread,id',
                'reply_content' => 'required|string',
            ]);

            // Create the reply
            $reply = Reply::create([
                'thread_id' => $validatedData['thread_id'],
                'user_id' => $user->id,
                'reply_content' => $validatedData['reply_content'],
            ]);

            return response()->json(['message' => 'Reply posted successfully!', 'reply' => $reply], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred', 'details' => $e->getMessage()], 500);
        }
    }
    public function deleteReply(Request $request)
{
    try {
        // Extract the token from the Authorization header
        $authHeader = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $authHeader);

        // Check if the token starts with prefix `1`
        if (!str_starts_with($token, '1')) {
            return response()->json(['error' => 'Unauthorized: Only tokens with prefix "1" can delete replies'], 403);
        }

        // Remove the prefix before decoding the token
        $strippedToken = substr($token, 1);
        JWTAuth::setToken($strippedToken);
        $user = JWTAuth::authenticate();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Validate the request
        $validatedData = $request->validate([
            'reply_id' => 'required|exists:replies,id',
        ]);

        // Find the reply
        $reply = Reply::find($validatedData['reply_id']);

        if (!$reply) {
            return response()->json(['error' => 'Reply not found'], 404);
        }

        // Delete the reply
        $reply->delete();

        return response()->json(['message' => 'Reply deleted successfully!'], 200);

    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred', 'details' => $e->getMessage()], 500);
    }
}
public function deleteReply1(Request $request)
{
    try {
        // Extract the token from the Authorization header
        $authHeader = $request->header('Authorization');
        if (!$authHeader) {
            return response()->json(['error' => 'Authorization header missing'], 401);
        }

        $token = str_replace('Bearer ', '', $authHeader);

        // Check if the token starts with prefix `2`
        if (!str_starts_with($token, '2')) {
            return response()->json(['error' => 'Unauthorized: Only tokens with prefix "2" can delete replies'], 403);
        }

        // Remove the prefix before decoding the token
        $strippedToken = substr($token, 1);
        JWTAuth::setToken($strippedToken);
        $user = JWTAuth::authenticate();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Validate the request
        $validatedData = $request->validate([
            'reply_id' => 'required|exists:replies,id',
        ]);

        // Find the reply
        $reply = Reply::find($validatedData['reply_id']);

        // Check if the reply belongs to the authenticated user
        if ($reply->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized: You can only delete your own replies'], 403);
        }

        // Delete the reply
        $reply->delete();

        return response()->json(['message' => 'Reply deleted successfully!'], 200);

    }  catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred', 'details' => $e->getMessage()], 500);
    }
}

}
