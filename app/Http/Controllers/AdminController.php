<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\ChatEvent;
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
        $chats =
        Chat::orderBy('created_at', 'desc')->get();
        $uniqueChat = Chat::find($chat_id);
        // dd($chat);
        if (!$uniqueChat) {
            return redirect()->back()->with('alert', 'No chat found with the given ID.');
        }

        return view('admin.index', compact('uniqueChat', 'chats'));
    }
    public function sendAdminReply(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'adminMsg' => 'required|string',
        ]);
        $chatId = $request->input('chatId');
        $chat = Chat::findOrFail($chatId);
        $chat->sender_id =Auth::id();
        // Save the admin reply to the chat
        $chat->admin_reply = $request->input('adminMsg');
        $chat->save();
        // Dispatch the ChatEvent
        event(new ChatEvent($chat));

        // Respond with a success message
        return response()->json(['message' => 'Admin reply sent successfully'], 200);
    }
}
