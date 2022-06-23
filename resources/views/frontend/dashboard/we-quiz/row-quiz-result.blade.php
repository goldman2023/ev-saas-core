<x-livewire-tables::table.cell class="align-middle">
    <a class="media align-items-center text-14" href="{{ route('dashboard.we-quiz.result.details', ['id' => $row->id]) }}">
        #{{ $row->id }}
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <a href="{{ route('user.details', $row->user->id) }}" class="flex items-center" >
        @if(!empty($row->user->thumbnail))
            <img class="h-10 w-10 rounded-full border-3 ring-2 border-gray-200 mr-3 object-cover shrink-0" src="{{ $row->user->getThumbnail(['w' => '120']) }}" />
        @endif

        <div class="w-full flex flex-col ">
            <strong class="">{{ $row->user->name.' '.$row->user->surname }}</strong>
            <span class="">{{ $row->user->email }}</span>
        </div>
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    @if($row->quiz_passed)
        <span class="badge-success">{{ translate('Passed') }}</span>
    @else
        <span class="badge-warning">{{ translate('Not passed') }}</span>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <span class="d-block text-14 mb-0">{{ $row->created_at?->diffForHumans() }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        <a href="{{ route('dashboard.we-quiz.result.details', ['id' => $row->id]) }}" class="btn btn-white flex items-center mr-2">
            @svg('heroicon-o-eye', ['class' => 'w-[18px] h-[18px]'])
            <span class="ml-2">{{ translate('Details') }}</span>
        </a>
    </div>
</x-livewire-tables::table.cell>
