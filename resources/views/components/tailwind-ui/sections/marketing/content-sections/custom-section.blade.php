<section class="relative {!! $getSectionSettingsClasses !!}">
    <div class="hidden">

        <div we-slot name="hero_info_slot" we-title="Section id" class="w-full mt-4">
            <x-ev.label we-name="hero_info_label" we-title="Section Id"
                class="mt-2 text-base text-gray-500 {{ $weData['hero_info_slot']['components']['hero_info_label']['data']['class'] ?? '' }}"
                :label="$weData['hero_info_slot']['components']['hero_info_label']['data']['label'] ?? ''">
            </x-ev.label>
        </div>
    </div>

    {!! bladeCompile($custom_content) !!}
</section>
