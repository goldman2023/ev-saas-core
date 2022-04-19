<section class="relative {!! $getSectionSettingsClasses !!}">
  <div class="w-full">
    <div class="container !max-w-[90%] sm:!max-w-2xl">
        <div class="action-content text-center">
  
          {{-- Section Title --}}
          <div we-slot name="title_slot" we-title="Section Title" class="w-full mb-4">
            <x-ev.label
                we-name="section_title"
                we-title="Title"
                class="text-[48px] text-gray-900 font-black leading-none mb-5 {{ $weData['title_slot']['components']['section_title']['data']['class'] ?? '' }}"
                :tag="$weData['title_slot']['components']['section_title']['data']['tag'] ?? ''"
                :label="$weData['title_slot']['components']['section_title']['data']['label'] ?? ''">
            </x-ev.label>
          </div>
  
          {{-- Section Text --}}
          <div we-slot name="text_slot" we-title="Section Text" class="w-full mb-8">
            <x-ev.label
                we-name="section_text"
                we-title="Text"
                class="text-20 font-medium text-gray-900 {{ $weData['text_slot']['components']['section_text']['data']['class'] ?? '' }}"
                :tag="$weData['text_slot']['components']['section_text']['data']['tag'] ?? ''"
                :label="$weData['text_slot']['components']['section_text']['data']['label'] ?? ''">
            </x-ev.label>
          </div>
  
          {{-- Buttons --}}
          @if(!empty($weData['button_group_slot']['components']['buttons']['data']['button_group'] ?? []))
            <div we-slot name="button_group_slot" we-title="Buttons" class="w-full">
                <x-ev.link-button-group
                    we-name="buttons"
                    we-title="Buttons"
                    {{-- class="{{ $data['button_group_slot']['components']['buttons']['data']['class'] ?? '' }}"" --}}
                    class="mb-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8 " 
                    :button-group="$weData['button_group_slot']['components']['buttons']['data']['button_group'] ?? []">
                </x-ev.link-button-group>
            </div>
          @endif
  
          {{-- Section Info Text --}}
          <div we-slot name="info_slot" we-title="Section Info Text" class="w-full ">
            <x-ev.label
                we-name="section_info"
                we-title="Text"
                class="text-20 font-medium text-gray-900 {{ $weData['info_slot']['components']['section_info']['data']['class'] ?? '' }}"
                :tag="$weData['info_slot']['components']['section_info']['data']['tag'] ?? ''"
                :label="$weData['info_slot']['components']['section_info']['data']['label'] ?? ''">
            </x-ev.label>
          </div>
  
        </div>
    </div>
  </div>
</section>
