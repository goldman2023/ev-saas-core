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
                    @if($order_items->filter(fn($item) => ($item->subject?->isProduct() ?? false) &&
                    ($item->subject?->isShippable() ?? false))->count() > 0)
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

                    {{-- Tracking number (only for Standard Products) --}}
                    @if(empty($order->tracking_number))
                    <span class="!hidden badge-danger !py-1 !px-3 mr-2">
                        {{ translate('Tracking number not added') }}
                    </span>
                    @endif
                    @endif
                </div>

                <div class="flex items-center relative" x-data="{ isOpen: false }" x-cloak>

                </div>
            </div>
            <a href="{{ route('dashboard.order.change-status', $order->id) }}" class="btn-primary !px-10 text-center !py-3 ml-3">

                <span>
                    {{ translate('Next status') }}
                </span>

                @svg('heroicon-o-arrow-right', ['class' => 'h-4 h-4 ml-3'])

            </a>
        </div>

    </x-slot>
</x-dashboard.section-headers.section-header>
<div class="-mt-6 mb-6">
    {{ Breadcrumbs::render('dashboard.orders', $order) }}
</div>

<x-theme::dashboard.orders.order-steps :order="$order"></x-theme::dashboard.orders.order-steps>

<div class="grid sm:grid-cols-12 gap-9">
    {{-- Right/Sidebar --}}
    <div class="sm:col-span-4">
        <div class="mb-9">
            <x-dashboard.customer.customer-card :user="$user"></x-dashboard.customer.customer-card>
        </div>

        <livewire:dashboard.orders.order-queues :order="$order" />

        <div class="we-qr-code card mb-3">
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


    <div class="sm:col-span-8">

        <div class="bg-white rounded shadow mb-3">
            <div class="max-w-2xl mx-auto pt-8 sm:py-8 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="px-4 space-y-2 sm:px-0 sm:flex sm:items-baseline sm:justify-between sm:space-y-0 mb-3">

                    {{-- <span class="badge-dark ml-2">
                        {{ \App\Enums\OrderTypeEnum::labels()[$order->type] ?? '' }}
                    </span> --}}

                    <div class="flex flex-col">
                        <span>{{ translate('Order placed on:') }}</span>
                        <time datetime="{{ $order->created_at->format('Y-m-d') }}" class="font-semibold text-gray-900">
                            {{ $order->created_at->format('M d, Y - H:i') }}
                        </time>
                    </div>

                    <div class="flex flex-col">
                        <span>{{ translate('Order delivery deadline:') }}</span>

                        @php
                            $wef_id = 'wef-order-'.$order->id.'-order_delivery_deadline';
                        @endphp
                        <time datetime="{{ $order->created_at->format('Y-m-d') }}" class="flex items-center font-semibold text-red-600"
                            id="{{ $wef_id }}"
                            @click="$dispatch('display-wef-editor-modal', {
                                'target': '{{ $wef_id }}',
                                'subject_id': {{ $order->id }},
                                'subject_type': '{{ base64_encode($order::class) }}',
                                'wef_key': 'order_delivery_deadline',
                                'wef_label': '{{ translate('Order delivery deadline') }}',
                                'data_type': 'date',
                                'form_type': 'date',
                                'custom_properties': {'range': false, 'with_time': false},
                            })" >

                            @if( $order->getWEF('order_delivery_deadline', false, 'date'))
                                {{ $order->getWEF('order_delivery_deadline', false, 'date') }}
                            @else
                            <span class="text-xs">
                                {{ translate('Not set. Set order deadline') }}
                            </span>
                            @endif
                            @svg('heroicon-s-pencil-square', ['class' => 'ml-2 h-5 w-5 cursor-pointer'])
                        </time>
                    </div>

                    <div class="hidden">
                        {{-- TODO: Make invoice generation posible --}}
                        <a href="#" class=" text-sm font-medium text-indigo-600 hover:text-indigo-500 ">
                            {{ translate('View invoice') }}
                            <span aria-hidden="true"> &rarr;</span>
                        </a>
                    </div>
                </div>

                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                        data-tabs-toggle="#order-tabs-content" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 rounded-t-lg border-b-2 text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                                id="order-details-tab" data-tabs-target="#order-details-content" type="button" role="tab"
                                aria-controls="#order-details-content" aria-selected="true">
                                {{ translate('Details') }}
                            </button>
                        </li>

                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700"
                                id="order-documents-tab" data-tabs-target="#order-documents-content" type="button" role="tab"
                                aria-controls="order-documents-content" aria-selected="false">
                                {{ translate('Documents') }}
                            </button>
                        </li>

                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700"
                                id="order-manufacturing-tab" data-tabs-target="#order-manufacturing-content" type="button" role="tab"
                                aria-controls="order-manufacturing-content" aria-selected="false">
                                {{ translate('Manufacturing') }}
                            </button>
                        </li>

                        <li class="mr-2" role="presentation">
                            <button
                                class="hidden inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700"
                                id="order-specification-tab" data-tabs-target="#order-specification-content" type="button" role="tab"
                                aria-controls="order-specification-content" aria-selected="false">
                                {{ translate('Specification') }}
                            </button>
                        </li>


                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700"
                                id="order-history-tab" data-tabs-target="#order-history-content" type="button" role="tab"
                                aria-controls="order-history-content" aria-selected="false">
                                {{ translate('History') }}
                            </button>
                        </li>
                        <li role="presentation">
                            <button
                                class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700"
                                id="order-actions-tab" data-tabs-target="#order-actions-content" type="button" role="tab"
                                aria-controls="order-actions-content" aria-selected="false">
                                {{ translate('Actions') }}
                            </button>
                        </li>
                    </ul>
                </div>
                <div id="order-tabs-content">
                    {{-- <div class="card mb-3">
                        <x-dashboard.orders.order-documents-list :order="$order">
                        </x-dashboard.orders.order-documents-list>
                    </div> --}}

                    <div class="rounded-lg dark:bg-gray-800" id="order-details-content" role="tabpanel" aria-labelledby="order-details-tab">
                        <div class="mb-6">
                            <x-dashboard.orders.order-products-list :order="$order" :orderItems="$order_items">
                            </x-dashboard.orders.order-products-list>
                        </div>

                        <div class="card mb-9">
                            <x-dashboard.orders.order-details-card :order="$order">
                            </x-dashboard.orders.order-details-card>
                        </div>

                    </div>

                    <div class="rounded-lg dark:bg-gray-800" id="order-specification-content" role="tabpanel" aria-labelledby="order-specification-tab">
                       Specification.

                    </div>

                    <div class="hidden bg-gray-50 rounded-lg dark:bg-gray-800" id="order-documents-content" role="tabpanel"
                        aria-labelledby="order-documents-tab">

                        <div class="card mb-6 !pb-6">
                            <div class="border-b border-gray-200 bg-white pb-3 mb-4">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ translate('Order documents')
                                    }}</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ translate('Here you can find all uploaded
                                    documents related to the current order') }}</p>
                            </div>

                            <livewire:dashboard.forms.file-manager.file-manager :subject="$order" field="documents"
                                :file-type="\App\Enums\FileTypesEnum::image()->value" :multiple="true"
                                add-new-item-label="{{ translate('Add new document') }}" wrapper-class="!max-w-full"
                                :where-wefs="[
                                    ['upload_tag', '!=', 'printing-label']
                                ]" />
                        </div>


                        <div
                            class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                            <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Invoices') }}</h4>
                        </div>
                        <livewire:dashboard.tables.recent-invoices-widget-table :order="$order" :per-page="10"
                            :show-per-page="false" :show-search="false" :column-select="false" :filters-enabled="false" :show-pagination="false"/>
                    </div>

                    <div class="hidden bg-gray-50 rounded-lg dark:bg-gray-800" id="order-manufacturing-content" role="tabpanel"
                        aria-labelledby="order-manufacturing-tab">
                        <x-theme::dashboard.orders.manufacturing-details :order="$order"></x-theme::dashboard.orders.manufacturing-details>
                    </div>

                    <div class="hidden dark:bg-gray-800" id="order-history-content" role="tabpanel"
                        aria-labelledby="order-history-tab">

                        <div class="grid grid-cols-2 gap-6">
                            <div class="card mb-9">
                                <div class="w-full pb-4 mb-4 border-b ">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Order status')
                                        }}</h3>
                                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                        {{ translate('Here you can see the current status of the order') }}
                                    </p>
                                </div>

                                <x-theme::dashboard.orders.order-timeline :order="$order"></x-theme::dashboard.orders.order-timeline>
                            </div>

                            @livewire('dashboard.elements.activity-log',
                            [
                                'subject' => $order,
                                'title' => translate('Order Activity')
                            ])
                        </div>


                    </div>

                    <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="order-actions-content" role="tabpanel"
                        aria-labelledby="order-actions-tab">
                        <ul role="list" class="-my-4 divide-y divide-gray-200">
                            <li class="flex items-center space-x-3 py-4">
                                <div class="flex-shrink-0">

                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ translate('Edit order') }}
                                    </p>

                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('order.edit', $order->id) }}" type="button"
                                        class="inline-flex items-center rounded-full bg-rose-50 px-3 py-0.5 text-sm font-medium text-rose-700 hover:bg-rose-100">
                                        @svg('heroicon-o-pencil', ['class' => 'h-4 h-4 mr-2'])

                                        <span>{{ translate('Edit') }}</span>
                                    </a>
                                </div>

                            </li>
                            <li class="flex items-center space-x-3 py-4">
                                <div class="flex-shrink-0">

                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        <a href="#">{{ translate('Pridėti į važtaraštį') }}</a>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <a href="#">{{ translate('Pending') }}</a>
                                    </p>
                                </div>

                                <div class="flex-shrink-0">
                                    <button type="button"
                                        class="inline-flex items-center rounded-full bg-rose-50 px-3 py-0.5 text-sm font-medium text-rose-700 hover:bg-rose-100">

                                        @svg('heroicon-o-plus', ['class' => '-ml-1 mr-0.5 h-5 w-5 text-rose-400'])
                                        <span>{{ translate('Add to list') }}</span>
                                    </button>
                                </div>
                            </li>

                            <li class="flex items-center space-x-3 py-4">
                                <div class="flex-shrink-0">

                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        <a href="#">{{ translate('Pridėti į spausdinimo eilę') }}</a>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <a href="#">{{ translate('Pending') }}</a>
                                    </p>
                                </div>

                                <div class="flex-shrink-0">
                                    <button type="button"
                                        class="inline-flex items-center rounded-full bg-rose-50 px-3 py-0.5 text-sm font-medium text-rose-700 hover:bg-rose-100">

                                        @svg('heroicon-o-plus', ['class' => '-ml-1 mr-0.5 h-5 w-5 text-rose-400'])
                                        <span>{{ translate('Add to print list') }}</span>
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>
        </div>

        <div class="card mb-3">
            <h3 class="text-2xl font-medium text-gray-900 mb-6">
                {{ translate('Order notes') }}
            </h3>
            <livewire:actions.social-comments :item="$order">
            </livewire:actions.social-comments>
        </div>


    </div>


</div>


@endsection

@push('footer_scripts')

@endpush
