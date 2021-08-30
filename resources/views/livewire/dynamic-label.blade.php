<div class="relative ev-dynamic-label-container">

    <span class="underline">{!! $label->value !!}</span>



    {{-- <x-ev.dynamic-components.edit-dropdown>
    </x-ev.dynamic-components.edit-dropdown> --}}

    @if ($show_input_field)
        {{-- TODO: Improve UX and UI of this element --}}
        <div class="ev-dynamic-input-field">
            <label for="email" class="block text-sm font-small text-black">
                {{ translate('Edit Label') }}
            </label>

            <button wire:click.prevent="close()" class="btn btn-sm btn-danger ev-dynamic-close-button">
                {{ translate('X') }}
            </button>

            <div class="mt-1">
                <div class="form-inline">
                    @if ($type === 'text')
                        <input wire:model.defer="label.value" type="text" name="email" id="email" class="form-control"
                            placeholder="{{ translate('Enter Text') }}">
                    @elseif($type === 'textarea')
                        <textarea wire:model.defer="label.value">
                        </textarea>
                    @endif

                    <button type="button" wire:click.prevent="updateLabel()" class="btn btn-sm btn-success ml-1">
                        <!-- Heroicon name: solid/sort-ascending -->

                        <span>{{ translate('Save') }} </span>
                    </button>
                </div>

            </div>
        </div>


    @endif

    {{-- TODO: Make nice icon and general styling --}}
    <button wire:click.prevent="editLabel()" class="btn btn-sm ev-dynamic-edit-button">
        {{ svg('heroicon-o-pencil-alt') }}
    </button>

</div>
