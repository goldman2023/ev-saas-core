@php 
  $image = 'section.data.'.$slot_name.'.components.'.$component_name.'.data';
  $image_id = str_replace('.', '-', $image);
@endphp
<div class="w-full flex flex-col relative {{ $component_data['class'] ?? '' }}">
    {{-- Image src --}}
    <div class="w-full" x-data="{
        id: '{{ $image_id }}'
      }" 
      x-on:we-media-selected-event.window="
        if($event.detail.for_id === id) {
            {{ $image }}.src = $event.detail.selected[0] || '';
        }
      "
    >
      <label class="block text-sm font-medium text-gray-700 pb-2"> {{ translate('Image') }} </label>
      
      <div class="mt-1 sm:mt-0 sm:col-span-2 cursor-pointer" >
        <div class="max-w-lg flex justify-center border-2 border-gray-300 border-dashed rounded-md"
             :class="{'px-6 pt-5 pb-6':{{ $image }}.src.length <= 0}"
             x-on:click="$wire.emit('showMediaLibrary', '{{ $image_id }}', 'section-background-mobile', [{{ $image }}.src])">
          
          <template x-if="{{ $image }}.src.length > 0">
            <div class="h-[200px] w-full rounded cursor-pointer">
              <img class="w-full h-[200px] object-cover" x-bind:src="window.WE.IMG.url({{ $image }}.src)" />
            </div>
          </template>

          <template x-if="{{ $image }}.src <= 0">
            <div class="space-y-1 text-center">
              <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" />
              </svg>
              <div class="flex text-sm text-gray-600">
                <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                  <span>{{ translate('Select a file') }}</span>
                </label>
                <p class="pl-1">{{ translate('or drag and drop') }}</p>
              </div>
              <p class="text-xs text-gray-500">{{ translate('PNG, JPG, GIF up to 3MB') }}</p>
            </div>
          </template>
          
        </div>
      </div>


      <x-we-edit.field-partials.collapsable title="{{ translate('Advanced options') }}" class="col-span-10 mt-4 mb-2" content-class="grid grid-cols-10 gap-3">
        {{-- Alt text --}}
        <div class="col-span-10">
          <label class="block text-14 font-medium text-gray-700">{{ translate('Alt text') }}</label>
          <div class="mt-1">
            <input type="text" x-model.lazy="{{ $image }}.alt_text" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
          </div>
        </div>
        
        {{-- Href --}}
        <div class="col-span-6">
          <label class="block text-14 font-medium text-gray-700">{{ translate('Url') }}</label>
          <div class="mt-1">
            <input type="text" x-model.lazy="{{ $image }}.href" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
          </div>
        </div>

        {{-- Link Target --}}
        <div class="col-span-4" x-data="{
          open: false,
          items: @js(\App\Enums\HrefTargetEnum::labels()),
        }" >
            <label id="listbox-label" class="block text-sm font-medium text-gray-700">{{ translate('Target') }}</label>
            
            <div class="mt-1 relative">
              <button x-on:click="open = !open" type="button" class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                <span class="block truncate" x-text="items[{{ $image }}.target]"></span>
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
    
                <template x-for="[target, label] of Object.entries(items)">
                  <li class="text-gray-900 hover:text-white hover:bg-indigo-600 cursor-pointer select-none relative py-2 pl-3 pr-9" role="option" 
                      x-on:click="{{ $image }}.target = target; open = false;">
                    <span class="block truncate" x-bind:class="{'font-semibold': target === {{ $image }}.target, 'font-normal': target !== {{ $image }}.target}" x-text="label"></span>
            
                    <span class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4" x-show="target === {{ $image }}.target">
                      @svg('heroicon-s-check', ['class' => 'h-5 w-5'])
                    </span>
                  </li>
                </template>
              </ul>
            </div>
        </div>

        {{-- Extra classes --}}
        <div class="col-span-10">
          <label class="block text-14 font-medium text-gray-700">{{ translate('Extra classes') }}</label>
          <div class="mt-1">
            <input type="text" x-model.lazy="{{ $image }}.class" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
          </div>
        </div>
      </x-we-edit.field-partials.collapsable>

    </div>
</div>