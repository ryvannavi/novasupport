<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TicketRepliedNotification extends Notification
{
    use Queueable;

    public function __construct(public Ticket $ticket) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $isAdmin = (bool) ($notifiable->is_admin ?? false);
        $customerName = $this->ticket->user->name ?? 'A customer';

        return [
            'ticket_id' => $this->ticket->id,
            'title' => $this->ticket->title,
            'message' => $isAdmin
                ? "{$customerName} replied to '{$this->ticket->title}'"
                : "Your support request '{$this->ticket->title}' has received a reply!",
            'type' => 'ticket_replied',
            'url' => $isAdmin
                ? '/admin/tickets/' . $this->ticket->id
                : '/tickets/' . $this->ticket->id,
        ];
    }
}