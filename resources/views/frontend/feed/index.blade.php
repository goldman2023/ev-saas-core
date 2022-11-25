@extends('frontend.layouts.feed')

@section('feed_content')
    <div class="mt-8 lg:px-16 col-span-12 sm:col-span-8 md:col-span-8 lg:col-span-8 flex flex-col">
        {{-- <div class="mb-8">
            <x-feed.elements.stories-global>
            </x-feed.elements.stories-global>
        </div> --}}

        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-12 space-y-4 px-0">
               {{-- <livewire:feed.elements.welcome-panel></livewire:feed.elements.welcome-panel> --}}
               <livewire:feed.elements.add-post class="mb-4" />
               <livewire:feed.feed-list :feed-type="$feed_type ?? 'recent'" />
            </div>
        </div>
    </div>

    <aside class="hidden sm:block sm:col-span-4 md:col-span-4 mt-8">
        <div class="sticky top-8 space-y-4">

            {{-- Upcoming Events --}}
            <livewire:feed.blocks.upcoming-events />

            {{--  --}}



            <livewire:feed.blocks.my-courses />

            <x-feed.elements.follow-suggestions>
            </x-feed.elements.follow-suggestions>

            {{-- @auth
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
            @endauth --}}
        </div>
    </aside>
@endsection
