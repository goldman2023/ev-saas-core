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
        <div class="px-4 py-2 h-full space-y-2 sm:px-0 flex items-center justify-between sm:space-y-0 mb-4">
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
                <span class="badge-danger !py-1 !px-3 mr-2">
                    {{ translate('Tracking number not added') }}
                </span>
                @endif
                @endif
            </div>

            <div class="flex items-center relative" x-data="{ isOpen: false }" x-cloak>
                <a class="flex items-center text-gray-900 mr-3" href="javascript:;"
                    onclick="window.print(); return false;">
                    @svg('heroicon-o-printer', ['class' => 'w-[18px] h-[18px] mr-2'])
                    {{ translate('Print order') }}
                </a>


            </div>
        </div>
        <a href="{{ route('order.change-status', $order->id) }}" class="btn-primary !px-10 text-center !py-3 ml-3">

            <span>
                {{ translate('Next status') }}
            </span>

            @svg('heroicon-o-arrow-right', ['class' => 'h-4 h-4 ml-3'])

        </a>
    </div>
    </x-slot>
</x-dashboard.section-headers.section-header>

<x-dashboard.orders.order-steps :order="$order"></x-dashboard.orders.order-steps>
<div class="grid sm:grid-cols-12 gap-9">
    {{-- Right/Sidebar --}}
    <div class="sm:col-span-4">
        <div class="mb-9">
            <x-dashboard.customer.customer-card :user="$user"></x-dashboard.customer.customer-card>
        </div>

        <div class="card mb-9 !pb-0">
            <div class="scale-75" style="margin-bottom: -20px; width: 125%; transform-origin: top left;">
                <x-dashboard.orders.order-details-card :order="$order">
                </x-dashboard.orders.order-details-card>
            </div>
        </div>
        <div class="card mb-9">
            <div class="w-full pb-4 mb-4 border-b ">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Order status') }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    {{ translate('Here you can see the current status of the order') }}
                </p>
            </div>


            <x-dashboard.orders.order-timeline :order="$order">
            </x-dashboard.orders.order-timeline>
        </div>

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

                    {{-- TODO: Create order delivery deadline mechanics --}}
                    <div class="flex flex-col">
                        <span>{{ translate('Order delivery deadline:') }}</span>
                        <time datetime="{{ $order->created_at->format('Y-m-d') }}" class="font-semibold text-red-600">
                            {{ $order->created_at->format('M d, Y - H:i') }}
                        </time>
                    </div>
                    {{-- <div>
                        <div class="atcb" style="display:none;">
                            {
                            "name":"{{ translate('Order') }} {{ $order->id }}",
                            "description":"{{ translate('Order notification') }}",
                            "startDate":"{{ date('Y-m-d', $order->getCoreMeta('start_date')) }}",
                            "endDate":"{{ date('Y-m-d', $order->getCoreMeta('start_date')) }}",
                            "startTime":"{{ date('H:i', $order->getCoreMeta('start_date')) }}",
                            "endTime":"{{ date('H:i', $order->getCoreMeta('end_date')) }}",
                            "label":"{{ translate('Add to Calendar') }}",
                            "options":[
                            "Apple",
                            "Google",
                            "iCal",
                            "Microsoft365",
                            ],
                            "timeZone":"{{ date_default_timezone_get() }}",
                            "timeZoneOffset":"{{ date('P') }}",
                            "trigger":"click",
                            "iCalFileName":"Order-{{ $order->id }}"
                            }
                        </div>
                    </div> --}}

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
                        data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 rounded-t-lg border-b-2 text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                                id="profile-tab" data-tabs-target="#profile" type="button" role="tab"
                                aria-controls="profile" aria-selected="true">
                                {{ translate('Details') }}
                            </button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700"
                                id="manufacturing-tab" data-tabs-target="#manufacturing" type="button" role="tab"
                                aria-controls="dashboard" aria-selected="false">
                                {{ translate('Manufacturing') }}
                            </button>
                        </li>

                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700"
                                id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                                aria-controls="dashboard" aria-selected="false">
                                {{ translate('Documents') }}
                            </button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700"
                                id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                                aria-controls="settings" aria-selected="false">
                                {{ translate('History') }}
                            </button>
                        </li>
                        <li role="presentation">
                            <button
                                class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 dark:border-gray-700"
                                id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab"
                                aria-controls="contacts" aria-selected="false">
                                {{ translate('Actions') }}
                            </button>
                        </li>
                    </ul>
                </div>
                <div id="myTabContent">
                    {{-- <div class="card mb-3">
                        <x-dashboard.orders.order-documents-list :order="$order">
                        </x-dashboard.orders.order-documents-list>
                    </div> --}}

                    <div class="rounded-lg dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="mb-6">
                            <x-dashboard.orders.order-products-list :order="$order" :orderItems="$order_items">
                            </x-dashboard.orders.order-products-list>
                        </div>

                        <div class="card mb-9">
                            <x-dashboard.orders.order-details-card :order="$order">
                            </x-dashboard.orders.order-details-card>
                        </div>

                    </div>
                    <div class="hidden bg-gray-50 rounded-lg dark:bg-gray-800" id="dashboard" role="tabpanel"
                        aria-labelledby="dashboard-tab">

                        <div class="card mb-6 !pb-6">
                            <div class="border-b border-gray-200 bg-white pb-3 mb-4">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ translate('Order documents')
                                    }}</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ translate('Here you can find all uploaded
                                    documents related to the current order') }}</p>
                            </div>

                            <livewire:dashboard.forms.file-manager.file-manager :subject="$order" field="documents"
                                :file-type="\App\Enums\FileTypesEnum::image()->value" :multiple="true"
                                add-new-item-label="{{ translate('Add new document') }}" wrapper-class="!max-w-full" />
                        </div>


                        <div
                            class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                            <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Invoices') }}</h4>
                        </div>
                        <livewire:dashboard.tables.recent-invoices-widget-table :order="$order" :per-page="10"
                            :show-per-page="false" :show-search="false" :column-select="false" />
                    </div>

                    <div class="hidden bg-gray-50 rounded-lg dark:bg-gray-800" id="manufacturing" role="tabpanel"
                        aria-labelledby="manufacturing-tab">
                        <x-dashboard.orders.manufacturing-details></x-dashboard.orders.manufacturing-details>

                    </div>

                    <div class="hidden bg-gray-50 rounded-lg dark:bg-gray-800" id="settings" role="tabpanel"
                        aria-labelledby="settings-tab">
                        @livewire('dashboard.elements.activity-log',
                        [
                        'subject' => $order,
                        'title' => translate('Order Activity')
                        ])

                    </div>
                    <div class="hidden p-4 bg-gray-50 rounded-lg dark:bg-gray-800" id="contacts" role="tabpanel"
                        aria-labelledby="contacts-tab">
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
            <h3 class="text-2xl font-bold tracking-tight text-gray-900 mb-6">
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
