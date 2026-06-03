<style>
@keyframes orbitDot  { 0%{transform:rotate(0deg) translateX(18px);} 100%{transform:rotate(360deg) translateX(18px);} }
@keyframes gradientMove { 0%{background-position:0% 50%;} 50%{background-position:100% 50%;} 100%{background-position:0% 50%;} }
@keyframes ringPulse { 0%{transform:scale(1);opacity:0.6;} 100%{transform:scale(2.2);opacity:0;} }
@keyframes shine { 0%{left:-100%;} 100%{left:200%;} }
@keyframes floatCard { 0%,100%{transform:translateY(0px);} 50%{transform:translateY(-6px);} }
@keyframes twinkle2 { 0%,100%{opacity:0.2;transform:scale(0.5);} 50%{opacity:1;transform:scale(1.2);} }

.contact-card {
    background:rgba(255,255,255,0.92);
    border:1px solid #eef0f8;
    border-radius:24px;
    padding:28px;
    box-shadow:0 4px 24px rgba(99,102,241,0.06);
    transition:all 0.35s cubic-bezier(0.34,1.56,0.64,1);
    position:relative; overflow:hidden;
}
.contact-card:hover {
    transform:translateY(-6px);
    box-shadow:0 20px 48px rgba(99,102,241,0.13);
    border-color:#c7d2fe;
}
.contact-card:hover::before { animation:shine 0.6s ease; }
.contact-card::before {
    content:''; position:absolute; top:0; left:-100%;
    width:50%; height:100%;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,0.4),transparent);
    pointer-events:none;
}
.info-icon-wrap {
    width:48px; height:48px; border-radius:14px;
    display:flex; align-items:center; justify-content:center;
    margin-bottom:14px; position:relative;
}
.ring {
    position:absolute; inset:-4px; border-radius:18px;
    border:2px solid; opacity:0;
}
.contact-card:hover .ring { animation:ringPulse 1s ease-out forwards; }
.form-input {
    width:100%; padding:12px 16px;
    border:1.5px solid #e2e8f0; border-radius:12px;
    font-size:13px; color:#0f172a; outline:none;
    font-family:'Figtree',sans-serif;
    transition:all 0.3s; box-sizing:border-box;
    background:rgba(255,255,255,0.9);
}
.form-input:focus {
    border-color:#6366f1;
    box-shadow:0 0 0 4px rgba(99,102,241,0.1);
    background:#fff;
}
</style>

