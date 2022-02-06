<x-livewire-tables::table.cell class="align-middle">
    <a class="media align-items-center text-14" href="{{ route('plan.edit', ['slug' => $row->slug]) }}">
        #{{ $row->id }}
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    {{ $row->getTranslation('title') }}
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

<x-livewire-tables::table.cell class="align-middle">
    <div class="btn-group" role="group">
        <a class="btn btn-sm btn-white d-flex align-items-center" href="{{ route('plan.edit', ['slug' => $row->slug]) }}">
            @svg('heroicon-o-pencil', ['class' => 'square-18 mr-2']) {{ translate('Edit') }}
        </a>
    </div>
</x-livewire-tables::table.cell>
