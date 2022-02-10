<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    <a class="media align-items-center text-14" href="{{ route('order.details', ['id' => $row->id]) }}">
        #{{ $row->id }}
        @if(!$row->viewed)
            <span class="ml-2 badge badge-warning">{{ translate('New') }}</span>
        @endif
    </a>
</x-livewire-tables::table.cell>

@if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('type')))
<x-livewire-tables::table.cell class="align-middle">
    <span class="d-block text-14 mb-0 {{ $row->type === App\Enums\OrderTypeEnum::subscription()->value ? 'text-info':'' }} {{ $row->type === App\Enum\OrderTypeEnum::installments()->value ? 'text-warning':'' }}">{{ $row->type }}</span>
</x-livewire-tables::table.cell>
@endif

<x-livewire-tables::table.cell class="align-middle">
    <span class="d-block text-14 mb-0">{{ $row->created_at->format('d.m.Y H:i') }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <span class="text-14">{{ $row->billing_first_name.' '.$row->billing_last_name }}</span>
</x-livewire-tables::table.cell>

@if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('payment_status')))
<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    @if($row->payment_status === App\Enums\PaymentStatusEnum::paid()->value)
        <span class="badge badge-soft-success">
          <span class="legend-indicator bg-success mr-1"></span> {{ ucfirst($row->payment_status) }}
        </span>
    @elseif($row->payment_status === App\Enums\PaymentStatusEnum::pending()->value)
        <span class="badge badge-soft-info">
          <span class="legend-indicator bg-info mr-1"></span> {{ ucfirst($row->payment_status) }}
        </span>
    @elseif($row->payment_status === App\Enums\PaymentStatusEnum::unpaid()->value)
        <span class="badge badge-soft-danger">
          <span class="legend-indicator bg-danger mr-1"></span> {{ ucfirst($row->payment_status) }}
        </span>
    @elseif($row->payment_status === App\Enums\PaymentStatusEnum::canceled()->value)
        <span class="badge badge-soft-warning">
          <span class="legend-indicator bg-warning mr-1"></span> {{ ucfirst($row->payment_status) }}
        </span>
    @endif
</x-livewire-tables::table.cell>
@endif

@if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('shipping_status')))
<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    @if($row->shipping_status === App\Enums\ShippingStatusEnum::delivered()->value)
        <span class="badge badge-soft-success">
          <span class="legend-indicator bg-success mr-1"></span> {{ ucfirst($row->shipping_status) }}
        </span>
    @elseif($row->shipping_status === App\Enums\ShippingStatusEnum::sent()->value)
        <span class="badge badge-soft-warning">
          <span class="legend-indicator bg-warning mr-1"></span> {{ ucfirst($row->shipping_status) }}
        </span>
    @elseif($row->shipping_status === App\Enums\ShippingStatusEnum::not_sent()->value)
        <span class="badge badge-soft-danger">
          <span class="legend-indicator bg-danger mr-1"></span> {{ \Str::replace('_', ' ', ucfirst($row->shipping_status)) }}
        </span>
    @endif
</x-livewire-tables::table.cell>
@endif

<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    <strong class="text-14">{{ \FX::formatPrice($row->total_price) }}</strong>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <div class="btn-group" role="group">
        <a class="btn btn-sm btn-white d-flex align-items-center" href="{{ route('order.details', ['id' => $row->id]) }}">
            @svg('heroicon-o-eye', ['class' => 'square-18 mr-2']) {{ translate('View') }}
        </a>
    </div>
</x-livewire-tables::table.cell>
