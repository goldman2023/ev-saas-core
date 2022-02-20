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

<x-livewire-tables::table.cell class="align-middle position-static">
    <div class="btn-group position-static" role="group" x-data="{ isOpen: false }" x-cloak>
        <a class="btn btn-sm btn-white d-flex align-items-center" href="{{ route('attributes.edit', ['id' => $row->id]) }}">
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
                <div wire:click="removeAttribute({{ $row->id }})" class="d-flex align-items-center px-3 py-3 pr-4 text-body text-14  border-top pointer">
                    @svg('heroicon-o-trash', ['class' => 'text-primary square-18'])
                    <span class="ml-2">{{ translate('Remove attribute') }}</span>
                </div>
            </li>
        </ul>
    </div>
</x-livewire-tables::table.cell>
