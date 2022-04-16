@extends('frontend.layouts.' . $globalLayout)

@section('content')
<div>
    {{-- Sidebar (Mobile/Tablet and Laptop/Desktop) --}}
    @include('frontend.dashboard.partials.sidebar')
    @include('frontend.dashboard.partials.sidebar-mobile')

    <div class="lg:pl-64 flex flex-col">
        @include('frontend.dashboard.navigation.topbar')

        <main class="flex-1">
            <div class="py-6">
                {{-- <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    <h1 class="text-2xl font-semibold text-gray-900"></h1>
                </div> --}}
                <div class="w-full px-4 sm:px-6 md:px-8">
                    @yield('panel_content')
                </div>
            </div>
        </main>

    </div>
</div>
@endsection
