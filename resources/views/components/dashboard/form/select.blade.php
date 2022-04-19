<div x-data="{
    open_dropdown: false,
    items: @js($items),
    displayed_items: @js($items),
    placeholder: '{{ $placeholder }}',
    nullable: @js($nullable),
    search: @js($search),
    search_query: '',
}" x-init="$watch('search_query', (value) => {
  let newItems = {};
  Object.entries(items).filter(entry => {
    if (entry[1].toLowerCase().indexOf(value.toLowerCase()) !== -1) {
      newItems[entry[0]] = entry[1];
      return true;
    }
  });

  displayed_items = newItems;
})" wire:ignore.self>
    <div class="relative" wire:ignore>
      <button type="button" @click="open_dropdown = !open_dropdown" 
              class="bg-white relative w-full max-w-lg border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-pointer focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm {{ $selectorClass ?? '' }} @error($field) is-invalid @enderror">
        <span class="block truncate" :class="{'text-gray-600':!items.hasOwnProperty({{ $selected }})}" x-text="items.hasOwnProperty({{ $selected }}) ? items[{{ $selected }}] : placeholder"></span>
        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
          @svg('heroicon-s-selector', ['class' => 'h-5 w-5 text-gray-400'])
        </span>
      </button>
  
      <ul class="absolute z-10 mt-1 w-full max-w-lg bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
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
              <li @click="{{ $selected }} = null; open_dropdown = false;" class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9">
                <span class="font-normal block truncate">{{ translate('Not selected') }}</span>
              </li>
            </template>

            <template x-for="(item, key) in displayed_items">
                <li @click="{{ $selected }} = key; open_dropdown = false;" class="text-gray-900 hover:bg-gray-200 cursor-pointer select-none relative py-2 pl-3 pr-9" role="option">
                    <span class="font-normal block truncate" :class="{'font-semibold': key == {{ $selected }}}" x-text="item"></span>
                    <span class="text-primary absolute inset-y-0 right-0 flex items-center pr-4" x-show="key == {{ $selected }}">
                      @svg('heroicon-o-check', ['class' => 'h-5 w-5'])
                    </span>
                </li>
            </template>
      </ul>
    </div>

    {{-- TODO: this does not work cuz of wire:ignore!, move it one step above --}}
    @if(!empty($field) && !$hideError)
        <x-system.invalid-msg field="{{ $field }}"></x-system.invalid-msg>
    @endif
</div>
  