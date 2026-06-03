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
        $unreadCount = auth()->user()->unreadNotifications->count();
        return response()->json(['unread_count' => $unreadCount]);
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