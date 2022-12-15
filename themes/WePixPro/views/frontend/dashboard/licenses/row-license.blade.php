<x-livewire-tables::table.cell class="align-middle text-center">
    @isset($row->user)
        <a href="{{ route('user.details', $row->user->id) }}">
            {{ $row->user->email }} <br>

            @isset($row->plan)
                {{ $row->plan->name }}
            @else
                {{ translate('No Plan') }}
            @endisset
        </a>
    @else
        {{ translate('No User') }}
    @endisset
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    @isset($row->data['cloud_service'])
        @if($row->data['cloud_service'] == 1)
            @svg('heroicon-o-check', ['class' => 'h-4 inline w-4 text-green-600'])
        @else
            @svg('heroicon-o-x-mark', ['class' => 'h-4 inline w-4 text-red-600'])
        @endif
    @endisset

</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    @isset($row->data['offline_service'])

        @if($row->data['offline_service'] == 1)
            @svg('heroicon-o-check', ['class' => 'text-center inline h-4 w-4 text-green-600'])
        @else
            @svg('heroicon-o-x-mark', ['class' => 'text-center inline h-4 w-4 text-red-600'])
        @endif
    @endisset

</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    {{ !empty($row?->data['license_image_limit'] ?? null) ? $row?->data['license_image_limit'] : '-' }}
    {{ translate(' images') }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle  text-center">
    @isset($row->data['hardware_id'])
        {{ ($row->data['hardware_id'])}}
    @endisset
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle  text-center">
    {{ empty($row?->serial_number ?? null) ? translate('Generating...') : ($row?->serial_number ?? '') }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle  text-center">
    @isset($row->user_subscription)
    @if(!empty($row->user_subscription->first()?->end_date ?? false))
    @if($row->user_subscription->first()->end_date < now())
    <span class="text-red-600">  Expired:
    @endif

        {{ $row->user_subscription->first()->end_date->format('d. M Y, H:i') }}

        @if($row->user_subscription->first()->end_date < now())
    </span>
    @endif
    @elseif(!empty($row->getData('expiration_date')))
        @if($row->getData('expiration_date') < now())
        <span class="text-red-600"> Expired:
        @endif
        {{ \Carbon::createFromFormat('Y-m-d H:i:s', $row->getData('expiration_date'))->format('d. M Y, H:i') }}

        @if($row->getData('expiration_date') < now())
        </span>
        @endif
    @else
        -
    @endif
    @endisset
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle static ">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
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
            @if(empty($row?->data['hardware_id'] ?? null))
                <li>
                    <button type="button" class="w-full flex items-center px-3 py-3 pr-4 text-gray-900 text-14 hover:bg-primary hover:text-white"
                        @click="$dispatch('display-modal', {'id': 'pix-pro-generate-license', 'serial_number' : '{{ $row?->serial_number ?? '' }}', 'license_id': '{{ $row->id ?? '' }}'})">
                        @svg('heroicon-o-document-arrow-down', ['class' => 'w-[18px] h-[18px] mr-2'])
                        <span class="ml-2">{{ translate('Generate License') }}</span>
                    </button>
                </li>
            @endif
            
            @if(!empty($row?->data['hardware_id'] ?? null))
                <li class="border-t border-gray-200">
                    <button type="button" wire:click="downloadLicense({{ $row->id }})"
                        class="w-full flex items-center px-3 py-3 pr-4 text-gray-900 text-14 hover:bg-danger hover:text-white">
                        @svg('heroicon-o-document-arrow-down', ['class' => 'w-[18px] h-[18px] mr-2'])
                        <span class="ml-2">{{ translate('Download .DAT file') }}</span>
                    </button>
                </li>
                <li class="border-t border-gray-200">
                    <button type="button" wire:click="disconnect({{ $row->id }})"
                        class="w-full flex items-center px-3 py-3 pr-4 text-gray-900 text-14 hover:bg-danger hover:text-white">
                        @svg('heroicon-o-x-mark', ['class' => 'w-[18px] h-[18px] mr-2'])
                        <span class="ml-2">{{ translate('Deactivate') }}</span>
                    </button>
                </li>
            @endif
        </ul>
    </div>
</x-livewire-tables::table.cell>
