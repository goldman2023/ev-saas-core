<div class="relative">

    <div class="text-right">

        {{-- TODO: Make nice icon and general styling --}}
        <button wire:click.prevent="editLabel()"
            class="ev-edit-inline  js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary card-unfold rounded-circle"
            href="javascript:;">
            @svg('heroicon-o-pencil-square')
            {{ translate('edit') }}
        </button>
    </div>

    @if ($show_input_field)
    {{-- TODO: Improve UX and UI of this element --}}
    <div class="rounded-md shadow-xl z-90"
        style="position: fixed; top: 0; height: 100%; right: 0; background: #efefef; width: 350px;">
        <div class="card h-100" style="padding-top: 250px;">
            <div class="card-header">
                <h5>
                    {{ translate('Edit Image') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="ev-livewire-input-row">
                    {{-- TODO: Make option to select from existing files --}}
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        {{ translate('Edit Image Source') }}
                    </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <div class="relative flex items-stretch flex-grow focus-within:z-10">
                            <input wire:model.defer="src.value" type="text" name="src" id="src"
                                style="min-width: 300px;"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300"
                                placeholder="{{ translate('Enter Text') }}">

                        </div>

                    </div>


                </div>

                <div class="ev-livewire-input-row">
                    {{-- TODO: Make option to select from existing files --}}
                    <label for="image-link" class="block text-sm font-medium text-gray-700">
                        {{ translate('Edit Image Link') }}
                    </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <div class="relative flex items-stretch flex-grow focus-within:z-10">
                            <input wire:model.defer="href.value" type="text" name="href" id="image-link"
                                style="min-width: 300px;"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300"
                                placeholder="{{ translate('Enter Text') }}">
                        </div>

                    </div>


                </div>


            </div>

            <div class="card-footer">
                <button type="button" wire:click.prevent="updateLabel()"
                class="btn btn-success">
                <!-- Heroicon name: solid/sort-ascending -->
                <span>{{ translate('Save') }} </span>
            </button>

            <button type="button" wire:click.prevent="closeEditing()"
                class="btn btn-danger">
                <!-- Heroicon name: solid/sort-ascending -->
                <span>{{ translate('Close') }} </span>
            </button>
            </div>
        </div>

    </div>


    @endif
</div>
