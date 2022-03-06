{{-- This class should be dynamic and should be passed from parent HeroSection (or WeComponent) component --}}
<section class="bg-white mx-auto max-w-7xl px-4">
    <div class="text-center">

        {{-- Section Title --}}
        <x-slot name="title_slot" we-title="Section Title">
            <x-ev.label
                we-name="section_title"
                we-title="Title"
                class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl {{ $data['title_slot']['components']['section_title']['data']['class'] ?? '' }}"
                :tag="$data['title_slot']['components']['section_title']['data']['tag'] ?? ''"
                :label="$data['title_slot']['components']['section_title']['title'] ?? ''">
            </x-ev.label>
        </x-slot>

        {{-- Section Text --}}
        <x-slot name="text_slot" we-title="Section Text">
            <x-ev.label
                we-name="section_text"
                we-title="Text"
                class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl {{ $data['text_slot']['components']['section_text']['data']['class'] ?? '' }}"
                :tag="$data['text_slot']['components']['section_text']['data']['tag'] ?? ''"
                :label="$data['text_slot']['components']['section_text']['data']['title'] ?? ''">
            </x-ev.label>
        </x-slot>

        <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
            {{-- Section Text --}}
            <x-slot name="button_group_slot" we-title="Buttons">
                <x-ev.link-button-group
                    we-name="buttons"
                    we-title="Buttons"
                    {{-- class="{{ $data['button_group_slot']['components']['buttons']['data']['class'] ?? '' }}"" --}}
                    class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8 " 
                    :button_group="$data['button_group_slot']['components']['buttons']['data']['button_group'] ?? []">
                </x-ev.link-button-group>
            </x-slot>
        </div>
    </div>
</section>
