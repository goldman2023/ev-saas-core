<x-livewire-tables::table.cell class="align-middle text-center">
    #{{ $row->license?->first()?->id ?? '' }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle  text-center">
    {{ empty($row->license?->first()?->serial_number ?? null) ? translate('Generating...') : ($row->license?->first()?->serial_number ?? '') }}
</x-livewire-tables::table.cell>

@do_action('view.dashboard.row-license.columns', $row->license?->first())

<x-livewire-tables::table.cell class="align-middle  text-center">
    @if(!empty($row->end_date))
        {{ Carbon::createFromTimestamp($row->end_date ?? '')->format('d. M Y, H:i') }}
    @else
        -
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle static ">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        @do_action('view.dashboard.plans.row-license.actions.start', $row->license->first())

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
            @do_action('view.dashboard.plans.row-license.actions.dropdown.start', $row->license->first())

        </ul>
    </div>
</x-livewire-tables::table.cell>