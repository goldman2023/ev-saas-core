<section class="relative bg-white @if($settings['background']['type'] === 'color') bg-[{{ $settings['background']['color'] ?? '' }}] @endif">
  <div class="max-w-6xl mx-auto px-4 sm:px-5">
    <main class=" mx-auto max-w-7xl px-4 sm:px-6 py-[154px]">
      <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-7 lg:text-left">
          {{-- Hero Title --}}
          <div we-slot name="title_slot" we-title="Hero Title" class="w-full">
            <x-ev.label
                we-name="hero_title"
                we-title="Title"
                class="block text-18 font-semibold lg:font-black leading-none text-gray-900 sm:text-20 lg:text-[48px] xl:text-[60px] lg:pr-[3rem] {{ $weData['title_slot']['components']['hero_title']['data']['class'] ?? '' }}"
                :tag="$weData['title_slot']['components']['hero_title']['data']['tag'] ?? ''"
                :label="$weData['title_slot']['components']['hero_title']['data']['label'] ?? ''">
            </x-ev.label>
          </div>

          {{-- Hero Subtitle --}}
          <div we-slot name="text_slot" we-title="Hero Subtitle" class="w-full">
            <x-ev.label
                we-name="hero_text"
                we-title="Subtitle"
                class="mt-3 text-base text-gray-500 sm:mt-5 lg:text-24 leading-8  lg:pr-[3rem] {{ $weData['text_slot']['components']['hero_text']['data']['class'] ?? '' }}"
                :tag="$weData['text_slot']['components']['hero_text']['data']['tag'] ?? ''"
                :label="$weData['text_slot']['components']['hero_text']['data']['label'] ?? ''">
            </x-ev.label>
          </div>

  
          {{-- Hero Buttons --}}
          <div we-slot name="button_group_slot" we-title="Buttons" class="w-full">
            <x-ev.link-button-group
                we-name="hero_buttons"
                we-title="Buttons"
                {{-- class="{{ $data['button_group_slot']['components']['buttons']['data']['class'] ?? '' }}"" --}}
                class="mt-5 max-w-md sm:flex sm:justify-start md:mt-8" 
                :button-group="$weData['button_group_slot']['components']['hero_buttons']['data']['button_group'] ?? []">
            </x-ev.link-button-group>
          </div>

          {{-- Hero info label --}}
          <div we-slot name="text_slot" we-title="Info Label" class="w-full mt-4">
            <x-ev.label
                we-name="hero_info_label"
                we-title="Info label"
                class="mt-2 text-base text-gray-500 {{ $weData['text_slot']['components']['hero_info_label']['data']['class'] ?? '' }}"
                :tag="$weData['text_slot']['components']['hero_info_label']['data']['tag'] ?? ''"
                :label="$weData['text_slot']['components']['hero_info_label']['data']['label'] ?? ''">
            </x-ev.label>
          </div>

        </div>

        <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-5 lg:flex lg:items-center">
          <svg class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-8 scale-75 origin-top sm:scale-100 lg:hidden" width="640" height="784" fill="none" viewBox="0 0 640 784" aria-hidden="true">
            <defs>
              <pattern id="4f4f415c-a0e9-44c2-9601-6ded5a34a13e" x="118" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
              </pattern>
            </defs>
            <rect y="72" width="640" height="640" class="text-gray-50" fill="currentColor" />
            <rect x="118" width="404" height="784" fill="url(#4f4f415c-a0e9-44c2-9601-6ded5a34a13e)" />
          </svg>
          
          {{-- Hero Image--}}
          <div we-slot name="image_slot" we-title="Hero Image" class="w-full mt-4">
            <x-ev.image
                we-name="hero_image"
                we-title="Image"
                class="w-full lg:max-w-[540px] {{ $weData['image_slot']['components']['hero_image']['data']['class'] ?? '' }}"
                :href="$weData['image_slot']['components']['hero_image']['data']['href'] ?? null"
                :target="$weData['image_slot']['components']['hero_image']['data']['target'] ?? null"
                :options="['w' => 600]"
                :alt-text="$weData['image_slot']['components']['hero_image']['data']['alt_text'] ?? ''"
                :src="$weData['image_slot']['components']['hero_image']['data']['src'] ?? ''">
            </x-ev.image>
          </div>
        </div>

      </div>
    </main>
  </div>
</section>