@if(request()->has('ajax'))
    <div style="padding:30px; animation:fadeUp 0.6s ease both;">
        <div style="max-width:750px; margin:0 auto;">

            <a href="{{ route('admin.index') }}" class="ajax-link" data-url="{{ route('admin.index') }}" style="display:inline-flex; align-items:center; gap:6px; font-size:12px; color:#6366f1; text-decoration:none; margin-bottom:20px; font-weight:600; cursor:pointer;" onmouseover="this.style.gap='10px'" onmouseout="this.style.gap='6px'">
                <i class="fa-solid fa-arrow-left"></i> Back to all requests
            </a>

            @if(session('success'))
                <div style="background:#dcfce7; color:#15803d; padding:12px 16px; border-radius:12px; font-size:12px; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Ticket Details -->
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

                <div style="display:flex; gap:16px; margin-bottom:16px;">
                    <div style="font-size:12px; color:#64748b;"><i class="fa-solid fa-user" style="color:#6366f1; margin-right:5px;"></i> {{ $ticket->user->name }} ({{ $ticket->user->email }})</div>
                    <div style="font-size:12px; color:#64748b;"><i class="fa-regular fa-clock" style="color:#6366f1; margin-right:5px;"></i> {{ $ticket->created_at->format('M d, Y H:i') }}</div>
                </div>

                <div style="background:#f8fafc; border-radius:12px; padding:16px; font-size:13px; color:#334155; line-height:1.7; margin-bottom:20px; white-space: pre-wrap; word-wrap: break-word;">{{ $ticket->description }}</div>

                <!-- Update Status -->
                <form method="POST" action="{{ route('admin.tickets.status', $ticket->id) }}" style="display:flex; align-items:center; gap:10px;">
                    @csrf
                    @method('PATCH')
                    <select name="status" style="flex:1; padding:9px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:12px; outline:none; color:#0f172a; cursor:pointer;" onfocus="this.style.borderColor='#6366f1'" onblur="this.style.borderColor='#e2e8f0'">
                        <option value="open" {{ $ticket->status==='open'?'selected':'' }}>Open</option>
                        <option value="in_progress" {{ $ticket->status==='in_progress'?'selected':'' }}>In Progress</option>
                        <option value="resolved" {{ $ticket->status==='resolved'?'selected':'' }}>Resolved</option>
                    </select>
                    <button type="submit" style="padding:9px 20px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border:none; border-radius:10px; font-size:12px; font-weight:600; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px; transition:all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(99,102,241,0.3)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                        <i class="fa-solid fa-floppy-disk"></i> Update Status
                    </button>
                </form>
            </div>

            <!-- Conversation Thread -->
            <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
                <i class="fa-solid fa-comments" style="color:#6366f1;"></i> Conversation ({{ $ticket->messages->count() }} messages)
            </div>

            @php 
                $allMessages = $ticket->messages->sortBy('created_at');
            @endphp

            @if($allMessages->count() === 0)
                <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:24px; text-align:center;">
                    <i class="fa-solid fa-robot" style="color:#94a3b8; font-size:24px; margin-bottom:10px; display:block;"></i>
                    <div style="font-size:13px; color:#64748b;">No messages yet. AI response is being generated...</div>
                </div>
            @else
                <!-- Chat Thread -->
                <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:20px; margin-bottom:16px;">
                    @foreach($allMessages as $message)
                        @if($message->sender_type === 'customer')
                            <!-- Customer Message (Right side - WHITE) -->
                            <div style="display:flex; justify-content:flex-end; margin-bottom:16px; animation:fadeUp 0.4s ease both;">
                                <div style="max-width:80%; background:#fff; color:#0f172a; border:1px solid #e2e8f0; border-radius:14px; padding:14px 16px;">
                                    <div style="font-size:12px; font-weight:600; margin-bottom:4px;">{{ $ticket->user->name }}</div>
                                    <div style="font-size:13px; line-height:1.5; margin-bottom:6px; white-space: pre-wrap; word-wrap: break-word;">{{ $message->content }}</div>
                                    <div style="font-size:10px; color:#94a3b8;">{{ $message->created_at->format('H:i') }}</div>
                                </div>
                            </div>
                        @else
                            <!-- NovaSupport Team Message (Left side - BLUE) -->
                            <div style="display:flex; justify-content:flex-start; margin-bottom:16px; animation:fadeUp 0.4s ease both;">
                                <div style="max-width:80%;">
                                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                        <div style="width:24px; height:24px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); border-radius:6px; display:flex; align-items:center; justify-content:center;">
                                        <i class="fa-solid fa-user" style="color:#7c3aed; font-size:11px;"></i>
                                        </div>
                                        <span style="font-size:11px; font-weight:600; color:#7c3aed;">NovaSupport Team</span>
                                        <span style="font-size:10px; color:#94a3b8;">{{ $message->created_at->format('H:i') }}</span>
                                        @if($message->is_ai_generated)
                                            @if($message->approved)
                                                <span style="font-size:9px; font-weight:600; padding:2px 8px; border-radius:99px; background:#dcfce7; color:#15803d; display:inline-flex; align-items:center; gap:3px;">
                                                    <i class="fa-solid fa-circle-check" style="font-size:7px;"></i> Sent
                                                </span>
                                            @else
                                                <span style="font-size:9px; font-weight:600; padding:2px 8px; border-radius:99px; background:#ede9fe; color:#5b21b6; display:inline-flex; align-items:center; gap:3px;">
                                                    <i class="fa-solid fa-clock" style="font-size:7px;"></i> Pending
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                    <div style="background:linear-gradient(135deg,#3b82f6,#2563eb); color:#fff; border-radius:12px; padding:12px 14px; font-size:13px; line-height:1.6; margin-bottom:10px; white-space: pre-wrap; word-wrap: break-word;">{{ $message->content }}</div>
                                    
                                    @if($message->is_ai_generated && !$message->approved)
                                        <div style="display:flex; gap:8px;">
                                            <form method="POST" action="{{ route('admin.messages.approve', $message->id) }}" style="flex:1;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" style="width:100%; padding:9px; border-radius:99px; background:linear-gradient(135deg,#059669,#047857); color:#fff; border:none; cursor:pointer; font-size:12px; font-weight:600; display:flex; align-items:center; justify-content:center; gap:6px; transition:all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(5,150,105,0.3)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                                                    <i class="fa-solid fa-circle-check"></i> Approve & Send
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.messages.reject', $message->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="padding:9px 18px; border-radius:99px; background:#fff; color:#dc2626; border:1.5px solid #fecaca; cursor:pointer; font-size:12px; font-weight:600; display:flex; align-items:center; gap:6px; transition:all 0.3s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fff'">
                                                    <i class="fa-solid fa-trash"></i> Reject
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif


            {{-- Customer Rating --}}
            @if($ticket->rating)
                <div style="background:rgba(255,255,255,0.92);border:1px solid #fde68a;border-radius:16px;padding:20px;margin-bottom:16px;animation:fadeUp 0.4s ease both;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:32px;height:32px;border-radius:10px;background:linear-gradient(135deg,#fef3c7,#fde68a);display:flex;align-items:center;justify-content:center;">
                                <i class="fa-solid fa-star" style="color:#d97706;font-size:13px;"></i>
                            </div>
                            <div>
                                <div style="font-size:12px;font-weight:700;color:#0f172a;">Customer Rating</div>
                                <div style="font-size:10px;color:#94a3b8;">{{ $ticket->rating->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:4px;background:#fef3c7;padding:6px 12px;border-radius:99px;">
                            @for($i=1;$i<=5;$i++)
                                <i class="fa-solid fa-star" style="font-size:13px;color:{{ $i <= $ticket->rating->stars ? '#f59e0b' : '#e2e8f0' }};"></i>
                            @endfor
                            <span style="font-size:12px;font-weight:700;color:#d97706;margin-left:6px;">{{ $ticket->rating->stars }}/5</span>
                        </div>
                    </div>
                    @if($ticket->rating->comment)
                        <div style="background:#fefce8;border:1px solid #fde68a;border-radius:10px;padding:12px 14px;">
                            <div style="font-size:10px;font-weight:600;color:#d97706;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;"><i class="fa-solid fa-quote-left" style="margin-right:4px;"></i> Customer Comment</div>
                            <div style="font-size:12px;color:#334155;line-height:1.6;font-style:italic;">"{{ $ticket->rating->comment }}"</div>
                        </div>
                    @else
                        <div style="font-size:11px;color:#94a3b8;font-style:italic;">No comment left.</div>
                    @endif
                </div>
            @endif

            <!-- Admin Reply Form (only if not resolved) -->
            @if($ticket->status !== 'resolved')
                <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:20px;">
                    <div style="font-size:12px; font-weight:600; color:#0f172a; margin-bottom:14px;">
                        <i class="fa-solid fa-reply" style="color:#6366f1; margin-right:6px;"></i> Send Message to Customer
                    </div>
                    <form id="adminReplyForm" style="display:flex; flex-direction:column; gap:12px;">
                        @csrf
                        <textarea 
                            id="adminReplyContent"
                            name="content" 
                            placeholder="Type your message to the customer..." 
                            style="width:100%; padding:12px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; outline:none; resize:vertical; min-height:100px; font-family:'Figtree', sans-serif; color:#0f172a;"
                            onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''"
                        ></textarea>
                        
                        <button 
                            type="submit" 
                            id="adminReplyBtn"
                            style="padding:11px 20px; background:linear-gradient(135deg,#059669,#047857); color:#fff; border:none; border-radius:10px; font-size:12px; font-weight:600; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.3s;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(5,150,105,0.3)'"
                            onmouseout="this.style.transform=''; this.style.boxShadow=''"
                        >
                            <i class="fa-solid fa-paper-plane"></i> Send to Customer
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Handle admin reply form submission
        document.getElementById('adminReplyForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();

            const content = document.getElementById('adminReplyContent').value.trim();
            const btn = document.getElementById('adminReplyBtn');

            if (!content) {
                alert('Please type a message');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch('{{ route("admin.tickets.reply", $ticket->id) }}', {
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
                    document.getElementById('adminReplyContent').value = '';
                    showToast('Message sent to customer!');
                    
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    alert('Error: ' + (data.message || 'Could not send message'));
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send to Customer';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error sending message');
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send to Customer';
            }
        });

        function showToast(message) {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #10b981;
                color: white;
                padding: 14px 20px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 600;
                z-index: 9999;
                animation: slideIn 0.3s ease;
                box-shadow: 0 4px 12px rgba(16,185,129,0.3);
            `;
            toast.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${message}`;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>

    <style>
        @keyframes slideIn {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(400px); opacity: 0; }
        }
    </style>
@else
    <x-app-layout>
        <div style="padding:30px; animation:fadeUp 0.6s ease both;">
            <div style="max-width:750px; margin:0 auto;">

                <a href="{{ route('admin.index') }}" class="ajax-link" data-url="{{ route('admin.index') }}" style="display:inline-flex; align-items:center; gap:6px; font-size:12px; color:#6366f1; text-decoration:none; margin-bottom:20px; font-weight:600; cursor:pointer;" onmouseover="this.style.gap='10px'" onmouseout="this.style.gap='6px'">
                    <i class="fa-solid fa-arrow-left"></i> Back to all requests
                </a>

                @if(session('success'))
                    <div style="background:#dcfce7; color:#15803d; padding:12px 16px; border-radius:12px; font-size:12px; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Ticket Details -->
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

                    <div style="display:flex; gap:16px; margin-bottom:16px;">
                        <div style="font-size:12px; color:#64748b;"><i class="fa-solid fa-user" style="color:#6366f1; margin-right:5px;"></i> {{ $ticket->user->name }} ({{ $ticket->user->email }})</div>
                        <div style="font-size:12px; color:#64748b;"><i class="fa-regular fa-clock" style="color:#6366f1; margin-right:5px;"></i> {{ $ticket->created_at->format('M d, Y H:i') }}</div>
                    </div>

                    <div style="background:#f8fafc; border-radius:12px; padding:16px; font-size:13px; color:#334155; line-height:1.7; margin-bottom:20px; white-space: pre-wrap; word-wrap: break-word;">{{ $ticket->description }}</div>

                    <!-- Update Status -->
                    <form method="POST" action="{{ route('admin.tickets.status', $ticket->id) }}" style="display:flex; align-items:center; gap:10px;">
                        @csrf
                        @method('PATCH')
                        <select name="status" style="flex:1; padding:9px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:12px; outline:none; color:#0f172a; cursor:pointer;" onfocus="this.style.borderColor='#6366f1'" onblur="this.style.borderColor='#e2e8f0'">
                            <option value="open" {{ $ticket->status==='open'?'selected':'' }}>Open</option>
                            <option value="in_progress" {{ $ticket->status==='in_progress'?'selected':'' }}>In Progress</option>
                            <option value="resolved" {{ $ticket->status==='resolved'?'selected':'' }}>Resolved</option>
                        </select>
                        <button type="submit" style="padding:9px 20px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border:none; border-radius:10px; font-size:12px; font-weight:600; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px; transition:all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(99,102,241,0.3)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                            <i class="fa-solid fa-floppy-disk"></i> Update Status
                        </button>
                    </form>
                </div>

                <!-- Conversation Thread -->
                <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-comments" style="color:#6366f1;"></i> Conversation ({{ $ticket->messages->count() }} messages)
                </div>

                @php 
                    $allMessages = $ticket->messages->sortBy('created_at');
                @endphp

                @if($allMessages->count() === 0)
                    <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:24px; text-align:center;">
                        <i class="fa-solid fa-robot" style="color:#94a3b8; font-size:24px; margin-bottom:10px; display:block;"></i>
                        <div style="font-size:13px; color:#64748b;">No messages yet. AI response is being generated...</div>
                    </div>
                @else
                    <!-- Chat Thread -->
                    <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:20px; margin-bottom:16px;">
                        @foreach($allMessages as $message)
                            @if($message->sender_type === 'customer')
                                <!-- Customer Message (Right side - WHITE) -->
                                <div style="display:flex; justify-content:flex-end; margin-bottom:16px; animation:fadeUp 0.4s ease both;">
                                    <div style="max-width:80%; background:#fff; color:#0f172a; border:1px solid #e2e8f0; border-radius:14px; padding:14px 16px;">
                                        <div style="font-size:12px; font-weight:600; margin-bottom:4px;">{{ $ticket->user->name }}</div>
                                        <div style="font-size:13px; line-height:1.5; margin-bottom:6px; white-space: pre-wrap; word-wrap: break-word;">{{ $message->content }}</div>
                                        <div style="font-size:10px; color:#94a3b8;">{{ $message->created_at->format('H:i') }}</div>
                                    </div>
                                </div>
                            @else
                                <!-- NovaSupport Team Message (Left side - BLUE) -->
                                <div style="display:flex; justify-content:flex-start; margin-bottom:16px; animation:fadeUp 0.4s ease both;">
                                    <div style="max-width:80%;">
                                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                            <div style="width:24px; height:24px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); border-radius:6px; display:flex; align-items:center; justify-content:center;">
                                            <i class="fa-solid fa-user" style="color:#7c3aed; font-size:11px;"></i>
                                            </div>
                                            <span style="font-size:11px; font-weight:600; color:#7c3aed;">NovaSupport Team</span>
                                            <span style="font-size:10px; color:#94a3b8;">{{ $message->created_at->format('H:i') }}</span>
                                            @if($message->is_ai_generated)
                                                @if($message->approved)
                                                    <span style="font-size:9px; font-weight:600; padding:2px 8px; border-radius:99px; background:#dcfce7; color:#15803d; display:inline-flex; align-items:center; gap:3px;">
                                                        <i class="fa-solid fa-circle-check" style="font-size:7px;"></i> Sent
                                                    </span>
                                                @else
                                                    <span style="font-size:9px; font-weight:600; padding:2px 8px; border-radius:99px; background:#ede9fe; color:#5b21b6; display:inline-flex; align-items:center; gap:3px;">
                                                        <i class="fa-solid fa-clock" style="font-size:7px;"></i> Pending
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                        <div style="background:linear-gradient(135deg,#3b82f6,#2563eb); color:#fff; border-radius:12px; padding:12px 14px; font-size:13px; line-height:1.6; margin-bottom:10px; white-space: pre-wrap; word-wrap: break-word;">{{ $message->content }}</div>
                                        
                                        @if($message->is_ai_generated && !$message->approved)
                                            <div style="display:flex; gap:8px;">
                                                <form method="POST" action="{{ route('admin.messages.approve', $message->id) }}" style="flex:1;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" style="width:100%; padding:9px; border-radius:99px; background:linear-gradient(135deg,#059669,#047857); color:#fff; border:none; cursor:pointer; font-size:12px; font-weight:600; display:flex; align-items:center; justify-content:center; gap:6px; transition:all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(5,150,105,0.3)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                                                        <i class="fa-solid fa-circle-check"></i> Approve & Send
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.messages.reject', $message->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="padding:9px 18px; border-radius:99px; background:#fff; color:#dc2626; border:1.5px solid #fecaca; cursor:pointer; font-size:12px; font-weight:600; display:flex; align-items:center; gap:6px; transition:all 0.3s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fff'">
                                                        <i class="fa-solid fa-trash"></i> Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

    
            {{-- Customer Rating --}}
            @if($ticket->rating)
                <div style="background:rgba(255,255,255,0.92);border:1px solid #fde68a;border-radius:16px;padding:20px;margin-bottom:16px;animation:fadeUp 0.4s ease both;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:32px;height:32px;border-radius:10px;background:linear-gradient(135deg,#fef3c7,#fde68a);display:flex;align-items:center;justify-content:center;">
                                <i class="fa-solid fa-star" style="color:#d97706;font-size:13px;"></i>
                            </div>
                            <div>
                                <div style="font-size:12px;font-weight:700;color:#0f172a;">Customer Rating</div>
                                <div style="font-size:10px;color:#94a3b8;">{{ $ticket->rating->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:4px;background:#fef3c7;padding:6px 12px;border-radius:99px;">
                            @for($i=1;$i<=5;$i++)
                                <i class="fa-solid fa-star" style="font-size:13px;color:{{ $i <= $ticket->rating->stars ? '#f59e0b' : '#e2e8f0' }};"></i>
                            @endfor
                            <span style="font-size:12px;font-weight:700;color:#d97706;margin-left:6px;">{{ $ticket->rating->stars }}/5</span>
                        </div>
                    </div>
                    @if($ticket->rating->comment)
                        <div style="background:#fefce8;border:1px solid #fde68a;border-radius:10px;padding:12px 14px;">
                            <div style="font-size:10px;font-weight:600;color:#d97706;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;"><i class="fa-solid fa-quote-left" style="margin-right:4px;"></i> Customer Comment</div>
                            <div style="font-size:12px;color:#334155;line-height:1.6;font-style:italic;">"{{ $ticket->rating->comment }}"</div>
                        </div>
                    @else
                        <div style="font-size:11px;color:#94a3b8;font-style:italic;">No comment left.</div>
                    @endif
                </div>
            @endif

            <!-- Admin Reply Form (only if not resolved) -->
                @if($ticket->status !== 'resolved')
                    <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:20px;">
                        <div style="font-size:12px; font-weight:600; color:#0f172a; margin-bottom:14px;">
                            <i class="fa-solid fa-reply" style="color:#6366f1; margin-right:6px;"></i> Send Message to Customer
                        </div>
                        <form id="adminReplyForm" style="display:flex; flex-direction:column; gap:12px;">
                            @csrf
                            <textarea 
                                id="adminReplyContent"
                                name="content" 
                                placeholder="Type your message to the customer..." 
                                style="width:100%; padding:12px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; outline:none; resize:vertical; min-height:100px; font-family:'Figtree', sans-serif; color:#0f172a;"
                                onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                                onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''"
                            ></textarea>
                            
                            <button 
                                type="submit" 
                                id="adminReplyBtn"
                                style="padding:11px 20px; background:linear-gradient(135deg,#059669,#047857); color:#fff; border:none; border-radius:10px; font-size:12px; font-weight:600; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.3s;"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(5,150,105,0.3)'"
                                onmouseout="this.style.transform=''; this.style.boxShadow=''"
                            >
                                <i class="fa-solid fa-paper-plane"></i> Send to Customer
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <script>
            // Handle admin reply form submission
            document.getElementById('adminReplyForm')?.addEventListener('submit', async function(e) {
                e.preventDefault();

                const content = document.getElementById('adminReplyContent').value.trim();
                const btn = document.getElementById('adminReplyBtn');

                if (!content) {
                    alert('Please type a message');
                    return;
                }

                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    const response = await fetch('{{ route("admin.tickets.reply", $ticket->id) }}', {
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
                        document.getElementById('adminReplyContent').value = '';
                        showToast('Message sent to customer!');
                        
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        alert('Error: ' + (data.message || 'Could not send message'));
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send to Customer';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error sending message');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send to Customer';
                }
            });

            function showToast(message) {
                const toast = document.createElement('div');
                toast.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: #10b981;
                    color: white;
                    padding: 14px 20px;
                    border-radius: 10px;
                    font-size: 13px;
                    font-weight: 600;
                    z-index: 9999;
                    animation: slideIn 0.3s ease;
                    box-shadow: 0 4px 12px rgba(16,185,129,0.3);
                `;
                toast.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${message}`;
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
        </script>

        <style>
            @keyframes slideIn {
                from { transform: translateX(400px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(400px); opacity: 0; }
            }
        </style>
    </x-app-layout>
@endif