<div class="flex flex-col {{ $component_data['class'] ?? '' }}" x-data="{
    buttons: @js(empty($component_data['button_group'] ?? []) ? [] : $component_data['button_group']),
    button_template: @js(App\View\Components\Ev\LinkButton::getDefaultData()),
    count() {
      if(this.buttons === undefined || this.buttons === null) {
        this.buttons = [this.button_template];
      }

      return this.buttons.length;
    },
    add() {
      {{-- let template = this.button_template; --}}
      this.buttons.push(this.button_template);
    },
    remove(index) {
      this.buttons.splice(index, 1);
    }
}" 
x-init="$watch('buttons', buttons => $wire.set('section.data.{{ $slot_name }}.components.{{ $component_name }}.data.button_group', buttons))"
wire:ignore>
    <template x-for="(button, index) in buttons">
      <div class="w-full border border-gray-200 rounded mt-2 first-of-type:mt-0" x-data="{
          open: false,
        }" :key="index" x-init="console.log(button)">

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
                <input type="text" x-model="buttons[index].label" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
              </div>
            </div>
          </div>
          
          <div class="flex px-2 py-2 border-t border-gray-200 mt-3" x-on:click="remove(buttons.indexOf(button))">
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