<style>
@keyframes shimmerSweep { 0%{left:-100%;} 100%{left:200%;} }
@keyframes dotPulse { 0%,100%{transform:scale(1);opacity:1;} 50%{transform:scale(1.4);opacity:0.7;} }
@keyframes badgePop { 0%{transform:scale(1);} 40%{transform:scale(1.4);} 70%{transform:scale(0.9);} 100%{transform:scale(1);} }
@keyframes cardFlipOut { 0%{transform:rotateY(0) scale(1);opacity:1;} 100%{transform:rotateY(90deg) scale(0.8);opacity:0;} }
@keyframes cardFlipIn { 0%{transform:rotateY(-90deg) scale(0.8);opacity:0;} 100%{transform:rotateY(0) scale(1);opacity:1;} }
@keyframes glowPulse { 0%,100%{box-shadow:0 0 0 0 rgba(99,102,241,0);} 50%{box-shadow:0 0 20px 4px rgba(99,102,241,0.25);} }
@keyframes rippleOut { 0%{transform:scale(0);opacity:0.5;} 100%{transform:scale(3);opacity:0;} }
@keyframes borderSlide { 0%{height:0;opacity:0;} 100%{height:100%;opacity:1;} }
@keyframes colorMorph { 0%{background-position:0% 50%;} 100%{background-position:100% 50%;} }
@keyframes slideInLeft { from{transform:translateX(-12px);opacity:0;} to{transform:translateX(0);opacity:1;} }

