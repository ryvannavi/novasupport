@php
$categories = [
    ['icon'=>'fa-rocket','color'=>'#7c3aed','bg'=>'linear-gradient(135deg,#ede9fe,#ddd6fe)','solidBg'=>'#ede9fe','title'=>'Getting Started','slug'=>'getting-started','badge'=>'New','badgeStyle'=>'background:#dcfce7;color:#15803d;','desc'=>'Everything you need to set up your account and get started with NovaSupport.'],
    ['icon'=>'fa-shield-halved','color'=>'#db2777','bg'=>'linear-gradient(135deg,#fce7f3,#fbcfe8)','solidBg'=>'#fce7f3','title'=>'Authentication & Security','slug'=>'authentication','badge'=>null,'badgeStyle'=>'','desc'=>'Manage account security, reset passwords, and configure two-factor authentication.'],
    ['icon'=>'fa-credit-card','color'=>'#ca8a04','bg'=>'linear-gradient(135deg,#fef9c3,#fde68a)','solidBg'=>'#fef9c3','title'=>'Billing & Pricing','slug'=>'billing','badge'=>null,'badgeStyle'=>'','desc'=>'Understand your billing cycle, manage payment methods, and view invoices.'],
    ['icon'=>'fa-gear','color'=>'#0891b2','bg'=>'linear-gradient(135deg,#e0f2fe,#bae6fd)','solidBg'=>'#e0f2fe','title'=>'Advanced Settings','slug'=>'advanced-settings','badge'=>null,'badgeStyle'=>'','desc'=>'Configure advanced options, manage integrations, and customize NovaSupport.'],
    ['icon'=>'fa-screwdriver-wrench','color'=>'#16a34a','bg'=>'linear-gradient(135deg,#dcfce7,#bbf7d0)','solidBg'=>'#dcfce7','title'=>'Technical Issues','slug'=>'technical-issues','badge'=>'Hot','badgeStyle'=>'background:#fee2e2;color:#dc2626;','desc'=>'Troubleshoot common technical problems, bugs, and errors instantly.'],
    ['icon'=>'fa-chart-line','color'=>'#0891b2','bg'=>'linear-gradient(135deg,#ecfeff,#a5f3fc)','solidBg'=>'#ecfeff','title'=>'Analytics & Reports','slug'=>'analytics','badge'=>null,'badgeStyle'=>'','desc'=>'Use the analytics dashboard, generate reports, and track support metrics.'],
];
@endphp

@if(request()->has('ajax'))
<div style="max-width:1200px;margin:0 auto;padding:0 24px;">
    @include('welcome-content', ['categories' => $categories])
</div>
@else
<x-app-layout>
<div style="max-width:1200px;margin:0 auto;padding:0 24px;">
    @include('welcome-content', ['categories' => $categories])
</div>
</x-app-layout>
@endif