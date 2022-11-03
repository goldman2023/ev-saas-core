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
        <a href="{{ route('orders.index') }}" class="btn-warning">
            @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
            <span>{{ translate('All orders') }}</span>
        </a>

        <a href="{{ route('order.edit', $order->id) }}" class="btn-primary ml-3">
            @svg('heroicon-o-pencil', ['class' => 'h-4 h-4 mr-2'])
            <span>{{ translate('Edit Order') }}</span>
        </a>
    </x-slot>
</x-dashboard.section-headers.section-header>
<div class="grid sm:grid-cols-12 gap-9">
    {{-- Right/Sidebar --}}
    <div class="sm:col-span-4">
        <div class="mb-9">
            <x-dashboard.customer.customer-card :user="$user"></x-dashboard.customer.customer-card>
        </div>
        <div class="card mb-9">
            <div class="w-full pb-4 mb-4 border-b ">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Order status') }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Here you can see the current status of the
                    order') }}</p>
            </div>

            <x-dashboard.orders.order-timeline>
            </x-dashboard.orders.order-timeline>
        </div>

        <div class="we-qr-code card mb-3">
            <div class="w-full pb-4 mb-4 border-b ">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('QR Code') }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('By scanning this QA code you can open this
                    page on mobile') }}</p>
            </div>

            {!! QrCode::size(200)->generate(URL::current()) !!}
        </div>

    </div>


    <div class="sm:col-span-8">

        <div class="bg-white rounded shadow">
            <div class="max-w-2xl mx-auto pt-8 sm:py-8 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="px-4 space-y-2 sm:px-0 sm:flex sm:items-baseline sm:justify-between sm:space-y-0 mb-3">
                    <div class="flex items-center sm:space-x-4">
                        <h1 class="ftext-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">{{
                            translate('Order') }}:
                            #{{ $order->id }}
                        </h1>

                        <span class="badge-dark ml-2">
                            {{ \App\Enums\OrderTypeEnum::labels()[$order->type] ?? '' }}
                        </span>
                        {{-- <a href="#"
                            class="hidden text-sm font-medium text-indigo-600 hover:text-indigo-500 sm:block">View
                            invoice<span aria-hidden="true"> &rarr;</span></a> --}}
                    </div>
                    <p class="text-sm text-gray-600">
                    <div>
                        {{ translate('Order placed on:') }} <br>
                        <time datetime="2021-03-22" class="font-semibold text-gray-900">
                            {{ $order->created_at->format('M d, Y H:i') }}
                        </time>
                    </div>
                    {{-- TODO: Create order delivery deadline mechanics --}}
                    <div>
                        {{ translate('Order delivery deadline:') }} <br>
                        <time class="font-semibold text-gray-900">
                            {{ $order->created_at->format('M d, Y H:i') }}
                        </time>
                    </div>
                    <div>
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
                            "MicrosoftTeams",
                            "Outlook.com",
                            "Yahoo"
                            ],
                            "timeZone":"{{ date_default_timezone_get() }}",
                            {{-- "timeZoneOffset":"{{ date('P') }}", --}}
                            "trigger":"click",
                            "iCalFileName":"Order-{{ $order->id }}"
                            }
                        </div>
                    </div>
                    </p>

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
                    <div class="bg-gray-50 rounded-lg dark:bg-gray-800" id="profile" role="tabpanel"
                        aria-labelledby="profile-tab">
                        <x-dashboard.orders.order-products-list :order="$order" :orderItems="$order_items">
                        </x-dashboard.orders.order-products-list>

                    </div>
                    <div class="hidden bg-gray-50 rounded-lg dark:bg-gray-800" id="dashboard" role="tabpanel"
                        aria-labelledby="dashboard-tab">
                        <div
                            class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                            <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Invoices') }}</h4>
                        </div>
                        <livewire:dashboard.tables.recent-invoices-widget-table :order="$order" :per-page="10"
                            :show-per-page="false" :show-search="false" :column-select="false" />
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
                                    <img class="h-8 w-8 rounded-full"
                                        src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80"
                                        alt="">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        <a href="#">{{ translate('Generuoti važtaraštį') }}</a>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <a href="#">{{ translate('Pending information') }}</a>
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button"
                                        class="inline-flex items-center rounded-full bg-rose-50 px-3 py-0.5 text-sm font-medium text-rose-700 hover:bg-rose-100">
                                        <svg class="-ml-1 mr-0.5 h-5 w-5 text-rose-400"
                                            x-description="Heroicon name: mini/plus" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z">
                                            </path>
                                        </svg>
                                        <span>{{ translate('Generate') }}</span>
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-4 py-2 space-y-2 sm:px-0 flex items-center justify-between sm:space-y-0 mb-4">
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
                        {{-- <a class="flex items-center text-gray-900 mr-3" href="javascript:;"
                            onclick="window.print(); return false;">
                            @svg('heroicon-o-printer', ['class' => 'w-[18px] h-[18px] mr-2'])
                            {{ translate('Print order') }}
                        </a> --}}

                        {{-- <button @click="isOpen = !isOpen" @keydown.escape="isOpen = false"
                            class="flex items-center">
                            @svg('heroicon-o-chevron-down', ['class' => 'ml-2 w-[18px] h-[18px]'])
                        </button>
                        <ul x-show="isOpen" @click.outside="isOpen = false"
                            class="absolute bg-white z-10 list-none p-0 border rounded top-[30px] right-0 shadow min-w-[150px]">
                            <li>
                                <a href="#" target="_blank"
                                    class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14">
                                    @svg('heroicon-o-trash', ['class' => 'w-[18px] h-[18px]'])
                                    <span class="ml-2">{{ translate('Cacnel order') }}</span>
                                </a>
                            </li>
                        </ul> --}}
                    </div>
                </div>


                <div class="mt-6">

                </div>


            </div>
        </div>

        <div class="card mb-3 mt-3">
            <x-dashboard.general.files-manager>
            </x-dashboard.general.files-manager>
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
