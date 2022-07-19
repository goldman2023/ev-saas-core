<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    <a class="media align-items-center text-14" href="{{ route('expense.details', ['id' => $row->id]) }}">
        #{{ $row->id }}
        @if(!$row->viewed)
            <span class="ml-2 badge badge-warning">{{ translate('New') }}</span>
        @endif
    </a>
</x-livewire-tables::table.cell>