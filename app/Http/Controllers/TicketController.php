<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function raiseTicket(){
        return view('client.raiseTicket');
    }
    public function adminTicket(){
        return view('admin.ticket');
    }
    public function tickets(){
        // Get the currently authenticated user's ID
        $userId = auth()->id();

        // Retrieve all tickets associated with the user
        $tickets = Ticket::where('user_id', $userId)->get();
        return view('client.ticketlist', compact('tickets'));
    }
    public function showTicket(){
        return view('');
    }
    public function addTickets(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'category' => 'required|string',
            'department' => 'required|string',
            'message' => 'required|string',
            // Add more validation rules if needed
        ]);

        // Create a new ticket instance
        $ticket = new Ticket();
        $ticket->user_id = auth()->id(); // Assuming you're using authentication
        $ticket->category = $validatedData['category'];
        $ticket->department = $validatedData['department'];
        $ticket->message = $validatedData['message'];
        $ticket->save();

        // Redirect back with success message or do something else
        return redirect()->back()->with('success', 'Ticket raised successfully!');
    }
}
