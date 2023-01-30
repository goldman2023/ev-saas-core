@extends('frontend.layouts.user_panel')

@section('page_title', translate('Order #').($order->id??'').translate('details'))

@push('head_scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/add-to-calendar-button@1.8/assets/css/atcb.min.css">
<script src="https://cdn.jsdelivr.net/npm/add-to-calendar-button@1.8" defer></script>
@endpush

@section('panel_content')

<x-dashboard.section-headers.section-header title="{{ translate('Order') }}:
                            #{{ $order->id }}" text="">
    <x-slot name="content">
        <div class="items-center flex content-center align-center">
            {{-- <a href="{{ route('orders.index') }}" class="btn-warning">
                @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('All orders') }}</span>
            </a> --}}
            {{-- Actions --}}
            <div class="px-4 py-2 h-full space-y-2 sm:px-0 flex items-center justify-between sm:space-y-0">
                <div class="flex items-center">
                    @php
                    $last_invoice = $order->invoices->first(); // it's already sorted by created_at DESC
                    @endphp

                    @if($last_invoice)
                    @if($last_invoice->payment_status === \App\Enums\PaymentStatusEnum::paid()->value)
                    <span class="badge-success !py-1 !px-3 mr-3">
                        {{ ucfirst(\Str::replace('_', ' ', $last_invoice->payment_status)) }}
                    </span>
                    @elseif($last_invoice->payment_status === \App\Enums\PaymentStatusEnum::pending()->value)
                    <span class="badge-warning  !py-1 !px-3 mr-3">
                        {{ ucfirst(\Str::replace('_', ' ', $last_invoice->payment_status)) }}
                    </span>
                    @elseif($last_invoice->payment_status === \App\Enums\PaymentStatusEnum::unpaid()->value)
                    <span class="badge-danger  !py-1 !px-3 mr-3">
                        {{ ucfirst(\Str::replace('_', ' ', $last_invoice->payment_status)) }}
                    </span>
                    @endif
                    @endif

                    {{-- Shipping status (only for Standard Products) --}}
                    @if($order_items->filter(fn($item) => ($item->subject?->isProduct() ?? false) && ($item->subject?->isShippable() ?? false))->count() > 0)
                        @if($order->shipping_status === \App\Enums\ShippingStatusEnum::delivered()->value)
                            <span class="badge-success !py-1 !px-3 mr-2">
                                {{ ucfirst(\Str::replace('_', ' ', $order->shipping_status)) }}
                            </span>
                        @elseif($order->shipping_status === \App\Enums\ShippingStatusEnum::sent()->value)
                            <span class="badge-warning !py-1 !px-3 mr-2">
                                {{ ucfirst(\Str::replace('_', ' ', $order->shipping_status)) }}
                            </span>
                        @elseif($order->shipping_status === \App\Enums\ShippingStatusEnum::not_sent()->value)
                            <span class="badge-danger !py-1 !px-3 mr-2">
                                {{ ucfirst(\Str::replace('_', ' ', $order->shipping_status)) }}
                            </span>
                        @endif
                    @endif
                </div>
            </div>
        </div>

    </x-slot>
</x-dashboard.section-headers.section-header>
<div class="-mt-6 mb-6">
    {{ Breadcrumbs::render('dashboard.orders', $order) }}
</div>

@admin
    <x-theme::dashboard.orders.order-steps :order="$order"></x-theme::dashboard.orders.order-steps>
@else
    <x-theme::dashboard.orders.customer-order-steps :order="$order"></x-theme::dashboard.orders.customer-order-steps>
@endadmin

