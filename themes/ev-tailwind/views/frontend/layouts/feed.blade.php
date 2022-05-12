@extends('frontend.layouts.app')

@section('content')
<div class="min-h-full bg-gray-200">
    <div class="max-w-5xl mx-auto  px-1 sm:px-6 lg:max-w-[1280px] lg:px-8 lg:grid lg:grid-cols-12 lg:gap-8 py-10 pt-3">
        <div class="hidden lg:block lg:col-span-2 sm:col-span-2">
            <x-feed.elements.feed-sidebar>
            </x-feed.elements.feed-sidebar>
        </div>
        <main class="sm:col-span-10 grid grid-cols-12 gap-6">
            @yield('feed_content')
        </main>

    </div>
</div>
@endsection
