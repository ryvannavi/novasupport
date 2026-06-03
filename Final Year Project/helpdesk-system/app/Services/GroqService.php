<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Message;

class GroqService
{
    protected string $apiKey;
    protected string $model = 'llama-3.3-70b-versatile';

    public function __construct()
    {
        $this->apiKey = config('services.groq.key');
    }

    public function generateReply(string $ticketTitle, string $ticketDescription, string $userName = null, int $ticketId = null): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a customer support agent for NovaSupport, an AI-powered helpdesk platform. Write a professional, friendly, and concise reply to the customer support ticket. Keep it under 100 words.',
                ],
                [
                    'role' => 'user',
                    'content' => "Ticket Title: {$ticketTitle}\n\nCustomer Issue: {$ticketDescription}",
                ],
            ],
            'max_tokens' => 250,
        ]);

        $reply = $response->json('choices.0.message.content') ?? 'Unable to generate reply.';

        // Check if this is the first message in the ticket
        $isFirstMessage = false;
        if ($ticketId) {
            $messageCount = Message::where('ticket_id', $ticketId)->count();
            $isFirstMessage = ($messageCount === 0);
        }

        // Only add "Hello [Name]," for the FIRST response
        if ($isFirstMessage) {
            $firstName = $userName ? explode(' ', $userName)[0] : 'there';
            return "Hello {$firstName},\n\n{$reply}\n\nBest regards,\nNovaSupport Team";
        } else {
            // Follow-up responses: no greeting
            return "{$reply}\n\nBest regards,\nNovaSupport Team";
        }
    }
}