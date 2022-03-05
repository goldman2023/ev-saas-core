<div class="grid grid-cols-10 gap-4">
    <div class="col-span-7 mb-2">
        <label for="email" class="block text-sm font-medium text-gray-700">{{ translate('Title') }}</label>
        <div class="mt-1">
          <input type="text" wire:model.lazy="section.data.{{ $slot_name }}.components.{{ $component_name }}.data.label" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
        </div>
    </div>
    <div class="col-span-3 mb-3" x-data="{
        open: false,
        items: @js(\App\Enums\TitleTagEnum::labels()),
        selectedTag: @js($component_data['tag']),
      }" x-init="$watch('open', tag => $wire.set('section.data.{{ $slot_name }}.components.{{ $component_name }}.data.tag', selectedTag))">
        <label id="listbox-label" class="block text-sm font-medium text-gray-700">{{ translate('Tag') }}</label>
        <div class="mt-1 relative">
          <button x-on:click="open = !open" type="button" class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
            <span class="block truncate" x-text="items[selectedTag]"></span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
              <!-- Heroicon name: solid/selector -->
              <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </span>
          </button>
      
          <ul class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" 
              x-on:click.away="open = false"
              x-show="open" 
              x-transition:enter=""
              x-transition:enter-start=""
              x-transition:enter-end=""
              x-transition:leave="transition ease-in duration-100"
              x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">

            <template x-for="[tag, label] of Object.entries(items)">
              <li class="text-gray-900 hover:text-white hover:bg-indigo-600 cursor-pointer select-none relative py-2 pl-3 pr-9" role="option" 
                  x-on:click="selectedTag = tag; open = false;">
                <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                <span class="block truncate" x-bind:class="{'font-semibold': tag === selectedTag, 'font-normal': tag !== selectedTag}" x-text="label"></span>
        
                <span class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4" x-show="tag === selectedTag">
                  <!-- Heroicon name: solid/check -->
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                </span>
              </li>
            </template>
          </ul>
        </div>
    </div>

    <div class="col-span-10">

    </div>

    {{-- <div class="w-full mb-3">
        <label for="email" class="block text-sm font-medium text-gray-700">{{ translate('Tag') }}</label>
        <div class="mt-1">
          <input type="text" wire:model.lazy="section.data.{{ $slot_name }}.components.{{ $component_name }}.data.tag" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
        </div>
    </div>

    <div class="w-full mb-3">
        <label for="email" class="block text-sm font-medium text-gray-700">{{ translate('ID') }}</label>
        <div class="mt-1">
          <input type="text" wire:model.lazy="section.data.{{ $slot_name }}.components.{{ $component_name }}.data.id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
        </div>
    </div> --}}
</div>