.sidebar-item {
    display:flex; align-items:center; justify-content:space-between;
    padding:9px 10px; border-radius:10px; cursor:pointer;
    transition:all 0.3s cubic-bezier(0.34,1.56,0.64,1);
    position:relative; overflow:hidden; user-select:none;
}
.sidebar-item::before {
    content:''; position:absolute; left:-100%; top:0; width:60%;
    height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.5),transparent);
    transition:none; pointer-events:none;
}
.sidebar-item:hover { transform:translateX(4px); background:linear-gradient(135deg,#f5f3ff,#eef2ff); }
.sidebar-item.active {
    background:linear-gradient(135deg,#ede9fe,#e0e7ff) !important;
    transform:translateX(5px);
    box-shadow:0 4px 16px rgba(99,102,241,0.15);
}
.sidebar-item.active::after {
    content:''; position:absolute; left:0; top:0; width:3px;
    background:linear-gradient(180deg,#6366f1,#8b5cf6);
    border-radius:0 3px 3px 0;
    animation:borderSlide 0.3s ease both;
    height:100%;
}
.active-dot {
    width:7px; height:7px; border-radius:50%;
    background:#6366f1; display:none;
    animation:dotPulse 1.5s ease-in-out infinite;
    box-shadow:0 0 6px rgba(99,102,241,0.5);
}
.sidebar-item.active .active-dot { display:block; }
.sidebar-item.active .chevron-icon { display:none; }

.cat-count {
    font-size:9px; font-weight:700; padding:2px 6px;
    border-radius:99px; background:#ede9fe; color:#6366f1;
    transition:all 0.3s;
}
.sidebar-item.active .cat-count {
    background:#6366f1; color:#fff;
    animation:badgePop 0.4s ease;
}

.cat-card-wrap {
    perspective:1000px;
    transition:all 0.35s cubic-bezier(0.34,1.56,0.64,1);
}
.cat-card-wrap.hidden {
    animation:cardFlipOut 0.25s ease forwards;
    pointer-events:none;
}
.cat-card-wrap.visible {
    animation:cardFlipIn 0.35s ease forwards;
}
.cat-card-wrap.active-glow .cat-card-inner {
    animation:glowPulse 2s ease-in-out infinite;
    border-color:#c7d2fe !important;
}
.cat-card-inner {
    background:rgba(255,255,255,0.92); border:1px solid #eef0f8;
    border-radius:16px; padding:18px 20px;
    display:flex; align-items:flex-start; gap:14px;
    transition:all 0.35s cubic-bezier(0.34,1.56,0.64,1);
    box-shadow:0 2px 8px rgba(0,0,0,0.03);
    text-decoration:none; color:inherit;
    position:relative; overflow:hidden;
}
.cat-card-inner:hover {
    transform:translateX(6px) translateY(-2px);
    box-shadow:0 12px 32px rgba(99,102,241,0.12);
    border-color:#c7d2fe;
}
.cat-card-inner:hover .cat-arrow { transform:translateX(5px); }
.cat-arrow { transition:transform 0.3s ease; }
.cat-card-inner.dimmed { opacity:0.35; filter:grayscale(0.5); }
</style>

{{-- HERO --}}
<div style="padding:22px 0 14px;display:flex;align-items:flex-start;justify-content:space-between;gap:20px;animation:fadeUp 0.7s 0.15s ease both;">
    <div style="font-size:30px;font-weight:800;color:#0f172a;line-height:1.15;letter-spacing:-0.02em;">
        Find the <span style="background:linear-gradient(135deg,#6366f1,#8b5cf6,#ec4899);background-size:200% auto;-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:gradientShift 4s ease infinite;">help</span> you<br>need for any problem
    </div>
    <div style="display:flex;align-items:center;background:rgba(255,255,255,0.92);border:1.5px solid #e2e8f0;border-radius:99px;padding:8px 12px 8px 18px;min-width:280px;box-shadow:0 4px 16px rgba(0,0,0,0.06);transition:all 0.3s;"
        onfocus-within="this.style.borderColor='#6366f1'">
        <input type="text" id="heroSearch" placeholder="Search for answers..." style="flex:1;border:none;background:transparent;font-size:12px;outline:none;color:#0f172a;"
            onfocus="this.parentElement.style.borderColor='#6366f1'"
            onblur="this.parentElement.style.borderColor='#e2e8f0'"/>
        <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;font-size:13px;"></i>
    </div>
</div>

{{-- MAIN LAYOUT --}}
<div style="display:grid;grid-template-columns:240px 1fr;gap:16px;padding:0 0 30px;">

    {{-- SIDEBAR --}}
    <div style="display:flex;flex-direction:column;gap:10px;animation:fadeUp 0.7s 0.3s ease both;">

        {{-- Sidebar search --}}
        <div style="background:rgba(255,255,255,0.9);border:1px solid #e8eaf0;border-radius:12px;padding:9px 13px;display:flex;align-items:center;gap:8px;box-shadow:0 2px 8px rgba(0,0,0,0.04);transition:all 0.3s;"
            onfocusin="this.style.borderColor='#6366f1'" onfocusout="this.style.borderColor='#e8eaf0'">
            <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;font-size:11px;"></i>
            <input id="sidebarSearch" type="text" placeholder="Search for answers..." style="flex:1;border:none;background:transparent;font-size:11px;outline:none;color:#0f172a;font-family:'Figtree',sans-serif;"/>
        </div>

        {{-- Category list --}}
        <div id="sidebarList" style="background:rgba(255,255,255,0.9);border:1px solid #e8eaf0;border-radius:14px;padding:6px;box-shadow:0 2px 10px rgba(0,0,0,0.04);">

            @php
            $allSideItems = [
                ['icon'=>'fa-rocket','color'=>'#7c3aed','bg'=>'#ede9fe','label'=>'Getting Started','slug'=>'getting-started','count'=>4],
                ['icon'=>'fa-shield-halved','color'=>'#db2777','bg'=>'#fce7f3','label'=>'Authentication','slug'=>'authentication','count'=>3],
                ['icon'=>'fa-credit-card','color'=>'#ca8a04','bg'=>'#fef9c3','label'=>'Billing & Pricing','slug'=>'billing','count'=>3],
                ['icon'=>'fa-gear','color'=>'#0891b2','bg'=>'#e0f2fe','label'=>'Advanced Settings','slug'=>'advanced-settings','count'=>3],
                ['icon'=>'fa-screwdriver-wrench','color'=>'#16a34a','bg'=>'#dcfce7','label'=>'Technical Issues','slug'=>'technical-issues','count'=>4],
                ['icon'=>'fa-chart-line','color'=>'#15803d','bg'=>'#f0fdf4','label'=>'Analytics','slug'=>'analytics','count'=>3],
            ];
            @endphp

            <div class="sidebar-item active" id="side-all" data-slug="all" onclick="filterCategory('all', this, event)">
                <div style="display:flex;align-items:center;gap:9px;">
                    <div style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#ede9fe,#ddd6fe);display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-layer-group" style="color:#6366f1;font-size:11px;"></i>
                    </div>
                    <span style="font-size:11px;font-weight:600;color:#4f46e5;">All Categories</span>
                </div>
                <div style="display:flex;align-items:center;gap:6px;">
                    <span class="cat-count">6</span>
                    <div class="active-dot"></div>
                    <i class="fa-solid fa-chevron-right chevron-icon" style="font-size:9px;color:#6366f1;"></i>
                </div>
            </div>

            @foreach($allSideItems as $i => $item)
            <div class="sidebar-item" id="side-{{ $item['slug'] }}" data-slug="{{ $item['slug'] }}"
                onclick="filterCategory('{{ $item['slug'] }}', this, event)"
                style="animation:slideInLeft 0.4s {{ $i * 0.05 + 0.1 }}s ease both;">
                <div style="display:flex;align-items:center;gap:9px;">
                    <div style="width:28px;height:28px;border-radius:8px;background:{{ $item['bg'] }};display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid {{ $item['icon'] }}" style="color:{{ $item['color'] }};font-size:12px;"></i>
                    </div>
                    <span style="font-size:11px;font-weight:500;color:#334155;">{{ $item['label'] }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:6px;">
                    <span class="cat-count">{{ $item['count'] }}</span>
                    <div class="active-dot"></div>
                    <i class="fa-solid fa-chevron-right chevron-icon" style="font-size:9px;color:#94a3b8;"></i>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Need more help box --}}
        <div style="background:rgba(255,255,255,0.9);border:1px solid #e8eaf0;border-radius:14px;padding:16px;box-shadow:0 2px 10px rgba(0,0,0,0.04);">
            <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#ede9fe,#ddd6fe);display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                <i class="fa-regular fa-envelope" style="color:#6366f1;font-size:15px;"></i>
            </div>
            <div style="font-size:13px;font-weight:700;color:#0f172a;margin-bottom:5px;">Need more help?</div>
            <div style="font-size:10px;color:#64748b;line-height:1.5;margin-bottom:12px;">Can't find what you're looking for? Submit a request and our team replies instantly.</div>
            @auth
            <a href="{{ route('tickets.create') }}" class="btn-nova ajax-nav-link" data-url="{{ route('tickets.create') }}" style="width:100%;justify-content:center;">
                <span><i class="fa-regular fa-envelope"></i> Submit Request</span>
            </a>
            @else
            <a href="{{ route('login') }}" class="btn-nova" style="width:100%;justify-content:center;">
                <span><i class="fa-regular fa-envelope"></i> Get Started</span>
            </a>
            @endauth
        </div>
    </div>

    {{-- RIGHT CARDS --}}
    <div id="catGrid" style="display:flex;flex-direction:column;gap:10px;">
        @foreach($categories as $i => $cat)
        <div class="cat-card-wrap visible" data-slug="{{ $cat['slug'] }}"
            style="animation:fadeUp 0.5s {{ $i * 0.08 + 0.3 }}s ease both;">
            <a href="{{ route('faq.category', $cat['slug']) }}" class="cat-card-inner ajax-nav-link" data-url="{{ route('faq.category', $cat['slug']) }}">
                <div style="width:44px;height:44px;border-radius:12px;background:{{ $cat['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,0.07);transition:transform 0.3s;">
                    <i class="fa-solid {{ $cat['icon'] }}" style="font-size:18px;color:{{ $cat['color'] }};"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:700;color:#0f172a;margin-bottom:5px;display:flex;align-items:center;gap:8px;">
                        {{ $cat['title'] }}
                        @if($cat['badge'])
                        <span style="font-size:9px;font-weight:700;padding:2px 8px;border-radius:99px;{{ $cat['badgeStyle'] }}">{{ $cat['badge'] }}</span>
                        @endif
                    </div>
                    <div style="font-size:11px;color:#64748b;line-height:1.6;margin-bottom:8px;">{{ $cat['desc'] }}</div>
                    <span style="font-size:11px;font-weight:600;color:#6366f1;display:inline-flex;align-items:center;gap:5px;">
                        Browse docs <i class="fa-solid fa-arrow-right cat-arrow" style="font-size:10px;"></i>
                    </span>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<script>
(function(){
    var activeSlug = 'all';

    window.filterCategory = function(slug, el, event) {
        if(slug === activeSlug) return;
        activeSlug = slug;

        // Ripple effect on clicked sidebar item
        var ripple = document.createElement('div');
        var rect = el.getBoundingClientRect();
        ripple.style.cssText = 'position:absolute;width:60px;height:60px;border-radius:50%;background:rgba(99,102,241,0.2);transform:scale(0);left:'+(event.clientX-rect.left-30)+'px;top:'+(event.clientY-rect.top-30)+'px;animation:rippleOut 0.6s ease;pointer-events:none;z-index:5;';
        el.appendChild(ripple);
        setTimeout(function(){ ripple.remove(); }, 600);

        // Shimmer sweep on active item
        setTimeout(function(){
            if(el.classList.contains('active')){
                el.style.setProperty('--shimmer','running');
                el.querySelector('::before');
                var sh = document.createElement('div');
                sh.style.cssText = 'position:absolute;top:0;left:-100%;width:60%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.6),transparent);pointer-events:none;animation:shimmerSweep 0.6s ease forwards;z-index:4;border-radius:10px;';
                el.appendChild(sh);
                setTimeout(function(){ sh.remove(); }, 700);
            }
        }, 50);

        // Update sidebar active states
        document.querySelectorAll('.sidebar-item').forEach(function(item){
            item.classList.remove('active');
        });
        el.classList.add('active');

        // Badge pop on count
        var badge = el.querySelector('.cat-count');
        if(badge){ badge.style.animation='none'; setTimeout(function(){ badge.style.animation='badgePop 0.4s ease'; },10); }

        // Filter cards with stagger
        var cards = document.querySelectorAll('.cat-card-wrap');
        var delay = 0;
        cards.forEach(function(card){
            var cardSlug = card.getAttribute('data-slug');
            var show = (slug === 'all' || cardSlug === slug);
            var inner = card.querySelector('.cat-card-inner');

            if(!show){
                card.style.animationDelay = delay+'ms';
                card.classList.remove('visible','active-glow');
                card.classList.add('hidden');
                setTimeout(function(c){ c.style.display='none'; }, 250+delay, card);
            } else {
                card.style.display='';
                setTimeout(function(c, d){
                    c.classList.remove('hidden');
                    c.classList.add('visible');
                    if(slug !== 'all') c.classList.add('active-glow');
                    else c.classList.remove('active-glow');
                }, delay, card, delay);
            }
            delay += 40;
        });
    };

    // Sidebar search filter
    var sideSearch = document.getElementById('sidebarSearch');
    var heroSearch = document.getElementById('heroSearch');

    function filterSearch(q){
        q = q.toLowerCase().trim();
        var cards = document.querySelectorAll('.cat-card-wrap');
        cards.forEach(function(card){
            if(!q){ card.style.display=''; card.querySelector('.cat-card-inner').classList.remove('dimmed'); return; }
            var title = card.querySelector('.cat-card-inner').textContent.toLowerCase();
            if(title.includes(q)){
                card.style.display='';
                card.querySelector('.cat-card-inner').classList.remove('dimmed');
            } else {
                card.querySelector('.cat-card-inner').classList.add('dimmed');
            }
        });
    }

    if(sideSearch) sideSearch.addEventListener('input', function(){ filterSearch(this.value); });
    if(heroSearch) heroSearch.addEventListener('input', function(){ filterSearch(this.value); });
})();
</script>