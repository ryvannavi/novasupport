<style>
.cat-card{background:rgba(255,255,255,0.92);border:1px solid #eef0f8;border-radius:20px;padding:22px 24px;display:flex;align-items:flex-start;gap:16px;cursor:pointer;transition:all 0.35s cubic-bezier(0.34,1.56,0.64,1);box-shadow:0 2px 8px rgba(0,0,0,0.03);text-decoration:none;position:relative;overflow:hidden;}
.cat-card:hover{transform:translateY(-6px) translateX(4px);box-shadow:0 20px 48px rgba(99,102,241,0.13);border-color:#c7d2fe;}
.cat-card:hover .cat-arrow{transform:translateX(6px);}
.cat-arrow{transition:transform 0.3s ease;}
.faq-search-wrap{background:rgba(255,255,255,0.95);border:2px solid #e2e8f0;border-radius:16px;padding:12px 18px;display:flex;align-items:center;gap:12px;transition:all 0.3s;box-shadow:0 4px 20px rgba(0,0,0,0.06);}
.faq-search-wrap:focus-within{border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,0.1);}
.faq-search-input{flex:1;border:none;background:transparent;font-size:14px;outline:none;color:#0f172a;font-family:'Figtree',sans-serif;}
.search-result-item{background:#fff;border:1px solid #eef0f8;border-radius:14px;padding:16px 20px;margin-bottom:10px;cursor:pointer;transition:all 0.2s;text-decoration:none;display:block;}
.search-result-item:hover{border-color:#c7d2fe;box-shadow:0 8px 24px rgba(99,102,241,0.1);transform:translateY(-2px);}
mark{background:#fef08a;color:#0f172a;border-radius:3px;padding:0 2px;}
</style>

<div style="max-width:1000px;margin:0 auto;padding:30px 24px;">

    {{-- HERO --}}
    <div style="text-align:center;margin-bottom:40px;animation:fadeUp 0.4s ease both;">
        <div style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#ede9fe,#ddd6fe);padding:6px 16px;border-radius:99px;font-size:11px;font-weight:600;color:#6366f1;margin-bottom:16px;">
            <i class="fa-solid fa-book-open"></i> Knowledge Base
        </div>
        <div style="font-size:32px;font-weight:800;color:#0f172a;line-height:1.2;margin-bottom:12px;">
            How can we <span style="background:linear-gradient(135deg,#6366f1,#8b5cf6,#ec4899);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">help</span> you?
        </div>
        <div style="font-size:14px;color:#64748b;margin-bottom:28px;">Browse our knowledge base or search for answers instantly</div>

        <div class="faq-search-wrap" style="max-width:560px;margin:0 auto;">
            <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;font-size:16px;"></i>
            <input class="faq-search-input" id="faqSearchInput" placeholder="Search articles, questions, topics..." autocomplete="off">
            <div id="faqSearchSpinner" style="display:none;"><i class="fa-solid fa-spinner fa-spin" style="color:#6366f1;font-size:14px;"></i></div>
        </div>
    </div>

    <div id="faqSearchResults" style="display:none;margin-bottom:24px;"></div>

    <div id="faqCategoryGrid">
        <div style="font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:16px;">Browse by Category</div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
            @foreach($categories as $slug => $cat)
            <a href="{{ route('faq.category', $slug) }}" class="cat-card ajax-nav-link" data-url="{{ route('faq.category', $slug) }}" style="animation:fadeUp 0.4s {{ $loop->index * 0.06 + 0.1 }}s ease both;">
                <div style="width:48px;height:48px;border-radius:14px;background:{{ $cat['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,0.08);">
                    <i class="fa-solid {{ $cat['icon'] }}" style="color:{{ $cat['color'] }};font-size:20px;"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:700;color:#0f172a;margin-bottom:4px;display:flex;align-items:center;gap:8px;">
                        {{ $cat['label'] }}
                        @if($cat['badge'])
                            <span style="font-size:9px;font-weight:700;padding:2px 8px;border-radius:99px;{{ $cat['badgeStyle'] }}">{{ $cat['badge'] }}</span>
                        @endif
                    </div>
                    <div style="font-size:11px;color:#94a3b8;margin-bottom:8px;">{{ $counts[$slug] ?? 0 }} articles</div>
                    <span style="font-size:11px;font-weight:600;color:#6366f1;display:inline-flex;align-items:center;gap:5px;">
                        Browse articles <i class="fa-solid fa-arrow-right cat-arrow" style="font-size:10px;"></i>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div style="margin-top:40px;background:linear-gradient(135deg,#1e1b4b,#312e81);border-radius:24px;padding:32px;text-align:center;position:relative;overflow:hidden;animation:fadeUp 0.4s 0.5s ease both;">
        <div style="position:absolute;top:-40px;right:-40px;width:180px;height:180px;background:rgba(99,102,241,0.2);border-radius:50%;filter:blur(40px);"></div>
        <div style="position:relative;z-index:2;">
            <div style="font-size:20px;font-weight:800;color:#fff;margin-bottom:8px;">Can't find what you're looking for?</div>
            <div style="font-size:13px;color:#94a3b8;margin-bottom:20px;">Our AI-powered support team is ready to help you instantly</div>
            @auth
                <a href="{{ route('tickets.create') }}" class="btn-nova ajax-nav-link" data-url="{{ route('tickets.create') }}" style="display:inline-flex;">
                    <span><i class="fa-regular fa-envelope"></i> Submit a Support Request</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-nova" style="display:inline-flex;">
                    <span><i class="fa-regular fa-envelope"></i> Sign in to Submit Request</span>
                </a>
            @endauth
        </div>
    </div>
</div>

<script>
(function(){
    var inp = document.getElementById('faqSearchInput');
    var results = document.getElementById('faqSearchResults');
    var grid = document.getElementById('faqCategoryGrid');
    var spinner = document.getElementById('faqSearchSpinner');
    if(!inp) return;
    var timer;
    inp.addEventListener('input', function(){
        clearTimeout(timer);
        var q = this.value.trim();
        if(q.length < 2){ results.style.display='none'; grid.style.display='block'; spinner.style.display='none'; return; }
        spinner.style.display='block';
        timer = setTimeout(function(){ doSearch(q); }, 300);
    });
    function hl(text,q){ return text.replace(new RegExp('('+q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')+')','gi'),'<mark>$1</mark>'); }
    function doSearch(q){
        fetch('{{ route("faq.search") }}?q='+encodeURIComponent(q))
        .then(function(r){return r.json();})
        .then(function(data){
            spinner.style.display='none';
            grid.style.display='none';
            results.style.display='block';
            if(!data.length){
                results.innerHTML='<div style="text-align:center;padding:40px;background:rgba(255,255,255,0.9);border-radius:20px;border:1px solid #eef0f8;"><i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;font-size:28px;display:block;margin-bottom:12px;"></i><div style="font-size:14px;font-weight:700;color:#0f172a;margin-bottom:6px;">No results found</div><div style="font-size:12px;color:#64748b;">Try different keywords</div></div>';
                return;
            }
            var html='<div style="font-size:12px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:12px;">'+data.length+' result'+(data.length!==1?'s':'')+' for "'+q+'"</div>';
            data.forEach(function(faq){
                html+='<a href="/faq/'+faq.category+'" class="search-result-item ajax-nav-link" data-url="/faq/'+faq.category+'">'
                    +'<div style="font-size:13px;font-weight:700;color:#0f172a;margin-bottom:6px;">'+hl(faq.question,q)+'</div>'
                    +'<div style="font-size:11px;color:#64748b;line-height:1.6;">'+hl(faq.answer.substring(0,120),q)+'...</div>'
                    +'<div style="font-size:10px;color:#6366f1;font-weight:600;margin-top:8px;text-transform:capitalize;"><i class="fa-solid fa-folder" style="margin-right:4px;"></i>'+faq.category.replace(/-/g,' ')+'</div>'
                    +'</a>';
            });
            results.innerHTML=html;
            if(typeof attachAjaxListeners==='function') attachAjaxListeners();
        }).catch(function(){ spinner.style.display='none'; });
    }
})();
</script>