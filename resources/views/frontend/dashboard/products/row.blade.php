<x-livewire-tables::table.cell class="align-middle p-0">
    <a class="media align-items-center text-14" href="{{ route('product.details', $row->slug) }}">
        #{{ $row->id }}
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle" style="width: 150px; box-sizing: content-box;">
    <a class="media flex justify-center items-center text-14" href="{{ route('product.details', $row->slug) }}">
        <x-tenant.system.image alt="{{ $row->name }}" class="w-[80px] h-[60px] object-contain"
            fit="contain" :image="$row->getThumbnail()">
        </x-tenant.system.image>
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center" style="min-width: 200px;">
    <a href="{{ route('product.details', $row->slug) }}" class="">
        {{ $row->getTranslation('name') }}
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    @if($row->status === App\Enums\StatusEnum::published()->value)
        <span class="badge-success">
          {{ ucfirst($row->status) }}
        </span>
    @elseif($row->status === App\Enums\StatusEnum::draft()->value)
        <span class="badge-warning">
          {{ ucfirst($row->status) }}
        </span>
    @elseif($row->status === App\Enums\StatusEnum::pending()->value)
        <span class="badge-info">
          {{ ucfirst($row->status) }}
        </span>
    @elseif($row->status === App\Enums\StatusEnum::private()->value)
        <span class="badge-dark">
          {{ ucfirst($row->status) }}
        </span>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="hidden md:table-cell align-middle text-center">
    <strong class="text-14">{{ \FX::formatPrice($row->total_price) }}</strong>
</x-livewire-tables::table.cell>


<x-livewire-tables::table.cell class="align-middle text-center">
    @if($row->public_view_count() > 10)
        <span class="flex justify-center items-center text-14 mb-0 text-danger">
            @svg('heroicon-o-eye', ['class' => 'h-[12px] w-[12px] mr-1'])
            {{ $row->public_view_count() }}
        </span>
    @else
        <span class="flex justify-center items-center text-14 mb-0">
            @svg('heroicon-o-eye', ['class' => 'h-[12px] w-[12px] mr-1'])
            {{ $row->public_view_count() }}
        </span>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <span class="block text-14 mb-0 text-center">{{ $row->updated_at?->diffForHumans() }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle static">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        <a class="btn btn-white flex items-center mr-2" href="{{ route('product.edit', ['slug' => $row->slug]) }}">
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
            @click.outside="isOpen = false"
            class="absolute bg-white z-10 list-none p-0 border rounded mt-10 shadow"
        >
            <li>
                <a class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14" href="{{ $row->getPermalink() }}"
                    target="_blank">
                    @svg('heroicon-o-eye', ['class' => 'w-[18px] h-[18px] mr-2'])
                    <span class="ml-2">{{ translate('Preview') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ $row?->getSingleCheckoutPermalink() ?? '#' }}" target="_blank"
                    class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14">
                    @svg('heroicon-o-link', ['class' => 'w-[18px] h-[18px]'])
                    <span class="ml-2">{{ translate('Copy checkout link') }}</span>
                </a>
            </li>
            <li>
                <div wire:click="duplicateProduct({{ $row->id }})"
                    class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14 cursor-pointer">
                    @svg('heroicon-o-duplicate', ['class' => 'w-[18px] h-[18px]'])
                    <span class="ml-2">{{ translate('Duplicate product') }}</span>
                </div>
            </li>
            <li>
                <div class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14 cursor-pointer" wire:click="importToStripe({{ $row->id }})">
                    @svg('lineawesome-stripe', ['class' => 'w-[18px] h-[18px] mr-2'])
                    <span class="ml-2">{{ translate('Import to Stripe') }}</span>
                </div>
            </li>
            <li>
                <div @click="$dispatch('invoke-delete', {'model_id': {{ $row->id }}, 'model_class': '{{ base64_encode($row::class) }}'})" class="cursor-pointer flex items-center px-3 py-3 pr-4 text-red-500 text-14 border-t">
                    @svg('heroicon-o-trash', ['class' => 'text-red-500 w-[18px] h-[18px]'])
                    <span class="ml-2">{{ translate('Remove product') }}</span>
                </div>
            </li>
        </ul>
    </div>
</x-livewire-tables::table.cell>
