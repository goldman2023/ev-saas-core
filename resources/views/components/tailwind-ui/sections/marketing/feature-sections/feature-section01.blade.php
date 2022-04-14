<div class="relative bg-white py-16 sm:py-24 lg:py-32 {!! $getSectionSettingsClasses !!}">
  <div class="mx-auto max-w-md px-4 text-center sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
    
    {{-- Tagline --}}
    <div we-slot name="tagline_slot" we-title="Tagline" class="w-full">
      <x-ev.label
          we-name="tagline"
          we-title="Title"
          class="text-18 font-semibold tracking-wider text-primary {{ $weData['tagline_slot']['components']['tagline']['data']['class'] ?? '' }}"
          :tag="$weData['tagline_slot']['components']['tagline']['data']['tag'] ?? ''"
          :label="$weData['tagline_slot']['components']['tagline']['data']['label'] ?? ''">
      </x-ev.label>
    </div>

    {{-- Title --}}
    <div we-slot name="title_slot" we-title="Title" class="w-full">
      <x-ev.label
          we-name="title"
          we-title="Title"
          class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-5xl {{ $weData['title_slot']['components']['title']['data']['class'] ?? '' }}"
          :tag="$weData['title_slot']['components']['title']['data']['tag'] ?? ''"
          :label="$weData['title_slot']['components']['title']['data']['label'] ?? ''">
      </x-ev.label>
    </div>

    {{-- Subtitle --}}
    <div we-slot name="subtitle_slot" we-title="Subtitle" class="w-full">
      <x-ev.label
          we-name="subtitle"
          we-title="Subtitle"
          class="mx-auto mt-5 max-w-prose text-xl text-gray-500 {{ $weData['subtitle_slot']['components']['subtitle']['data']['class'] ?? '' }}"
          :tag="$weData['subtitle_slot']['components']['subtitle']['data']['tag'] ?? ''"
          :label="$weData['subtitle_slot']['components']['subtitle']['data']['label'] ?? ''">
      </x-ev.label>
    </div>

    {{-- ITT Group --}}
    <div we-slot name="itt_group_slot" we-title="Features" class="w-full mt-12">
      <x-ev.image-title-text-group
          we-name="itts"
          we-title="Features"
          class=""
          :per_row="$weData['itt_group_slot']['components']['itts']['data']['per_row'] ?? []"
          :itt-group="$weData['itt_group_slot']['components']['itts']['data']['itt_group'] ?? []">

          {{-- Add component content here instead of the image-title-text-group.blade and use $component->{property} to get the properties --}}
          @if(!empty($component->ittGroup))
            @foreach($component->ittGroup as $itt)
              <div class="pt-6 {{ $itt['class'] ?? '' }}">
                @if(!empty($itt['href'] ?? null))
                  <a class="block w-full" href="{{ $itt['href'] }}" target="{{ $itt['target'] ?? '_self' }}">
                @endif

                <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg px-6 py-5 h-full">
                  <div class="-mt-6 h-full">
                    @if(!empty($itt['image'] ?? null))
                      <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                        <img src="{{ IMG::get($itt['image']['file_name'], IMG::mergeWithDefaultOptions($itt['options'] ?? [], 'original')) }}" alt="{{ $itt['image_alt_text'] ?? '' }}" 
                              class="" />
                      </div>
                    @endif

                    <div class="w-full">
                      @if(!empty($itt['title'] ?? null) && !empty($itt['title_tag'] ?? null))
                        <{{ $itt['title_tag'] }} class="mt-8 text-20 font-medium tracking-tight text-gray-900 max-w-[250px] mx-auto">
                          {{ $itt['title'] }}
                        </{{ $itt['title_tag'] }}>
                      @endif

                      @if(!empty($itt['text'] ?? null))
                        <p class="mt-5 text-base text-gray-500">
                          {{ $itt['text'] }}
                        </p>
                      @endif
                    </div>
                  </div>
                </div>

                @if(!empty($itt['href'] ?? null))
                  </a>
                @endif
              </div>
            @endforeach
          @endif

      </x-ev.image-title-text-group>
    </div>

    {{-- Buttons --}}
    <div we-slot name="button_group_slot" we-title="Buttons" class="w-full mt-[40px]">
      <x-ev.link-button-group
          we-name="buttons"
          we-title="Buttons"
          {{-- class="{{ $data['button_group_slot']['components']['buttons']['data']['class'] ?? '' }}"" --}}
          class="w-full flex justify-center" 
          :button-group="$weData['button_group_slot']['components']['buttons']['data']['button_group'] ?? []">
      </x-ev.link-button-group>
    </div>

  </div>
</div>
