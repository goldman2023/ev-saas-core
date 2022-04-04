@php 
  $label = 'section.data.'.$slot_name.'.components.'.$component_name.'.data';
@endphp
<div class="grid grid-cols-10 gap-4">
    <div class="col-span-7 ">
        <label class="block text-sm font-medium text-gray-700">{{ translate('Title') }}</label>
        <div class="mt-1">
          <input type="text" x-model.lazy="{{ $label }}.label" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
        </div>
    </div>
    @php
      $selected_tag = $label.'.tag';
    @endphp
    <div class="col-span-3" x-data="{
        open: false,
        items: @js(\App\Enums\TitleTagEnum::labels()),
      }" >

        <label id="listbox-label" class="block text-sm font-medium text-gray-700">{{ translate('Tag') }}</label>
        <div class="mt-1 relative">
          <button x-on:click="open = !open" type="button" class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
            <span class="block truncate" x-text="items[{{ $selected_tag }}]"></span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
              @svg('heroicon-s-selector', ['class' => 'h-5 w-5'])
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

            <template x-for="[tag, label] of Object.entries(items)" :key="tag">
              <li class="text-gray-900 hover:text-white hover:bg-indigo-600 cursor-pointer select-none relative py-2 pl-3 pr-9" role="option" 
                  x-on:click="{{ $selected_tag }} = tag; open = false;">
                <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                <span class="block truncate" x-bind:class="{'font-semibold': tag === {{ $selected_tag }}, 'font-normal': tag !== {{ $selected_tag }}}" x-text="label"></span>
        
                <span class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4" x-show="tag === {{ $selected_tag }}">
                  @svg('heroicon-s-check', ['class' => 'h-5 w-5'])
                </span>
              </li>
            </template>
          </ul>
        </div>
    </div>

    <x-we-edit.field-partials.collapsable title="{{ translate('Advanced options') }}" class="col-span-10 mt-1" content-class="grid grid-cols-10 gap-3">
      {{-- Extra classes --}}
      <div class="col-span-10">
        <label class="block text-14 font-medium text-gray-700">{{ translate('Extra classes') }}</label>
        <div class="mt-1">
          <input type="text" x-model.lazy="{{ $label }}.class" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
        </div>
      </div>
    </x-we-edit.field-partials.collapsable>
</div>