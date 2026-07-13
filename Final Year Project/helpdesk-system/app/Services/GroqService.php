<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Ticket;

class GroqService
{
    protected ?string $apiKey;
    protected string $model = 'llama-3.3-70b-versatile';

    public function __construct()
    {
        $this->apiKey = config('services.groq.key');
    }

    /**
     * Generate a smart AI reply using the FULL conversation history of the ticket.
     * The AI decides greeting, tone, and closing by itself.
     * NEVER throws: if the API key is missing or Groq fails, a friendly
     * fallback reply is returned so ticket submission always succeeds.
     */
    public function replyToTicket(Ticket $ticket): string
    {
        if (empty($this->apiKey)) {
            Log::warning('GroqService: GROQ_API_KEY is not set — using fallback reply.');
            return $this->fallbackReply($ticket);
        }

        $firstName = explode(' ', $ticket->user->name ?? 'there')[0];

        // Build the conversation history as a chat
        $chat = [];

        // The ticket description is the customer's first message
        $chat[] = [
            'role'    => 'user',
            'content' => "Ticket subject: {$ticket->title}\n\n{$ticket->description}",
        ];

        foreach ($ticket->messages()->orderBy('created_at')->get() as $m) {
            $chat[] = [
                'role'    => $m->sender_type === 'customer' ? 'user' : 'assistant',
                'content' => $m->content,
            ];
        }

        $hasRepliedBefore = collect($chat)->contains(fn ($c) => $c['role'] === 'assistant');

        $system = "You are the support agent for NovaSupport, an AI-powered helpdesk for a tech software company. "
            . "You are chatting with a customer named {$firstName}. You can see the entire conversation so far. "
            . "Reply ONLY to the customer's most recent message.\n\n"
            . "Rules:\n"
            . ($hasRepliedBefore
                ? "- This is a FOLLOW-UP reply. Do NOT greet again (no 'Hello', no 'Hi there'). Do NOT introduce yourself. Do NOT repeat advice you already gave — instead give the NEXT troubleshooting step, more specific help, or ask ONE short clarifying question.\n"
                : "- This is your FIRST reply. Start with exactly: Hello {$firstName},\n")
            . "- Be specific and practical, like a skilled human support agent.\n"
            . "- Keep it under 120 words. Plain text only, no markdown, no bullet symbols.\n"
            . "- If the customer's issue appears solved or they are thanking you, write a short warm closing, thank them for contacting NovaSupport, and end with:\nBest regards,\nNovaSupport Team\n"
            . "- If the issue is NOT yet solved, do NOT add a signature — just reply conversationally, like a live chat.\n"
            . "- Never make up features, links, or emails that were not mentioned. For password resets, account issues, or billing, guide them through realistic general steps.";

        try {
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'      => $this->model,
                'messages'   => array_merge([['role' => 'system', 'content' => $system]], $chat),
                'max_tokens' => 300,
            ]);

            if (!$response->successful()) {
                Log::error('Groq API error: ' . $response->status() . ' ' . $response->body());
                return $this->fallbackReply($ticket);
            }

            $reply = $response->json('choices.0.message.content');

            if (!$reply) {
                Log::error('Groq returned empty reply: ' . $response->body());
                return $this->fallbackReply($ticket);
            }

            return trim($reply);
        } catch (\Throwable $e) {
            Log::error('GroqService exception: ' . $e->getMessage());
            return $this->fallbackReply($ticket);
        }
    }

    /**
     * Friendly reply used when the AI is unavailable, so the customer
     * always gets an instant acknowledgement and the app never crashes.
     */
    protected function fallbackReply(Ticket $ticket): string
    {
        $firstName = explode(' ', $ticket->user->name ?? 'there')[0];

        return "Hello {$firstName},\n\n"
            . "Thanks for contacting NovaSupport. We've received your request about \"{$ticket->title}\" "
            . "and our support team is looking into it. We'll get back to you here with more details as soon as possible.\n\n"
            . "Best regards,\nNovaSupport Team";
    }

    /**
     * Kept for backward compatibility in case it's referenced elsewhere.
     */
    public function generateReply(string $ticketTitle, string $ticketDescription, string $userName = null, int $ticketId = null): string
    {
        if ($ticketId) {
            $ticket = Ticket::find($ticketId);
            if ($ticket) {
                return $this->replyToTicket($ticket);
            }
        }

        if (empty($this->apiKey)) {
            return 'Thanks for contacting NovaSupport. Our team has received your request and will reply shortly.';
        }

        try {
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'    => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a customer support agent for NovaSupport. Write a professional, friendly, concise reply. Under 100 words.'],
                    ['role' => 'user', 'content' => "Ticket Title: {$ticketTitle}\n\nCustomer Issue: {$ticketDescription}"],
                ],
                'max_tokens' => 250,
            ]);

            return $response->json('choices.0.message.content') ?? 'Unable to generate reply.';
        } catch (\Throwable $e) {
            Log::error('GroqService exception: ' . $e->getMessage());
            return 'Thanks for contacting NovaSupport. Our team has received your request and will reply shortly.';
        }
    }
}