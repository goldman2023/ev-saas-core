<x-livewire-tables::table.cell class="align-middle">
    <a class="media align-items-center text-14" href="{{ route('plan.edit', ['id' => $row->id]) }}">
        #{{ $row->id }}
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    {{ $row->getTranslation('name') }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    @if($row->status === App\Enums\StatusEnum::published()->value)
        <span class="badge badge-soft-success">
          <span class="legend-indicator bg-success mr-1"></span> {{ ucfirst($row->status) }}
        </span>
    @elseif($row->status === App\Enums\StatusEnum::draft()->value)
        <span class="badge badge-soft-warning">
          <span class="legend-indicator bg-warning mr-1"></span> {{ ucfirst($row->status) }}
        </span>
    @elseif($row->status === App\Enums\StatusEnum::pending()->value)
        <span class="badge badge-soft-info">
          <span class="legend-indicator bg-info mr-1"></span> {{ ucfirst($row->status) }}
        </span>
    @elseif($row->status === App\Enums\StatusEnum::private()->value)
        <span class="badge badge-soft-dark">
          <span class="legend-indicator bg-dark mr-1"></span> {{ ucfirst($row->status) }}
        </span>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    <strong class="text-14">{{ \FX::formatPrice($row->total_price) }}</strong>
</x-livewire-tables::table.cell>


<x-livewire-tables::table.cell class="align-middle">
    <span class="d-block text-14 mb-0">{{ $row->created_at?->format('d.m.Y') ?? '' }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <span class="d-block text-14 mb-0">{{ $row->updated_at?->format('d.m.Y') ?? '' }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle position-static">
    <div class="btn-group position-static" role="group" x-data="{ isOpen: false }" x-cloak>
        <a class="btn btn-sm btn-white d-flex align-items-center" href="{{ route('product.edit', ['slug' => $row->slug]) }}">
            @svg('heroicon-o-pencil', ['class' => 'square-18 mr-2']) {{ translate('Edit') }}
        </a>

        <button 
            @click="isOpen = !isOpen" 
            @keydown.escape="isOpen = false" 
            class="d-flex align-items-center btn btn-xs" 
        >
            @svg('heroicon-o-chevron-down', ['class' => 'square-18'])
        </button>
        <ul x-show="isOpen"
            @click.away="isOpen = false"
            class="position-absolute bg-white z-10 list-style-none p-0 border rounded mt-7 shadow"
        >
            <li>
                <a href="{{ $row?->getSingleCheckoutPermalink() ?? '#' }}" target="_blank" class="d-flex align-items-center px-3 py-3 pr-4 text-body text-14">
                    @svg('heroicon-o-link', ['class' => 'square-18'])
                    <span class="ml-2">{{ translate('Copy checkout link') }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="d-flex align-items-center px-3 py-3 pr-4 text-body text-14  border-top">
                    @svg('heroicon-o-trash', ['class' => 'text-primary square-18'])
                    <span class="ml-2">{{ translate('Remove product') }}</span>
                </a>
            </li>
        </ul>
    </div>
</x-livewire-tables::table.cell>
