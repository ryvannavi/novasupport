@if(request()->has('ajax'))
    <div style="padding:30px; animation:fadeUp 0.6s ease both;">
        <div style="max-width:1000px; margin:0 auto;">

            <!-- Header -->
            <div style="background:linear-gradient(135deg,#1e1b4b,#312e81); border-radius:20px; padding:28px 32px; margin-bottom:24px; position:relative; overflow:hidden;">
                <div style="position:absolute; top:-30px; right:-30px; width:150px; height:150px; background:rgba(99,102,241,0.3); border-radius:50%; filter:blur(40px);"></div>
                <div style="position:relative; z-index:2;">
                    <div style="font-size:11px; font-weight:600; color:#a5b4fc; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">
                        <i class="fa-solid fa-shield-halved"></i> Admin Panel
                    </div>
                    <div style="font-size:22px; font-weight:800; color:#fff; margin-bottom:6px;">All Support Requests</div>
                    <div style="font-size:12px; color:#94a3b8;">Manage and respond to all customer support requests</div>
                </div>
            </div>

            @if(session('success'))
                <div style="background:#dcfce7; color:#15803d; padding:12px 16px; border-radius:12px; font-size:12px; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Stats -->
            <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:24px;">
                @php
                    $total = $tickets->count();
                    $open = $tickets->where('status','open')->count();
                    $inProgress = $tickets->where('status','in_progress')->count();
                    $resolved = $tickets->where('status','resolved')->count();
                @endphp
                <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:16px 20px;">
                    <div style="font-size:24px; font-weight:800; color:#0f172a;">{{ $total }}</div>
                    <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Total Requests</div>
                </div>
                <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:16px 20px;">
                    <div style="font-size:24px; font-weight:800; color:#7c3aed;">{{ $open }}</div>
                    <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Open</div>
                </div>
                <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:16px 20px;">
                    <div style="font-size:24px; font-weight:800; color:#d97706;">{{ $inProgress }}</div>
                    <div style="font-size:11px; color:#94a3b8; margin-top:2px;">In Progress</div>
                </div>
                <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:16px 20px;">
                    <div style="font-size:24px; font-weight:800; color:#059669;">{{ $resolved }}</div>
                    <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Resolved</div>
                </div>
            </div>

            <!-- Tickets List -->
            <div style="display:flex; flex-direction:column; gap:10px;">
                @foreach($tickets as $i => $ticket)
                <a href="{{ route('admin.show', $ticket->id) }}" class="ajax-link" data-url="{{ route('admin.show', $ticket->id) }}" style="text-decoration:none; background:rgba(255,255,255,0.92); border:1px solid #eef0f8; border-radius:16px; padding:16px 20px; display:flex; align-items:center; gap:16px; transition:all 0.35s cubic-bezier(0.34,1.56,0.64,1); box-shadow:0 2px 8px rgba(0,0,0,0.03); animation:fadeUp 0.5s {{ $i * 0.06 + 0.2 }}s ease both;"
                    onmouseover="this.style.transform='translateX(6px) translateY(-2px)'; this.style.boxShadow='0 12px 32px rgba(99,102,241,0.12)'; this.style.borderColor='#c7d2fe';"
                    onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.03)'; this.style.borderColor='#eef0f8';">
                    <div style="width:44px; height:44px; border-radius:12px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa-solid fa-headset" style="color:#7c3aed; font-size:18px;"></i>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:3px;">#SR-00{{ $ticket->id }} — {{ $ticket->title }}</div>
                        <div style="font-size:11px; color:#64748b;"><i class="fa-solid fa-user" style="margin-right:4px;"></i>{{ $ticket->user->name }} · {{ $ticket->created_at->diffForHumans() }}</div>
                    </div>
                    @php
                        $statusStyles = ['open'=>'background:#ede9fe;color:#5b21b6;','in_progress'=>'background:#fef3c7;color:#92400e;','resolved'=>'background:#d1fae5;color:#065f46;'];
                        $statusIcons = ['open'=>'fa-circle-dot','in_progress'=>'fa-spinner','resolved'=>'fa-circle-check'];
                    @endphp
                    <span style="font-size:10px; font-weight:600; padding:4px 12px; border-radius:99px; {{ $statusStyles[$ticket->status] ?? '' }} display:inline-flex; align-items:center; gap:4px; white-space:nowrap;">
                        <i class="fa-solid {{ $statusIcons[$ticket->status] ?? '' }}" style="font-size:8px;"></i>
                        {{ ucfirst(str_replace('_',' ',$ticket->status)) }}
                    </span>
                    <i class="fa-solid fa-chevron-right" style="color:#94a3b8; font-size:11px;"></i>
                </a>
                @endforeach
            </div>
        </div>
    </div>
