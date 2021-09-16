<div>
    {{-- TODO: Make nice icon and general styling --}}
    {{-- TODO: Make nice icon and general styling --}}
    <button wire:click.prevent="editLabel()"
    style="position:absolute; left: 100%; margin-left: 10px; top: 0;"
            class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary card-unfold rounded-circle"
            href="javascript:;">
            @svg('heroicon-o-pencil-alt')
            {{ translate('edit') }}
        </button>

    @if ($show_input_field)
        {{-- TODO: Improve UX and UI of this element --}}
        <div class="absolute top-0 bg-white p-3 rounded-md shadow-xl z-90" style="z-index: 99999">
            <div class="card">
                <div class="card-body">
            <div class="ev-livewire-input-row">
                {{-- TODO: Make option to select from existing files --}}
                <label for="email" class="block text-sm font-medium text-gray-700">
                    {{ translate('Edit Link') }}
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <div class="relative flex items-stretch flex-grow focus-within:z-10">
                        <input wire:model.defer="href.value" type="text" name="src" id="src" style="min-width: 300px;"
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300"
                            placeholder="{{ translate('Enter Text') }}">

                    </div>

                </div>


            </div>

            <div class="ev-livewire-input-row">
                {{-- TODO: Make option to select from existing files --}}
                <label for="image-link" class="block text-sm font-medium text-gray-700">
                    {{ translate('Edit Link Text') }}
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <div class="relative flex items-stretch flex-grow focus-within:z-10">
                        <input wire:model.defer="label.value" type="text" name="href" id="image-link" style="min-width: 300px;"
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300"
                            placeholder="{{ translate('Enter Text') }}">
                    </div>

                </div>


            </div>
            </div>

            <div>
                <button type="button" wire:click.prevent="updateLabel()"
                    class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    <!-- Heroicon name: solid/sort-ascending -->
                    <span>{{ translate('Save') }} </span>
                </button>
                <button wire:click.prevent="close()" class="btn btn-sm btn-danger ev-dynamic-close-button">
                    <span>{{ translate('Cancel') }} </span>
                </button>
            </div>
            </div>
        </div>
    @endif
</div>
