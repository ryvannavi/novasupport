@if(request()->has('ajax'))
    <div style="padding:30px; animation:fadeUp 0.6s ease both;">
        <div style="max-width:900px; margin:0 auto;">

            <!-- Header -->
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
                <div>
                    <div style="font-size:22px; font-weight:800; color:#0f172a; margin-bottom:4px;">My Support Requests</div>
                    <div style="font-size:12px; color:#64748b;">Track and manage all your support requests</div>
                </div>
                <a href="{{ route('tickets.create') }}" class="btn-nova ajax-nav-link" data-url="{{ route('tickets.create') }}">
                    <span><i class="fa-solid fa-plus"></i> New Request</span>
                </a>
            </div>

            @if(session('success'))
                <div style="background:#dcfce7; color:#15803d; padding:12px 16px; border-radius:12px; font-size:12px; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Tickets List -->
            @if($tickets->count() === 0)
                <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:20px; padding:60px; text-align:center;">
                    <div style="width:60px; height:60px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                        <i class="fa-solid fa-ticket" style="color:#7c3aed; font-size:24px;"></i>
                    </div>
                    <div style="font-size:16px; font-weight:700; color:#0f172a; margin-bottom:6px;">No requests yet</div>
                    <div style="font-size:12px; color:#64748b; margin-bottom:20px;">Submit your first support request and get instant AI-powered help.</div>
                    <a href="{{ route('tickets.create') }}" class="btn-nova ajax-nav-link" data-url="{{ route('tickets.create') }}">
                        <span><i class="fa-solid fa-plus"></i> Submit Request</span>
                    </a>
                </div>
            @else
                <div style="display:flex; flex-direction:column; gap:10px;">
                    @foreach($tickets as $i => $ticket)
                    <a href="{{ route('tickets.show', $ticket->id) }}" class="ajax-link" data-url="{{ route('tickets.show', $ticket->id) }}" style="text-decoration:none; background:rgba(255,255,255,0.92); border:1px solid #eef0f8; border-radius:16px; padding:18px 20px; display:flex; align-items:center; gap:16px; transition:all 0.35s cubic-bezier(0.34,1.56,0.64,1); box-shadow:0 2px 8px rgba(0,0,0,0.03); position:relative; overflow:hidden; animation:fadeUp 0.5s {{ $i * 0.08 + 0.2 }}s ease both;"
                        onmouseover="this.style.transform='translateX(6px) translateY(-2px)'; this.style.boxShadow='0 12px 32px rgba(99,102,241,0.12)'; this.style.borderColor='#c7d2fe';"
                        onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.03)'; this.style.borderColor='#eef0f8';">
                        <div style="width:44px; height:44px; border-radius:12px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="fa-solid fa-headset" style="color:#7c3aed; font-size:18px;"></i>
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:3px;">#SR-00{{ $ticket->id }} — {{ $ticket->title }}</div>
                            <div style="font-size:11px; color:#64748b;">{{ $ticket->created_at->diffForHumans() }}</div>
                        </div>
                        @php
                            $statusStyles = [
                                'open' => 'background:#ede9fe; color:#5b21b6;',
                                'in_progress' => 'background:#fef3c7; color:#92400e;',
                                'resolved' => 'background:#d1fae5; color:#065f46;',
                            ];
                            $statusIcons = [
                                'open' => 'fa-circle-dot',
                                'in_progress' => 'fa-spinner',
                                'resolved' => 'fa-circle-check',
                            ];
                        @endphp
                        <span style="font-size:10px; font-weight:600; padding:4px 12px; border-radius:99px; {{ $statusStyles[$ticket->status] ?? '' }} display:inline-flex; align-items:center; gap:4px;">
                            <i class="fa-solid {{ $statusIcons[$ticket->status] ?? 'fa-circle' }}" style="font-size:8px;"></i>
                            {{ ucfirst(str_replace('_',' ',$ticket->status)) }}
                        </span>
                        <i class="fa-solid fa-chevron-right" style="color:#94a3b8; font-size:11px;"></i>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@else
    <x-app-layout>
        <div style="padding:30px; animation:fadeUp 0.6s ease both;">
            <div style="max-width:900px; margin:0 auto;">

                <!-- Header -->
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
                    <div>
                        <div style="font-size:22px; font-weight:800; color:#0f172a; margin-bottom:4px;">My Support Requests</div>
                        <div style="font-size:12px; color:#64748b;">Track and manage all your support requests</div>
                    </div>
                    <a href="{{ route('tickets.create') }}" class="btn-nova ajax-nav-link" data-url="{{ route('tickets.create') }}">
                        <span><i class="fa-solid fa-plus"></i> New Request</span>
                    </a>
                </div>

                @if(session('success'))
                    <div style="background:#dcfce7; color:#15803d; padding:12px 16px; border-radius:12px; font-size:12px; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Tickets List -->
                @if($tickets->count() === 0)
                    <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:20px; padding:60px; text-align:center;">
                        <div style="width:60px; height:60px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                            <i class="fa-solid fa-ticket" style="color:#7c3aed; font-size:24px;"></i>
                        </div>
                        <div style="font-size:16px; font-weight:700; color:#0f172a; margin-bottom:6px;">No requests yet</div>
                        <div style="font-size:12px; color:#64748b; margin-bottom:20px;">Submit your first support request and get instant AI-powered help.</div>
                        <a href="{{ route('tickets.create') }}" class="btn-nova ajax-nav-link" data-url="{{ route('tickets.create') }}">
                            <span><i class="fa-solid fa-plus"></i> Submit Request</span>
                        </a>
                    </div>
                @else
                    <div style="display:flex; flex-direction:column; gap:10px;">
                        @foreach($tickets as $i => $ticket)
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="ajax-link" data-url="{{ route('tickets.show', $ticket->id) }}" style="text-decoration:none; background:rgba(255,255,255,0.92); border:1px solid #eef0f8; border-radius:16px; padding:18px 20px; display:flex; align-items:center; gap:16px; transition:all 0.35s cubic-bezier(0.34,1.56,0.64,1); box-shadow:0 2px 8px rgba(0,0,0,0.03); position:relative; overflow:hidden; animation:fadeUp 0.5s {{ $i * 0.08 + 0.2 }}s ease both;"
                            onmouseover="this.style.transform='translateX(6px) translateY(-2px)'; this.style.boxShadow='0 12px 32px rgba(99,102,241,0.12)'; this.style.borderColor='#c7d2fe';"
                            onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.03)'; this.style.borderColor='#eef0f8';">
                            <div style="width:44px; height:44px; border-radius:12px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fa-solid fa-headset" style="color:#7c3aed; font-size:18px;"></i>
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:3px;">#SR-00{{ $ticket->id }} — {{ $ticket->title }}</div>
                                <div style="font-size:11px; color:#64748b;">{{ $ticket->created_at->diffForHumans() }}</div>
                            </div>
                            @php
                                $statusStyles = [
                                    'open' => 'background:#ede9fe; color:#5b21b6;',
                                    'in_progress' => 'background:#fef3c7; color:#92400e;',
                                    'resolved' => 'background:#d1fae5; color:#065f46;',
                                ];
                                $statusIcons = [
                                    'open' => 'fa-circle-dot',
                                    'in_progress' => 'fa-spinner',
                                    'resolved' => 'fa-circle-check',
                                ];
                            @endphp
                            <span style="font-size:10px; font-weight:600; padding:4px 12px; border-radius:99px; {{ $statusStyles[$ticket->status] ?? '' }} display:inline-flex; align-items:center; gap:4px;">
                                <i class="fa-solid {{ $statusIcons[$ticket->status] ?? 'fa-circle' }}" style="font-size:8px;"></i>
                                {{ ucfirst(str_replace('_',' ',$ticket->status)) }}
                            </span>
                            <i class="fa-solid fa-chevron-right" style="color:#94a3b8; font-size:11px;"></i>
                        </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </x-app-layout>
@endif