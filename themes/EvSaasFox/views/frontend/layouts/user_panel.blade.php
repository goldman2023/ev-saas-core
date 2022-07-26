@extends('frontend.layouts.' . $globalLayout)

@section('content')
<script src="{{ static_asset('js/editor.js', false, true, true) }}"></script>

@if(auth()->user()->isAdmin())
<div>
    {{-- Sidebar (Mobile/Tablet and Laptop/Desktop) --}}
    @include('frontend.dashboard.partials.sidebar')
    @include('frontend.dashboard.partials.sidebar-mobile')

    <div class="lg:pl-64 flex flex-col">
        @include('frontend.dashboard.navigation.topbar')

        <main class="flex-1 we-user-panel__wrapper">
            <div class="py-6 px-4 sm:px-6 md:px-8 we-user-panel__container">
                <div class="w-full ">
                    @yield('panel_content')
                </div>
            </div>
        </main>

    </div>
</div>
@else
<div class="min-h-full bg-gray-200 col-span-12 w-full">
    <div class="max-w-5xl mx-auto  px-2 md:px-6 lg:max-w-[1280px] lg:px-8 lg:grid lg:grid-cols-12 lg:gap-8 py-10 pt-3">
        <div class="hidden lg:block lg:col-span-2 sm:col-span-2">
            <x-feed.elements.feed-sidebar>
            </x-feed.elements.feed-sidebar>
        </div>
        <main class="sm:col-span-10 ">
            @yield('panel_content')
        </main>
    </div>
</div>
@endif
@endsection
