<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    <a class="media align-items-center text-14" href="{{ route('task.details', ['id' => $row->id]) }}">
        #{{ $row->id }}
        @if (!$row->viewed)
            <span class="ml-2 badge badge-warning">{{ translate('New') }}</span>
        @endif
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    {{ $row->name }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">

    @if ($row->type === App\Enums\TaskTypesEnum::issue()->value)
        <span class="badge-success">{{ ucfirst($row->type) }}</span>
    @elseif($row->type === App\Enums\TaskTypesEnum::payment()->value)
        <span class="badge-info">{{ ucfirst($row->type) }}</span>
    @elseif($row->type === App\Enums\TaskTypesEnum::improvement()->value)
        <span class="badge-danger">{{ ucfirst($row->type) }}</span>
    @elseif($row->type === App\Enums\TaskTypesEnum::other()->value)
        <span class="badge-purple">{{ ucfirst($row->type) }}</span>
    @elseif($row->type === App\Enums\TaskTypesEnum::request()->value)
        <span class="badge-info">{{ ucfirst($row->type) }}</span>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">

    @if ($row->status === App\Enums\TaskStatusEnum::scoping()->value)
        <span class="badge-success">{{ ucfirst($row->status) }}</span>
    @elseif($row->status === App\Enums\TaskStatusEnum::backlog()->value)
        <span class="badge-info">{{ ucfirst($row->status) }}</span>
    @elseif($row->status === App\Enums\TaskStatusEnum::in_progress()->value)
        <span class="badge-danger">{{ ucfirst($row->status) }}</span>
    @elseif($row->status === App\Enums\TaskStatusEnum::review()->value)
        <span class="badge-purple">{{ ucfirst($row->status) }}</span>
    @elseif($row->status === App\Enums\TaskStatusEnum::done()->value)
        <span class="badge-info">{{ ucfirst($row->status) }}</span>
    @endif

</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <a class="media align-items-center text-14" href="{{ route('user.details', ['id' => $row->assignee_id]) }}">
        @php
            $user = App\Models\User::where('id', $row->assignee_id)->first();
        @endphp
        @if (!empty($user->thumbnail))
            <img class="h-10 w-10 rounded-full border-3 ring-2 border-gray-200 mr-3 object-cover shrink-0"
                src="{{ $user->getThumbnail(['w' => '120']) }}" />
        @endif
        <span class="text-blue-600"> {{ $user->name . ' ' . $user->surname }}</span>
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <a class="media align-items-center text-14" href="{{ route('user.details', ['id' => $row->user_id]) }}">
        @php
            $user = App\Models\User::where('id', $row->user_id)->first();
        @endphp
        @if (!empty($user->thumbnail))
            <img class="h-10 w-10 rounded-full border-3 ring-2 border-gray-200 mr-3 object-cover shrink-0"
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
