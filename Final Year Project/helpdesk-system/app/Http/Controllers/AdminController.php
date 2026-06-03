<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Message;
use App\Models\User;
use App\Notifications\TicketRepliedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('user')->orderBy('created_at', 'desc')->get();
        
        if (request()->has('ajax')) {
            return view('admin.index', ['tickets' => $tickets])->render();
        }
        
        return view('admin.index', ['tickets' => $tickets]);
    }

    public function show($id)
    {
        $ticket = Ticket::with(['user', 'messages', 'rating'])->findOrFail($id);
        
        if (request()->has('ajax')) {
            return view('admin.show', ['ticket' => $ticket])->render();
        }
        
        return view('admin.show', ['ticket' => $ticket]);
    }

    public function updateStatus(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function approveMessage($id)
    {
        $message = Message::findOrFail($id);
        $message->update(['approved' => true]);

        try {
            $ticket = $message->ticket;
            $ticket->user->notify(new TicketRepliedNotification($ticket));
        } catch (\Exception $e) {
            // Notification failed silently
        }

        return redirect()->back()->with('success', 'Message approved! Customer can now see it.');
    }

    public function rejectMessage($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        return redirect()->back()->with('success', 'Message rejected and deleted.');
    }

    public function analytics()
    {
        // --- Ticket Counts ---
        $total      = Ticket::count();
        $open       = Ticket::where('status', 'open')->count();
        $inProgress = Ticket::where('status', 'in_progress')->count();
        $resolved   = Ticket::where('status', 'resolved')->count();

        // --- Average Response Time (hours) ---
        // First admin message per ticket vs ticket created_at
        $avgResponseTime = null;
        $tickets = Ticket::with(['messages' => function($q) {
            $q->where('sender_type', 'admin')->orderBy('created_at', 'asc');
        }])->get();

        $responseTimes = [];
        foreach ($tickets as $ticket) {
            $firstAdminMsg = $ticket->messages->first();
            if ($firstAdminMsg) {
                $diffHours = $ticket->created_at->diffInMinutes($firstAdminMsg->created_at) / 60;
                $responseTimes[] = $diffHours;
            }
        }
        $avgResponseTime = count($responseTimes) > 0
            ? round(array_sum($responseTimes) / count($responseTimes), 1)
            : null;

        // --- Total Messages ---
        $totalMessages = Message::count();

        // --- AI Stats ---
        $aiMessages      = Message::where('is_ai_generated', true)->count();
        $aiApproved      = Message::where('is_ai_generated', true)->where('approved', true)->count();
        $aiRejected      = Message::where('is_ai_generated', true)->where('approved', false)->count();
        $aiApprovalRate  = $aiMessages > 0 ? round(($aiApproved / $aiMessages) * 100) : 0;
        $aiResponseRate  = $total > 0 ? round(($aiMessages / max($total, 1)) * 100) : 0;

        // --- Line Chart: Tickets per day (last 30 days) ---
        $last30Days = collect();
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $count = Ticket::whereDate('created_at', $date)->count();
            $last30Days->push(['date' => $date, 'count' => $count]);
        }

        $chartDates  = $last30Days->pluck('date')->toJson();
        $chartCounts = $last30Days->pluck('count')->toJson();

        // --- Avg Customer Satisfaction ---
        $avgRating = \App\Models\Rating::avg('stars');
        $avgRating = $avgRating ? round($avgRating, 1) : null;
        $totalRatings = \App\Models\Rating::count();

        $data = compact(
            'total', 'open', 'inProgress', 'resolved',
            'avgResponseTime', 'totalMessages',
            'aiMessages', 'aiApproved', 'aiRejected', 'aiApprovalRate', 'aiResponseRate',
            'chartDates', 'chartCounts',
            'avgRating', 'totalRatings'
        );

        if (request()->has('ajax')) {
            return view('admin.analytics', $data)->render();
        }

        return view('admin.analytics', $data);
    }

    public function replyToCustomer(Request $request, $id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            
            $validated = $request->validate([
                'content' => 'required|string|min:2|max:2000',
            ]);

            // Create admin's manual message (NO auto AI response)
            $message = Message::create([
                'ticket_id' => $ticket->id,
                'created_by' => auth()->id(),
                'content' => $validated['content'],
                'is_ai_generated' => false,
                'approved' => true,
                'sender_type' => 'admin',
            ]);

            // Notify customer
            try {
                $ticket->user->notify(new TicketRepliedNotification($ticket));
            } catch (\Exception $e) {
                // Notification failed silently
            }

            return response()->json(['success' => true, 'message' => 'Message sent to customer']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}