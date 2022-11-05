<x-livewire-tables::table.cell class="align-middle">
    {{-- route('blog.post.edit', ['id' => $row->id]) --}}
    <a class="media align-items-center text-14" href="{{ '#' }}">
        #{{ $row->id }}
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    {{ $row->name }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    <span>{{ $row->type }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    @if($row->filterable)
        <span class="badge-success">
            {{ translate('Filterable') }}
        </span>
    @else
        <span class="badge-dark">
            {{ translate('Not filterable') }}
        </span>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle  text-center">
    <span class="d-block text-14 mb-0">{{ $row->created_at?->format('d.m.Y') ?? '' }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle position-static">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        <a class="btn btn-white flex items-center mr-2" href="{{ route('attributes.edit', ['id' => $row->id]) }}">
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
                <a href="javascript:;" wire:click="removeAttribute({{ $row->id }})" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14  border-t">
                    @svg('heroicon-o-trash', ['class' => 'text-danger w-[18px] h-[18px]'])
                    <span class="ml-2">{{ translate('Remove attribute') }}</span>
                </a>
            </li>
        </ul>
    </div>
</x-livewire-tables::table.cell>
