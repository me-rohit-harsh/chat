<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use App\Events\ChatEvent;

class ChatController extends Controller
{

    public function chat()
    {
        return view('client.index');
    }
    public function startConv(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([

            'department' => 'required|string',
            'category' => 'required|string',
            'message' => 'required|string',
        ]);
        $user = Auth::user();

        // Create a new chat instance
        $chat = new Chat();
        $chat->name = $user->name;
        $chat->user_id = $user->id;
        $chat->department = $validatedData['department'];
        $chat->category = $validatedData['category'];
        $chat->message = $validatedData['message'];
        $chat->status = 'open'; // Set the initial status to "open"

        // Save the chat instance
        $chat->save();
        event(new ChatEvent("User Msg: " . $chat->message));

        // Optionally, you can return a response indicating success or failure
        return response()->json(['message' => 'Conversation started successfully'], 200);
    }
    public function chatList()
    {

        $userId = Auth::user()->id;
        $chats = Chat::where('user_id', $userId)->get();
        return view('client.chatlist', compact('chats'));
    }
}
