<div>
    {{-- TODO: Make nice icon and general styling --}}
    {{-- TODO: Make nice icon and general styling --}}
    <button wire:click.prevent="editLabel()" style="position:absolute; left: 100%; margin-left: 10px; top: 0;"
        class="ev-edit-inline  js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary card-unfold rounded-circle bg-white"
        href="javascript:;">
        @svg('heroicon-o-pencil-square')
        {{ translate('edit') }}
    </button>

    @if ($show_input_field)
    {{-- TODO: Improve UX and UI of this element --}}
    <div class="rounded-md shadow-xl z-90"
        style="position: fixed; top: 0; height: 100%; right: 0; background: #efefef; width: 350px;">
        <div class="card h-100" style="padding-top: 250px;">
            <div class="card-header">
                <h5>{{ translate('Edit Button') }}</h5>
            </div>
            <div class="card-body text-left">
                <div class="ev-livewire-input-row mb-3">
                    {{-- TODO: Make option to select from existing files --}}
                    <label for="email" class="">
                        {{ translate('Edit Link') }}
                    </label>
                    <div class="">
                        <div class="relative flex items-stretch flex-grow focus-within:z-10">
                            <input wire:model.defer="href.value" type="text" name="src" id="src"
                                style="min-width: 300px;"
                                class="form-control"
                                placeholder="{{ translate('Enter Text') }}">

                        </div>

                    </div>


                </div>

                <div class="ev-livewire-input-row mb-3">
                    {{-- TODO: Make option to select from existing files --}}
                    <label for="image-link" class="form-label">
                        {{ translate('Edit Link Text') }}
                    </label>
                    <div class="">
                        <div class="">
                            <input wire:model.defer="label.value" type="text" name="href" id="image-link"
                                style="min-width: 300px;" class="form-control"
                                placeholder="{{ translate('Enter Text') }}">
                        </div>

                    </div>


                </div>
            </div>
            <div class="card-footer text-left">
                <button type="button" wire:click.prevent="updateLabel()" class="btn btn-success">
                    <!-- Heroicon name: solid/sort-ascending -->
                    <span>{{ translate('Save') }} </span>
                </button>
                <button wire:click.prevent="close()" class="btn btn-danger ev-dynamic-close-button">
                    <span>{{ translate('Close') }} </span>
                </button>
            </div>

        </div>


    </div>
    @endif
</div>