<div style="max-width:1000px;margin:0 auto;padding:30px 24px;">

    {{-- HERO --}}
    <div style="text-align:center;margin-bottom:48px;animation:fadeUp 0.4s ease both;">
        <div style="position:relative;display:inline-block;margin-bottom:20px;">
            <div style="width:72px;height:72px;border-radius:20px;background:linear-gradient(135deg,#6366f1,#8b5cf6,#ec4899);background-size:200% 200%;animation:gradientMove 3s ease infinite;display:flex;align-items:center;justify-content:center;box-shadow:0 12px 32px rgba(99,102,241,0.35);margin:0 auto;">
                <i class="fa-solid fa-headset" style="color:#fff;font-size:28px;"></i>
            </div>
            <div style="position:absolute;top:50%;left:50%;width:8px;height:8px;background:#f472b6;border-radius:50%;animation:orbitDot 2s linear infinite;box-shadow:0 0 6px rgba(244,114,182,0.8);margin:-4px 0 0 -4px;"></div>
        </div>
        <div style="font-size:36px;font-weight:800;color:#0f172a;line-height:1.2;margin-bottom:12px;">
            Get in <span style="background:linear-gradient(135deg,#6366f1,#8b5cf6,#ec4899);background-size:200% auto;-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:gradientMove 3s ease infinite;">Touch</span>
        </div>
        <div style="font-size:14px;color:#64748b;max-width:480px;margin:0 auto;line-height:1.7;">
            We're here 24/7 — our AI support responds in seconds, and our team follows up personally.
        </div>
    </div>

    {{-- INFO CARDS --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px;">

        <div class="contact-card" style="animation:fadeUp 0.4s 0.1s ease both;">
            <div style="position:absolute;top:-20px;right:-20px;width:80px;height:80px;background:rgba(99,102,241,0.08);border-radius:50%;filter:blur(20px);"></div>
            <div class="info-icon-wrap" style="background:linear-gradient(135deg,#ede9fe,#ddd6fe);">
                <i class="fa-solid fa-envelope" style="color:#6366f1;font-size:20px;"></i>
                <div class="ring" style="border-color:#6366f1;"></div>
            </div>
            <div style="font-size:12px;font-weight:700;color:#0f172a;margin-bottom:6px;">Email Us</div>
            <div style="font-size:13px;color:#6366f1;font-weight:600;margin-bottom:8px;">support@novasupport.io</div>
            <div style="font-size:11px;color:#94a3b8;line-height:1.5;">We reply to every email within 24 hours</div>
        </div>

        <div class="contact-card" style="animation:floatCard 4s ease-in-out infinite,fadeUp 0.4s 0.2s ease both;">
            <div style="position:absolute;top:-20px;right:-20px;width:80px;height:80px;background:rgba(236,72,153,0.08);border-radius:50%;filter:blur(20px);"></div>
            <div class="info-icon-wrap" style="background:linear-gradient(135deg,#fce7f3,#fbcfe8);">
                <i class="fa-solid fa-comments" style="color:#db2777;font-size:20px;"></i>
                <div class="ring" style="border-color:#db2777;"></div>
            </div>
            <div style="font-size:12px;font-weight:700;color:#0f172a;margin-bottom:6px;">Live Chat</div>
            <div style="display:flex;align-items:center;gap:6px;margin-bottom:8px;">
                <div style="width:8px;height:8px;background:#4ade80;border-radius:50%;animation:ringPulse 1.5s ease-out infinite;box-shadow:0 0 6px rgba(74,222,128,0.6);"></div>
                <span style="font-size:12px;color:#059669;font-weight:600;">Available 24/7</span>
            </div>
            <div style="font-size:11px;color:#94a3b8;line-height:1.5;margin-bottom:12px;">AI responds in seconds, team follows up personally</div>
            @auth
            <a href="{{ route('tickets.create') }}" class="btn-nova ajax-nav-link" data-url="{{ route('tickets.create') }}" style="display:inline-flex;font-size:11px;padding:7px 16px;">
                <span><i class="fa-solid fa-bolt"></i> Start Chat</span>
            </a>
            @else
            <a href="{{ route('login') }}" class="btn-nova" style="display:inline-flex;font-size:11px;padding:7px 16px;">
                <span><i class="fa-solid fa-bolt"></i> Sign in to Chat</span>
            </a>
            @endauth
        </div>

        <div class="contact-card" style="animation:fadeUp 0.4s 0.3s ease both;">
            <div style="position:absolute;top:-20px;right:-20px;width:80px;height:80px;background:rgba(6,182,212,0.08);border-radius:50%;filter:blur(20px);"></div>
            <div class="info-icon-wrap" style="background:linear-gradient(135deg,#cffafe,#a5f3fc);">
                <i class="fa-solid fa-location-dot" style="color:#0891b2;font-size:20px;"></i>
                <div class="ring" style="border-color:#0891b2;"></div>
            </div>
            <div style="font-size:12px;font-weight:700;color:#0f172a;margin-bottom:6px;">Our Office</div>
            <div style="font-size:12px;color:#0891b2;font-weight:600;margin-bottom:4px;">123 Tech Avenue</div>
            <div style="font-size:11px;color:#64748b;margin-bottom:4px;">Silicon Valley, CA 94025</div>
            <div style="font-size:11px;color:#94a3b8;display:flex;align-items:center;gap:5px;">
                <i class="fa-solid fa-clock" style="font-size:9px;"></i> Open 24/7
            </div>
        </div>
    </div>

    {{-- CONTACT FORM --}}
    <div style="animation:fadeUp 0.4s 0.35s ease both;">
        <div style="background:rgba(255,255,255,0.95);border:1px solid #eef0f8;border-radius:28px;padding:36px;box-shadow:0 8px 40px rgba(99,102,241,0.08);position:relative;overflow:hidden;">
            <div style="position:absolute;top:-60px;right:-60px;width:200px;height:200px;background:linear-gradient(135deg,rgba(99,102,241,0.08),rgba(236,72,153,0.06));border-radius:50%;filter:blur(40px);"></div>
            <div style="position:absolute;bottom:-40px;left:-40px;width:160px;height:160px;background:linear-gradient(135deg,rgba(6,182,212,0.07),rgba(139,92,246,0.05));border-radius:50%;filter:blur(30px);"></div>

            <div style="position:relative;z-index:2;">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:28px;">
                    <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-paper-plane" style="color:#fff;font-size:16px;"></i>
                    </div>
                    <div>
                        <div style="font-size:18px;font-weight:800;color:#0f172a;">Send us a Message</div>
                        <div style="font-size:12px;color:#94a3b8;">Your message creates a support ticket — AI replies instantly</div>
                    </div>
                </div>

                <div id="contactFormWrap" style="display:grid;gap:16px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div>
                            <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:7px;text-transform:uppercase;letter-spacing:0.05em;">Your Name</label>
                            <input id="cName" type="text" class="form-input" value="{{ auth()->user()->name ?? '' }}" placeholder="e.g. Alex Johnson">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:7px;text-transform:uppercase;letter-spacing:0.05em;">Email Address</label>
                            <input id="cEmail" type="email" class="form-input" value="{{ auth()->user()->email ?? '' }}" placeholder="you@example.com">
                        </div>
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:7px;text-transform:uppercase;letter-spacing:0.05em;">Subject</label>
                        <input id="cSubject" type="text" class="form-input" placeholder="What can we help you with?">
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:7px;text-transform:uppercase;letter-spacing:0.05em;">Message</label>
                        <textarea id="cMessage" rows="5" class="form-input" style="resize:none;" placeholder="Tell us more about your issue or question..."></textarea>
                    </div>

                    @auth
                    <button id="cSubmitBtn" onclick="submitContact()"
                        style="padding:14px 32px;background:linear-gradient(135deg,#6366f1,#8b5cf6,#ec4899);background-size:200% auto;color:#fff;border:none;border-radius:14px;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px;transition:all 0.3s;font-family:'Figtree',sans-serif;width:100%;"
                        onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 32px rgba(99,102,241,0.4)'"
                        onmouseout="this.style.transform='';this.style.boxShadow=''">
                        <i class="fa-solid fa-paper-plane"></i> Send Message
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="btn-nova" style="display:flex;align-items:center;justify-content:center;gap:8px;padding:14px;border-radius:14px;font-size:14px;text-decoration:none;">
                        <span><i class="fa-solid fa-right-to-bracket"></i> Sign in to Send Message</span>
                    </a>
                    @endauth
                </div>

                {{-- Success --}}
                <div id="cSuccess" style="display:none;text-align:center;padding:40px;">
                    <div style="font-size:48px;margin-bottom:16px;">🎉</div>
                    <div style="font-size:20px;font-weight:800;color:#0f172a;margin-bottom:8px;">Message Sent!</div>
                    <div style="font-size:13px;color:#64748b;margin-bottom:4px;">Your support ticket has been created.</div>
                    <div style="font-size:13px;color:#6366f1;font-weight:600;margin-bottom:20px;">Our AI is already preparing your response!</div>
                    <a href="{{ route('tickets.index') }}" class="btn-nova ajax-nav-link" data-url="{{ route('tickets.index') }}" style="display:inline-flex;">
                        <span><i class="fa-solid fa-list"></i> View My Tickets</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    window.submitContact = async function() {
        var subject = document.getElementById('cSubject').value.trim();
        var message = document.getElementById('cMessage').value.trim();
        var btn = document.getElementById('cSubmitBtn');

        if(!subject){ alert('Please enter a subject.'); return; }
        if(!message){ alert('Please enter a message.'); return; }

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';

        try {
            var formData = new FormData();
            formData.append('title', subject);
            formData.append('description', message);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            var res = await fetch('{{ route("tickets.store") }}', {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: formData
            });

            if(res.ok || res.status === 302) {
                document.getElementById('contactFormWrap').style.display = 'none';
                var s = document.getElementById('cSuccess');
                s.style.display = 'block';
                s.style.animation = 'fadeUp 0.5s ease both';
                if(typeof attachAjaxListeners === 'function') attachAjaxListeners();
            } else {
                var data = await res.json().catch(function(){ return {}; });
                alert(data.message || 'Error sending. Please try again.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send Message';
            }
        } catch(err) {
            alert('Something went wrong. Please try again.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send Message';
        }
    };
})();
</script>