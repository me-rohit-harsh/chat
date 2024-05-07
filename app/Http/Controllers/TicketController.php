<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketConversation;
use App\Models\User;

class TicketController extends Controller
{
    public function raiseTicket(){
        return view('client.Ticket.raiseTicket');
    }
    public function index(Request $request)
    {
        $search = $request->input('search');



        if ($search) {

            $tickets = Ticket::where(function ($query) use ($search) {
                $query->where('category', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhere('message', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('department', 'like', '%' . $search . '%');
            })

                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orderByDesc('id')
                ->paginate(10);

            return view('admin.Ticket.index', compact('tickets'));
        }

        $tickets = Ticket::with([ 'user'])->orderByDesc('id')
            ->paginate(10);
        return view('admin.Ticket.index', compact('tickets'));
    }
    // public function tickets(){
    //     // Get the currently authenticated user's ID
    //     $userId = auth()->id();

    //     // Retrieve all tickets associated with the user
    //     $tickets = Ticket::where('user_id', $userId)->get();
    //     return view('client.ticketlist', compact('tickets'));
    // }

    public function user_support_tickets()
    {
        $customerId= auth()->id();
        $ticket = Ticket::where('user_id', $customerId)
            ->orderByDesc('id')
            ->paginate(10);
        return view('client.Ticket.ticketlist', compact('ticket'));
    }
    public function showTicket($id)
    {

        // Get the currently authenticated user
        $customerId= auth()->id();
        $customer = User::find($customerId);

        // Find the ticket related to the current user by ID
        $ticket = Ticket::where('user_id', $customerId)
            ->where('id', $id)
            ->first();

        if ($ticket) {
            // If the ticket is found, retrieve the ticket details and conversations

            $adminconv = TicketConversation::with(['ticket'])
            ->where('ticket_id', $id)
                ->where('con_type', 'Admin')
                ->get();
            $customerconv = TicketConversation::with(['ticket'])
            ->where('ticket_id', $id)
                ->where('con_type', 'Customer')
                ->get();

            // Merge the admin and customer conversations
            $mergedConversations = $adminconv->merge($customerconv);

            // Sort the merged conversations based on their timestamps
            $sortedConversations = $mergedConversations->sortByDesc('created_at');


            // Pass the ticket, customer, and sorted conversations to the view
            return view('client.Ticket.ticketsShow', compact('ticket', 'customer', 'sortedConversations'));
        } else {
            // If the ticket is not found, redirect the user to the ticket page
            return redirect()->route('user_support_tickets')->with('error', 'Ticket not found.');
        }
    }
    public function viewTickets($id = null)
    {
        // Find the ticket related to the current user by ID
        $ticket = Ticket::where('id', $id)->first();




        if ($ticket) {
            // Retrieve customer details
            $customer = User::find($ticket->user_id);

            // Retrieve conversations related to the ticket
            $adminconv = TicketConversation::with(['ticket'])
            ->where('ticket_id', $id)
                ->where('con_type', 'Admin')
                ->get();

            $customerconv = TicketConversation::with(['ticket'])
            ->where('ticket_id', $id)
                ->where('con_type', 'Customer')
                ->get();

            // Merge the admin and customer conversations
            $conversations = $adminconv->merge($customerconv);

            // Sort the merged conversations based on their timestamps
            $sortedConversations = $conversations->sortByDesc('created_at')->values();

            // Render the ticket details view with relevant data
            return view('admin.Ticket.ticket', compact('ticket', 'customer', 'id', 'sortedConversations'));
        } else {
            // If the ticket is not found, redirect the user to the ticket page
            return redirect()->route('ticket.list')->with('error', 'Ticket not found.');
        }
    }

    public function ticketConversation(Request  $request)
    {

        try {

            // $fileArray = $request->file('file');

            // $lastInsertedId = '';

            // $assetIds = [];
            // if ($fileArray) {
            //     foreach ($fileArray as $file) {
            //         $path = $this->uploadService->upload($file);
            //         $fileName = $file->getClientOriginalName();
            //         $mimeType = $file->getMimeType();
            //         $extension = $file->getClientOriginalExtension();

            //         $asset = new Asset();
            //         $asset->name = $fileName;
            //         $asset->image_path = $path;
            //         $asset->mime_type = $mimeType;
            //         $asset->extensions = $extension;
            //         $asset->save();
            //         $lastInsertedId = $asset->id;
            //         $assetIds[] = $lastInsertedId;
            //     }
            // }



            // $assetIdsList = implode(",", $assetIds);


            $conversation = new TicketConversation();
            $conversation->message = $request->message;
            $conversation->con_type = 'Admin';
            $conversation->ticket_id = $request->ticketId;
            // if ($fileArray) {
            //     $conversation->asset_id = $assetIdsList;
            // }
            $conversation->save();
            // Retrieve the ticket associated with the conversation
            $ticket = Ticket::findOrFail($request->ticketId);

            // Update the status of the ticket to "In Progress"
            $ticket->status = 'In progress';
            $ticket->save();
 
        } catch (\Exception $e) {

            session()->flash('error', $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
        session()->flash('success', 'Conversation added  successfully !!');
        return redirect()->back();
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
    public function ticketAdminConv(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'message' => 'required', // Ensure that the message field is required
            ]);

            if ($request->ctype == 'create') {
                $conversation = new TicketConversation();
                $conversation->ticket_id = $request->id;
            } else {
                $conversation = TicketConversation::findOrFail($request->id);
            }

            $conversation->message = $validatedData['message'];
            $conversation->con_type = 'Admin';
            $conversation->save();

            return response()->json([
                'msg'    => 'Record Saved',
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg'    => 'Error saving the Conversation: ' . $e->getMessage(),
                'status' => false,
            ], 500); // You can adjust the HTTP status code based on your requirements
        }
    }
    public function ticketCustomerConv(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'message' => 'required', // Ensure that the message field is required
            ]);

            $conversation = TicketConversation::findOrFail($request->id);
            $conversation->message = $validatedData['message'];
            $conversation->con_type = 'Customer';
            $conversation->save();

          

            return response()->json([
                'msg'    => 'Record Saved',
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg'    => 'Error saving the Conversation: ' . $e->getMessage(),
                'status' => false,
            ], 500); // You can adjust the HTTP status code based on your requirements
        }
    }
    public function delete($id)
    {
        // Find the Conv by ID
        $conv = TicketConversation::find($id);

        // Check if the conve exists
        if (!$conv) {
            return redirect()->back()->with('error', 'Conver not found.');
        }
        // Delete the ticket
        $conv->delete();

        return redirect()->back()->with('success', 'Message deleted successfully.');
    }
    public function saveTicketStatus(Request $request)
    {
        try {
            $ticket = Ticket::findOrFail($request->id);
            $ticket->status = $request->status;
            $ticket->save();

            return response()->json([
                'msg'    => 'Record Saved successfully',
                'category' => $ticket->category,
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg'    => 'Error saving  The data: ' . $e->getMessage(),
                'category' => '',
                'status' => false,
            ], 500); // You can adjust the HTTP status code based on your requirements
        }
    }

    public function CusTicketConversation(Request  $request)
    {

        try {

            // $fileArray = $request->file('file');

            // $lastInsertedId = '';
            // $assetIds = [];
            // if ($fileArray) {
            //     foreach ($fileArray as $file) {
            //         $path = $this->uploadService->upload($file);
            //         $fileName = $file->getClientOriginalName();
            //         $mimeType = $file->getMimeType();
            //         $extension = $file->getClientOriginalExtension();

            //         $asset = new Asset();
            //         $asset->name = $fileName;
            //         $asset->image_path = $path;
            //         $asset->mime_type = $mimeType;
            //         $asset->extensions = $extension;
            //         $asset->save();
            //         $lastInsertedId = $asset->id;
            //         $assetIds[] = $lastInsertedId;
            //     }
            // }


            $conversation = new TicketConversation();
            $conversation->message = $request->message;
            $conversation->con_type = 'Customer';
            $conversation->ticket_id = $request->ticketId;
            $conversation->save();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
        session()->flash('success', 'Conversation added  successfully !!');
        return redirect()->back();
    }
    public function closeTicket(Request $request)
    {
        try {
            $ticket = Ticket::findOrFail($request->id);
            $ticket->status = 'Closed';
            $ticket->save();
            return response()->json([
                'msg' => 'Ticket closed successfully',
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error closing the ticket: ' . $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }
}
