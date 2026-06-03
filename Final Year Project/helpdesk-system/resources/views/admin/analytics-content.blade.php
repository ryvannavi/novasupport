<style>
.stat-card{background:rgba(255,255,255,0.92);border:1px solid #eef0f8;border-radius:20px;padding:20px 22px;position:relative;overflow:hidden;transition:all 0.35s cubic-bezier(0.34,1.56,0.64,1);}
.stat-card:hover{transform:translateY(-6px);box-shadow:0 20px 48px rgba(99,102,241,0.13);border-color:#c7d2fe;}
.card-orb{position:absolute;border-radius:50%;filter:blur(28px);pointer-events:none;}
.count-num{font-size:30px;font-weight:800;line-height:1;margin-bottom:4px;}
.count-label{font-size:11px;color:#94a3b8;font-weight:500;text-transform:uppercase;letter-spacing:0.06em;}
.badge-pill{display:inline-flex;align-items:center;gap:5px;font-size:10px;font-weight:600;padding:3px 10px;border-radius:99px;margin-top:8px;}
.chart-card{background:rgba(255,255,255,0.92);border:1px solid #eef0f8;border-radius:20px;padding:24px 28px;margin-top:24px;box-shadow:0 4px 24px rgba(99,102,241,0.06);}
@keyframes aorb1{0%,100%{transform:translate(0,0);}50%{transform:translate(30px,20px);}}
@keyframes aorb2{0%,100%{transform:translate(0,0);}50%{transform:translate(-20px,30px);}}
</style>

<div style="position:fixed;width:320px;height:320px;background:rgba(139,92,246,0.12);top:80px;right:5%;border-radius:50%;filter:blur(70px);pointer-events:none;z-index:3;animation:aorb1 12s ease-in-out infinite;"></div>
<div style="position:fixed;width:240px;height:240px;background:rgba(236,72,153,0.09);bottom:120px;left:3%;border-radius:50%;filter:blur(70px);pointer-events:none;z-index:3;animation:aorb2 15s ease-in-out infinite;"></div>

{{-- HEADER --}}
<div style="background:linear-gradient(135deg,#1e1b4b,#312e81);border-radius:24px;padding:32px 36px;margin-bottom:28px;position:relative;overflow:hidden;animation:fadeUp 0.4s ease both;">
    <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;background:rgba(99,102,241,0.25);border-radius:50%;filter:blur(50px);"></div>
    <div style="position:relative;z-index:2;">
        <div style="font-size:11px;font-weight:600;color:#a5b4fc;text-transform:uppercase;letter-spacing:0.12em;margin-bottom:10px;">
            <i class="fa-solid fa-chart-line"></i> &nbsp;Analytics Dashboard
        </div>
        <div style="font-size:26px;font-weight:800;color:#fff;margin-bottom:6px;">System Performance</div>
        <div style="font-size:12px;color:#94a3b8;">Real-time metrics for your AI-powered helpdesk &middot; Last updated just now</div>
    </div>
    <div style="position:absolute;top:28px;right:36px;display:flex;align-items:center;gap:7px;">
        <div style="width:8px;height:8px;background:#4ade80;border-radius:50%;animation:pulse 2s infinite;box-shadow:0 0 8px rgba(74,222,128,0.6);"></div>
        <span style="font-size:11px;color:#94a3b8;font-weight:500;">Live</span>
    </div>
</div>

{{-- ROW 1 --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;">
    <div class="stat-card" style="animation:fadeUp 0.4s 0.05s ease both;">
        <div class="card-orb" style="width:100px;height:100px;background:rgba(99,102,241,0.18);top:-20px;right:-20px;"></div>
        <div style="width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,#ede9fe,#c7d2fe);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
            <i class="fa-solid fa-ticket" style="color:#6366f1;font-size:16px;"></i>
        </div>
        <div class="count-num" style="color:#0f172a;">{{ $total }}</div>
        <div class="count-label">Total Tickets</div>
        <div class="badge-pill" style="background:#ede9fe;color:#6366f1;"><i class="fa-solid fa-arrow-trend-up" style="font-size:8px;"></i> All time</div>
    </div>
    <div class="stat-card" style="animation:fadeUp 0.4s 0.08s ease both;">
        <div class="card-orb" style="width:100px;height:100px;background:rgba(239,68,68,0.15);top:-20px;right:-20px;"></div>
        <div style="width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,#fee2e2,#fca5a5);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
            <i class="fa-solid fa-circle-exclamation" style="color:#ef4444;font-size:16px;"></i>
        </div>
        <div class="count-num" style="color:#ef4444;">{{ $open }}</div>
        <div class="count-label">Open</div>
        @if($total > 0)<div class="badge-pill" style="background:#fee2e2;color:#ef4444;">{{ round(($open/$total)*100) }}% of total</div>@endif
    </div>
    <div class="stat-card" style="animation:fadeUp 0.4s 0.11s ease both;">
        <div class="card-orb" style="width:100px;height:100px;background:rgba(245,158,11,0.15);top:-20px;right:-20px;"></div>
        <div style="width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,#fef3c7,#fde68a);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
            <i class="fa-solid fa-spinner" style="color:#d97706;font-size:16px;"></i>
        </div>
        <div class="count-num" style="color:#d97706;">{{ $inProgress }}</div>
        <div class="count-label">In Progress</div>
        @if($total > 0)<div class="badge-pill" style="background:#fef3c7;color:#d97706;">{{ round(($inProgress/$total)*100) }}% of total</div>@endif
    </div>
    <div class="stat-card" style="animation:fadeUp 0.4s 0.14s ease both;">
        <div class="card-orb" style="width:100px;height:100px;background:rgba(5,150,105,0.15);top:-20px;right:-20px;"></div>
        <div style="width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,#d1fae5,#a7f3d0);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
            <i class="fa-solid fa-circle-check" style="color:#059669;font-size:16px;"></i>
        </div>
        <div class="count-num" style="color:#059669;">{{ $resolved }}</div>
        <div class="count-label">Resolved</div>
        @if($total > 0)<div class="badge-pill" style="background:#d1fae5;color:#059669;">{{ round(($resolved/$total)*100) }}% of total</div>@endif
    </div>
</div>

{{-- ROW 2 --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-top:14px;">
    <div class="stat-card" style="animation:fadeUp 0.4s 0.17s ease both;">
        <div class="card-orb" style="width:100px;height:100px;background:rgba(6,182,212,0.15);top:-20px;right:-20px;"></div>
        <div style="width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,#cffafe,#a5f3fc);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
            <i class="fa-solid fa-clock" style="color:#0891b2;font-size:16px;"></i>
        </div>
        @if($avgResponseTime !== null)
            <div class="count-num" style="color:#0891b2;">{{ number_format($avgResponseTime,1) }}h</div>
            <div class="count-label">Avg Response Time</div>
            <div class="badge-pill" style="background:#cffafe;color:#0891b2;"><i class="fa-solid fa-bolt" style="font-size:8px;"></i> First reply</div>
        @else
            <div class="count-num" style="color:#0891b2;font-size:20px;">—</div>
            <div class="count-label">Avg Response Time</div>
            <div style="font-size:10px;color:#94a3b8;margin-top:6px;">No replies yet</div>
        @endif
    </div>
    <div class="stat-card" style="animation:fadeUp 0.4s 0.20s ease both;">
        <div class="card-orb" style="width:100px;height:100px;background:rgba(139,92,246,0.15);top:-20px;right:-20px;"></div>
        <div style="width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,#ede9fe,#ddd6fe);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
            <i class="fa-solid fa-comments" style="color:#7c3aed;font-size:16px;"></i>
        </div>
        <div class="count-num" style="color:#7c3aed;">{{ $totalMessages }}</div>
        <div class="count-label">Total Messages</div>
        <div class="badge-pill" style="background:#ede9fe;color:#7c3aed;">Across all tickets</div>
    </div>
    <div class="stat-card" style="animation:fadeUp 0.4s 0.23s ease both;">
        <div class="card-orb" style="width:100px;height:100px;background:rgba(236,72,153,0.12);top:-20px;right:-20px;"></div>
        <div style="width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,#fce7f3,#fbcfe8);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
            <i class="fa-solid fa-robot" style="color:#db2777;font-size:16px;"></i>
        </div>
        <div class="count-num" style="color:#db2777;">{{ $aiResponseRate }}%</div>
        <div class="count-label">AI Response Rate</div>
        <div class="badge-pill" style="background:#fce7f3;color:#db2777;"><i class="fa-solid fa-robot" style="font-size:8px;"></i> {{ $aiMessages }} AI replies</div>
    </div>
    <div class="stat-card" style="animation:fadeUp 0.4s 0.26s ease both;">
        <div class="card-orb" style="width:100px;height:100px;background:rgba(16,185,129,0.13);top:-20px;right:-20px;"></div>
        <div style="width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,#d1fae5,#6ee7b7);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
            <i class="fa-solid fa-thumbs-up" style="color:#059669;font-size:16px;"></i>
        </div>
        <div class="count-num" style="color:#059669;">{{ $aiApprovalRate }}%</div>
        <div class="count-label">AI Approval Rate</div>
        <div class="badge-pill" style="background:#d1fae5;color:#059669;">{{ $aiApproved }} approved &middot; {{ $aiRejected }} rejected</div>
    </div>
</div>


{{-- SATISFACTION SCORE --}}
<div style="margin-top:14px;">
    <div class="stat-card" style="animation:fadeUp 0.4s 0.29s ease both;background:linear-gradient(135deg,rgba(255,255,255,0.95),rgba(254,243,199,0.4));border-color:#fde68a;">
        <div class="card-orb" style="width:120px;height:120px;background:rgba(245,158,11,0.15);top:-30px;right:-30px;"></div>
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <div style="width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,#fef3c7,#fde68a);display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-star" style="color:#d97706;font-size:16px;"></i>
                    </div>
                    <div>
                        <div class="count-label">Customer Satisfaction</div>
                        <div style="font-size:10px;color:#94a3b8;">Based on {{ $totalRatings }} rating{{ $totalRatings !== 1 ? 's' : '' }}</div>
                    </div>
                </div>
                @if($avgRating)
                    <div style="display:flex;align-items:baseline;gap:8px;">
                        <div class="count-num" style="color:#d97706;font-size:38px;">{{ $avgRating }}</div>
                        <div style="font-size:14px;color:#94a3b8;font-weight:600;">/ 5.0</div>
                    </div>
                    <div style="display:flex;gap:4px;margin-top:8px;">
                        @for($i=1;$i<=5;$i++)
                            <i class="fa-solid fa-star" style="font-size:16px;color:{{ $i <= round($avgRating) ? '#f59e0b' : '#e2e8f0' }};"></i>
                        @endfor
                    </div>
                @else
                    <div class="count-num" style="color:#d97706;font-size:20px;">—</div>
                    <div style="font-size:11px;color:#94a3b8;margin-top:4px;">No ratings yet</div>
                @endif
            </div>
            @if($avgRating)
                <div style="text-align:center;padding:16px 20px;background:rgba(245,158,11,0.1);border-radius:16px;">
                    <div style="font-size:36px;margin-bottom:4px;">
                        @if($avgRating >= 4.5) 🤩
                        @elseif($avgRating >= 3.5) 😊
                        @elseif($avgRating >= 2.5) 🙂
                        @elseif($avgRating >= 1.5) 😐
                        @else 😞
                        @endif
                    </div>
                    <div style="font-size:10px;color:#d97706;font-weight:600;">
                        @if($avgRating >= 4.5) Excellent
                        @elseif($avgRating >= 3.5) Great
                        @elseif($avgRating >= 2.5) Good
                        @elseif($avgRating >= 1.5) Fair
                        @else Poor
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- CHART --}}
<div class="chart-card" style="animation:fadeUp 0.4s 0.3s ease both;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div>
            <div style="font-size:15px;font-weight:800;color:#0f172a;">Tickets Over Time</div>
            <div style="font-size:11px;color:#94a3b8;margin-top:3px;">Daily ticket submissions — last 30 days</div>
        </div>
        <div style="font-size:11px;color:#6366f1;font-weight:600;background:#ede9fe;padding:6px 14px;border-radius:99px;">
            <i class="fa-solid fa-calendar-days" style="font-size:10px;"></i> Last 30 days
        </div>
    </div>
    <div id="ticketLineChart"></div>
</div>

<script>
(function(){
    var dates  = {!! $chartDates !!};
    var counts = {!! $chartCounts !!};
    function buildChart(){
        var el = document.getElementById('ticketLineChart');
        if(!el) return;
        new ApexCharts(el,{
            series:[{name:'Tickets',data:counts}],
            chart:{type:'area',height:300,toolbar:{show:false},fontFamily:'Figtree,sans-serif',background:'transparent',animations:{enabled:true,easing:'easeinout',speed:700}},
            dataLabels:{enabled:false},
            stroke:{curve:'smooth',width:3,colors:['#6366f1']},
            fill:{type:'gradient',gradient:{shadeIntensity:1,opacityFrom:0.4,opacityTo:0.02,stops:[0,95,100]}},
            markers:{size:4,colors:['#fff'],strokeColors:'#6366f1',strokeWidth:2,hover:{size:7}},
            xaxis:{categories:dates,labels:{style:{colors:'#94a3b8',fontSize:'10px'},rotate:-30,formatter:function(v){if(!v)return'';var d=new Date(v);return(d.getMonth()+1)+'/'+d.getDate();}},axisBorder:{show:false},axisTicks:{show:false}},
            yaxis:{labels:{style:{colors:'#94a3b8',fontSize:'11px'},formatter:function(v){return Math.floor(v);}},min:0,tickAmount:4},
            grid:{borderColor:'#f1f5f9',strokeDashArray:4},
            tooltip:{theme:'light',y:{formatter:function(v){return v+' ticket'+(v!==1?'s':'');}}},
            colors:['#6366f1']
        }).render();
    }
    if(typeof ApexCharts!=='undefined'){buildChart();}
    else{var s=document.createElement('script');s.src='https://cdn.jsdelivr.net/npm/apexcharts';s.onload=buildChart;document.head.appendChild(s);}
})();
</script>