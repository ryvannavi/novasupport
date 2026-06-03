<style>
.acc-item{background:rgba(255,255,255,0.92);border:1px solid #eef0f8;border-radius:16px;margin-bottom:10px;overflow:hidden;transition:all 0.3s ease;box-shadow:0 2px 8px rgba(0,0,0,0.03);}
.acc-item.open{border-color:#c7d2fe;box-shadow:0 8px 32px rgba(99,102,241,0.1);}
.acc-header{padding:18px 22px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;gap:16px;transition:background 0.2s;}
.acc-header:hover{background:rgba(99,102,241,0.03);}
.acc-title{font-size:14px;font-weight:700;color:#0f172a;flex:1;line-height:1.4;}
.acc-icon{width:28px;height:28px;border-radius:8px;background:#ede9fe;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all 0.3s;}
.acc-item.open .acc-icon{background:linear-gradient(135deg,#6366f1,#8b5cf6);}
.acc-body{max-height:0;overflow:hidden;transition:max-height 0.4s cubic-bezier(0.4,0,0.2,1);}
.acc-body.open{max-height:600px;}
.acc-content{padding:0 22px 20px;border-top:1px solid #f1f5f9;}
.helpful-btn{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:99px;border:1.5px solid #e2e8f0;background:#fff;font-size:11px;font-weight:600;cursor:pointer;transition:all 0.2s;color:#64748b;font-family:'Figtree',sans-serif;}
.helpful-btn:hover{border-color:#6366f1;color:#6366f1;background:#ede9fe;}
.helpful-btn.yes-btn:hover{border-color:#059669;color:#059669;background:#d1fae5;}
.helpful-btn.no-btn:hover{border-color:#ef4444;color:#ef4444;background:#fee2e2;}
.rel-card{background:rgba(255,255,255,0.92);border:1px solid #eef0f8;border-radius:14px;padding:14px 16px;cursor:pointer;transition:all 0.25s;text-decoration:none;display:block;}
.rel-card:hover{border-color:#c7d2fe;transform:translateY(-3px);box-shadow:0 8px 24px rgba(99,102,241,0.1);}
</style>

<div style="max-width:860px;margin:0 auto;padding:30px 24px;">

    <a href="{{ route('faq.index') }}" class="ajax-nav-link" data-url="{{ route('faq.index') }}"
        style="display:inline-flex;align-items:center;gap:7px;font-size:12px;color:#6366f1;text-decoration:none;font-weight:600;margin-bottom:24px;transition:gap 0.2s;"
        onmouseover="this.style.gap='10px'" onmouseout="this.style.gap='7px'">
        <i class="fa-solid fa-arrow-left"></i> Back to Knowledge Base
    </a>

    {{-- Hero --}}
    <div style="background:linear-gradient(135deg,#1e1b4b,#312e81);border-radius:24px;padding:32px 36px;margin-bottom:28px;position:relative;overflow:hidden;animation:fadeUp 0.4s ease both;">
        <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;background:rgba(99,102,241,0.2);border-radius:50%;filter:blur(50px);"></div>
        <div style="position:relative;z-index:2;display:flex;align-items:center;gap:20px;">
            <div style="width:56px;height:56px;border-radius:16px;background:{{ $meta['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fa-solid {{ $meta['icon'] }}" style="color:{{ $meta['color'] }};font-size:22px;"></i>
            </div>
            <div>
                <div style="font-size:11px;font-weight:600;color:#a5b4fc;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:6px;">Knowledge Base</div>
                <div style="font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;">{{ $meta['label'] }}</div>
                <div style="font-size:12px;color:#94a3b8;">{{ $faqs->count() }} article{{ $faqs->count() !== 1 ? 's' : '' }}</div>
            </div>
        </div>
    </div>

    {{-- Category Search --}}
    <div style="background:rgba(255,255,255,0.92);border:1.5px solid #e2e8f0;border-radius:14px;padding:10px 16px;display:flex;align-items:center;gap:10px;margin-bottom:20px;transition:all 0.3s;">
        <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;"></i>
        <input id="catSearchInput" placeholder="Search in {{ $meta['label'] }}..."
            style="flex:1;border:none;background:transparent;font-size:13px;outline:none;color:#0f172a;font-family:'Figtree',sans-serif;"
            onfocus="this.parentElement.style.borderColor='#6366f1';this.parentElement.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
            onblur="this.parentElement.style.borderColor='#e2e8f0';this.parentElement.style.boxShadow=''">
    </div>

    {{-- Accordion --}}
    <div id="accList">
        @forelse($faqs as $i => $faq)
        <div class="acc-item" id="faq-{{ $faq->id }}" style="animation:fadeUp 0.4s {{ $i * 0.06 + 0.1 }}s ease both;" data-question="{{ strtolower($faq->question) }}" data-answer="{{ strtolower($faq->answer) }}">
            <div class="acc-header" onclick="toggleAcc({{ $faq->id }})">
                <div class="acc-title">{{ $faq->question }}</div>
                <div class="acc-icon" id="accIcon-{{ $faq->id }}">
                    <i class="fa-solid fa-plus" style="color:#6366f1;font-size:12px;" id="accIconI-{{ $faq->id }}"></i>
                </div>
            </div>
            <div class="acc-body" id="accBody-{{ $faq->id }}">
                <div class="acc-content">
                    <div style="font-size:13px;color:#334155;line-height:1.8;margin-bottom:16px;padding-top:14px;">{{ $faq->answer }}</div>
                    <div style="display:flex;align-items:center;gap:10px;padding-top:12px;border-top:1px solid #f1f5f9;">
                        <span style="font-size:11px;color:#94a3b8;font-weight:500;">Was this helpful?</span>
                        <button class="helpful-btn yes-btn" onclick="markHelpful({{ $faq->id }}, true, this)"><i class="fa-solid fa-thumbs-up"></i> Yes</button>
                        <button class="helpful-btn no-btn" onclick="markHelpful({{ $faq->id }}, false, this)"><i class="fa-solid fa-thumbs-down"></i> No</button>
                        <span id="helpfulMsg-{{ $faq->id }}" style="font-size:11px;color:#059669;display:none;font-weight:600;align-items:center;gap:5px;"><i class="fa-solid fa-circle-check"></i> Thanks!</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:40px;background:rgba(255,255,255,0.9);border-radius:20px;">
            <i class="fa-solid fa-box-open" style="color:#94a3b8;font-size:28px;display:block;margin-bottom:12px;"></i>
            <div style="font-size:14px;font-weight:700;color:#0f172a;">No articles yet</div>
        </div>
        @endforelse
    </div>

    <div id="catNoResults" style="display:none;text-align:center;padding:40px;background:rgba(255,255,255,0.9);border-radius:20px;border:1px solid #eef0f8;">
        <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;font-size:28px;display:block;margin-bottom:12px;"></i>
        <div style="font-size:14px;font-weight:700;color:#0f172a;">No results found</div>
    </div>

    {{-- Related --}}
    @if($related->count())
    <div style="margin-top:36px;animation:fadeUp 0.4s 0.5s ease both;">
        <div style="font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:14px;">Related Categories</div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
            @foreach($related as $rSlug => $rCat)
            <a href="{{ route('faq.category', $rSlug) }}" class="rel-card ajax-nav-link" data-url="{{ route('faq.category', $rSlug) }}">
                <div style="width:36px;height:36px;border-radius:10px;background:{{ $rCat['bg'] }};display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                    <i class="fa-solid {{ $rCat['icon'] }}" style="color:{{ $rCat['color'] }};font-size:15px;"></i>
                </div>
                <div style="font-size:12px;font-weight:700;color:#0f172a;margin-bottom:4px;">{{ $rCat['label'] }}</div>
                <div style="font-size:11px;color:#6366f1;font-weight:600;">Browse articles →</div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Submit Ticket CTA --}}
    <div style="margin-top:32px;background:linear-gradient(135deg,#1e1b4b,#312e81);border-radius:20px;padding:24px 28px;display:flex;align-items:center;justify-content:space-between;gap:20px;animation:fadeUp 0.4s 0.6s ease both;">
        <div>
            <div style="font-size:15px;font-weight:800;color:#fff;margin-bottom:4px;">Still need help?</div>
            <div style="font-size:12px;color:#94a3b8;">Submit a ticket and our AI support team replies instantly</div>
        </div>
        @auth
            <a href="{{ route('tickets.create') }}" class="btn-nova ajax-nav-link" data-url="{{ route('tickets.create') }}" style="white-space:nowrap;flex-shrink:0;">
                <span><i class="fa-regular fa-envelope"></i> Submit Request</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-nova" style="white-space:nowrap;flex-shrink:0;">
                <span><i class="fa-solid fa-right-to-bracket"></i> Sign in</span>
            </a>
        @endauth
    </div>
</div>

<script>
(function(){
    window.toggleAcc = function(id) {
        var body = document.getElementById('accBody-'+id);
        var item = document.getElementById('faq-'+id);
        var icon = document.getElementById('accIconI-'+id);
        var iconWrap = document.getElementById('accIcon-'+id);
        var isOpen = item.classList.contains('open');
        document.querySelectorAll('.acc-item.open').forEach(function(el){
            el.classList.remove('open');
            el.querySelector('.acc-body').classList.remove('open');
            var ic = el.querySelector('.acc-header i'); if(ic){ ic.className='fa-solid fa-plus'; ic.style.color='#6366f1'; }
        });
        if(!isOpen){ item.classList.add('open'); body.classList.add('open'); icon.className='fa-solid fa-minus'; icon.style.color='#fff'; }
    };

    window.markHelpful = function(id, yes, btn) {
        var msg = document.getElementById('helpfulMsg-'+id);
        btn.parentElement.querySelectorAll('.helpful-btn').forEach(function(b){ b.disabled=true; b.style.opacity='0.5'; });
        if(msg){ msg.style.display='inline-flex'; }
    };

    var catSearch = document.getElementById('catSearchInput');
    var noRes = document.getElementById('catNoResults');
    if(catSearch){
        catSearch.addEventListener('input', function(){
            var q = this.value.toLowerCase().trim();
            var items = document.querySelectorAll('.acc-item');
            var visible = 0;
            items.forEach(function(item){
                var match = !q || (item.getAttribute('data-question')||'').includes(q) || (item.getAttribute('data-answer')||'').includes(q);
                item.style.display = match ? '' : 'none';
                if(match) visible++;
            });
            if(noRes) noRes.style.display = visible===0 ? 'block' : 'none';
        });
    }

    var hash = window.location.hash;
    if(hash && hash.startsWith('#faq-')){
        var id = hash.replace('#faq-','');
        setTimeout(function(){ if(window.toggleAcc) window.toggleAcc(id); }, 300);
    }
})();
</script>