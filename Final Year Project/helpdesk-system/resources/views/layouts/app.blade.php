<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NovaSupport') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Figtree', sans-serif; background: #fff; overflow-x: hidden; min-height: 100vh; }
        .nova-bg { position:fixed; inset:0; background:linear-gradient(135deg,#fff,#f5f3ff,#eef2ff,#fce7f3,#ecfeff,#fff); background-size:400% 400%; animation:gradientShift 14s ease infinite; z-index:0; }
        .blob { position:fixed; border-radius:50%; filter:blur(65px); z-index:1; pointer-events:none; }
        .blob1 { width:280px; height:280px; background:rgba(139,92,246,0.2); top:-70px; left:-50px; animation:blobDrift1 10s ease-in-out infinite; }
        .blob2 { width:230px; height:230px; background:rgba(236,72,153,0.14); top:60px; right:-60px; animation:blobDrift2 13s ease-in-out infinite; }
        .blob3 { width:190px; height:190px; background:rgba(6,182,212,0.11); bottom:30px; left:33%; animation:blobDrift3 11s ease-in-out infinite; }
        .nova-stars { position:fixed; inset:0; z-index:2; pointer-events:none; }
        .nova-star { position:absolute; border-radius:50%; animation:twinkle var(--d) ease-in-out infinite var(--dl); }
        .nova-content { position:relative; z-index:10; opacity:1; transition:opacity 0.3s ease; }
        .nova-content.loading { opacity:0.5; pointer-events:none; }
        .nova-nav-pill { background:rgba(255,255,255,0.88); backdrop-filter:blur(16px); border-radius:99px; border:1px solid rgba(220,220,255,0.7); padding:10px 20px; display:flex; align-items:center; justify-content:space-between; box-shadow:0 4px 20px rgba(99,102,241,0.08); transition:box-shadow 0.3s; }
        .nova-nav-pill:hover { box-shadow:0 8px 30px rgba(99,102,241,0.12); }
        .nova-logo { font-size:15px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:6px; text-decoration:none; cursor:pointer; }
        .nova-logo span { color:#6366f1; }
        .nova-logo-sep { color:#e2e8f0; margin:0 8px; }
        .nova-logo-sub { font-size:11px; color:#94a3b8; font-weight:400; }
        .nova-nav-links { display:flex; align-items:center; gap:20px; }
        .nova-nav-link { font-size:12px; color:#475569; cursor:pointer; text-decoration:none; transition:all 0.2s; position:relative; padding:4px 0; background:none; border:none; }
        .nova-nav-link::after { content:''; position:absolute; bottom:-2px; left:0; width:0; height:2px; background:#6366f1; border-radius:99px; transition:width 0.3s; }
        .nova-nav-link:hover { color:#6366f1; }
        .nova-nav-link:hover::after { width:100%; }
        .nova-nav-right { display:flex; align-items:center; gap:10px; }
        .nova-user { font-size:12px; color:#475569; font-weight:500; }
        .btn-nova { font-size:12px; font-weight:600; padding:9px 20px; border-radius:99px; background:#1e1b4b; color:#fff; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:7px; transition:all 0.3s; position:relative; overflow:hidden; text-decoration:none; letter-spacing:0.01em; }
        .btn-nova::before { content:''; position:absolute; inset:0; background:linear-gradient(135deg,#6366f1,#8b5cf6); opacity:0; transition:opacity 0.3s; border-radius:99px; }
        .btn-nova:hover::before { opacity:1; }
        .btn-nova:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(99,102,241,0.35); color:#fff; }
        .btn-nova span { position:relative; z-index:1; display:flex; align-items:center; gap:7px; }
        @keyframes gradientShift { 0%{background-position:0% 50%;} 50%{background-position:100% 50%;} 100%{background-position:0% 50%;} }
        @keyframes blobDrift1 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(20px,15px);} }
        @keyframes blobDrift2 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(-15px,20px);} }
        @keyframes blobDrift3 { 0%,100%{transform:translate(0,0);} 50%{transform:translate(15px,-15px);} }
        @keyframes twinkle { 0%,100%{opacity:0;transform:scale(0.2);} 50%{opacity:0.9;transform:scale(1);} }
        @keyframes navSlideDown { from{opacity:0;transform:translateY(-16px);} to{opacity:1;transform:translateY(0);} }
        @keyframes fadeUp { from{opacity:0;transform:translateY(20px);} to{opacity:1;transform:translateY(0);} }
        @keyframes ripple { 0%{transform:scale(0);opacity:0.5;} 100%{transform:scale(4);opacity:0;} }
        @keyframes pulse { 0%,100%{transform:scale(1);} 50%{transform:scale(1.2);} }
        @keyframes slideIn { from { transform: translateX(400px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(400px); opacity: 0; } }

        /* ============ RESPONSIVE (mobile / tablet) ============ */
        .nova-burger { display:none; width:38px; height:38px; border-radius:99px; border:1px solid #e2e8f0; background:rgba(255,255,255,0.9); color:#334155; font-size:15px; cursor:pointer; align-items:center; justify-content:center; transition:all 0.2s; flex-shrink:0; }
        .nova-burger:hover { border-color:#6366f1; color:#6366f1; }
        .nova-mobile-menu { position:absolute; left:0; right:0; top:calc(100% + 10px); z-index:60; background:#ffffff; border:1px solid rgba(220,220,255,0.8); border-radius:20px; box-shadow:0 16px 48px rgba(30,27,75,0.18); padding:8px; opacity:0; transform:translateY(-12px) scale(0.98); transform-origin:top center; pointer-events:none; visibility:hidden; transition:opacity 0.22s ease, transform 0.28s cubic-bezier(0.34,1.3,0.64,1), visibility 0.28s; will-change:transform, opacity; }
        .nova-mobile-menu.open { opacity:1; transform:translateY(0) scale(1); pointer-events:auto; visibility:visible; }
        .nova-mobile-link { display:flex; align-items:center; gap:10px; padding:13px 16px; font-size:14px; color:#334155; text-decoration:none; border-radius:14px; font-weight:500; background:none; border:none; width:100%; text-align:left; cursor:pointer; font-family:inherit; }
        .nova-mobile-link:active, .nova-mobile-link:hover { background:#f5f3ff; color:#6366f1; }
        .nova-mobile-link i { width:18px; text-align:center; color:#6366f1; font-size:13px; }
        .nova-mobile-cta { display:flex; align-items:center; justify-content:center; gap:8px; margin:8px; padding:13px; border-radius:14px; background:#1e1b4b; color:#fff; font-size:14px; font-weight:600; text-decoration:none; }

        @media (max-width: 920px) {
            .nova-nav-links { display:none; }
            .nova-user { display:none; }
            .nova-burger { display:inline-flex; }
            .nova-logo-sep, .nova-logo-sub { display:none; }
        }
        @media (max-width: 640px) {
            .nova-nav-right .btn-nova { display:none; }        /* CTA moves into mobile menu */
            .nova-nav-right form { display:none !important; }  /* Log out moves into mobile menu */
            .nova-nav-pill { padding:8px 12px; backdrop-filter:none; background:rgba(255,255,255,0.97); }
            .nova-logo { font-size:16px; }
            #notifDropdown { position:fixed !important; top:70px !important; left:12px !important; right:12px !important; width:auto !important; }
            /* Big blurs are expensive on phone GPUs — lighter versions keep the vibe but scroll smooth */
            .blob { filter:blur(38px); opacity:0.8; }
            .blob3 { display:none; }
        }

        /* Stack ALL inline grids on small screens (works with inline styles via !important) */
        @media (max-width: 900px) {
            div[style*="grid-template-columns:repeat(4"], div[style*="grid-template-columns: repeat(4"],
            div[style*="grid-template-columns:repeat(3"], div[style*="grid-template-columns: repeat(3"] {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
        @media (max-width: 640px) {
            div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
            body { -webkit-text-size-adjust: 100%; }
            input, select, textarea { font-size:16px !important; } /* stops iPhone auto-zoom on tap */
            h1, div[style*="font-size:44px"], div[style*="font-size:40px"], div[style*="font-size:38px"] { font-size:30px !important; line-height:1.2 !important; }
            div[style*="font-size:34px"], div[style*="font-size:32px"] { font-size:26px !important; }
        }
    </style>
</head>
<body>
    <div class="nova-bg"></div>
    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
    <div class="blob blob3"></div>
    <div class="nova-stars" id="novaStars"></div>

    {{-- NAVBAR --}}
    <div style="padding:14px 24px; position:relative; z-index:50; animation:navSlideDown 0.6s ease both;">
        <div style="max-width:1200px; margin:0 auto; position:relative;">
            <div class="nova-nav-pill">
                <a href="{{ url('/') }}" class="nova-logo ajax-nav-link" data-url="/">
                    Nova<span>Support</span>
                    <span class="nova-logo-sep">|</span>
                    <span class="nova-logo-sub">Support center</span>
                </a>

                <div class="nova-nav-links">
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.index') }}" class="nova-nav-link ajax-nav-link" data-url="{{ route('admin.index') }}">
                                <i class="fa-solid fa-shield-halved" style="font-size:10px;"></i> Admin Panel
                            </a>
                            <a href="{{ route('admin.analytics') }}" class="nova-nav-link ajax-nav-link" data-url="{{ route('admin.analytics') }}">
                                <i class="fa-solid fa-chart-line" style="font-size:10px;"></i> Analytics
                            </a>
                            <a href="{{ route('admin.faq.index') }}" class="nova-nav-link ajax-nav-link" data-url="{{ route('admin.faq.index') }}">
                                <i class="fa-solid fa-book-open" style="font-size:10px;"></i> Manage FAQ
                            </a>
                        @else
                            <a href="{{ url('/') }}" class="nova-nav-link ajax-nav-link" data-url="/">Home</a>
                            <a href="{{ route('tickets.index') }}" class="nova-nav-link ajax-nav-link" data-url="{{ route('tickets.index') }}">My Requests</a>
                            <a href="{{ route('faq.index') }}" class="nova-nav-link ajax-nav-link" data-url="{{ route('faq.index') }}">FAQ</a>
                            <a href="{{ route('contact') }}" class="nova-nav-link ajax-nav-link" data-url="{{ route('contact') }}">Contact</a>
                        @endif
                    @else
                        <a href="{{ url('/') }}" class="nova-nav-link ajax-nav-link" data-url="/">Home</a>
                        <a href="{{ route('faq.index') }}" class="nova-nav-link ajax-nav-link" data-url="{{ route('faq.index') }}">FAQ</a>
                        <a href="{{ route('contact') }}" class="nova-nav-link ajax-nav-link" data-url="{{ route('contact') }}">Contact</a>
                    @endauth
                </div>

                <div class="nova-nav-right">
                    @auth
                        {{-- NOTIFICATION BELL WITH SMOOTH AJAX --}}
                        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                        <div style="position:relative; cursor:pointer;" id="notificationBell" onclick="toggleNotifications(event)">
                            <div style="width:34px; height:34px; background:rgba(99,102,241,0.08); border-radius:99px; display:flex; align-items:center; justify-content:center; transition:all 0.3s;" onmouseover="this.style.background='rgba(99,102,241,0.15)'" onmouseout="this.style.background='rgba(99,102,241,0.08)'">
                                <i class="fa-solid fa-bell" style="color:#6366f1; font-size:14px;"></i>
                            </div>
                            
                            @if($unreadCount > 0)
                                <div id="notificationBadge" style="position:absolute; top:-4px; right:-4px; width:18px; height:18px; background:#ef4444; border-radius:99px; display:flex; align-items:center; justify-content:center; font-size:9px; font-weight:700; color:#fff; border:2px solid #fff; animation:pulse 2s infinite; transition:all 0.3s ease;">
                                    <span id="badgeCount">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                                </div>
                            @endif

                            {{-- DROPDOWN --}}
                            <div id="notifDropdown" style="display:none; position:absolute; top:44px; right:0; width:320px; background:#fff; border:1px solid #e8eaf0; border-radius:16px; box-shadow:0 12px 40px rgba(0,0,0,0.12); z-index:100; overflow:hidden;">
                                <div style="padding:12px 16px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
                                    <span style="font-size:13px; font-weight:700; color:#0f172a;">
                                        Notifications
                                        @if($unreadCount > 0)
                                            <span id="unreadBadge" style="font-size:10px; font-weight:600; padding:2px 8px; border-radius:99px; background:#ede9fe; color:#6366f1; margin-left:6px;">
                                                <span id="unreadCount">{{ $unreadCount }}</span> new
                                            </span>
                                        @endif
                                    </span>
                                    @if($unreadCount > 0)
                                        <button id="markAllReadBtn" onclick="markAllAsRead(); return false;" style="font-size:11px; color:#6366f1; background:none; border:none; cursor:pointer; font-weight:500; transition:all 0.3s;">Mark all read</button>
                                    @endif
                                </div>
                                <div style="max-height:300px; overflow-y:auto;" id="notificationsList">
                                    @forelse(auth()->user()->notifications->take(10) as $notification)
                                        <div class="notification-item" data-notification-id="{{ $notification->id }}" data-url="{{ $notification->data['url'] ?? '#' }}" style="display:flex; padding:12px 16px; border-bottom:1px solid #f8fafc; text-decoration:none; transition:all 0.3s ease; background:{{ $notification->read_at ? '#fff' : '#f5f3ff' }}; cursor:pointer;">
                                            <div style="display:flex; align-items:flex-start; gap:10px; flex:1;">
                                                <div style="width:32px; height:32px; border-radius:8px; background:{{ $notification->data['type'] === 'new_ticket' ? 'linear-gradient(135deg,#ede9fe,#ddd6fe)' : 'linear-gradient(135deg,#dcfce7,#bbf7d0)' }}; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                                    <i class="fa-solid {{ $notification->data['type'] === 'new_ticket' ? 'fa-headset' : 'fa-comment-dots' }}" style="font-size:13px; color:{{ $notification->data['type'] === 'new_ticket' ? '#7c3aed' : '#16a34a' }};"></i>
                                                </div>
                                                <div style="flex:1;">
                                                    <div style="font-size:11px; color:#0f172a; font-weight:{{ $notification->read_at ? '400' : '600' }}; line-height:1.4; margin-bottom:3px;">{{ $notification->data['message'] }}</div>
                                                    <div style="font-size:10px; color:#94a3b8;">{{ $notification->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                            @if(!$notification->read_at)
                                                <div class="blue-dot" style="width:7px; height:7px; background:#6366f1; border-radius:50%; flex-shrink:0; margin:4px 0 0 8px; transition:all 0.3s ease;"></div>
                                            @endif
                                        </div>
                                    @empty
                                        <div style="padding:24px; text-align:center;">
                                            <i class="fa-solid fa-bell-slash" style="color:#94a3b8; font-size:24px; margin-bottom:8px; display:block;"></i>
                                            <div style="font-size:12px; color:#64748b;">No notifications yet</div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <span class="nova-user">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="nova-nav-link">Log out</button>
                        </form>
                        @if(!auth()->user()->is_admin)
                            <a href="{{ route('tickets.create') }}" class="btn-nova ajax-nav-link" data-url="{{ route('tickets.create') }}">
                                <span><i class="fa-regular fa-envelope"></i> Submit Request</span>
                            </a>
                        @else
                            <span style="font-size:11px; padding:6px 12px; border-radius:99px; background:#ede9fe; color:#6366f1; font-weight:600;">
                                <i class="fa-solid fa-shield-halved"></i> Admin
                            </span>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="nova-nav-link">Sign in</a>
                        <a href="{{ route('register') }}" class="btn-nova ajax-nav-link" data-url="{{ route('register') }}">
                            <span><i class="fa-regular fa-envelope"></i> Get Started</span>
                        </a>
                    @endauth

                    {{-- HAMBURGER (mobile only) --}}
                    <button type="button" class="nova-burger" id="novaBurger" onclick="toggleMobileMenu()" aria-label="Menu">
                        <i class="fa-solid fa-bars" id="burgerIcon"></i>
                    </button>
                </div>
            </div>

            {{-- MOBILE MENU --}}
            <div class="nova-mobile-menu" id="novaMobileMenu">
                @auth
                    <div style="padding:12px 16px 8px; font-size:12px; color:#94a3b8; font-weight:600;">
                        <i class="fa-regular fa-user" style="margin-right:6px;"></i>{{ auth()->user()->name }}
                    </div>
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.index') }}" class="nova-mobile-link"><i class="fa-solid fa-shield-halved"></i> Admin Panel</a>
                        <a href="{{ route('admin.analytics') }}" class="nova-mobile-link"><i class="fa-solid fa-chart-line"></i> Analytics</a>
                        <a href="{{ route('admin.faq.index') }}" class="nova-mobile-link"><i class="fa-solid fa-book-open"></i> Manage FAQ</a>
                    @else
                        <a href="{{ url('/') }}" class="nova-mobile-link"><i class="fa-solid fa-house"></i> Home</a>
                        <a href="{{ route('tickets.index') }}" class="nova-mobile-link"><i class="fa-regular fa-folder-open"></i> My Requests</a>
                        <a href="{{ route('faq.index') }}" class="nova-mobile-link"><i class="fa-regular fa-circle-question"></i> FAQ</a>
                        <a href="{{ route('contact') }}" class="nova-mobile-link"><i class="fa-regular fa-envelope"></i> Contact</a>
                        <a href="{{ route('tickets.create') }}" class="nova-mobile-cta"><i class="fa-regular fa-envelope"></i> Submit Request</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nova-mobile-link"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</button>
                    </form>
                @else
                    <a href="{{ url('/') }}" class="nova-mobile-link"><i class="fa-solid fa-house"></i> Home</a>
                    <a href="{{ route('faq.index') }}" class="nova-mobile-link"><i class="fa-regular fa-circle-question"></i> FAQ</a>
                    <a href="{{ route('contact') }}" class="nova-mobile-link"><i class="fa-regular fa-envelope"></i> Contact</a>
                    <a href="{{ route('login') }}" class="nova-mobile-link"><i class="fa-solid fa-arrow-right-to-bracket"></i> Sign in</a>
                    <a href="{{ route('register') }}" class="nova-mobile-cta"><i class="fa-regular fa-envelope"></i> Get Started</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="nova-content" id="ajaxContent">
        {{ $slot }}
    </div>

    <script>
        const AJAX_CONTENT = document.getElementById('ajaxContent');

        // Mobile hamburger menu
        function toggleMobileMenu() {
            const m = document.getElementById('novaMobileMenu');
            const icon = document.getElementById('burgerIcon');
            m.classList.toggle('open');
            icon.className = m.classList.contains('open') ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
        }
        document.addEventListener('click', function(e) {
            const m = document.getElementById('novaMobileMenu');
            const b = document.getElementById('novaBurger');
            if (m && m.classList.contains('open') && !m.contains(e.target) && !b.contains(e.target)) {
                m.classList.remove('open');
                document.getElementById('burgerIcon').className = 'fa-solid fa-bars';
            }
        });

        // Stars
        const sc = document.getElementById('novaStars');
        const colors = ['#a78bfa','#818cf8','#c4b5fd','#f472b6','#67e8f9','#86efac'];
        for(let i=0;i<45;i++){
            const s=document.createElement('div'); s.className='nova-star';
            const size=Math.random()*2.5+1;
            s.style.cssText=`width:${size}px;height:${size}px;left:${Math.random()*100}%;top:${Math.random()*100}%;background:${colors[Math.floor(Math.random()*colors.length)]};--d:${(Math.random()*3+1.5).toFixed(1)}s;--dl:${(Math.random()*6).toFixed(1)}s;`;
            sc.appendChild(s);
        }

        // Progress bar
        function getBar() {
            let bar = document.getElementById('novaBar');
            if (!bar) {
                bar = document.createElement('div');
                bar.id = 'novaBar';
                bar.style.cssText = 'position:fixed;top:0;left:0;height:3px;width:0;background:linear-gradient(90deg,#6366f1,#8b5cf6,#ec4899);z-index:99999;transition:width 0.2s ease;pointer-events:none;box-shadow:0 0 6px rgba(99,102,241,0.5);';
                document.body.appendChild(bar);
            }
            return bar;
        }
        function barStart() { const b=getBar(); b.style.transition='width 0.2s ease'; b.style.width='40%'; }
        function barDone()  { const b=getBar(); b.style.width='100%'; setTimeout(()=>{ b.style.transition='opacity 0.3s'; b.style.opacity='0'; setTimeout(()=>{ b.style.width='0'; b.style.opacity='1'; },300); },150); }

        // Core AJAX loader
        let _busy = false;
        async function go(url) {
            if (_busy) return;
            _busy = true;
            barStart();
            try {
                const sep = url.includes('?') ? '&' : '?';
                const res = await fetch(url + sep + 'ajax=1', {
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                });
                const html = await res.text();
                if (html && html.trim()) {
                    AJAX_CONTENT.style.opacity = '0';
                    await new Promise(r => setTimeout(r, 60));
                    AJAX_CONTENT.innerHTML = html;
                    window.history.pushState({}, '', url);
                    window.scrollTo(0, 0);
                    // Re-run scripts
                    AJAX_CONTENT.querySelectorAll('script').forEach(old => {
                        const s = document.createElement('script');
                        s.textContent = old.textContent;
                        document.body.appendChild(s);
                        document.body.removeChild(s);
                    });
                    initListeners();
                    requestAnimationFrame(() => { AJAX_CONTENT.style.opacity = '1'; });
                }
                barDone();
            } catch(e) {
                barDone();
                AJAX_CONTENT.style.opacity = '1';
            } finally {
                _busy = false;
            }
        }

        // Single global click handler — catches everything
        document.addEventListener('click', function(e) {
            const link = e.target.closest('[data-url]');
            if (!link) return;
            const url = link.getAttribute('data-url');
            if (!url || url === '#') return;
            // Allow logout form submit
            if (link.tagName === 'BUTTON' && link.type === 'submit') return;
            e.preventDefault();
            _busy = false;
            go(url);
        });

        // Notification click handler
        function initNotifListeners() {
            document.querySelectorAll('.notification-item').forEach(item => {
                const clone = item.cloneNode(true);
                item.parentNode.replaceChild(clone, item);
                clone.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const nid = this.getAttribute('data-notification-id');
                    const url = this.getAttribute('data-url');
                    // Visual feedback
                    const dot = this.querySelector('.blue-dot');
                    if (dot) { dot.style.opacity='0'; dot.style.transform='scale(0)'; }
                    this.style.background = '#fff';
                    // Close dropdown
                    const dd = document.getElementById('notifDropdown');
                    if (dd) dd.style.display = 'none';
                    // Mark read silently
                    fetch('/notifications/'+nid+'/read', {
                        method:'POST',
                        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}
                    }).then(()=>updateBadge()).catch(()=>{});
                    // Navigate
                    if (url && url !== '#') { _busy=false; go(url); }
                });
            });
        }

        function initListeners() { initNotifListeners(); }
        initListeners();

        window.addEventListener('popstate', () => { _busy=false; go(window.location.pathname); });

        // Notification bell toggle
        function toggleNotifications(e) {
            e.stopPropagation();
            const dd = document.getElementById('notifDropdown');
            if (dd) dd.style.display = dd.style.display === 'none' ? 'block' : 'none';
        }
        document.addEventListener('click', function(e) {
            const bell = document.getElementById('notificationBell');
            const dd = document.getElementById('notifDropdown');
            if (dd && bell && !bell.contains(e.target)) dd.style.display = 'none';
        });

        function updateBadge() {
            const badge = document.getElementById('notificationBadge');
            const count = document.getElementById('badgeCount');
            const unread = document.getElementById('unreadCount');
            if (!badge || !count) return;
            const n = Math.max(0, parseInt(count.textContent) - 1);
            if (n <= 0) {
                badge.style.opacity = '0'; badge.style.transform = 'scale(0)';
                setTimeout(() => badge.style.display='none', 300);
                const ub = document.getElementById('unreadBadge');
                if (ub) { ub.style.opacity='0'; setTimeout(()=>ub.style.display='none',300); }
            } else {
                count.textContent = n > 9 ? '9+' : n;
                if (unread) unread.textContent = n;
            }
        }

        function markAllAsRead() {
            document.querySelectorAll('.blue-dot').forEach(d=>{ d.style.opacity='0'; d.style.transform='scale(0)'; });
            document.querySelectorAll('.notification-item').forEach(i=>i.style.background='#fff');
            fetch('/notifications/mark-all-read',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}})
            .then(()=>{
                const badge=document.getElementById('notificationBadge');
                if(badge){badge.style.opacity='0';badge.style.transform='scale(0)';setTimeout(()=>badge.style.display='none',300);}
                const ub=document.getElementById('unreadBadge');
                if(ub){ub.style.opacity='0';setTimeout(()=>ub.style.display='none',300);}
                const btn=document.getElementById('markAllReadBtn');
                if(btn){btn.style.opacity='0';setTimeout(()=>btn.style.display='none',300);}
            }).catch(()=>{});
        }

        function showToast(message) {
            const t=document.createElement('div');
            t.style.cssText='position:fixed;top:20px;right:20px;background:#10b981;color:#fff;padding:14px 20px;border-radius:10px;font-size:13px;font-weight:600;z-index:9999;box-shadow:0 4px 12px rgba(16,185,129,0.3);transform:translateX(400px);transition:transform 0.3s ease;';
            t.innerHTML='<i class="fa-solid fa-circle-check"></i> '+message;
            document.body.appendChild(t);
            requestAnimationFrame(()=>{ t.style.transform='translateX(0)'; });
            setTimeout(()=>{ t.style.transform='translateX(400px)'; setTimeout(()=>t.remove(),300); },3000);
        }

        function attachAjaxListeners() { initListeners(); }
    </script>
    @include('layouts.partials.realtime')
</body>
</html>