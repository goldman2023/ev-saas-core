<div class="{{ $class }}" x-data="{
    open_dropdown: false,
    multiple: @js($multiple),
    {{-- TODO: Ordering of items is changed if numbers(ids) are keys - cuz of Array! --}}
    items: @js($items),
    displayed_items: @js($items),
    placeholder: '{{ $placeholder }}',
    nullable: @js($nullable),
    search: @js($search),
    search_query: '',
    countSelected() {
      if(Array.isArray({{ $selected }})) {
        return {{ $selected }}.length;
      } 
      return 0;
    },
    select(key) {
      if(this.multiple) {
        if(this.isSelected(key)) {
          this.deSelect(key);
        } else {
          {{ $selected }}.push(key);
        }
      } else {
        {{ $selected }} = key;
      }
    },
    deSelect(key) {
      {{ $selected }}.splice({{ $selected }}.indexOf(key), 1);
    },
    isSelected(key) {
      if(this.multiple) {
        return {{ $selected }}.indexOf(key) !== -1;
      } else {
        return {{ $selected }} == key;
      }
    }
}" 
x-init="
  if(this.multiple && !Array.isArray({{ $selected }})) {
    {{ $selected }} = new Array(0);
  }

  $watch('search_query', (value) => {
    let newItems = {};
    Object.entries(items).filter(entry => {
      if (entry[1].toLowerCase().indexOf(value.toLowerCase()) !== -1) {
        newItems[entry[0]] = entry[1];
        return true;
      }
    });

    displayed_items = newItems;
  });

  {!! $xAppendToInit !!}
"
{{-- x-effect="items = @js($items); console.log(items)"  --}}
@if(!empty($xShowIf)) x-show="{!! $xShowIf !!}" @endif
wire:ignore.self>
    <div class="relative" wire:ignore.self>

      <button type="button" @click="open_dropdown = !open_dropdown" 
              class="bg-white relative w-full max-w-lg border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-pointer focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm {{ $selectorClass ?? '' }} @error($errorField) is-invalid @enderror"
              :class="{'mb-3': multiple}">
        
        <template x-if="multiple">
          <span class="block truncate text-gray-600" x-text="placeholder"></span>
        </template>

        <template x-if="!multiple">
          <span class="block truncate" 
            :class="{'text-gray-600':!items.hasOwnProperty({{ $selected }})}" 
            x-text="items.hasOwnProperty({{ $selected }}) ? items[{{ $selected }}] : placeholder"></span>
        </template>

        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
          @svg('heroicon-s-chevron-up-down', ['class' => 'h-5 w-5 text-gray-400', 'wire:ignore'])
        </span>
      </button>

      <ul wire:ignore class="absolute z-10 mt-1 w-full max-w-lg bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
            x-show="open_dropdown"
            x-transition:enter=""
            x-transition:enter-start=""
            x-transition:enter-end=""
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click.outside="open_dropdown = false">

            <template x-if="search">
              <div class="w-full border-b border-gray-200 py-2 mb-0 px-2">
                <input type="text" class="form-standard w-full focus:ring-0 " placeholder="{{ translate('Search...') }}" x-model.debounce.500ms="search_query" />
              </div>
            </template>

            <template x-if="nullable">
              <li @click="event.stopPropagation(); select(null); if(!multiple) open_dropdown = false;" class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9">
                <span class="font-normal block truncate">{{ translate('Not selected') }}</span>
              </li>
            </template>

            <template x-for="(item, key) in displayed_items">
                <li @click="event.stopPropagation(); select(key); if(!multiple) open_dropdown = false;" class="text-gray-900 hover:bg-gray-200 cursor-pointer select-none relative py-2 pl-3 pr-9" role="option">
                    <span class="font-normal block truncate" :class="{'font-semibold': isSelected(key)}" x-text="item"></span>
                    <span class="text-primary absolute inset-y-0 right-0 flex items-center pr-4" x-show="isSelected(key)">
                      @svg('heroicon-o-check', ['class' => 'h-5 w-5'])
                    </span>
                </li>
            </template>
      </ul>

      <template x-if="multiple">
        <div class="w-full flex flex-wrap gap-x-2 gap-y-2">
            <template x-if="countSelected() > 0">
                <template x-for="(item, key) in {{ $selected }}">
                    <div class="bg-gray-400 text-gray-900 rounded relative px-2">
                        <span
                            class=""
                            x-text="items[item]"></span>
                        <button type="button"
                            class="px-1"
                            @click="event.stopPropagation(); deSelect(item)">
                            <span>×</span>
                        </button>
                    </div>
                </template>
            </template>
            <template x-if="countSelected() <= 0">
                <p class="block pb-2 text-14 text-gray-500">
                  {{ translate('No items selected...') }}
                </p>
            </template>
        </div>
      </template>
  
      
    </div>

    @if(!empty($errorField) && !$hideError)
        <x-system.invalid-msg field="{{ $errorField }}"></x-system.invalid-msg>
    @endif
</div>
  