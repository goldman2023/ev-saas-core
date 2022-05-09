@extends('frontend.layouts.app')

@section('content')
<div class="min-h-full bg-gray-200">
    <div class="max-w-5xl mx-auto sm:px-6 lg:max-w-[1440px] lg:px-8 lg:grid lg:grid-cols-12 lg:gap-8 py-10 pt-3">
        <div class="hidden lg:block lg:col-span-2 xl:col-span-2">
            <x-feed.elements.feed-sidebar>
            </x-feed.elements.feed-sidebar>
        </div>
        <main class="lg:col-span-12 xl:col-span-10 grid grid-cols-12 gap-6">

            <div class="col-span-12 xl:col-span-9 flex flex-col">
                <div class="mb-3">
                    <x-feed.elements.stories-global>
                    </x-feed.elements.stories-global>
                </div>
    
                <div class="grid grid-cols-12 gap-5 mt-4">

                    <div class="col-span-12 md:col-span-7 space-y-4 px-4 md:px-0">
                       {{-- <livewire:feed.elements.welcome-panel></livewire:feed.elements.welcome-panel> --}}
                        <livewire:feed.elements.add-post />
                        <livewire:feed.feed-list />
                    </div>

                    <div class="col-span-12 md:col-span-5 px-4 md:px-0">
                        {{-- Upcoming Events --}}
                        <livewire:feed.blocks.upcoming-events />
                    </div>
                </div>
            </div>
            
            <aside class="hidden xl:block xl:col-span-3">
                <div class="sticky top-4 space-y-4">
                    <x-feed.elements.follow-suggestions>
                    </x-feed.elements.follow-suggestions>
    
                    @auth
                        <section aria-labelledby="trending-heading">
                            <div class="bg-white rounded-lg shadow">
                                <div class="p-6">
                                    <h2 id="trending-heading" class="text-base font-medium text-gray-900">
                                        {{ translate('Recently visited') }}
                                    </h2>
                                    <div class="mt-6 flow-root">
                                        @livewire('feed.recently-viewed')
                                    </div>
                                    <div class="mt-6">
                                        <a href="#"
                                            class="hidden w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                            View all </a>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endauth
                </div>
            </aside>
        </main>
        
    </div>
</div>

@endsection
