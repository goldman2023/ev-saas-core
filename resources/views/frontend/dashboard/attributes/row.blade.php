<x-livewire-tables::table.cell class="align-middle">
    {{-- route('blog.post.edit', ['id' => $row->id]) --}}
    <a class="media align-items-center text-14" href="{{ '#' }}">
        #{{ $row->id }}
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    {{ $row->getTranslation('name') }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <span>{{ $row->type }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    @if($row->filterable)
        <span class="badge badge-soft-info">
          <span class="legend-indicator bg-info mr-1"></span> {{ translate('Filterable') }}
        </span>
    @else
        <span class="badge badge-soft-dark">
          <span class="legend-indicator bg-dark mr-1"></span> {{ translate('Not filterable') }}
        </span>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <span class="d-block text-14 mb-0">{{ $row->created_at?->format('d.m.Y') ?? '' }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <div class="btn-group" role="group">
        <a class="btn btn-sm btn-white d-flex align-items-center" href="{{ route('attributes.edit', ['id' => $row->id]) }}">
            @svg('heroicon-o-pencil', ['class' => 'square-18 mr-2']) {{ translate('Edit') }}
        </a>
    </div>
</x-livewire-tables::table.cell>
