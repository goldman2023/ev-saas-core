<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    <a class="media align-items-center text-14" href="{{ route('order.details', ['id' => $row->id]) }}">
        #{{ $row->id }}
        @if(!$row->viewed)
            <span class="ml-2 badge badge-warning">{{ translate('New') }}</span>
        @endif
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    <span class="d-block text-14 mb-0 {{ $row->type === \App\Enums\OrderTypeEnum::subscription()->value ? 'text-info':'' }} {{ $row->type === App\Enums\OrderTypeEnum::installments()->value ? 'text-warning':'' }}">{{ $row->type }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    @isset($row->user)
        <a class="media align-items-center text-14" href="{{ route('user.details', ['id' => $row->user->id]) }}">
            <strong> {{ $row->user->name }} {{ $row->user->surname }} </strong> <br>
            {{ $row->user->email }}
        </a>
     @endisset

    {{-- <span class="text-14">{{ $row->billing_first_name.' '.$row->billing_last_name }}</span> --}}
</x-livewire-tables::table.cell>


<x-livewire-tables::table.cell class="align-middle">
    <span class="d-block text-14 mb-0">{{ $row->created_at->format('d M, Y H:i') }}</span>
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

<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    <strong class="text-14">{{ \FX::formatPrice($row->total_price) }}</strong>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        <a class="btn btn-white flex items-center mr-2" href="{{ route('order.details', ['id' => $row->id]) }}">
            @svg('heroicon-o-eye', ['class' => 'w-[18px] h-[18px] mr-2']) {{ translate('View') }}
        </a>

        <button
            @click="isOpen = !isOpen"
            @keydown.escape="isOpen = false"
            class="flex items-center btn"
        >
            @svg('heroicon-o-chevron-down', ['class' => 'w-[18px] h-[18px]'])
        </button>
        <ul x-show="isOpen"
            @click.outside="isOpen = false"
            class="absolute bg-white z-10 list-none p-0 border rounded mt-10 shadow"
        >
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
