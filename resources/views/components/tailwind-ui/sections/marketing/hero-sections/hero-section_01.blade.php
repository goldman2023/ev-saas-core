<section class="bg-white mx-auto max-w-7xl px-4">
    <div class="text-center">
        {{-- @dd($dataOverides['text_slot']['components']['section_text']['data']['tag']) --}}
        {{-- Section Title --}}
        <div we-slot name="title_slot" we-title="Section Title" class="w-full">
            <x-ev.label
                we-name="section_title"
                we-title="Title"
                class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl {{ $dataOverides['title_slot']['components']['section_title']['data']['class'] ?? '' }}"
                :tag="$dataOverides['title_slot']['components']['section_title']['data']['tag'] ?? ''"
                :label="$dataOverides['title_slot']['components']['section_title']['data']['label'] ?? ''">
            </x-ev.label>
        </div>

        {{-- Section Text --}}
        <div we-slot name="text_slot" we-title="Section Text" class="w-full">
            <x-ev.label
                we-name="section_text"
                we-title="Text"
                class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl {{ $dataOverides['text_slot']['components']['section_text']['data']['class'] ?? '' }}"
                :tag="$dataOverides['text_slot']['components']['section_text']['data']['tag'] ?? ''"
                :label="$dataOverides['text_slot']['components']['section_text']['data']['label'] ?? ''">
            </x-ev.label>
        </div>

        {{-- Buttons --}}
        <div we-slot name="button_group_slot" we-title="Buttons" class="w-full">
            <x-ev.link-button-group
                we-name="buttons"
                we-title="Buttons"
                {{-- class="{{ $data['button_group_slot']['components']['buttons']['data']['class'] ?? '' }}"" --}}
                class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8 " 
                :button-group="$dataOverides['button_group_slot']['components']['buttons']['data']['button_group'] ?? []">
            </x-ev.link-button-group>
        </div>
    </div>
</section>
