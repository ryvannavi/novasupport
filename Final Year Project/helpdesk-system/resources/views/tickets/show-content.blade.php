<div style="padding:30px; animation:fadeUp 0.6s ease both;">
    <div style="max-width:700px; margin:0 auto;">

        <a href="{{ route('tickets.index') }}" class="ajax-link" data-url="{{ route('tickets.index') }}" style="display:inline-flex; align-items:center; gap:6px; font-size:12px; color:#6366f1; text-decoration:none; margin-bottom:20px; font-weight:600; cursor:pointer;" onmouseover="this.style.gap='10px'" onmouseout="this.style.gap='6px'">
            <i class="fa-solid fa-arrow-left"></i> Back to requests
        </a>

        <!-- Ticket Card -->
        <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:20px; padding:28px; margin-bottom:16px; box-shadow:0 4px 20px rgba(99,102,241,0.06);">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:16px;">
                <div>
                    <div style="font-size:11px; color:#94a3b8; margin-bottom:4px;">#SR-00{{ $ticket->id }}</div>
                    <div style="font-size:20px; font-weight:800; color:#0f172a;">{{ $ticket->title }}</div>
                </div>
                @php
                    $statusStyles = ['open'=>'background:#ede9fe;color:#5b21b6;','in_progress'=>'background:#fef3c7;color:#92400e;','resolved'=>'background:#d1fae5;color:#065f46;'];
                    $statusIcons = ['open'=>'fa-circle-dot','in_progress'=>'fa-spinner','resolved'=>'fa-circle-check'];
                @endphp
                <span style="font-size:11px; font-weight:600; padding:5px 14px; border-radius:99px; {{ $statusStyles[$ticket->status] ?? '' }} display:inline-flex; align-items:center; gap:5px; white-space:nowrap;">
                    <i class="fa-solid {{ $statusIcons[$ticket->status] ?? '' }}"></i>
                    {{ ucfirst(str_replace('_',' ',$ticket->status)) }}
                </span>
            </div>
            <div style="font-size:12px; color:#64748b; margin-bottom:12px;"><i class="fa-regular fa-clock" style="margin-right:5px;"></i> {{ $ticket->created_at->format('M d, Y H:i') }}</div>
            <div style="background:#f8fafc; border-radius:12px; padding:16px; font-size:13px; color:#334155; line-height:1.7; white-space: pre-wrap; word-wrap: break-word;">{{ $ticket->description }}</div>
        </div>

        <!-- Messages/Conversation Thread -->
        <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-comments" style="color:#6366f1;"></i> Conversation
        </div>

        @php
            $allMessages = $ticket->messages->sortBy('created_at');
        @endphp

        @if($allMessages->count() === 0)
            <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:24px; text-align:center;">
                <i class="fa-solid fa-hourglass-half" style="color:#94a3b8; font-size:24px; margin-bottom:10px; display:block;"></i>
                <div style="font-size:13px; font-weight:600; color:#0f172a; margin-bottom:4px;">Waiting for reply</div>
                <div style="font-size:11px; color:#64748b;">Our AI support team is preparing your response. Usually takes under 2 minutes.</div>
            </div>
        @else
            <!-- Chat Thread -->
            <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:20px; margin-bottom:16px;" id="conversationThread">
                @foreach($allMessages as $message)
                    @if($message->sender_type === 'customer')
                        <!-- Customer Message (Right side - WHITE) -->
                        <div style="display:flex; justify-content:flex-end; margin-bottom:16px; animation:fadeUp 0.4s ease both;">
                            <div style="max-width:80%; background:#fff; color:#0f172a; border:1px solid #e2e8f0; border-radius:14px; padding:14px 16px;">
                                <div style="font-size:13px; line-height:1.5; margin-bottom:6px; white-space: pre-wrap; word-wrap: break-word;">{{ $message->content }}</div>
                                <div style="font-size:10px; color:#94a3b8;">{{ $message->created_at->format('H:i') }}</div>
                            </div>
                        </div>
                    @elseif($message->approved)
                        <!-- Only show APPROVED NovaSupport Team Messages (Left side - BLUE) -->
                        <div style="display:flex; justify-content:flex-start; margin-bottom:16px; animation:fadeUp 0.4s ease both;">
                            <div style="max-width:80%;">
                                <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                    <div style="width:24px; height:24px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); border-radius:6px; display:flex; align-items:center; justify-content:center;">
                                        <i class="fa-solid fa-user" style="color:#7c3aed; font-size:11px;"></i>
                                    </div>
                                    <span style="font-size:11px; font-weight:600; color:#7c3aed;">NovaSupport Team</span>
                                    <span style="font-size:10px; color:#94a3b8;">{{ $message->created_at->format('H:i') }}</span>
                                </div>
                                <div style="background:linear-gradient(135deg,#3b82f6,#2563eb); color:#fff; border-radius:12px; padding:12px 14px; font-size:13px; line-height:1.6; white-space: pre-wrap; word-wrap: break-word;">{{ $message->content }}</div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        <!-- Reply Form -->
        @if($ticket->status !== 'resolved')
            <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:20px; margin-bottom:16px;">
                <div style="font-size:12px; font-weight:600; color:#0f172a; margin-bottom:14px;">
                    <i class="fa-solid fa-reply" style="color:#6366f1; margin-right:6px;"></i> Reply to Support Team
                </div>
                <form id="replyForm" style="display:flex; flex-direction:column; gap:12px;">
                    @csrf
                    <textarea
                        id="replyContent"
                        name="content"
                        placeholder="Type your message here... (tell us more about the issue, ask questions, etc.)"
                        style="width:100%; padding:12px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; outline:none; resize:vertical; min-height:100px; font-family:'Figtree', sans-serif; color:#0f172a;"
                        onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''"
                    ></textarea>

                    <button
                        type="submit"
                        id="replyBtn"
                        style="padding:11px 20px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border:none; border-radius:10px; font-size:12px; font-weight:600; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.3s;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(99,102,241,0.3)'"
                        onmouseout="this.style.transform=''; this.style.boxShadow=''"
                    >
                        <i class="fa-solid fa-paper-plane"></i> Send Reply
                    </button>
                </form>
            </div>
        @else
            <div style="background:#d1fae5; color:#065f46; padding:12px 16px; border-radius:12px; font-size:12px; display:flex; align-items:center; gap:8px;">
                <i class="fa-solid fa-circle-check"></i> This ticket is resolved. No further replies allowed.
            </div>
        @endif
    </div>
</div>

<script>
    document.getElementById('replyForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        const content = document.getElementById('replyContent').value.trim();
        const btn = document.getElementById('replyBtn');

        if (!content) {
            alert('Please type a message');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch('{{ route("tickets.reply", $ticket->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ content: content })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                document.getElementById('replyContent').value = '';
                if (typeof showToast === 'function') showToast('Reply sent! Our team will respond shortly.');

                // Use AJAX reload instead of full page reload
                setTimeout(() => {
                    if (typeof go === 'function') {
                        _busy = false;
                        go(window.location.pathname);
                    } else {
                        location.reload();
                    }
                }, 1000);
            } else {
                alert('Error: ' + (data.message || 'Could not send reply'));
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send Reply';
            }
        } catch (error) {
            alert('Error sending reply');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send Reply';
        }
    });
</script>