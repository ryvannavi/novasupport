<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewTicketNotification extends Notification
{
    use Queueable;

    public function __construct(public Ticket $ticket) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => $this->ticket->title,
            'user_name' => $this->ticket->user->name,
            'message' => "New support request from {$this->ticket->user->name}: {$this->ticket->title}",
            'type' => 'new_ticket',
            'url' => '/admin/tickets/' . $this->ticket->id,
        ];
    }
}