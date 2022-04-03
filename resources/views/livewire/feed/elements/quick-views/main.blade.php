<!--
  This example requires Tailwind CSS v2.0+

  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/aspect-ratio'),
    ],
  }
  ```
-->
<div x-show="isModalOpen" x-on:click.away="isModalOpen = false" x-cloak x-transition
    class="fixed z-[100] inset-0 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex min-h-screen text-center md:block md:px-2 lg:px-4" style="font-size: 0">
        <!--
        Background overlay, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100"
          To: "opacity-0"
      -->
        <div class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity md:block" aria-hidden="true">
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden md:inline-block md:align-middle md:h-screen" aria-hidden="true">&#8203;</span>

        <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
          To: "opacity-100 translate-y-0 md:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 md:scale-100"
          To: "opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
      -->
        <div
            class="flex text-base text-left transform transition w-full md:inline-block md:max-w-2xl md:px-4 md:my-8 md:align-middle lg:max-w-4xl">
            <div
                class="w-full relative flex items-center bg-white px-4 pt-14 pb-8 overflow-hidden shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                <button x-on:click="isModalOpen = false" type="button"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 sm:top-8 sm:right-6 md:top-6 md:right-6 lg:top-8 lg:right-8">
                    <span class="sr-only">Close</span>
                    <!-- Heroicon name: outline/x -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="w-full grid grid-cols-1 gap-y-8 gap-x-6 items-start sm:grid-cols-12 lg:gap-x-8">
                    <div class="sm:col-span-4 lg:col-span-5">
                        <div class="aspect-w-1 aspect-h-1 rounded-lg bg-gray-100 overflow-hidden">
                            <img src="https://tailwindui.com/img/ecommerce-images/product-page-03-product-04.jpg"
                                alt="Back angled view with bag open and handles to the side."
                                class="object-center object-cover">
                        </div>
                    </div>
                    <div class="sm:col-span-8 lg:col-span-7">
                        <h2 class="text-2xl font-extrabold text-gray-900 sm:pr-12">
                            {{ $item->subject->name }}
                        </h2>

                        <section aria-labelledby="information-heading" class="mt-3">
                            <h3 id="information-heading" class="sr-only">Product information</h3>

                            <div class="grid grid-cols-3 content-center">
                                <div class="col-span-2">
                                    <x-feed.elements.card-header-user-info :item="$item">
                                    </x-feed.elements.card-header-user-info>
                                </div>
                                <div>
                                    @livewire('actions.wishlist-button', [
                                        'object' => $item->causer,
                                        'action' => 'Follow'
                                        ])
                                </div>
                            </div>



                            <div class="mt-6">
                                <h4 class="sr-only">Description</h4>

                                <p class="text-sm text-gray-700">
                                    {!! $item->subject->content !!}
                                </p>
                            </div>
                        </section>

                        <section aria-labelledby="options-heading" class="mt-6">
                            {{-- <h3 id="options-heading" class="sr-only">Product options</h3> --}}

                            <div class="mt-6">


                                <livewire:actions.wishlist-button
                                    class="w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500"
                                    wire:key="post_{{ $item->id }}" action="Like" :object="$item->subject">
                                </livewire:actions.wishlist-button>
                                </button>
                            </div>
                            <p class="text-center sm:static sm:mt-6 mb-3">
                                <a href="{{ $item->subject->getPermalink() }}"
                                    class="font-medium text-indigo-600 hover:text-indigo-500">
                                    {{ translate('View full details') }}
                                </a>
                            </p>




                        </section>

                        <livewire:feed.elements.quick-views.elements.comments>
                        </livewire:feed.elements.quick-views.elements.comments>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
