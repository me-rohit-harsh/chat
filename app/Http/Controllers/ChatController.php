<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;

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
            'name'=>'required|String',
            'department' => 'required|string',
            'category' => 'required|string',
            'message' => 'required|string',
        ]);

        // Create a new chat instance
        $chat = new Chat();
        $chat->name = $validatedData['name'];
        $chat->department = $validatedData['department'];
        $chat->category = $validatedData['category'];
        $chat->message = $validatedData['message'];
        $chat->status = 'open'; // Set the initial status to "open"

        // Save the chat instance
        $chat->save();

        // Optionally, you can return a response indicating success or failure
        return response()->json(['message' => 'Conversation started successfully'], 200);
    }

}
