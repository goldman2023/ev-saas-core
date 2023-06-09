<x-livewire-tables::table.cell class="align-middle text-center">
    <div class="flex items-center h-[38px]">
    @isset($row->plan)
        {{ $row->plan->name }}
    @else
        {{ translate('No Plan') }}
    @endisset
    </div>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center h-8">
    @if(($row->data['cloud_service'] ?? 0) == 1)
        @svg('heroicon-o-check', ['class' => 'h-4 inline w-4 text-green-600'])
    @else
        @svg('heroicon-o-x-mark', ['class' => 'h-4 inline w-4 text-red-600'])
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    @if(($row->data['offline_service'] ?? 0)  == 1)
        @svg('heroicon-o-check', ['class' => 'text-center inline h-4 w-4 text-green-600'])
    @else
        @svg('heroicon-o-x-mark', ['class' => 'text-center inline h-4 w-4 text-red-600'])
    @endif
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

{{-- <x-livewire-tables::table.cell class="align-middle static ">
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
            class="absolute bg-white z-10 right-0 list-none p-0 border rounded mt-10 shadow overflow-hidden"
        >
            @do_action('view.dashboard.plans.row-license.actions.dropdown.start', $row)

        </ul>
    </div>
</x-livewire-tables::table.cell> --}}
