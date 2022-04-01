@extends('frontend.layouts.app')

@section('content')
<div class="min-h-full bg-gray-200">
    <!--
      When the mobile menu is open, add `overflow-hidden` to the `body` element to prevent double scrollbars

      Menu open: "fixed inset-0 z-40 overflow-y-auto", Menu closed: ""
    -->
    <div class="py-10 pt-3">
        <div class="max-w-3xl mx-auto sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="hidden lg:block lg:col-span-2 xl:col-span-2">
                <x-feed.elements.feed-sidebar>
                </x-feed.elements.feed-sidebar>
            </div>
            <main class="lg:col-span-6 xl:col-span-7">

                <div class="mb-3">
                    <x-feed.elements.stories-global>
                    </x-feed.elements.stories-global>

                </div>
                <div class="mt-4">


                    <h1 class="sr-only">Recent questions</h1>
                    <div role="list" class="space-y-4">
                       <livewire:feed.elements.welcome-panel></livewire:feed.elements.welcome-panel>

                       <livewire:feed.elements.add-post></livewire:feed.elements.add-post>
                        <livewire:feed.feed-list> </livewire:feed.feed-list>


                        <!-- More questions... -->
                    </div>
                </div>
            </main>
            <aside class="xl:block col-span-4 xl:col-span-3">
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
        </div>
    </div>
</div>

@endsection
