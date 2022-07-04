<section class="relative {!! $getSectionSettingsClasses !!}">
  <div class="max-w-6xl mx-auto px-4 sm:px-5">
    <main class=" mx-auto max-w-7xl">
      <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-7 lg:text-left">
          {{-- Hero Title --}}
          <div we-slot name="title_slot" we-title="Hero Title" class="w-full">
            <x-ev.label
                we-name="hero_title"
                we-title="Title"
                class="block text-center lg:text-left font-semibold lg:font-black leading-none text-gray-900 text-28 sm:text-36 lg:text-[48px] xl:text-[60px] lg:pr-[3rem]  {{ $weData['title_slot']['components']['hero_title']['data']['class'] ?? '' }}"
                :tag="$weData['title_slot']['components']['hero_title']['data']['tag'] ?? ''"
                :label="$weData['title_slot']['components']['hero_title']['data']['label'] ?? ''">
            </x-ev.label>
          </div>

          {{-- Hero Subtitle --}}
          <div we-slot name="text_slot" we-title="Hero Subtitle" class="w-full">
            <x-ev.label
                we-name="hero_text"
                we-title="Subtitle"
                class="mt-3 text-center lg:text-left text-base text-gray-500 sm:mt-5 sm:text-18 lg:text-24 leading-6 lg:leading-8  lg:pr-[3rem]  {{ $weData['text_slot']['components']['hero_text']['data']['class'] ?? '' }}"
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
                class="mt-5 flex justify-center lg:justify-start lg:mt-8"
                :button-group="$weData['button_group_slot']['components']['hero_buttons']['data']['button_group'] ?? []">
            </x-ev.link-button-group>
          </div>

          {{-- Hero info label --}}
          <div we-slot name="hero_info_slot" we-title="Info Label" class="w-full mt-4">
            <x-ev.label
                we-name="hero_info_label"
                we-title="Info label"
                class="mt-2 text-base text-gray-500 {{ $weData['hero_info_slot']['components']['hero_info_label']['data']['class'] ?? '' }}"
                :tag="$weData['hero_info_slot']['components']['hero_info_label']['data']['tag'] ?? ''"
                :label="$weData['hero_info_slot']['components']['hero_info_label']['data']['label'] ?? ''">
            </x-ev.label>
          </div>

        </div>

        <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-5 lg:flex lg:items-center">
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
                :src="$weData['image_slot']['components']['hero_image']['data']['src']['file_name'] ?? ''">
            </x-ev.image>
          </div>
        </div>

      </div>
    </main>
  </div>
</section>
