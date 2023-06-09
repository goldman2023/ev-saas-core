@extends('frontend.layouts.app')

@section('content')
<div class="min-h-full bg-gray-200">

    <!--
      When the mobile menu is open, add `overflow-hidden` to the `body` element to prevent double scrollbars

      Menu open: "fixed inset-0 z-40 overflow-y-auto", Menu closed: ""
    -->
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:max-w-7xl lg:px-0 lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="hidden lg:block lg:col-span-2 xl:col-span-2">
                <x-feed.elements.feed-sidebar>
                </x-feed.elements.feed-sidebar>
            </div>
            <main class="lg:col-span-9 xl:col-span-10">
                <div class="mt-4">


                    <div class="mb-5">
                        <x-feed.elements.shop.shop-archive-filters :hide="true">
                        </x-feed.elements.shop.shop-archive-filters>
                    </div>

                    <div role="list" class="grid grid-cols-2 gap-5 md:grid-cols-3">

                        @foreach ($shops as $shop)
                            <livewire:feed.elements.shop-card :shop="$shop"></livewire:feed.elements.shop-card>
                        @endforeach


                        <!-- More questions... -->
                    </div>
                </div>
            </main>
            <aside class="xl:block col-span-4 xl:col-span-3">

            </aside>
        </div>
    </div>
</div>

@endsection
