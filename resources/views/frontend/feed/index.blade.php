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


                <div class="mt-4">
                    <h1 class="sr-only">Recent questions</h1>
                    <div role="list" class="space-y-4">
                        <div class="bg-gray-50 px-4 py-6 sm:px-6">
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full"
                                        src="{{ auth()->user()->getThumbnail() }}"
                                        alt="">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <form action="#">
                                        <div>
                                            <label for="comment" class="sr-only">About</label>
                                            <textarea id="comment" name="comment" rows="3"
                                                class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-md"
                                                placeholder="{{ translate('What\'s on your mind?') }}"></textarea>
                                        </div>
                                        <div class="mt-3 flex items-center justify-between">
                                            <a href="#"
                                                class="group inline-flex items-start text-sm space-x-2 text-gray-500 hover:text-gray-900">
                                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                                    x-description="Heroicon name: solid/question-mark-circle"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span>
                                                    {{ translate('Post will be visible publicly') }}
                                                </span>
                                            </a>
                                            <button type="submit"
                                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                {{ translate('Add a post') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
