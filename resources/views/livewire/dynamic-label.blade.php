<div class="relative">
    {!! $label->value !!}

    <button wire:click.prevent="editLabel()" class="text-xs">
        {{ translate('Edit') }}
    </button>



    @if ($show_input_field)
        <div class="absolute top-0">

            <input type="text" wire:model="label.value" class="mt-2 text-sm sm:text-base pl-2 pr-4
        rounded-lg border border-gray-400 w-full py-2
        focus:outline-none focus:border-blue-400" />

            <button wire:click.prevent="updateLabel()">
                {{ translate('Save') }}
            </button>

        </div>
    @endif
</div>
