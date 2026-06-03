<x-app-layout>
    <div style="padding:30px; animation:fadeUp 0.6s ease both;">
        <div style="max-width:900px; margin:0 auto;">

            <!-- Welcome Banner -->
            <div style="background:linear-gradient(135deg,#1e1b4b,#312e81); border-radius:20px; padding:28px 32px; margin-bottom:24px; position:relative; overflow:hidden;">
                <div style="position:absolute; top:-30px; right:-30px; width:150px; height:150px; background:rgba(99,102,241,0.3); border-radius:50%; filter:blur(40px);"></div>
                <div style="position:absolute; bottom:-20px; left:20%; width:100px; height:100px; background:rgba(236,72,153,0.2); border-radius:50%; filter:blur(30px);"></div>
                <div style="position:relative; z-index:2;">
                    <div style="font-size:11px; font-weight:600; color:#a5b4fc; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">
                        <i class="fa-solid fa-bolt"></i> AI-Powered Support
                    </div>
                    <div style="font-size:22px; font-weight:800; color:#fff; margin-bottom:6px;">
                        Welcome back, {{ auth()->user()->name }}! 👋
                    </div>
                    <div style="font-size:12px; color:#94a3b8;">Manage your support requests and get AI-powered help instantly.</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:24px;">
                <a href="{{ route('tickets.create') }}" style="text-decoration:none; background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:20px; text-align:center; transition:all 0.3s; display:block;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 30px rgba(99,102,241,0.12)'; this.style.borderColor='#c7d2fe'" onmouseout="this.style.transform=''; this.style.boxShadow=''; this.style.borderColor='#e8eaf0'">
                    <div style="width:44px; height:44px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 10px;">
                        <i class="fa-solid fa-plus" style="color:#7c3aed; font-size:18px;"></i>
                    </div>
                    <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:3px;">New Request</div>
                    <div style="font-size:11px; color:#94a3b8;">Submit a support request</div>
                </a>
                <a href="{{ route('tickets.index') }}" style="text-decoration:none; background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:20px; text-align:center; transition:all 0.3s; display:block;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 30px rgba(99,102,241,0.12)'; this.style.borderColor='#c7d2fe'" onmouseout="this.style.transform=''; this.style.boxShadow=''; this.style.borderColor='#e8eaf0'">
                    <div style="width:44px; height:44px; background:linear-gradient(135deg,#e0f2fe,#bae6fd); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 10px;">
                        <i class="fa-solid fa-list" style="color:#0891b2; font-size:18px;"></i>
                    </div>
                    <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:3px;">My Requests</div>
                    <div style="font-size:11px; color:#94a3b8;">View all your requests</div>
                </a>
                @if(auth()->user()->is_admin)
                <a href="{{ route('admin.index') }}" style="text-decoration:none; background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:20px; text-align:center; transition:all 0.3s; display:block;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 30px rgba(99,102,241,0.12)'; this.style.borderColor='#c7d2fe'" onmouseout="this.style.transform=''; this.style.boxShadow=''; this.style.borderColor='#e8eaf0'">
                    <div style="width:44px; height:44px; background:linear-gradient(135deg,#dcfce7,#bbf7d0); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 10px;">
                        <i class="fa-solid fa-shield-halved" style="color:#16a34a; font-size:18px;"></i>
                    </div>
                    <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:3px;">Admin Panel</div>
                    <div style="font-size:11px; color:#94a3b8;">Manage all requests</div>
                </a>
                @else
                <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:20px; text-align:center;">
                    <div style="width:44px; height:44px; background:linear-gradient(135deg,#fce7f3,#fbcfe8); border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 10px;">
                        <i class="fa-solid fa-robot" style="color:#db2777; font-size:18px;"></i>
                    </div>
                    <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:3px;">AI Replies</div>
                    <div style="font-size:11px; color:#94a3b8;">Instant AI-powered answers</div>
                </div>
                @endif
            </div>

            <!-- Info Card -->
            <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:16px; padding:20px 24px; display:flex; align-items:center; gap:16px;">
                <div style="width:44px; height:44px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-circle-info" style="color:#7c3aed; font-size:18px;"></i>
                </div>
                <div>
                    <div style="font-size:13px; font-weight:700; color:#0f172a; margin-bottom:3px;">How NovaSupport works</div>
                    <div style="font-size:11px; color:#64748b; line-height:1.6;">Submit a support request → Our AI instantly generates a reply → Our team reviews and approves it → You get the answer! Average response time: under 2 minutes.</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
