<x-livewire-tables::table.cell class="align-middle text-center">
    #{{ $row->license?->first()?->id ?? '' }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    {{ $row->license?->first()?->license_name ?? '' }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle  text-center">
    {{ $row->license?->first()?->license_type ?? '' }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle  text-center">
    {{ empty($row->license?->first()?->serial_number ?? null) ? translate('Generating...') : ($row->license?->first()?->serial_number ?? '') }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle  text-center">
    {{ date('d. M Y, H:i', $row->end_date ?? '') }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle static ">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        @do_action('view.dashboard.plans.row-license.actions.start')
        
        {{-- <a class="btn btn-white flex items-center mr-2" href="{{ route('plan.edit', ['id' => $row->id]) }}">
            @svg('heroicon-o-pencil', ['class' => 'w-[18px] h-[18px] mr-2']) {{ translate('Edit') }}
        </a>

        <button 
            @click="isOpen = !isOpen" 
            @keydown.escape="isOpen = false" 
            class="flex items-center btn" 
        >
            @svg('heroicon-o-chevron-down', ['class' => 'w-[18px] h-[18px]'])
        </button>
        <ul x-show="isOpen"
            @click.away="isOpen = false"
            class="absolute bg-white z-10 list-none p-0 border rounded mt-10 shadow"
        >
            <li>
                <a href="{{ $row?->getSingleCheckoutPermalink() ?? '#' }}" target="_blank" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14">
                    @svg('heroicon-o-link', ['class' => 'w-[18px] h-[18px]'])
                    <span class="ml-2">{{ translate('Copy checkout link') }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14  border-t">
                    @svg('heroicon-o-trash', ['class' => 'text-danger w-[18px] h-[18px]'])
                    <span class="ml-2">{{ translate('Remove plan') }}</span>
                </a>
            </li>
        </ul> --}}
    </div>
</x-livewire-tables::table.cell>