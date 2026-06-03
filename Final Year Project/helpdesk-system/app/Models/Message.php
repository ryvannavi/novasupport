<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'ticket_id',
        'created_by',
        'content',
        'is_ai_generated',
        'approved',
        'sender_type',
    ];

    protected function casts(): array
    {
        return [
            'is_ai_generated' => 'boolean',
            'approved' => 'boolean',
        ];
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}