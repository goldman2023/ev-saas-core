<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    <a class="media align-items-center text-14" href="{{ route('order.details', ['id' => $row->id]) }}">
        <input type="checkbox" value="{{ $row->id }}" class="p-3 rounded mr-2" name="orders"
            @click="$dispatch('table-item-toggle', {table_id: '{{ $tableId }}', id: Number($event.target.getAttribute('value'))})" />
        @if(!$row->viewed)
        <span class="ml-1 badge badge-warning">{{ translate('New') }}</span>
        @endif
    </a>
</x-livewire-tables::table.cell>

{{-- <x-livewire-tables::table.cell class="align-middle text-center">
    <span
        class="d-block text-14 mb-0 {{ $row->type === \App\Enums\OrderTypeEnum::subscription()->value ? 'text-info':'' }} {{ $row->type === App\Enums\OrderTypeEnum::installments()->value ? 'text-warning':'' }}">{{
        $row->type }}</span>
</x-livewire-tables::table.cell> --}}
<x-livewire-tables::table.cell class="align-middle min-w-[300px] max-w-[300px]">
    <div class="flex">
        <a class="py-2 flex media whitespace-normal align-items-center text-14"
            href="{{ route('order.details', ['id' => $row->id]) }}">

            @isset($row->get_primary_order_item()->subject)
                <img src="{{ $row->get_primary_order_item()->subject->getThumbnail() }}" class="w-[75px] h-auto rounded mr-2"
                    width="50" height="50" alt="" />
            @endisset
            
            <strong class="text-md">
                {{ $row->get_primary_order_item()->name }}
                <span class="font-normal"> <br> {{ translate('Order') }} #{{ $row->id }} </span>
            </strong>
        </a>
    </div>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="min-h-[100px] align-middle max-w-[300px]">
    @isset($row->user)
    <div class="py-2">
        <a class="align-items-center text-14 line-clamp-1 overflow-hidden" href="{{ route('user.details', ['id' => $row->user->id]) }}">
            <strong> {{ $row->user->name }} {{ $row->user->surname }} </strong>
        </a>
            {{ $row->user->email }}
    </div>
    @endisset
</x-livewire-tables::table.cell>



{{-- Actions --}}
<x-livewire-tables::table.cell class="align-middle text-center">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        <button type="button" class="btn bg-gray-100 flex items-center mr-2"
            wire:click="incrementOrderCycleStatus({{ $row->id }})">
            @svg('heroicon-o-arrow-right', ['class' => 'w-[18px] h-[18px] mr-2']) {{ translate('Next Step') }}
        </button>

        <a class="btn btn-white flex items-center mr-2" href="{{ route('order.details', ['id' => $row->id]) }}">
            @svg('heroicon-o-eye', ['class' => 'w-[18px] h-[18px] mr-2']) {{ translate('View') }}
        </a>

        <button @click="isOpen = !isOpen" @keydown.escape="isOpen = false" class="flex items-center btn">
            @svg('heroicon-o-chevron-down', ['class' => 'w-[18px] h-[18px]'])
        </button>
        <ul x-show="isOpen" @click.outside="isOpen = false"
            class="absolute bg-white z-10 list-none p-0 border rounded mt-10 shadow">
            <li>
                <a class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14" href="{{ $row->getPermalink() }} "
                    target="_blank">
                    @svg('heroicon-o-eye', ['class' => 'w-[18px] h-[18px] mr-2'])
                    <span class="ml-2">{{ translate('Preview') }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-3 pr-4 text-danger text-14 border-t">
                    @svg('heroicon-o-trash', ['class' => 'text-danger w-[18px] h-[18px]'])
                    <span class="ml-2">{{ translate('Remove order') }}</span>
                </a>
            </li>
        </ul>
    </div>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    @if($row->tasks->where('type', 'printing')->count() > 0)
    <span class="badge-success">
        {{ translate('Printed') }}
    </span>
    @else
    <span class="badge-info">
        {{ translate('Not printed') }}
    </span>
    @endif
</x-livewire-tables::table.cell>





@if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('payment_status')))
<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    @if($row->payment_status === \App\Enums\PaymentStatusEnum::paid()->value)
    <span class="badge-success">
        {{ ucfirst($row->payment_status) }}
    </span>
    @elseif($row->payment_status === \App\Enums\PaymentStatusEnum::pending()->value)
    <span class="badge-info">
        {{ ucfirst($row->payment_status) }}
    </span>
    @elseif($row->payment_status === \App\Enums\PaymentStatusEnum::unpaid()->value)
    <span class="badge-danger">
        {{ ucfirst($row->payment_status) }}
    </span>
    @elseif($row->payment_status === \App\Enums\PaymentStatusEnum::canceled()->value)
    <span class="badge-warning">
        {{ ucfirst($row->payment_status) }}
    </span>
    @endif
</x-livewire-tables::table.cell>
@endif

<x-livewire-tables::table.cell class="align-middle">
    <span class="d-block text-14 mb-0">{{ $row->created_at->diffForHumans() }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    <strong class="text-14">{{ \FX::formatPrice($row->total_price) }}</strong>
</x-livewire-tables::table.cell>
