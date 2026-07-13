<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AdminFaqController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (request()->has('ajax')) {
        return view('welcome')->render();
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (request()->has('ajax')) {
        return view('dashboard')->render();
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Contact page
Route::get('/contact', function() {
    if(request()->has('ajax')) return view('contact')->render();
    return view('contact');
})->name('contact');

// FAQ routes (public)
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/faq/{slug}', [FaqController::class, 'category'])->name('faq.category');
Route::get('/faq-search', [FaqController::class, 'search'])->name('faq.search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{id}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
    Route::post('/tickets/{id}/rate', [RatingController::class, 'store'])->name('tickets.rate');

    Route::post('/notifications/{id}/read', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return response()->json(['success' => true]);
    });

    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    });

    // Check for new notifications (Real-time polling)
    Route::get('/notifications/check', function () {
        $user = auth()->user();
        $since = request('since');

        $new = $since
            ? $user->notifications()->where('created_at', '>', $since)->orderBy('created_at', 'desc')->get()
            : collect();

        return response()->json([
            'unread_count' => $user->unreadNotifications->count(),
            'server_time'  => now()->toDateTimeString(),
            'new' => $new->map(function ($n) {
                return [
                    'id'      => $n->id,
                    'message' => $n->data['message'] ?? 'New notification',
                    'type'    => $n->data['type'] ?? 'info',
                    'url'     => $n->data['url'] ?? '#',
                    'time'    => $n->created_at->diffForHumans(),
                ];
            })->values(),
        ]);
    });

    // Live chat polling for ticket conversation pages
    Route::get('/tickets/{id}/messages/poll', function ($id) {
        $user = auth()->user();
        $ticket = \App\Models\Ticket::findOrFail($id);

        if (!$user->is_admin && $ticket->user_id !== $user->id) {
            abort(403);
        }

        $since = request('since');

        if (!$since) {
            return response()->json([
                'server_time' => now()->toDateTimeString(),
                'messages'    => [],
            ]);
        }

        $messages = $ticket->messages()
            ->where('updated_at', '>', $since)
            ->orderBy('created_at')
            ->get()
            ->filter(function ($m) use ($user) {
                // Skip the viewer's own manually typed messages (already on their screen)
                if (!$m->is_ai_generated && $m->created_by === $user->id) return false;
                // Customers only see customer messages + approved team replies
                if (!$user->is_admin) return $m->sender_type === 'customer' || $m->approved;
                return true;
            })
            ->values();

        return response()->json([
            'server_time' => now()->toDateTimeString(),
            'messages' => $messages->map(function ($m) use ($ticket) {
                return [
                    'id'          => $m->id,
                    'content'     => $m->content,
                    'sender_type' => $m->sender_type,
                    'is_ai'       => (bool) $m->is_ai_generated,
                    'approved'    => (bool) $m->approved,
                    'time'        => $m->created_at->format('H:i'),
                    'sender_name' => $ticket->user->name,
                ];
            }),
        ]);
    });
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    Route::get('/faq', [AdminFaqController::class, 'index'])->name('admin.faq.index');
    Route::post('/faq', [AdminFaqController::class, 'store'])->name('admin.faq.store');
    Route::delete('/faq/{id}', [AdminFaqController::class, 'destroy'])->name('admin.faq.destroy');
    Route::get('/tickets/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::patch('/tickets/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.tickets.status');
    Route::patch('/messages/{id}/approve', [AdminController::class, 'approveMessage'])->name('admin.messages.approve');
    Route::delete('/messages/{id}/reject', [AdminController::class, 'rejectMessage'])->name('admin.messages.reject');
    Route::post('/tickets/{id}/reply', [AdminController::class, 'replyToCustomer'])->name('admin.tickets.reply');
});

require __DIR__.'/auth.php';