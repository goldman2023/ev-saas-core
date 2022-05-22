<x-livewire-tables::table.cell class="align-middle ">
    <a class="media items-center text-14" href="{{ route('user.details', $row->id) }}">
        #{{ $row->id }}
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle ">
    <a href="{{ route('user.details', $row->id) }}" class="flex items-center" >
        @if(!empty($row->thumbnail))
            <img class="h-10 w-10 rounded-full border-3 ring-2 border-gray-200 mr-3 object-cover shrink-0" src="{{ $row->getThumbnail(['w' => '120']) }}" />
        @endif

        <div class="w-full flex flex-col ">
            <strong class="">{{ $row->name.' '.$row->surname }}</strong>
            <span class="">{{ $row->email }}</span>
        </div>
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    @if($row->user_type === \App\Enums\UserTypeEnum::customer()->value)
        <span class="badge-dark">
          {{ ucfirst($row->user_type) }}
        </span>
    @elseif($row->user_type === \App\Enums\UserTypeEnum::staff()->value)
        <span class="badge-warning">
          {{ ucfirst($row->user_type) }}
        </span>
    @elseif($row->user_type === \App\Enums\UserTypeEnum::seller()->value)
        <span class="badge-info">
          {{ ucfirst($row->user_type) }}
        </span>
    @elseif($row->user_type === \App\Enums\UserTypeEnum::admin()->value)
        <span class="badge-success">
          {{ ucfirst($row->user_type) }}
        </span>
    @endif
</x-livewire-tables::table.cell>
    
<x-livewire-tables::table.cell class="align-middle text-center">
    @if($row->entity === \App\Enums\UserEntityEnum::individual()->value)
        <span class="badge-dark">
        {{ ucfirst($row->entity) }}
        </span>
    @elseif($row->entity === \App\Enums\UserEntityEnum::company()->value)
        <span class="badge-info">
        {{ ucfirst($row->entity) }}
        </span>
    @endif 
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="hidden md:table-cell align-middle text-center">
    @if($row->isVerified())
        <span class="badge-success">
        {{ translate('Verified') }}
        </span>
    @else
        <span class="badge-danger">
        {{ translate('Not verified') }}
        </span>
    @endif 
</x-livewire-tables::table.cell>


<x-livewire-tables::table.cell class="align-middle ">
    <span class="block text-14 mb-0">{{ $row->created_at?->format('d.m.Y') ?? '' }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle static ">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        <a class="btn btn-white flex items-center mr-2" href="{{ route('user.details', $row->id) }}">
            @svg('heroicon-o-eye', ['class' => 'w-[18px] h-[18px] mr-2']) {{ translate('View') }}
        </a>

        {{-- <button 
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
                <a href="{{ $row?->getSingleCheckoutPermalink() ?? '#' }}" target="_blank" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14">
                    @svg('heroicon-o-link', ['class' => 'w-[18px] h-[18px]'])
                    <span class="ml-2">{{ translate('Copy checkout link') }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14  border-t">
                    @svg('heroicon-o-trash', ['class' => 'text-danger w-[18px] h-[18px]'])
                    <span class="ml-2">{{ translate('Remove plan') }}</span>
                </a>
            </li>
        </ul> --}}
    </div>
</x-livewire-tables::table.cell>
