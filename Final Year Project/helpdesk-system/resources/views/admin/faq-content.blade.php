{{-- Header --}}
<div style="background:linear-gradient(135deg,#1e1b4b,#312e81);border-radius:24px;padding:28px 32px;margin-bottom:24px;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-30px;right:-30px;width:160px;height:160px;background:rgba(99,102,241,0.25);border-radius:50%;filter:blur(40px);"></div>
    <div style="position:relative;z-index:2;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <div style="font-size:11px;font-weight:600;color:#a5b4fc;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:8px;"><i class="fa-solid fa-book-open"></i> FAQ Management</div>
            <div style="font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;">Manage Knowledge Base</div>
            <div style="font-size:12px;color:#94a3b8;">Add articles to reduce support tickets — customers will find answers themselves</div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:32px;font-weight:800;color:#fff;">{{ $faqs->count() }}</div>
            <div style="font-size:11px;color:#94a3b8;">Total Articles</div>
        </div>
    </div>
</div>

@if(session('success'))
<div style="background:#dcfce7;color:#15803d;padding:12px 16px;border-radius:12px;font-size:12px;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif

{{-- Stats Row --}}
@php
$catLabels = ['getting-started'=>'Getting Started','authentication'=>'Authentication & Security','billing'=>'Billing & Pricing','advanced-settings'=>'Advanced Settings','technical-issues'=>'Technical Issues','analytics'=>'Analytics & Reports'];
$catIcons  = ['getting-started'=>['icon'=>'fa-rocket','color'=>'#7c3aed','bg'=>'#ede9fe'],'authentication'=>['icon'=>'fa-shield-halved','color'=>'#db2777','bg'=>'#fce7f3'],'billing'=>['icon'=>'fa-credit-card','color'=>'#ca8a04','bg'=>'#fef9c3'],'advanced-settings'=>['icon'=>'fa-gear','color'=>'#0891b2','bg'=>'#e0f2fe'],'technical-issues'=>['icon'=>'fa-screwdriver-wrench','color'=>'#16a34a','bg'=>'#dcfce7'],'analytics'=>['icon'=>'fa-chart-line','color'=>'#0891b2','bg'=>'#ecfeff']];
$grouped = $faqs->groupBy('category');
@endphp

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px;">
    @foreach($catLabels as $slug => $label)
    @php $meta = $catIcons[$slug]; $count = $grouped->get($slug, collect())->count(); @endphp
    <div style="background:rgba(255,255,255,0.92);border:1px solid #eef0f8;border-radius:16px;padding:14px 16px;display:flex;align-items:center;gap:12px;box-shadow:0 2px 8px rgba(0,0,0,0.03);">
        <div style="width:36px;height:36px;border-radius:10px;background:{{ $meta['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid {{ $meta['icon'] }}" style="color:{{ $meta['color'] }};font-size:14px;"></i>
        </div>
        <div>
            <div style="font-size:18px;font-weight:800;color:#0f172a;">{{ $count }}</div>
            <div style="font-size:10px;color:#94a3b8;font-weight:500;">{{ $label }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- Add New Article --}}
<div style="background:rgba(255,255,255,0.92);border:1px solid #eef0f8;border-radius:20px;padding:24px;margin-bottom:24px;box-shadow:0 4px 20px rgba(99,102,241,0.06);">
    <div style="font-size:14px;font-weight:700;color:#0f172a;margin-bottom:18px;display:flex;align-items:center;gap:8px;">
        <div style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#ede9fe,#ddd6fe);display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid fa-plus" style="color:#6366f1;font-size:12px;"></i>
        </div>
        Add New Article
        <span style="font-size:11px;color:#94a3b8;font-weight:400;margin-left:4px;">— reduce tickets by answering common questions</span>
    </div>
    <form method="POST" action="{{ route('admin.faq.store') }}" style="display:grid;gap:14px;">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
            <div>
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Category</label>
                <select name="category" required style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;color:#0f172a;outline:none;font-family:'Figtree',sans-serif;background:#fff;cursor:pointer;"
                    onfocus="this.style.borderColor='#6366f1'" onblur="this.style.borderColor='#e2e8f0'">
                    <option value="">Select category...</option>
                    <option value="getting-started">Getting Started</option>
                    <option value="authentication">Authentication & Security</option>
                    <option value="billing">Billing & Pricing</option>
                    <option value="advanced-settings">Advanced Settings</option>
                    <option value="technical-issues">Technical Issues</option>
                    <option value="analytics">Analytics & Reports</option>
                </select>
            </div>
            <div>
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Question</label>
                <input name="question" required placeholder="e.g. How do I reset my password?" maxlength="300"
                    style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;color:#0f172a;outline:none;font-family:'Figtree',sans-serif;box-sizing:border-box;"
                    onfocus="this.style.borderColor='#6366f1'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
        </div>
        <div>
            <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Answer</label>
            <textarea name="answer" required placeholder="Write a clear, helpful answer for customers..." rows="3" maxlength="2000"
                style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;color:#0f172a;outline:none;resize:vertical;font-family:'Figtree',sans-serif;box-sizing:border-box;"
                onfocus="this.style.borderColor='#6366f1'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
            <button type="submit" style="padding:10px 24px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border:none;border-radius:10px;font-size:12px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:7px;transition:all 0.3s;"
                onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px rgba(99,102,241,0.3)'"
                onmouseout="this.style.transform='';this.style.boxShadow=''">
                <i class="fa-solid fa-plus"></i> Publish Article
            </button>
            <span style="font-size:11px;color:#94a3b8;">This article will be visible to all customers immediately</span>
        </div>
    </form>
