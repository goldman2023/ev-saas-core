@extends('frontend.layouts.' . $globalLayout)

@section('content')
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
@endsection
