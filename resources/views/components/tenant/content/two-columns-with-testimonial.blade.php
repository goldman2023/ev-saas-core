<!--
  This example requires Tailwind CSS v2.0+

  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/typography'),
    ],
  }
  ```
-->
<div class="py-16 bg-gray-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 space-y-8 sm:px-6 lg:px-8">
        <div class="text-base max-w-prose mx-auto lg:max-w-none">

            <x-ev.label :label="ev_dynamic_translate('Page Description')"
                class="text-base text-indigo-600 font-semibold tracking-wide uppercase" tag="h2">
            </x-ev.label>

            <x-ev.label tag="h1" class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl"
                :label="ev_dynamic_translate('Page Title')">
            </x-ev.label>
        </div>
        <div class="relative z-10 text-base max-w-prose mx-auto lg:max-w-5xl lg:mx-0 lg:pr-72">
            <p class="text-lg text-gray-500">
                <x-ev.label :label="ev_dynamic_translate('Page Excerpt')">
                </x-ev.label>
            </p>
        </div>
        <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-start">
            <div class="relative z-10">
                <div class="prose prose-indigo text-gray-500 mx-auto lg:max-w-none">
                    <x-ev.label :label="ev_dynamic_translate('Page Content')">
                    </x-ev.label>
                </div>
                <div class="mt-10 flex text-base max-w-prose mx-auto lg:max-w-none">
                    <div>
                        <x-ev.link-button :href="ev_dynamic_translate('#button1')"
                            :label="ev_dynamic_translate('Button 1')" class="ev-button">
                        </x-ev.link-button>
                        {{-- <a href="{{ ev_dynamic_translate('#button1')->value }}"
                            class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        </a> --}}
                    </div>
                    <div>
                        <x-ev.link-button :href="ev_dynamic_translate('#button2')"
                            :label="ev_dynamic_translate('Button 2')" type="link" class="ev-button">
                            {{-- Icon can go here --}}
                        </x-ev.link-button>
                    </div>
                </div>
            </div>
            <div class="mt-12 relative text-base max-w-prose mx-auto lg:mt-0 lg:max-w-none">
                <svg class="absolute top-0 right-0 -mt-20 -mr-20 lg:top-auto lg:right-auto lg:bottom-1/2 lg:left-1/2 lg:mt-0 lg:mr-0 xl:top-0 xl:right-0 xl:-mt-20 xl:-mr-20"
                    width="404" height="384" fill="none" viewBox="0 0 404 384" aria-hidden="true">
                    <defs>
                        <pattern id="bedc54bc-7371-44a2-a2bc-dc68d819ae60" x="0" y="0" width="20" height="20"
                            patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="404" height="384" fill="url(#bedc54bc-7371-44a2-a2bc-dc68d819ae60)" />
                </svg>
                <blockquote class="relative bg-white rounded-lg shadow-lg">
                    <div class="rounded-t-lg px-6 py-8 sm:px-10 sm:pt-10 sm:pb-8">
                        <x-ev.dynamic-image :src="ev_dynamic_translate('#testimonial-logo', true)" alt="Any alt text"
                            :href="ev_dynamic_translate('#testimonial-logo-link', true)">
                        </x-ev.dynamic-image>
                        <div class="relative text-lg text-gray-700 font-medium mt-8">
                            <svg class="absolute top-0 left-0 transform -translate-x-3 -translate-y-2 h-8 w-8 text-gray-200"
                                fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                <path
                                    d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                            </svg>
                            <p class="relative">
                                <x-ev.label :label="ev_dynamic_translate('Testimonial Description', true)">
                                </x-ev.label>
                            </p>
                        </div>
                    </div>
                    <cite
                        class="relative flex items-center sm:items-start bg-indigo-600 rounded-b-lg not-italic py-5 px-6 sm:py-5 sm:pl-12 sm:pr-10 sm:mt-10">
                        <div
                            class="relative rounded-full border-2 border-white sm:absolute sm:top-0 sm:transform sm:-translate-y-1/2">

                            {{-- New Version --}}
                            <x-ev.dynamic-image alt="Any alt text"
                                :href="ev_dynamic_translate('#testimonial-img-link', true)"
                                :src="ev_dynamic_translate('#testimonial-img', true)">
                            </x-ev.dynamic-image>

                            {{-- Old Version --}}
                            {{-- <img class="w-12 h-12 sm:w-20 sm:h-20 rounded-full bg-indigo-300"
                                src="{!! ev_dynamic_translate('#testimonial-img', true)->value !!}" alt=""> --}}
                        </div>
                        <span class="relative ml-4 text-indigo-300 font-semibold leading-6 sm:ml-24 sm:pl-1">
                            <p class="text-white font-semibold sm:inline">
                                <x-ev.label :label="ev_dynamic_translate('Testimonial Person', true)">
                                <x-ev.label>
                            </p>
                            <p class="sm:inline">
                                <x-ev.label :label="ev_dynamic_translate('Testimonial Possition', true)">
                                </x-ev.label>
                            </p>
                        </span>
                    </cite>
                </blockquote>
            </div>
        </div>
    </div>
</div>
