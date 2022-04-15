<div class="relative bg-white py-16 sm:py-24 lg:py-32 {!! $getSectionSettingsClasses !!}">
  <div class="mx-auto max-w-md px-4 text-center sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">

    {{-- ITT Group --}}
    <div we-slot name="itt_group_slot" we-title="Features" class="w-full">
      <x-ev.image-title-text-group
          we-name="itts"
          we-title="Features"
          class="grid gap-8 grid-cols-1  sm:grid-cols-2 lg:grid-cols-3 "
          :per_row="$weData['itt_group_slot']['components']['itts']['data']['per_row'] ?? []"
          :itt-group="$weData['itt_group_slot']['components']['itts']['data']['itt_group'] ?? []">

          {{-- Add component content here instead of the image-title-text-group.blade and use $component->{property} to get the properties --}}
          @if(!empty($component->ittGroup))
            @foreach($component->ittGroup as $itt)
              <div class="{{ $itt['class'] ?? '' }}">
                @if(!empty($itt['href'] ?? null))
                  <a class="block w-full" href="{{ $itt['href'] }}" target="{{ $itt['target'] ?? '_self' }}">
                @endif

                <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6">
                  <div class="w-full">
                    @if(!empty($itt['image'] ?? null))
                      <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
                        <img src="{{ IMG::get($itt['image']['file_name'], IMG::mergeWithDefaultOptions($itt['options'] ?? [], 'original')) }}" alt="{{ $itt['image_alt_text'] ?? '' }}" 
                              class="w-full object-cover" />
                      </div>
                    @endif

                    <div class="w-full text-left px-6">
                      @if(!empty($itt['title'] ?? null) && !empty($itt['title_tag'] ?? null))
                        <{{ $itt['title_tag'] }} class="mt-6 text-20 font-medium tracking-tight text-gray-900">
                          {{ $itt['title'] }}
                        </{{ $itt['title_tag'] }}>
                      @endif

                      @if(!empty($itt['text'] ?? null))
                        <p class="mt-3 text-base text-gray-500 line-clamp-5">
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
