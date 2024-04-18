<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Chat;
use App\Models\Ticket;
use App\Events\ChatEvent;

class CreateTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chat;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Extract data from the chat
        $chat = $this->chat->fresh();  // Refresh chat to get the latest data

        // Check if created_at and updated_at are equal
        if ($chat->created_at == $chat->updated_at) {
            // Prepare data for the ticket
            $data = [
                'user_id' => $chat->user_id,
                'department' => $chat->department,
                'category' => $chat->category,
                'message' => $chat->message,
                'admin_reply' => null, 
                'status' => 'open', 
            ];

            // Create a new ticket instance
            $ticket = new Ticket();
            $ticket->fill($data);
            $ticket->save();
            // set the admin reply in the chat event
            $chat->admin_reply = "Ticket Id: $ticket->id. As our customer support is busy, your chat has been converted to a ticket. Please check your email for further updates. Thank you.";
            // $chat->status = 'closed';
            // Set the status of chat to closed and save the chat
            $chat->save();
            // Optionally, you can delete the chat object after converting it into a ticket
            // $chat->delete();

            event(new ChatEvent($chat));

        }
    }
}
