{{-- This class should be dynamic and should be passed from parent HeroSection (or WeComponent) component --}}
<section class="bg-white mx-auto max-w-7xl px-4">
    <div class="text-center">

        {{-- Section Title --}}
        <x-slot name="title_slot" we-title="Section Title">
            <x-ev.label
                we-name="section_title"
                we-title="Title"
                class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl {{ $data['title_slot']['section_title']['class'] ?? '' }}"
                :tag="$data['title_slot']['section_title']['tag'] ?? ''"
                :label="$data['title_slot']['section_title']['title'] ?? ''">
            </x-ev.label>
        </x-slot>

        {{-- Section Text --}}
        <x-slot name="text_slot" we-title="Section Text">
            <x-ev.label
                we-name="section_text"
                we-title="Text"
                class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl {{ $data['text_slot']['section_text']['class'] ?? '' }}"
                :tag="$data['text_slot']['section_text']['tag'] ?? ''"
                :label="$data['text_slot']['section_text']['title'] ?? ''">
            </x-ev.label>
        </x-slot>

        <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
            <div class="rounded-md shadow">
                <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10"> Get started </a>
            </div>
            <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10"> Live demo </a>
            </div>
        </div>
    </div>
</section>
