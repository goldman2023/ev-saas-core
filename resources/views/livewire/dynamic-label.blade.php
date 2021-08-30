<div class="relative">
    {!! $label->value !!}

    
    
    {{-- <x-ev.dynamic-components.edit-dropdown>
    </x-ev.dynamic-components.edit-dropdown> --}}

    @if ($show_input_field)
        {{-- TODO: Improve UX and UI of this element --}}
        <div class="position-absolute bottom-100 left-0 bg-white" style="z-index: 99999">


            <label for="email" class="block text-sm font-medium text-gray-700">
                {{ translate('Edit Label') }}
            </label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <div class="relative flex items-stretch flex-grow focus-within:z-10">
                    @if ($type === 'text')
                        <input wire:model.defer="label.value" type="text" name="email" id="email"
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300"
                            placeholder="{{ translate('Enter Text') }}">
                    @elseif($type === 'textarea')
                        <textarea wire:model.defer="label.value">
                        </textarea>
                    @endif
                </div>
                <button type="button" wire:click.prevent="updateLabel()"
                    class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    <!-- Heroicon name: solid/sort-ascending -->

                    <span>{{ translate('Save') }} </span>
                </button>
            </div>
        </div>


    @endif

    {{-- TODO: Make nice icon and general styling --}}
    <button wire:click.prevent="editLabel()" class="btn btn-sm btn-primary">
        {{ translate('Edit') }} {{ $info }}
    </button>

</div>
