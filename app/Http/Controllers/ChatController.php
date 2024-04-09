<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use App\Events\UserChatUpdateEvent;
use App\Events\UserChatEvent;
use App\Models\Conversation;

class ChatController extends Controller
{

    public function chat()
    {
        $authId = Auth()->user()->id;
        $lastOpenChat = Chat::where('user_id', $authId)
            ->where('status', '!=', 'closed')
            ->orderBy('created_at', 'desc')
            ->first();

        // Check if the last open chat exists
        if ($lastOpenChat) {
            // Retrieve all chats
            // Retrieve conversations related to the last open chat
            $conversations = $lastOpenChat->conversations()->orderBy('created_at', 'asc')->get();

            // Return the view with the data
            return view('client.index', compact('lastOpenChat', 'conversations'));
        } else {
            // No active chat found, return the view without data
            return view('client.index', compact('lastOpenChat'));
        }
    }

    public function startConv(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'department' => 'required|string',
            'category' => 'required|string',
            'message' => 'required|string',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Create a new chat instance
        $chat = new Chat();
        $chat->user_id = $user->id; // Set the user_id to the ID of the authenticated user
        $chat->department = $validatedData['department'];
        $chat->category = $validatedData['category'];
        $chat->message = $validatedData['message'];
        $chat->status = 'open'; // Set the initial status to "open"

        // Save the chat instance
        $chat->save();
        event(new UserChatEvent($chat));

        // Optionally, you can return a response indicating success or failure
        return response()->json(['message' => 'Conversation started successfully', 'chatId' => $chat->id], 200);
    }

    public function chatList()
    {

        $userId = Auth::user()->id;
        $chats = Chat::where('user_id', $userId)->get();
        return view('client.chatlist', compact('chats'));
    }

    public function updateChatMessage(Request $request)
    {
        // dd($request->all());
        // Validate the incoming request data
        $request->validate([
            'message' => 'required|string',
        ]);

        // Get the ID of the authenticated user
        $userId = Auth::id();
        // Find the chat related to the authenticated user's ID
        $chat = Chat::where('user_id', $userId)
            ->where('status', '!=', 'closed')
            ->orderBy('created_at', 'desc')
            ->first();
        $conversation = new Conversation;
        $conversation->chat_id = $chat->id;
        $conversation->user_id = $userId;
        $conversation->con_type = 'customer';
        $conversation->message = $request->input('message');
        $conversation->save();

        // Update the chat message content
        // $chat->message = $request->input('message');
        // $chat->save();
        event(new UserChatUpdateEvent($conversation));

        // Return a response indicating success
        return response()->json(['message' => 'Chat message updated successfully'], 200);
    }
}
