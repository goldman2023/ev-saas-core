<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    <a class="media align-items-center text-14" href="{{ route('order.details', ['id' => $row->id]) }}">
        #{{ $row->id }}
        @if(!$row->viewed)
            <span class="ml-2 badge badge-warning">{{ translate('New') }}</span>
        @endif
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <span class="d-block text-14 mb-0">{{ $row->created_at->format('d.m.Y H:i') }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <span class="text-14">{{ $row->billing_first_name.' '.$row->billing_last_name }}</span>
</x-livewire-tables::table.cell>

@if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('payment_status')))
<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    @if($row->payment_status === App\Models\Order::PAYMENT_STATUS_PAID)
        <span class="badge badge-soft-success">
          <span class="legend-indicator bg-success mr-1"></span> {{ ucfirst($row->payment_status) }}
        </span>
    @elseif($row->payment_status === App\Models\Order::PAYMENT_STATUS_PENDING)
        <span class="badge badge-soft-info">
          <span class="legend-indicator bg-info mr-1"></span> {{ ucfirst($row->payment_status) }}
        </span>
    @elseif($row->payment_status === App\Models\Order::PAYMENT_STATUS_UNPAID)
        <span class="badge badge-soft-danger">
          <span class="legend-indicator bg-danger mr-1"></span> {{ ucfirst($row->payment_status) }}
        </span>
    @elseif($row->payment_status === App\Models\Order::PAYMENT_STATUS_CANCELED)
        <span class="badge badge-soft-warning">
          <span class="legend-indicator bg-warning mr-1"></span> {{ ucfirst($row->payment_status) }}
        </span>
    @endif
</x-livewire-tables::table.cell>
@endif

@if (!$columnSelect || ($columnSelect && $this->isColumnSelectEnabled('shipping_status')))
<x-livewire-tables::table.cell class="hidden md:table-cell align-middle">
    @if($row->shipping_status === App\Models\Order::SHIPPING_STATUS_DELIVERED)
        <span class="badge badge-soft-success">
          <span class="legend-indicator bg-success mr-1"></span> {{ ucfirst($row->shipping_status) }}
        </span>
    @elseif($row->shipping_status === App\Models\Order::SHIPPING_STATUS_SENT)
        <span class="badge badge-soft-warning">
          <span class="legend-indicator bg-warning mr-1"></span> {{ ucfirst($row->shipping_status) }}
        </span>
    @elseif($row->shipping_status === App\Models\Order::SHIPPING_STATUS_NOT_SENT)
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
        <a class="btn btn-sm btn-white" href="{{ route('order.details', ['id' => $row->id]) }}">
            <i class="tio-visible-outlined"></i> {{ translate('View') }}
        </a>
    </div>
</x-livewire-tables::table.cell>
