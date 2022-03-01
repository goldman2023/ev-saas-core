{{-- This is a section that can be used in a page builer --}}
<!-- This example requires Tailwind CSS v2.0+ -->

{{-- This class should be dynamic and should be passed from parent HeroSection (or WeComponent) component --}}
<div {{ $attributes }} class="bg-white">
    <div>
        <!-- Hero card -->
        <div class="relative">
            <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gray-100"></div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="relative shadow-xl sm:rounded-2xl sm:overflow-hidden">
                    <div class="absolute inset-0">
                        <img class="h-full w-full object-cover"
                            src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2830&q=80&sat=-100"
                            alt="People working on laptops">
                        <div class="absolute inset-0 bg-indigo-700 mix-blend-multiply"></div>
                    </div>
                    <div class="relative px-4 py-16 sm:px-6 sm:py-24 lg:py-32 lg:px-8">
                        <x-slot name="section_title">
                            <x-ev.label
                                class="text-center text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl"
                                :label="ev_dynamic_translate('Section title', false)">
                            </x-ev.label>
                        </x-slot>

                        <x-slot name="section_text">
                            <x-ev.label class="mt-6 max-w-lg mx-auto text-center text-xl text-indigo-200 sm:max-w-3xl"
                                :label="ev_dynamic_translate('Section title', false)">
                            </x-ev.label>
                        </x-slot>


                        <div class="mt-10 max-w-sm mx-auto sm:max-w-none sm:flex sm:justify-center">
                            <x-slot name="section_cta">
                                <div class="space-y-4 sm:space-y-0 sm:mx-auto sm:inline-grid sm:grid-cols-2 sm:gap-5">

                                    <x-ev.link-button
                                        class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-indigo-700 bg-white hover:bg-indigo-50 sm:px-8"
                                        :href="ev_dynamic_translate('#button1')"
                                        :label="ev_dynamic_translate('Button 1')" class="ev-button">
                                    </x-ev.link-button>

                                    <x-ev.link-button
                                        class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-500 bg-opacity-60 hover:bg-opacity-70 sm:px-8"
                                        :href="ev_dynamic_translate('#button1')"
                                        target="_blank"
                                        :label="ev_dynamic_translate('Button 2')" class="ev-button">
                                    </x-ev.link-button>

                                </div>
                            </x-slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logo cloud -->
        <div class="bg-gray-100">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm font-semibold uppercase text-gray-500 tracking-wide">Trusted by over 5
                    very average small businesses</p>
                <div class="mt-6 grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5">
                    <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
                        <img class="h-12" src="https://tailwindui.com/img/logos/tuple-logo-gray-400.svg" alt="Tuple">
                    </div>
                    <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
                        <img class="h-12" src="https://tailwindui.com/img/logos/mirage-logo-gray-400.svg" alt="Mirage">
                    </div>
                    <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
                        <img class="h-12" src="https://tailwindui.com/img/logos/statickit-logo-gray-400.svg"
                            alt="StaticKit">
                    </div>
                    <div class="col-span-1 flex justify-center md:col-span-2 md:col-start-2 lg:col-span-1">
                        <img class="h-12" src="https://tailwindui.com/img/logos/transistor-logo-gray-400.svg"
                            alt="Transistor">
                    </div>
                    <div class="col-span-2 flex justify-center md:col-span-2 md:col-start-4 lg:col-span-1">
                        <img class="h-12" src="https://tailwindui.com/img/logos/workcation-logo-gray-400.svg"
                            alt="Workcation">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- More main page content here... -->

</div>
