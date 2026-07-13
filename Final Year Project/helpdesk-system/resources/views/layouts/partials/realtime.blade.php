@auth
<script>
(function () {
    // ==========================================================
    // SHARED: audio ping
    // ==========================================================
    let audioCtx = null;

    function initAudio() {
        if (!audioCtx) {
            try { audioCtx = new (window.AudioContext || window.webkitAudioContext)(); } catch (e) {}
        }
        if (audioCtx && audioCtx.state === 'suspended') {
            audioCtx.resume().catch(function () {});
        }
        ['click', 'keydown', 'scroll', 'touchstart'].forEach(function (ev) {
            document.removeEventListener(ev, initAudio);
        });
    }
    ['click', 'keydown', 'scroll', 'touchstart'].forEach(function (ev) {
        document.addEventListener(ev, initAudio);
    });

    function playPing() {
        if (!audioCtx) return;
        try {
            if (audioCtx.state === 'suspended') audioCtx.resume();
            const o = audioCtx.createOscillator();
            const g = audioCtx.createGain();
            o.connect(g); g.connect(audioCtx.destination);
            o.type = 'sine';
            o.frequency.setValueAtTime(880, audioCtx.currentTime);
            o.frequency.exponentialRampToValueAtTime(1320, audioCtx.currentTime + 0.1);
            g.gain.setValueAtTime(0.3, audioCtx.currentTime);
            g.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.5);
            o.start(); o.stop(audioCtx.currentTime + 0.5);
        } catch (e) {}
    }

    const IS_ADMIN = {{ auth()->user()->is_admin ? 'true' : 'false' }};
    const CSRF = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '';

    function esc(s) {
        const d = document.createElement('div');
        d.textContent = s == null ? '' : String(s);
        return d.innerHTML;
    }

    // ==========================================================
    // PART 1: NOTIFICATION POLLING (bell, badge, toast)
    // ==========================================================
    let lastCheck = null;
    let seenIds = new Set();

    function setBadge(count) {
        const bell = document.getElementById('notificationBell');
        if (!bell) return;
        let badge = document.getElementById('notificationBadge');

        if (count <= 0) {
            if (badge) { badge.style.opacity = '0'; setTimeout(() => badge.remove(), 300); }
            return;
        }

        if (!badge) {
            badge = document.createElement('div');
            badge.id = 'notificationBadge';
            badge.style.cssText = 'position:absolute; top:-4px; right:-4px; width:18px; height:18px; background:#ef4444; border-radius:99px; display:flex; align-items:center; justify-content:center; font-size:9px; font-weight:700; color:#fff; border:2px solid #fff; animation:pulse 2s infinite; transition:all 0.3s ease;';
            badge.innerHTML = '<span id="badgeCount"></span>';
            bell.appendChild(badge);
        }
        const c = document.getElementById('badgeCount');
        if (c) c.textContent = count > 9 ? '9+' : count;
        badge.style.display = 'flex';
        badge.style.opacity = '1';
        badge.style.transform = 'scale(1)';
    }

    function liveToast(n) {
        const t = document.createElement('div');
        t.style.cssText = 'position:fixed; top:20px; right:20px; display:flex; align-items:center; gap:12px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; padding:14px 18px; border-radius:14px; font-size:13px; font-weight:600; z-index:9999; box-shadow:0 8px 24px rgba(99,102,241,0.4); transform:translateX(420px); transition:transform 0.35s cubic-bezier(0.34,1.56,0.64,1); cursor:pointer; max-width:340px;';
        t.innerHTML = '<div style="width:34px;height:34px;background:rgba(255,255,255,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fa-solid fa-bell"></i></div><div style="line-height:1.4;">' + esc(n.message) + '<div style="font-size:10px;font-weight:400;opacity:0.8;">Just now — click to view</div></div>';
        t.onclick = function () { if (n.url && n.url !== '#') window.location.href = n.url; };
        document.body.appendChild(t);
        requestAnimationFrame(() => { t.style.transform = 'translateX(0)'; });
        setTimeout(() => { t.style.transform = 'translateX(420px)'; setTimeout(() => t.remove(), 400); }, 5000);
    }

    function prependToDropdown(n) {
        const list = document.getElementById('notificationsList');
        if (!list) return;
        const isTicket = n.type === 'new_ticket';
        const item = document.createElement('div');
        item.className = 'notification-item';
        item.setAttribute('data-notification-id', n.id);
        item.setAttribute('data-url', n.url);
        item.style.cssText = 'display:flex; padding:12px 16px; border-bottom:1px solid #f8fafc; transition:all 0.3s ease; background:#f5f3ff; cursor:pointer;';
        item.innerHTML = '<div style="display:flex; align-items:flex-start; gap:10px; flex:1;"><div style="width:32px; height:32px; border-radius:8px; background:' + (isTicket ? 'linear-gradient(135deg,#ede9fe,#ddd6fe)' : 'linear-gradient(135deg,#dcfce7,#bbf7d0)') + '; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class="fa-solid ' + (isTicket ? 'fa-headset' : 'fa-comment-dots') + '" style="font-size:13px; color:' + (isTicket ? '#7c3aed' : '#16a34a') + ';"></i></div><div style="flex:1;"><div style="font-size:11px; color:#0f172a; font-weight:600; line-height:1.4; margin-bottom:3px;">' + esc(n.message) + '</div><div style="font-size:10px; color:#94a3b8;">' + esc(n.time) + '</div></div></div><div class="blue-dot" style="width:7px; height:7px; background:#6366f1; border-radius:50%; flex-shrink:0; margin:4px 0 0 8px; transition:all 0.3s ease;"></div>';
        list.prepend(item);
        if (typeof initNotifListeners === 'function') initNotifListeners();
    }

    async function poll() {
        if (document.hidden) return;
        try {
            const url = '/notifications/check' + (lastCheck ? '?since=' + encodeURIComponent(lastCheck) : '');
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const data = await res.json();
            lastCheck = data.server_time;
            setBadge(data.unread_count);

            (data.new || []).forEach(function (n) {
                if (seenIds.has(n.id)) return;
                seenIds.add(n.id);
                liveToast(n);
                prependToDropdown(n);
                playPing();
            });
        } catch (e) { /* retry next cycle */ }
    }

    poll();
    setInterval(poll, 8000);
    document.addEventListener('visibilitychange', function () { if (!document.hidden) poll(); });

    // ==========================================================
    // PART 2: LIVE CHAT — messages appear inside the conversation
    // ==========================================================
    let chatTicketId = null;
    let chatSince = null;
    let chatSeen = new Set();

    function currentTicketId() {
        const m = window.location.pathname.match(/^\/(?:admin\/)?tickets\/(\d+)\/?$/);
        return m ? m[1] : null;
    }

    function findThread() {
        const byId = document.getElementById('conversationThread');
        if (byId) return byId;
        const bubbles = document.querySelectorAll('div[style*="fadeUp"]');
        for (let i = bubbles.length - 1; i >= 0; i--) {
            const st = bubbles[i].getAttribute('style') || '';
            if (st.indexOf('justify-content:flex-end') !== -1 || st.indexOf('justify-content:flex-start') !== -1) {
                return bubbles[i].parentElement;
            }
        }
        return null;
    }

    // --- Smooth approve: no popup, no reload ---
    window.rtApprove = async function (id) {
        const actions = document.getElementById('rt-actions-' + id);
        if (actions) actions.style.opacity = '0.5';
        try {
            const res = await fetch('/admin/messages/' + id + '/approve', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: new URLSearchParams({ _method: 'PATCH' })
            });
            if (!res.ok) throw new Error('failed');

            if (actions) {
                actions.style.transition = 'all 0.3s ease';
                actions.style.opacity = '0';
                actions.style.maxHeight = '0';
                setTimeout(() => actions.remove(), 300);
            }
            const badge = document.getElementById('rt-badge-' + id);
            if (badge) {
                badge.style.background = '#dcfce7';
                badge.style.color = '#15803d';
                badge.innerHTML = '<i class="fa-solid fa-circle-check" style="font-size:7px;"></i> Sent';
            }
        } catch (e) {
            if (actions) actions.style.opacity = '1';
        }
    };

    // --- Smooth reject: no popup, bubble fades away ---
    window.rtReject = async function (id) {
        const msg = document.getElementById('rt-msg-' + id);
        if (msg) msg.style.opacity = '0.5';
        try {
            const res = await fetch('/admin/messages/' + id + '/reject', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: new URLSearchParams({ _method: 'DELETE' })
            });
            if (!res.ok) throw new Error('failed');

            if (msg) {
                msg.style.transition = 'all 0.4s ease';
                msg.style.opacity = '0';
                msg.style.transform = 'translateX(-20px)';
                setTimeout(() => msg.remove(), 400);
            }
        } catch (e) {
            if (msg) msg.style.opacity = '1';
        }
    };

    function customerBubble(m) {
        return '<div style="display:flex; justify-content:flex-end; margin-bottom:16px; animation:fadeUp 0.4s ease both;">'
            + '<div style="max-width:80%; background:#fff; color:#0f172a; border:1px solid #e2e8f0; border-radius:14px; padding:14px 16px;">'
            + (IS_ADMIN ? '<div style="font-size:12px; font-weight:600; margin-bottom:4px;">' + esc(m.sender_name) + '</div>' : '')
            + '<div style="font-size:13px; line-height:1.5; margin-bottom:6px; white-space:pre-wrap; word-wrap:break-word;">' + esc(m.content) + '</div>'
            + '<div style="font-size:10px; color:#94a3b8;">' + esc(m.time) + '</div>'
            + '</div></div>';
    }

    function teamBubble(m) {
        let badge = '';
        let actions = '';
        if (IS_ADMIN && m.is_ai) {
            badge = m.approved
                ? '<span id="rt-badge-' + m.id + '" style="font-size:9px; font-weight:600; padding:2px 8px; border-radius:99px; background:#dcfce7; color:#15803d;"><i class="fa-solid fa-circle-check" style="font-size:7px;"></i> Sent</span>'
                : '<span id="rt-badge-' + m.id + '" style="font-size:9px; font-weight:600; padding:2px 8px; border-radius:99px; background:#ede9fe; color:#5b21b6;"><i class="fa-solid fa-clock" style="font-size:7px;"></i> Pending</span>';
            if (!m.approved) {
                actions = '<div id="rt-actions-' + m.id + '" style="display:flex; gap:8px; margin-top:10px; overflow:hidden;">'
                    + '<button onclick="rtApprove(\'' + m.id + '\')" style="flex:1; padding:9px; border-radius:99px; background:linear-gradient(135deg,#059669,#047857); color:#fff; border:none; cursor:pointer; font-size:12px; font-weight:600; transition:all 0.3s;" onmouseover="this.style.transform=\'translateY(-1px)\'" onmouseout="this.style.transform=\'\'"><i class="fa-solid fa-circle-check"></i> Approve & Send</button>'
                    + '<button onclick="rtReject(\'' + m.id + '\')" style="padding:9px 18px; border-radius:99px; background:#fff; color:#dc2626; border:1.5px solid #fecaca; cursor:pointer; font-size:12px; font-weight:600; transition:all 0.3s;" onmouseover="this.style.background=\'#fee2e2\'" onmouseout="this.style.background=\'#fff\'"><i class="fa-solid fa-trash"></i> Reject</button>'
                    + '</div>';
            }
        }
        return '<div id="rt-msg-' + m.id + '" style="display:flex; justify-content:flex-start; margin-bottom:16px; animation:fadeUp 0.4s ease both;">'
            + '<div style="max-width:80%;">'
            + '<div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">'
            + '<div style="width:24px; height:24px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); border-radius:6px; display:flex; align-items:center; justify-content:center;"><i class="fa-solid fa-user" style="color:#7c3aed; font-size:11px;"></i></div>'
            + '<span style="font-size:11px; font-weight:600; color:#7c3aed;">NovaSupport Team</span>'
            + '<span style="font-size:10px; color:#94a3b8;">' + esc(m.time) + '</span>'
            + badge
            + '</div>'
            + '<div style="background:linear-gradient(135deg,#3b82f6,#2563eb); color:#fff; border-radius:12px; padding:12px 14px; font-size:13px; line-height:1.6; white-space:pre-wrap; word-wrap:break-word;">' + esc(m.content) + '</div>'
            + actions
            + '</div></div>';
    }

    function appendMessage(m) {
        const thread = findThread();
        if (!thread) {
            if (typeof go === 'function') { try { _busy = false; } catch (e) {} go(window.location.pathname); }
            else { location.reload(); }
            return;
        }
        const wrap = document.createElement('div');
        wrap.innerHTML = m.sender_type === 'customer' ? customerBubble(m) : teamBubble(m);
        const el = wrap.firstElementChild;
        thread.appendChild(el);
        el.scrollIntoView({ behavior: 'smooth', block: 'end' });
    }

    async function chatPoll() {
        if (document.hidden) return;
        const tid = currentTicketId();
        if (!tid) { chatTicketId = null; return; }

        if (tid !== chatTicketId) {
            chatTicketId = tid;
            chatSince = null;
            chatSeen = new Set();
        }

        try {
            const url = '/tickets/' + tid + '/messages/poll' + (chatSince ? '?since=' + encodeURIComponent(chatSince) : '');
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const data = await res.json();
            chatSince = data.server_time;

            (data.messages || []).forEach(function (m) {
                if (chatSeen.has(m.id)) return;
                chatSeen.add(m.id);
                appendMessage(m);
                playPing();
            });
        } catch (e) { /* retry next cycle */ }
    }

    chatPoll();
    setInterval(chatPoll, 5000);
})();
</script>
@endauth