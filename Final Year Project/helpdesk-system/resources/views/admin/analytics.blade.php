@if(request()->has('ajax'))
    <div style="padding:30px; animation:fadeUp 0.4s ease both;">
        <div style="max-width:1100px; margin:0 auto;">
            @include('admin.analytics-content')
        </div>
    </div>
@else
    <x-app-layout>
        <div style="padding:30px; animation:fadeUp 0.4s ease both;">
            <div style="max-width:1100px; margin:0 auto;">
                @include('admin.analytics-content')
            </div>
        </div>
    </x-app-layout>
@endif