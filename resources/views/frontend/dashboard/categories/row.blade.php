<x-livewire-tables::table.cell class="align-middle ">
    <a class="media items-center text-14" href="{{ route('category.edit', ['id' => $row->id]) }}">
        #{{ $row->id }}
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle ">
    {{ $row->getTranslation('name') }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle ">
    @if($row->featured)
        <span class="badge-success">
            {{ translate('Featured') }}
        </span>
    @else
        <span class="badge-dark">
          {{ translate('Not featured') }}
        </span>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="hidden md:table-cell align-middle ">
    <strong class="text-14">{{ $row->descendants_count }}</strong>
</x-livewire-tables::table.cell>


<x-livewire-tables::table.cell class="align-middle ">
    <span class="d-block text-14 mb-0">{{ $row->created_at?->format('d.m.Y') ?? '' }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle static ">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        <a class="btn btn-white flex items-center mr-2" href="{{ route('category.edit', ['id' => $row->id]) }}">
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
                <a href="#" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14  border-t">
                    @svg('heroicon-o-trash', ['class' => 'text-danger w-[18px] h-[18px]'])
                    <span class="ml-2">{{ translate('Remove category') }}</span>
                </a>
            </li>
        </ul>
    </div>
</x-livewire-tables::table.cell>
