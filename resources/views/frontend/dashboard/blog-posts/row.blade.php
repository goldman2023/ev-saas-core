<x-livewire-tables::table.cell class="align-middle">
    <a class="media align-items-center text-14" href="{{ route('blog.posts.edit', ['slug' => $row->slug]) }}">
        #{{ $row->id }}
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    {{ $row->getTranslation('title') }}
{{--    <span class="d-block text-14 mb-0 {{ $row->type === App\Models\Order::TYPE_SUBSCRIPTION ? 'text-info':'' }} {{ $row->type === App\Models\Order::TYPE_INSTALLMENTS ? 'text-warning':'' }}">{{ $row->type }}</span>--}}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    @if($row->status === App\Models\BlogPost::STATUS_PUBLISHED)
        <span class="badge badge-soft-success">
          <span class="legend-indicator bg-success mr-1"></span> {{ ucfirst($row->status) }}
        </span>
    @elseif($row->status === App\Models\BlogPost::STATUS_DRAFT)
        <span class="badge badge-soft-warning">
          <span class="legend-indicator bg-warning mr-1"></span> {{ ucfirst($row->status) }}
        </span>
    @elseif($row->status === App\Models\BlogPost::STATUS_PENDING)
        <span class="badge badge-soft-info">
          <span class="legend-indicator bg-info mr-1"></span> {{ ucfirst($row->status) }}
        </span>
    @elseif($row->status === App\Models\BlogPost::STATUS_PRIVATE)
        <span class="badge badge-soft-dark">
          <span class="legend-indicator bg-dark mr-1"></span> {{ ucfirst($row->status) }}
        </span>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    @if($row->subscription_only)
        <span class="badge badge-soft-warning">
          <span class="legend-indicator bg-warning mr-1"></span> {{ translate('Subscription') }}
        </span>
    @else
        <span class="badge badge-soft-dark">
          <span class="legend-indicator bg-dark mr-1"></span> {{ translate('Free') }}
        </span>
    @endif
</x-livewire-tables::table.cell>


<x-livewire-tables::table.cell class="align-middle">
    <span class="d-block text-14 mb-0">{{ $row->created_at?->format('d.m.Y') ?? '' }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <span class="d-block text-14 mb-0">{{ $row->updated_at?->format('d.m.Y') ?? '' }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <div class="btn-group" role="group">
        <a class="btn btn-sm btn-white d-flex align-items-center" href="{{ route('blog.posts.edit', ['slug' => $row->slug]) }}">
            @svg('heroicon-o-eye', ['class' => 'square-18 mr-2']) {{ translate('View') }}
        </a>
    </div>
</x-livewire-tables::table.cell>
