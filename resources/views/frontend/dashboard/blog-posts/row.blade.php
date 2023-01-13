<x-livewire-tables::table.cell class="align-middle">

    <a class="media align-items-center text-12 mt-1" href="{{ route('blog.post.edit', ['id' => $row->id]) }}">
        <div class="w-full">

            <img class="rounded max-w-[150px] mx-auto inline-block" src="{{ $row->getThumbnail() }}" />
        </div>

        #{{ $row->id }}
    </a>

</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-start font-medium text-md">
    <div class="max-w-[250px] text-left whitespace-normal">
        {{ $row->getTranslation('name') }}
    </div>
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

<x-livewire-tables::table.cell class="align-middle text-center">
    @if($row->subscription_only)
    <span class="badge-warning">
        {{ translate('Subscription') }}
    </span>
    @else
    <span class="badge-dark">
        {{ translate('Free') }}
    </span>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <span class="d-block text-14 mb-0">{{ $row->updated_at?->diffForhumans() ?? '' }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        <a href="{{ $row->getPermalink() }}" target="_blank" class="btn btn-white flex items-center mr-2">
            @svg('heroicon-o-eye', ['class' => 'w-[18px] h-[18px]'])
            <span class="ml-2">{{ translate('Preview') }}</span>
        </a>
        <a class="btn btn-white flex items-center mr-2" href="{{ route('blog.post.edit', ['id' => $row->id]) }}">
            @svg('heroicon-o-pencil', ['class' => 'w-[18px] h-[18px] mr-2']) {{ translate('Edit') }}
        </a>

        <button @click="isOpen = !isOpen" @keydown.escape="isOpen = false" class="flex items-center btn">
            @svg('heroicon-o-chevron-down', ['class' => 'w-[18px] h-[18px]'])
        </button>
        <ul x-show="isOpen" @click.away="isOpen = false"
            class="absolute bg-white z-10 list-none p-0 border rounded mt-10 shadow">
            <li>
                <a href="#" target="_blank" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14">
                    @svg('heroicon-o-eye', ['class' => 'w-[18px] h-[18px]'])
                    <span class="ml-2">{{ translate('Preview') }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14  border-t">
                    @svg('heroicon-o-trash', ['class' => 'text-danger w-[18px] h-[18px]'])
                    <span class="ml-2">{{ translate('Remove post') }}</span>
                </a>
            </li>
        </ul>
    </div>
</x-livewire-tables::table.cell>
