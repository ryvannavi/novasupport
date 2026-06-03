<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Message;
use App\Models\User;
use App\Services\GroqService;
use App\Notifications\NewTicketNotification;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function create()
    {
        if (request()->has('ajax')) {
            return view('tickets.create')->render();
        }
        
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
        ]);

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 'open',
        ]);

        // Generate AI reply automatically
        try {
            $groq = new GroqService();
            $aiReply = $groq->generateReply(
                $ticket->title, 
                $ticket->description,
                auth()->user()->name,
                $ticket->id  // Pass ticket ID to check if first message
            );

            Message::create([
                'ticket_id' => $ticket->id,
                'created_by' => auth()->id(),
                'content' => $aiReply,
                'is_ai_generated' => true,
                'approved' => false,
                'sender_type' => 'ai',
            ]);
        } catch (\Exception $e) {
            // AI failed silently
        }

        // Notify all admins
        try {
            $admins = User::where('is_admin', true)->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewTicketNotification($ticket));
            }
        } catch (\Exception $e) {
            // Notification failed silently
        }

        return redirect('/tickets')->with('success', 'Support request submitted! Our team will reply shortly.');
    }

    public function index()
    {
        $tickets = auth()->user()->tickets()->latest()->get();
        
        if (request()->has('ajax')) {
            return view('tickets.index', ['tickets' => $tickets])->render();
        }
        
        return view('tickets.index', ['tickets' => $tickets]);
    }

    public function show($id)
    {
        $ticket = Ticket::with('messages')->findOrFail($id);
        
        if (auth()->check() && !auth()->user()->is_admin && $ticket->user_id !== auth()->id()) {
            abort(403);
        }
        
        if (request()->has('ajax')) {
            return view('tickets.show-content', ['ticket' => $ticket])->render();
        }
        
        return view('tickets.show', ['ticket' => $ticket]);
    }

    public function reply(Request $request, $id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            
            if ($ticket->user_id !== auth()->id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $validated = $request->validate([
                'content' => 'required|string|min:2|max:2000',
            ]);

            // Create customer message
            $message = Message::create([
                'ticket_id' => $ticket->id,
                'created_by' => auth()->id(),
                'content' => $validated['content'],
                'is_ai_generated' => false,
                'approved' => true,
                'sender_type' => 'customer',
            ]);

            // Auto-generate AI response to customer's reply (NO greeting)
            try {
                $groq = new GroqService();
                $aiReply = $groq->generateReply(
                    $ticket->title,
                    $validated['content'],
                    auth()->user()->name,
                    $ticket->id  // Pass ticket ID - will NOT add greeting
                );

                Message::create([
                    'ticket_id' => $ticket->id,
                    'created_by' => auth()->id(),
                    'content' => $aiReply,
                    'is_ai_generated' => true,
                    'approved' => false,
                    'sender_type' => 'ai',
                ]);
            } catch (\Exception $e) {
                // AI failed silently
            }

            // Notify all admins that customer replied
            try {
                $admins = User::where('is_admin', true)->get();
                foreach ($admins as $admin) {
                    $admin->notify(new \App\Notifications\TicketRepliedNotification($ticket));
                }
            } catch (\Exception $e) {
                // Notification failed silently
            }

            return response()->json(['success' => true, 'message' => 'Reply sent']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}