</div>

{{-- Articles List --}}
<div style="background:rgba(255,255,255,0.92);border:1px solid #eef0f8;border-radius:20px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,0.03);">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div style="font-size:14px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;">
            <i class="fa-solid fa-list" style="color:#6366f1;"></i> All Articles
        </div>
        <a href="{{ url('/faq') }}" target="_blank" style="font-size:11px;color:#6366f1;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:5px;background:#ede9fe;padding:6px 12px;border-radius:99px;">
            <i class="fa-solid fa-eye" style="font-size:10px;"></i> Preview as Customer
        </a>
    </div>

    @if($faqs->isEmpty())
    <div style="text-align:center;padding:40px;">
        <i class="fa-solid fa-book-open" style="color:#94a3b8;font-size:28px;display:block;margin-bottom:12px;"></i>
        <div style="font-size:14px;font-weight:700;color:#0f172a;">No articles yet</div>
        <div style="font-size:12px;color:#64748b;margin-top:4px;">Add your first article above to help customers find answers</div>
    </div>
    @else
    @foreach($grouped as $cat => $items)
    <div style="margin-bottom:20px;">
        @php $meta = $catIcons[$cat] ?? ['icon'=>'fa-file','color'=>'#6366f1','bg'=>'#ede9fe']; @endphp
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;padding-bottom:8px;border-bottom:2px solid #f1f5f9;">
            <div style="width:24px;height:24px;border-radius:6px;background:{{ $meta['bg'] }};display:flex;align-items:center;justify-content:center;">
                <i class="fa-solid {{ $meta['icon'] }}" style="color:{{ $meta['color'] }};font-size:10px;"></i>
            </div>
            <span style="font-size:12px;font-weight:700;color:#0f172a;">{{ $catLabels[$cat] ?? $cat }}</span>
            <span style="font-size:10px;background:#ede9fe;color:#6366f1;padding:2px 8px;border-radius:99px;font-weight:600;">{{ $items->count() }}</span>
        </div>
        @foreach($items as $faq)
        <div style="display:flex;align-items:flex-start;gap:14px;padding:12px 0;border-bottom:1px solid #f8fafc;{{ $loop->last?'border-bottom:none;':'' }}">
            <div style="flex:1;">
                <div style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">{{ $faq->question }}</div>
                <div style="font-size:11px;color:#64748b;line-height:1.5;">{{ Str::limit($faq->answer, 120) }}</div>
            </div>
            <form method="POST" action="{{ route('admin.faq.destroy', $faq->id) }}" onsubmit="return confirm('Delete this article? Customers will no longer see it.')">
                @csrf @method('DELETE')
                <button type="submit" style="padding:6px 12px;background:#fee2e2;color:#ef4444;border:none;border-radius:8px;font-size:11px;font-weight:600;cursor:pointer;transition:all 0.2s;white-space:nowrap;display:flex;align-items:center;gap:5px;"
                    onmouseover="this.style.background='#ef4444';this.style.color='#fff'"
                    onmouseout="this.style.background='#fee2e2';this.style.color='#ef4444'">
                    <i class="fa-solid fa-trash" style="font-size:10px;"></i> Delete
                </button>
            </form>
        </div>
        @endforeach
    </div>
    @endforeach
    @endif
</div>