{{-- <x-livewire-tables::table.cell class="align-middle ">
    <a class="media items-center text-14" href="{{ route('plan.edit', ['id' => $row->id]) }}">
        #{{ $row->id }}
    </a>
</x-livewire-tables::table.cell> --}}

<x-livewire-tables::table.cell class="align-middle ">
    {{ $row->getTranslation('name') }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="hidden md:table-cell align-middle text-center">
    <strong class="text-14">1</strong>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="hidden md:table-cell align-middle text-center">
    <strong class="text-14">{{ \FX::formatPrice($row->total_price) }}</strong>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle static ">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        <a class="btn btn-white flex items-center mr-2" href="#">
            @svg('heroicon-o-eye', ['class' => 'w-[18px] h-[18px] mr-2']) {{ translate('View') }}
        </a>

        @if(!get_tenant_setting('multiplan_purchase'))
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
                        @svg('heroicon-o-arrow-circle-up', ['class' => 'w-[18px] h-[18px]'])
                        <span class="ml-2">{{ translate('Upgrade Plan') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ $row?->getSingleCheckoutPermalink() ?? '#' }}" target="_blank" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14">
                        @svg('heroicon-o-arrow-circle-down', ['class' => 'w-[18px] h-[18px]'])
                        <span class="ml-2">{{ translate('Downgrade Plan') }}</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14  border-t">
                        @svg('heroicon-o-trash', ['class' => 'text-danger w-[18px] h-[18px]'])
                        <span class="ml-2">{{ translate('Cancel plan') }}</span>
                    </a>
                </li>
            </ul>
        @endif
        
    </div>
</x-livewire-tables::table.cell>
