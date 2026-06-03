@if(request()->has('ajax'))
    @include('tickets.show-content')
@else
    <x-app-layout>
        @include('tickets.show-content')
    </x-app-layout>
@endif