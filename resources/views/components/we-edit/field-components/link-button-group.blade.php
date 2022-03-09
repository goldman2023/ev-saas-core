@php 
  $button_group = 'section.data.'.$slot_name.'.components.'.$component_name.'.data.button_group';
@endphp
<div class="flex flex-col relative {{ $component_data['class'] ?? '' }}" x-data="{
    buttons: @js(empty($component_data['button_group'] ?? []) ? [] : $component_data['button_group']),
    button_template: @js(App\View\Components\Ev\LinkButton::getDefaultData()),
    count() {
      if(this.buttons === undefined || this.buttons === null) {
        this.buttons = [this.button_template];
      }

      return {{ $button_group }}.length;
    },
    add() {
      {{ $button_group }}.push(JSON.parse(JSON.stringify(this.button_template)));
      {{-- $wire.set('section.data.{{ $slot_name }}.components.{{ $component_name }}.data.button_group', this.buttons); --}}
    },
    remove(index) {
      {{ $button_group }}.splice(index, 1);
      {{-- $wire.set('section.data.{{ $slot_name }}.components.{{ $component_name }}.data.button_group', this.buttons); --}}
    }
}"
wire:ignore>

    {{-- <x-tailwind-ui.system.spinner 
        class="absolute-center z-10 hidden"
        spinnerClass="w-6 h-6"
        wire:target="set('section.data.{{ $slot_name }}.components.{{ $component_name }}.data.button_group')"
        wire:loading.class.remove="hidden"></x-tailwind-ui.system.spinner> --}}

        {{-- wire:loading.class="prevent-pointer-events opacity-40" --}}
    <div class="w-full" >
      <template x-for="(button, index) in {{ $button_group }}">
        <div class="w-full border border-gray-200 rounded mt-2 first-of-type:mt-0" x-data="{
            open: false,
          }" >
          {{-- x-init="$watch('button', button => $wire.set('section.data.{{ $slot_name }}.components.{{ $component_name }}.data.button_group.'+index, button))" --}}
          <div class="flex items-center justify-between bg-white px-3 py-2 cursor-pointer" :class="{'border-b border-gray-200':open}" x-on:click="open = !open">
            <div class="flex items-center">
              @svg('lineawesome-link-solid', ['class' => 'w-5 h-5 mr-3'])
              <h4 class="text-16 text-gray-900 line-clamp-1" x-text="button.label"></h4>
            </div>
  
            @svg('heroicon-o-chevron-down', ['class' => 'text-gray-600 sw-4 h-4', 'x-bind:class' => "{'rotate-180':open}"])
          </div>
      
          <div class="w-full " x-show="open">
            <div class="grid grid-cols-10 gap-3 p-3">
              {{-- Label input --}}
              <div class="col-span-10">
                <label class="block text-14 font-medium text-gray-700">{{ translate('Label') }}</label>
                <div class="mt-1">
                  <input type="text" x-model.lazy="button.label" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
              </div>

              {{-- Href input --}}
              <div class="col-span-6">
                <label class="block text-14 font-medium text-gray-700">{{ translate('Url') }}</label>
                <div class="mt-1">
                  <input type="text" x-model.lazy="button.href" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
              </div>

              <div class="col-span-4" x-data="{
                open: false,
                items: @js(\App\Enums\HrefTargetEnum::labels()),
                selectedTarget: button.target,
              }" >
              {{-- x-init="$watch('selectedTarget', selectedTarget => $wire.set('section.data.{{ $slot_name }}.components.{{ $component_name }}.data.button_group.'+index+'.target', selectedTarget))" --}}
                  <label id="listbox-label" class="block text-sm font-medium text-gray-700">{{ translate('Target') }}</label>
                  <div class="mt-1 relative">
                    <button x-on:click="open = !open" type="button" class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                      <span class="block truncate" x-text="items[{{ $button_group }}[index].target]"></span>
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
          
                      <template x-for="[target, label] of Object.entries(items)">
                        <li class="text-gray-900 hover:text-white hover:bg-indigo-600 cursor-pointer select-none relative py-2 pl-3 pr-9" role="option" 
                            x-on:click="{{ $button_group }}[index].target = target; open = false;">
                          <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                          <span class="block truncate" x-bind:class="{'font-semibold': target === {{ $button_group }}[index].target, 'font-normal': target !== {{ $button_group }}[index].target}" x-text="label"></span>
                  
                          <span class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4" x-show="target === {{ $button_group }}[index].target">
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
            </div>
            
            <div class="flex px-2 py-2 border-t border-gray-200 mt-3" x-on:click="remove(index)">
              <span class="flex items-center text-15 text-red-600 hover:text-red-800 hover:underline cursor-pointer ml-auto">
                @svg('lineawesome-trash-solid', ['class' => 'w-4 h-4 mr-2'])
                {{ translate('Remove') }}
              </span>
            </div>
          </div>
        </div>
      </template>
      
      <div class="w-full mt-2">
        <span class="text-14 text-sky-600 hover:text-sky-800 py-2 px-2 cursor-pointer" x-on:click="add()">+ {{ translate('Add new') }}</span>
      </div>
    </div>
    
</div>