<div class="grid sm:grid-cols-12 gap-4">
    {{-- Left/Sidebar --}}
    <div class="sm:col-span-4">
        <x-dashboard.customer.customer-card :user="$user"></x-dashboard.customer.customer-card>

        {{-- Order Documents --}}
        <div class="w-full flex items-center flex-wrap bg-white border border-gray-300 p-4 mb-3 rounded-lg">
            <div class="w-full pb-4 border-b ">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ translate('Documents') }}
                </h3>
            </div>

            @php
                $documents = $order->getUploadsWhere(property_name: 'documents', wef_params: [
                    ['upload_tag', 'IN', get_customer_visible_documents_tags()]
                ], return_all: true);
            @endphp

            @if($documents->isNotEmpty())
                <div class="w-full overflow-hidden bg-white ">
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($documents as $index => $doc)
                            <li>
                                <div class="block hover:bg-gray-50 py-4 @if($index === $documents->count() - 1) !pb-1 @endif">
                                    <div class="flex items-center ">
                                        <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                            <div class="truncate">
                                                <div class="flex text-sm">
                                                    <p class="truncate font-medium text-indigo-600">{{ $doc->file_original_name ?? '' }}</p>
                                                    {{-- <p class="ml-1 flex-shrink-0 font-normal text-gray-500">in Engineering</p> --}}
                                                </div>
                                                <div class="mt-2 flex">
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        @svg('heroicon-o-calendar-days', ['class' => 'mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400'])
                                                        <p>
                                                            {{ translate('Created on') }}
                                                            <time datetime="{{ $doc->created_at->format('Y-m-d') }}">
                                                                {{ $doc->created_at->format('d M, Y') }}
                                                            </time>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                                                <div class="flex -space-x-1 overflow-hidden">
                                                    <a href="{{ $doc->url() }}" class="btn-primary btn-primary !text-12 !px-3 !py-1" target="_blank">
                                                        {{ translate('View') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    
                    </ul>
                </div>
            @endif

            
        </div>

        <div class="we-qr-code w-full flex items-center flex-wrap bg-white border border-gray-300 p-4 mb-3 rounded-lg">
            <div class="w-full pb-4 mb-4 border-b ">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ translate('QR Code') }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    {{ translate('By scanning this QA code you can open this page on mobile') }}
                </p>
            </div>

            {!! QrCode::size(200)->generate(URL::current()) !!}
        </div>

    </div>

    {{-- Main Order Panel --}}
    <div class="sm:col-span-8">
        <div class="w-full flex items-center flex-wrap bg-white border border-gray-300 p-4 mb-3 rounded-lg">
            <dl class="w-full grid flex-1 gap-x-6 text-sm sm:grid-cols-6">
              <div>
                <dt class="font-medium text-gray-900">{{ translate('Order ID') }}</dt>
                <dd class="mt-1 text-gray-500">#{{ $order->id }}</dd>
              </div>
              <div class="hidden sm:block">
                <dt class="font-medium text-gray-900">{{ translate('Date placed') }}</dt>
                <dd class="mt-1 text-gray-500">
                  <time datetime="{{ $order->created_at->format('Y-m-d') }}">{{ $order->created_at->format('d M, Y') }}</time>
                </dd>
              </div>
              <div class="hidden sm:block">
                <dt class="font-medium text-gray-900">{{ translate('Delivery deadline') }}</dt>
                <dd class="mt-1 text-gray-500">
                    @php
                        $delivery_deadline_class = '';
                        $delivery_deadline_carbon = $order->getWEF('order_delivery_deadline', false, 'carbon');
                        if($delivery_deadline_carbon->isPast()) {
                            $delivery_deadline_class = 'text-danger';
                        } else if($delivery_deadline_carbon->diffInDays(\Carbon::now()) < 5) {
                            $delivery_deadline_class = 'text-warning';
                        }
                    @endphp
                  <time datetime="{{ $order->created_at->format('Y-m-d') }}" class="{{ $delivery_deadline_class }}">
                    {{ $order->getWEF('order_delivery_deadline', false, 'date', 'N/A') }}
                  </time>
                </dd>
              </div>
              <div>
                <dt class="font-medium text-gray-900">{{ translate('Total (with tax)') }}</dt>
                <dd class="mt-1 font-medium text-gray-900">{{ \FX::formatPrice($order->total_price) }}</dd>
              </div>
              <div>
                <dt class="font-medium text-gray-900">{{ translate('Status') }}</dt>
                <dd class="mt-1 font-medium {{ get_order_cycle_status_color($order->getWEF('cycle_status')) }}">
                  {{ \WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum::getPublicStatusesLabels()[$order->getWEF('cycle_status')] ?? \WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum::labels()[2] }}
                </dd>
              </div>
              <div>
                <dt class="font-medium text-gray-900">{{ translate('Payment status') }}</dt>
                <dd class="mt-1 font-medium text-gray-900">
                  {{-- Make label function... --}}
                  @if($order->payment_status === \App\Enums\PaymentStatusEnum::paid()->value)
                    <span class="badge-success">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                  @elseif($order->payment_status === \App\Enums\PaymentStatusEnum::pending()->value)
                    <span class="badge-info">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                  @elseif($order->payment_status === \App\Enums\PaymentStatusEnum::unpaid()->value)
                    <span class="badge-danger">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                  @elseif($order->payment_status === \App\Enums\PaymentStatusEnum::canceled()->value)
                    <span class="badge-warning">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                  @endif
                </dd>
              </div>
            </dl>
        </div>

        {{-- Order Items --}}
        <div class="w-full flex items-center flex-wrap bg-white border border-gray-300 p-4 mb-3 rounded-lg">
            <div class="w-full pb-4 mb-4 border-b">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ translate('Order Items') }}
                </h3>
            </div>

            <x-dashboard.orders.order-products-list :order="$order" :orderItems="$order_items">
            </x-dashboard.orders.order-products-list>
        </div>

        {{-- Order Invoices --}}
        <div class="w-full flex items-center flex-wrap bg-white border border-gray-300 p-4 mb-3 rounded-lg">
            <div class="w-full pb-4 border-b">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ translate('Invoices') }}
                </h3>
            </div>

            <livewire:dashboard.tables.recent-invoices-widget-table :order="$order"
                        :show-per-page="false" :show-search="false" :column-select="false" :filters-enabled="false" :show-pagination="false" />
        </div>

        {{-- Order Notes --}}
        <div class="w-full flex items-center flex-wrap bg-white border border-gray-300 p-4 mb-3 rounded-lg">
            <div class="w-full pb-4 mb-4 border-b">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ translate('Order Notes') }}
                </h3>
            </div>

            <livewire:actions.social-comments :item="$order" class="w-full">
            </livewire:actions.social-comments>
        </div>


    </div>


</div>


@endsection

@push('footer_scripts')

@endpush
