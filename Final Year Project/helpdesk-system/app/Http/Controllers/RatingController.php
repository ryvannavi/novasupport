<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, $ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);

        // Only ticket owner can rate
        if ($ticket->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Only resolved tickets
        if ($ticket->status !== 'resolved') {
            return response()->json(['success' => false, 'message' => 'Ticket not resolved yet'], 400);
        }

        // Only one rating per ticket
        if ($ticket->rating) {
            return response()->json(['success' => false, 'message' => 'Already rated'], 400);
        }

        $validated = $request->validate([
            'stars'   => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Rating::create([
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id(),
            'stars'     => $validated['stars'],
            'comment'   => $validated['comment'] ?? null,
        ]);

        return response()->json(['success' => true, 'message' => 'Thank you for your rating!']);
    }
}