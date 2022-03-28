@extends('frontend.layouts.app')

@section('content')
<!--
  This example requires Tailwind CSS v2.0+

  This example requires some changes to your config:

  ```
  // tailwind.config.js
  const colors = require('tailwindcss/colors')

  module.exports = {
    // ...
    theme: {
      extend: {
        colors: {
          rose: colors.rose,
        },
      },
    },
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-gray-100">
  <body class="h-full">
  ```
-->
<div class="min-h-full bg-gray-200">
    <!--
      When the mobile menu is open, add `overflow-hidden` to the `body` element to prevent double scrollbars

      Menu open: "fixed inset-0 z-40 overflow-y-auto", Menu closed: ""
    -->


    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="hidden lg:block lg:col-span-2 xl:col-span-2">
                <x-feed.elements.feed-sidebar>
                </x-feed.elements.feed-sidebar>
            </div>
            <main class="lg:col-span-6 xl:col-span-7">
                <div class="px-4 sm:px-0">
                    <div class="sm:hidden">
                        <label for="question-tabs" class="sr-only">Select a tab</label>
                        <select id="question-tabs"
                            class="block w-full rounded-md border-gray-300 text-base font-medium text-gray-900 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                            <option selected>Recent</option>

                            <option>Most Liked</option>

                            <option>Most Answers</option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <nav class="relative z-0 rounded-lg shadow flex divide-x divide-gray-200" aria-label="Tabs">
                            <!-- Current: "text-gray-900", Default: "text-gray-500 hover:text-gray-700" -->
                            <a href="#" aria-current="page"
                                class="text-gray-900 rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-6 text-sm font-medium text-center hover:bg-gray-50 focus:z-10">
                                <span>Recent</span>
                                <span aria-hidden="true" class="bg-rose-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                            </a>

                            <a href="#"
                                class="text-gray-500 hover:text-gray-700 group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-6 text-sm font-medium text-center hover:bg-gray-50 focus:z-10">
                                <span>Most Liked</span>
                                <span aria-hidden="true"
                                    class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>
                            </a>

                            <a href="#"
                                class="text-gray-500 hover:text-gray-700 rounded-r-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-6 text-sm font-medium text-center hover:bg-gray-50 focus:z-10">
                                <span>Most Answers</span>
                                <span aria-hidden="true"
                                    class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="mt-4">
                    <h1 class="sr-only">Recent questions</h1>
                    <div role="list" class="space-y-4">
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
                                        class="w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
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
