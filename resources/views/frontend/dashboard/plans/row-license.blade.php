<x-livewire-tables::table.cell class="align-middle text-center">
    #{{ $row->id ?? '' }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle  text-center">
    {{ empty($row?->serial_number ?? null) ? translate('Generating...') : ($row?->serial_number ?? '') }}
</x-livewire-tables::table.cell>

@do_action('view.dashboard.row-license.columns', $row)

<x-livewire-tables::table.cell class="align-middle  text-center">
    @if(!empty($row->user_subscription->first()?->end_date ?? false))
        {{ $row->user_subscription->first()->end_date->format('d. M Y, H:i') }}
    @elseif(!empty($row->getData('expiration_date')))
        {{ \Carbon::createFromFormat('Y-m-d H:i:s', $row->getData('expiration_date'))->format('d. M Y, H:i') }}
    @else
        -
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle static ">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        @do_action('view.dashboard.plans.row-license.actions.start', $row)

        <button
            @click="isOpen = !isOpen"
            @keydown.escape="isOpen = false"
            class="flex items-center btn"
        >
            @svg('heroicon-o-chevron-down', ['class' => 'w-[18px] h-[18px]'])
        </button>
        <ul x-show="isOpen"
            @click.away="isOpen = false"
            class="absolute bg-white z-10 list-none p-0 border rounded mt-10 shadow overflow-hidden"
        >
            @do_action('view.dashboard.plans.row-license.actions.dropdown.start', $row)

        </ul>
    </div>
</x-livewire-tables::table.cell>
