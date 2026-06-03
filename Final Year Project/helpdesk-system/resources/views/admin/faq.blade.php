@if(request()->has('ajax'))
<div style="padding:30px;animation:fadeUp 0.4s ease both;">
    <div style="max-width:900px;margin:0 auto;">
        @include('admin.faq-content')
    </div>
</div>
@else
<x-app-layout>
<div style="padding:30px;animation:fadeUp 0.4s ease both;">
    <div style="max-width:900px;margin:0 auto;">
        @include('admin.faq-content')
    </div>
</div>
</x-app-layout>
@endif