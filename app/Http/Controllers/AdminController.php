<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class AdminController extends Controller
{


    public function getChats(Request $request)
    {
        $status = $request->status;

        if ($status == '') {
            $chats = Chat::all();
        } else {
            $chats = Chat::where('status', $status)->get();
        }
        return view('admin.index', compact('chats'));
    }
    public function postChats(Request $request)
    {
        $status = $request->status;

        if ($status == 'all') {
            $chats = Chat::all();
        } else {
            $chats = Chat::where('status', $status)->get();
        }

        return view('admin.index', compact('chats'));
    }

    public function showChat($chat_id)
    {
        $chats = Chat::all();
        $uniqueChat = Chat::find($chat_id);
// dd($chat);
        if (!$uniqueChat) {
            return redirect()->back()->with('alert', 'No chat found with the given ID.');
        }

        return view('admin.index', compact('uniqueChat', 'chats'));
    }
    public function sendAdminReply(Request $request)
    {
        echo("here is am");
        dd($request->all());
        // Validate the incoming request data
        $request->validate([
            'adminMsg' => 'required|string|max:255',
        ]);

        // Assuming you're sending admin replies to a specific chat
        // You might need to adjust this part based on your application's logic
        $chatId = $request->input('chat_id'); // Assuming you have a hidden input with chat_id in your form
        $chat = Chat::findOrFail($chatId);

        // Save the admin reply to the chat
        $chat->admin_reply = $request->input('adminMsg');
        $chat->save();

        // You can also do any additional processing here, like sending notifications, etc.

        // Respond with a success message
        return response()->json(['message' => 'Admin reply sent successfully'], 200);
    }
}
