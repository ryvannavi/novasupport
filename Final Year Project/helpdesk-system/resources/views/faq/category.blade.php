@if(request()->has('ajax'))
<div style="animation:fadeUp 0.4s ease both;">
    @include('faq.category-content')
</div>
@else
<x-app-layout>
<div style="animation:fadeUp 0.4s ease both;">
    @include('faq.category-content')
</div>
</x-app-layout>
@endif