@else
    <x-app-layout>
        <div style="padding:30px; animation:fadeUp 0.6s ease both;">
            <div style="max-width:1000px; margin:0 auto;">

                <!-- Header -->
                <div style="background:linear-gradient(135deg,#1e1b4b,#312e81); border-radius:20px; padding:28px 32px; margin-bottom:24px; position:relative; overflow:hidden;">
                    <div style="position:absolute; top:-30px; right:-30px; width:150px; height:150px; background:rgba(99,102,241,0.3); border-radius:50%; filter:blur(40px);"></div>
                    <div style="position:relative; z-index:2;">
                        <div style="font-size:11px; font-weight:600; color:#a5b4fc; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">
                            <i class="fa-solid fa-shield-halved"></i> Admin Panel
                        </div>
                        <div style="font-size:22px; font-weight:800; color:#fff; margin-bottom:6px;">All Support Requests</div>
                        <div style="font-size:12px; color:#94a3b8;">Manage and respond to all customer support requests</div>
                    </div>
                </div>

                @if(session('success'))
                    <div style="background:#dcfce7; color:#15803d; padding:12px 16px; border-radius:12px; font-size:12px; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Stats -->
                <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:24px;">
                    @php
                        $total = $tickets->count();
                        $open = $tickets->where('status','open')->count();
                        $inProgress = $tickets->where('status','in_progress')->count();
                        $resolved = $tickets->where('status','resolved')->count();
                    @endphp
                    <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:16px 20px;">
                        <div style="font-size:24px; font-weight:800; color:#0f172a;">{{ $total }}</div>
                        <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Total Requests</div>
                    </div>
                    <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:16px 20px;">
                        <div style="font-size:24px; font-weight:800; color:#7c3aed;">{{ $open }}</div>
                        <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Open</div>
                    </div>
                    <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:16px 20px;">
                        <div style="font-size:24px; font-weight:800; color:#d97706;">{{ $inProgress }}</div>
                        <div style="font-size:11px; color:#94a3b8; margin-top:2px;">In Progress</div>
                    </div>
                    <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:16px 20px;">
                        <div style="font-size:24px; font-weight:800; color:#059669;">{{ $resolved }}</div>
                        <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Resolved</div>
                    </div>
                </div>

                <!-- Tickets List -->
                <div style="display:flex; flex-direction:column; gap:10px;">
                    @foreach($tickets as $i => $ticket)
                    <a href="{{ route('admin.show', $ticket->id) }}" class="ajax-link" data-url="{{ route('admin.show', $ticket->id) }}" style="text-decoration:none; background:rgba(255,255,255,0.92); border:1px solid #eef0f8; border-radius:16px; padding:16px 20px; display:flex; align-items:center; gap:16px; transition:all 0.35s cubic-bezier(0.34,1.56,0.64,1); box-shadow:0 2px 8px rgba(0,0,0,0.03); animation:fadeUp 0.5s {{ $i * 0.06 + 0.2 }}s ease both;"
                        onmouseover="this.style.transform='translateX(6px) translateY(-2px)'; this.style.boxShadow='0 12px 32px rgba(99,102,241,0.12)'; this.style.borderColor='#c7d2fe';"
                        onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.03)'; this.style.borderColor='#eef0f8';">
                        <div style="width:44px; height:44px; border-radius:12px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="fa-solid fa-headset" style="color:#7c3aed; font-size:18px;"></i>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:3px;">#SR-00{{ $ticket->id }} — {{ $ticket->title }}</div>
                            <div style="font-size:11px; color:#64748b;"><i class="fa-solid fa-user" style="margin-right:4px;"></i>{{ $ticket->user->name }} · {{ $ticket->created_at->diffForHumans() }}</div>
                        </div>
                        @php
                            $statusStyles = ['open'=>'background:#ede9fe;color:#5b21b6;','in_progress'=>'background:#fef3c7;color:#92400e;','resolved'=>'background:#d1fae5;color:#065f46;'];
                            $statusIcons = ['open'=>'fa-circle-dot','in_progress'=>'fa-spinner','resolved'=>'fa-circle-check'];
                        @endphp
                        <span style="font-size:10px; font-weight:600; padding:4px 12px; border-radius:99px; {{ $statusStyles[$ticket->status] ?? '' }} display:inline-flex; align-items:center; gap:4px; white-space:nowrap;">
                            <i class="fa-solid {{ $statusIcons[$ticket->status] ?? '' }}" style="font-size:8px;"></i>
                            {{ ucfirst(str_replace('_',' ',$ticket->status)) }}
                        </span>
                        <i class="fa-solid fa-chevron-right" style="color:#94a3b8; font-size:11px;"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </x-app-layout>
@endif