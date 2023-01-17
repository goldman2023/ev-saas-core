<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    <a class="media align-items-center text-14" href="{{ route('task.details', ['id' => $row->id]) }}">
        <input type="checkbox" value="{{ $row->id }}" class="p-2 rounded mr-2" name="orders"
            @click="$dispatch('table-item-toggle', {table_id: '{{ $tableId }}', id: Number($event.target.value)})"/>

        {{-- #{{ $row->id }} --}}
        @if (!$row->viewed)
            <span class="ml-2 badge badge-warning">{{ translate('New') }}</span>
        @endif
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    {{ $row->name }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    @if ($row->type === \WeThemes\WeBaltic\App\Enums\TaskTypesEnum::printing()->value)
        <span class="badge-info">{{ \Str::headline($row->type) }}</span>
    @elseif($row->type === \WeThemes\WeBaltic\App\Enums\TaskTypesEnum::delivery()->value)
        <span class="badge-dark">{{ \Str::headline($row->type) }}</span>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">

    @if ($row->status === \App\Enums\TaskStatusEnum::scoping()->value)
        <span class="badge-dark">{{ \Str::headline($row->status) }}</span>
    @elseif($row->status === \App\Enums\TaskStatusEnum::backlog()->value)
        <span class="badge-info">{{ \Str::headline($row->status) }}</span>
    @elseif($row->status === \App\Enums\TaskStatusEnum::in_progress()->value)
        <span class="badge-warning">{{ \Str::headline($row->status) }}</span>
    @elseif($row->status === \App\Enums\TaskStatusEnum::review()->value)
        <span class="badge-purple">{{ \Str::headline($row->status) }}</span>
    @elseif($row->status === \App\Enums\TaskStatusEnum::done()->value)
        <span class="badge-success">{{ \Str::headline($row->status) }}</span>
    @endif

</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <a class="media flex flex-col items-center text-14" href="{{ route('user.details', ['id' => $row->assignee_id]) }}">
        @php
            $user = App\Models\User::where('id', $row->assignee_id)->first();
        @endphp
        @if (!empty($user->thumbnail))
            <img class="h-6 w-6 rounded-full border-3 ring-2 border-gray-200 object-cover shrink-0 mb-2"
                src="{{ $user->getThumbnail(['w' => '120']) }}" />
        @endif
        <span class="text-blue-600"> {{ $user->name . ' ' . $user->surname }}</span>
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <a class="media flex flex-col items-center text-14" href="{{ route('user.details', ['id' => $row->user_id]) }}">
        @php
            $user = App\Models\User::where('id', $row->user_id)->first();
        @endphp
        @if (!empty($user->thumbnail))
            <img class="h-6 w-6 rounded-full border-3 ring-2 border-gray-200 object-cover shrink-0 mb-2"
                src="{{ $user->getThumbnail(['w' => '120']) }}" />
        @endif
        <span class="text-blue-600"> {{ $user->name . ' ' . $user->surname }}</span>
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    {{ $row->created_at }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        <a class="btn btn-white flex items-center mr-2" href="{{ route('task.details', ['id' => $row->id]) }}">
            @svg('heroicon-o-eye', ['class' => 'w-[18px] h-[18px] mr-2']) {{ translate('View') }}
        </a>

        <button @click="isOpen = !isOpen" @keydown.escape="isOpen = false" class="flex items-center btn">
            @svg('heroicon-o-chevron-down', ['class' => 'w-[18px] h-[18px]'])
        </button>
        <ul x-show="isOpen" @click.outside="isOpen = false"
            class="absolute bg-white z-10 list-none p-0 border rounded mt-10 shadow">
            <li>
                <a class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14"
                    href="{{ route('task.edit', ['id' => $row->id]) }} " target="_blank">
                    @svg('heroicon-o-pencil', ['class' => 'w-[18px] h-[18px] mr-2'])
                    <span class="ml-2">{{ translate('Edit') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('task.destroy', ['id' => $row->id]) }}" class="flex items-center px-3 py-3 pr-4 text-danger text-14 border-t">
                    @svg('heroicon-o-trash', ['class' => 'text-danger w-[18px] h-[18px]'])
                    <span class="ml-2">{{ translate('Remove task') }}</span>
                </a>
            </li>
        </ul>
    </div>
</x-livewire-tables::table.cell>
