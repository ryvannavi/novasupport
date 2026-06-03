@if(request()->has('ajax'))
<div style="animation:fadeUp 0.4s ease both;">
    @include('contact-content')
</div>
@else
<x-app-layout>
<div style="animation:fadeUp 0.4s ease both;">
    @include('contact-content')
</div>
</x-app-layout>
@endif