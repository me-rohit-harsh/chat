<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\ChatEvent;
use App\Models\Conversation;

class AdminController extends Controller







{


    public function getChats(Request $request)
    {
        $status = $request->status;

        if ($status == '') {
            $chats = Chat::orderBy('created_at', 'desc')->get();
        } else {
            $chats = Chat::where('status', $status)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        return view('admin.index', compact('chats'));
    }

    public function postChats(Request $request)
    {
        $status = $request->status;

        if ($status == 'all') {
            $chats = Chat::orderBy('created_at', 'desc')->get();
        } else {
            $chats = Chat::where('status', $status)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('admin.index', compact('chats'));
    }


    public function showChat($chat_id)
    {

        $uniqueChat = Chat::find($chat_id);
        // dd($chat);
        if (!$uniqueChat) {
            return redirect()->back()->with('alert', 'No chat found with the given ID.');
        }
        $chats =
            Chat::orderBy('created_at', 'desc')->get();
            // dd($chats);
        $conversations = $uniqueChat->conversations()->orderBy('created_at', 'asc')->get();

        return view('admin.index', compact('uniqueChat', 'chats', 'conversations'));
    }
    public function sendAdminReply(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'adminMsg' => 'required|string',
            'chatId' => 'required|exists:chats,id', // Ensure chatId exists in the chats table
        ]);
        $chatId = $request->input('chatId');
        $chat = Chat::findOrFail($chatId);
        $user = Auth()->user();
        // Save the admin reply to the conversation table
        $conversation = new Conversation();
        $conversation->chat_id = $chat->id;
        $conversation->user_id = $user->id; // Since it's an admin reply, user_id can be null
        $conversation->message = $request->input('adminMsg');
        $conversation->con_type = 'admin'; // Set the conversation type to 'admin'
        $conversation->save();

        // Update the chat with admin reply
        $chat->admin_reply = $request->input('adminMsg');
        $chat->save();

        // Dispatch the ChatEvent
        event(new ChatEvent($chat));
        // Respond with a success message
        return response()->json(['message' => 'Admin reply sent successfully'], 200);
    }
}
