<x-livewire-tables::table.cell class="align-middle text-left">
    <a class="media align-items-center text-14" href="{{ route('order.details', ['id' => $row->order->id]) }}">
        #{{ $row->id }}

        @if(!$row->viewed_by_customer && $row->user_id === auth()->user()->id)
            <span class="ml-2 badge badge-warning">{{ translate('New') }}</span>
        @endif
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-left">
    <a class="media align-items-center text-14" href="{{ route('order.details', ['id' => $row->order->id]) }}">
        #{{ $row->invoice_number }}
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-left">
    <a class="media align-items-center text-14" href="{{ route('order.details', ['id' => $row->order->id]) }}">
        #{{ $row->order->id }}
    </a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-left">
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


<x-livewire-tables::table.cell class="align-middle text-left">
    <strong class="text-14">{{ \FX::formatPrice($row->total_price) }}</strong>
</x-livewire-tables::table.cell>


<x-livewire-tables::table.cell class="align-middle text-left">
    <span class="d-block text-14 mb-0">{{ !empty($row->end_date) ? date('d M, Y', $row->end_date) : '/' }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        <a class="btn btn-primary flex items-center mr-2" target="_blank" href="{{ $row->meta[\StripeService::getStripeMode().'stripe_hosted_invoice_url'] ?? '#' }}">
            {{-- {{ route('order.details', ['id' => $row->id]) }} --}}
            @svg('heroicon-o-eye', ['class' => 'w-[18px] h-[18px] '])
            {{ translate('View') }}
        </a>

        <a class="btn btn-info flex items-center mr-2" target="_blank" href="{{ $row->meta[\StripeService::getStripeMode().'stripe_invoice_pdf_url'] ?? '#' }} ">
            @svg('heroicon-s-download', ['class' => 'w-[18px] h-[18px] '])
            {{ translate('Download') }}
        </a>

        {{-- <button 
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
        </ul> --}}
    </div>
</x-livewire-tables::table.cell>
