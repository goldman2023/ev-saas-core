@extends('frontend.layouts.user_panel')

@section('page_title', translate('Order #').($order->id??'').translate('details'))

@push('head_scripts')

@endpush

@section('panel_content')
    <x-dashboard.section-headers.section-header title="{{ translate('All orders') }}" text="">
        <x-slot name="content">
            <a href="{{ route('orders.index') }}" class="btn-primary">
                @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('All orders') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="bg-gray-50">
        <div class="max-w-2xl mx-auto pt-16 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="px-4 space-y-2 sm:px-0 sm:flex sm:items-baseline sm:justify-between sm:space-y-0">
            <div class="flex sm:items-baseline sm:space-x-4">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">{{ translate('Order') }}: #{{ $order->id }}</h1>
            <a href="#" class="hidden text-sm font-medium text-indigo-600 hover:text-indigo-500 sm:block">View invoice<span aria-hidden="true"> &rarr;</span></a>
            </div>
            <p class="text-sm text-gray-600">Order placed 
                <time datetime="2021-03-22" class="font-semibold text-gray-900">{{ $order->created_at->format('M d, Y') }}</time>
            </p>
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 sm:hidden">View invoice<span aria-hidden="true"> &rarr;</span></a>
        </div>
        
        {{-- Actions --}}
        <div class="px-4 py-2 mt-3 space-y-2 sm:px-0 flex items-center justify-between sm:space-y-0">
            <div class="flex items-center">
                @if($order->payment_status === \App\Enums\PaymentStatusEnum::paid()->value)
                    <span class="badge-success !py-1 !px-3 mr-3">
                        {{ ucfirst(\Str::replace('_', ' ', $order->payment_status)) }}
                    </span>
                @elseif($order->payment_status === \App\Enums\PaymentStatusEnum::pending()->value)
                    <span class="badge-warning  !py-1 !px-3 mr-3">
                        {{ ucfirst(\Str::replace('_', ' ', $order->payment_status)) }}
                    </span>
                @elseif($order->payment_status === \App\Enums\PaymentStatusEnum::unpaid()->value)
                    <span class="badge-danger  !py-1 !px-3 mr-3">
                        {{ ucfirst(\Str::replace('_', ' ', $order->payment_status)) }}
                    </span>
                @endif

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

                @if(empty($order->tracking_number))
                    <span class="badge-danger !py-1 !px-3 mr-2">
                        {{ translate('Tracking number not added') }}
                    </span>
                @else

                @endif
            </div>
            
            <div class="flex items-center relative" x-data="{ isOpen: false }" x-cloak>
                <a class="flex items-center text-gray-900 mr-3" href="javascript:;" onclick="window.print(); return false;">
                    @svg('heroicon-o-printer', ['class' => 'w-[18px] h-[18px] mr-2']) 
                    {{ translate('Print order') }}
                </a>

                <button 
                    @click="isOpen = !isOpen" 
                    @keydown.escape="isOpen = false" 
                    class="flex items-center" 
                >
                    @svg('heroicon-o-chevron-down', ['class' => 'ml-2 w-[18px] h-[18px]'])
                </button>
                <ul x-show="isOpen"
                    @click.outside="isOpen = false"
                    class="absolute bg-white z-10 list-none p-0 border rounded top-[30px] right-0 shadow min-w-[150px]"
                >
                    <li>
                        <a class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14" href="#"
                            target="_blank">
                            @svg('heroicon-o-document-duplicate', ['class' => 'w-[18px] h-[18px] mr-2']) 
                            <span class="ml-2">{{ translate('Duplicate') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" target="_blank"
                            class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14">
                            @svg('heroicon-o-trash', ['class' => 'w-[18px] h-[18px]'])
                            <span class="ml-2">{{ translate('Cacnel order') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    
        <!-- Products -->
        <div class="mt-6">    
            <div class="space-y-8">
                @if($order_items->isNotEmpty())
                    @foreach($order_items as $item)
                        <div class="bg-white border-t border-b border-gray-200 shadow-sm sm:border sm:rounded-lg">
                            <div class="py-6 px-4 sm:px-6 lg:grid lg:grid-cols-12 lg:gap-x-8 lg:p-8">
                            <div class="sm:flex lg:col-span-7">
                                <div class="flex-shrink-0 w-full aspect-w-1 aspect-h-1 rounded-lg overflow-hidden sm:aspect-none sm:w-40 sm:h-40 border border-gray-200 shadow">
                                    <img src="{{ $item->subject->getTHumbnail(['w' => 600]) }}" alt="" class="w-full h-full object-center object-cover sm:w-full sm:h-full">
                                </div>
                    
                                <div class="flex flex-col mt-6 sm:mt-0 sm:ml-6">
                                    <h3 class="text-base font-medium text-gray-900">
                                        <a href="#">{{ $item->name }}</a>
                                    </h3>
                                    
                                    <p class="mt-3 text-sm text-gray-500">{{ $item->excerpt }}</p>

                                    <dl class="flex text-sm divide-x divide-gray-200 space-x-4 sm:space-x-6 mt-5">
                                        <div class="flex">
                                            <dt class="font-semibold text-gray-900">{{ translate('Quantity') }}</dt>
                                            <dd class="ml-2 text-gray-700">{{ $item->quantity }}</dd>
                                        </div>
                                        <div class="pl-4 flex sm:pl-6">
                                            <dt class="font-semibold text-gray-900">{{ translate('Price') }}</dt>
                                            <dd class="ml-2 text-gray-700">{{ FX::formatPrice($item->total_price * $item->quantity) }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                
                            <div class="mt-6 lg:mt-0 lg:col-span-5">
                                <dl class="grid grid-cols-2 gap-x-6 text-sm">
                                <div>
                                    <dt class="font-medium text-gray-900">Delivery address</dt>
                                    <dd class="mt-3 text-gray-500">
                                    <span class="block">Floyd Miles</span>
                                    <span class="block">7363 Cynthia Pass</span>
                                    <span class="block">Toronto, ON N3Y 4H8</span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-900">Shipping updates</dt>
                                    <dd class="mt-3 text-gray-500 space-y-3">
                                    <p>f•••@example.com</p>
                                    <p>1•••••••••40</p>
                                    <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500">Edit</button>
                                    </dd>
                                </div>
                                </dl>
                            </div>
                            </div>
                
                            <div class="border-t border-gray-200 py-6 px-4 sm:px-6 lg:p-8">
                            <h4 class="sr-only">Status</h4>
                            <p class="text-sm font-medium text-gray-900">Preparing to ship on <time datetime="2021-03-24">March 24, 2021</time></p>
                            <div class="mt-6" aria-hidden="true">
                                <div class="bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-2 bg-indigo-600 rounded-full" style="width: calc((1 * 2 + 1) / 8 * 100%)"></div>
                                </div>
                                <div class="hidden sm:grid grid-cols-4 text-sm font-medium text-gray-600 mt-6">
                                <div class="text-indigo-600">Order placed</div>
                                <div class="text-center text-indigo-600">Processing</div>
                                <div class="text-center">Shipped</div>
                                <div class="text-right">Delivered</div>
                                </div>
                            </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                
        
                <!-- More products... -->
            </div>
        </div>
    
        <!-- Billing -->
        <div class="mt-16">
            <h2 class="sr-only">Billing Summary</h2>
    
            <div class="bg-gray-100 py-6 px-4 sm:px-6 sm:rounded-lg lg:px-8 lg:py-8 lg:grid lg:grid-cols-12 lg:gap-x-8">
            <dl class="grid grid-cols-2 gap-6 text-sm sm:grid-cols-2 md:gap-x-8 lg:col-span-7">
                <div>
                <dt class="font-medium text-gray-900">Billing address</dt>
                <dd class="mt-3 text-gray-500">
                    <span class="block">Floyd Miles</span>
                    <span class="block">7363 Cynthia Pass</span>
                    <span class="block">Toronto, ON N3Y 4H8</span>
                </dd>
                </div>
                <div>
                <dt class="font-medium text-gray-900">Payment information</dt>
                <div class="mt-3">
                    <dd class="-ml-4 -mt-4 flex flex-wrap">
                    <div class="ml-4 mt-4 flex-shrink-0">
                        <svg aria-hidden="true" width="36" height="24" viewBox="0 0 36 24" xmlns="http://www.w3.org/2000/svg" class="h-6 w-auto">
                        <rect width="36" height="24" rx="4" fill="#224DBA" />
                        <path d="M10.925 15.673H8.874l-1.538-6c-.073-.276-.228-.52-.456-.635A6.575 6.575 0 005 8.403v-.231h3.304c.456 0 .798.347.855.75l.798 4.328 2.05-5.078h1.994l-3.076 7.5zm4.216 0h-1.937L14.8 8.172h1.937l-1.595 7.5zm4.101-5.422c.057-.404.399-.635.798-.635a3.54 3.54 0 011.88.346l.342-1.615A4.808 4.808 0 0020.496 8c-1.88 0-3.248 1.039-3.248 2.481 0 1.097.969 1.673 1.653 2.02.74.346 1.025.577.968.923 0 .519-.57.75-1.139.75a4.795 4.795 0 01-1.994-.462l-.342 1.616a5.48 5.48 0 002.108.404c2.108.057 3.418-.981 3.418-2.539 0-1.962-2.678-2.077-2.678-2.942zm9.457 5.422L27.16 8.172h-1.652a.858.858 0 00-.798.577l-2.848 6.924h1.994l.398-1.096h2.45l.228 1.096h1.766zm-2.905-5.482l.57 2.827h-1.596l1.026-2.827z" fill="#fff" />
                        </svg>
                        <p class="sr-only">Visa</p>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="text-gray-900">Ending with 4242</p>
                        <p class="text-gray-600">Expires 02 / 24</p>
                    </div>
                    </dd>
                </div>
                </div>
            </dl>
    
            <dl class="mt-8 divide-y divide-gray-200 text-sm lg:mt-0 lg:col-span-5">
                <div class="pb-4 flex items-center justify-between">
                <dt class="text-gray-600">Subtotal</dt>
                <dd class="font-medium text-gray-900">$72</dd>
                </div>
                <div class="py-4 flex items-center justify-between">
                <dt class="text-gray-600">Shipping</dt>
                <dd class="font-medium text-gray-900">$5</dd>
                </div>
                <div class="py-4 flex items-center justify-between">
                <dt class="text-gray-600">Tax</dt>
                <dd class="font-medium text-gray-900">$6.16</dd>
                </div>
                <div class="pt-4 flex items-center justify-between">
                <dt class="font-medium text-gray-900">Order total</dt>
                <dd class="font-medium text-indigo-600">$83.16</dd>
                </div>
            </dl>
            </div>
        </div>
        </div>
    </div>
  


    <!-- Card -->
    <div class="card">
        <!-- Card Body -->
        <div class="w-full">
            <div class="flex items-center">
                <div class="col-sm mb-2 sm:mb-0">

                    <nav class="mb-2">
                        <a href="{{ route('orders.index') }}" class="text-14 inline-flex items-center">
                            @svg('heroicon-o-chevron-left', ['class' => 'w-[14px] h-[14px] mr-1'])
                            <span>{{ translate('Go back to Orders') }}</span>
                        </a>
                    </nav>

                    <div class="flex items-center">
                        <h1 class="font-semibold text-24 mr-3">{{ translate('Order') }} #{{ $order->id }}</h1>

                        @if($order->payment_status === \App\Enums\PaymentStatusEnum::paid()->value)
                            <span class="badge-success mr-3">
                                {{ ucfirst(\Str::replace('_', ' ', $order->payment_status)) }}
                            </span>
                        @elseif($order->payment_status === \App\Enums\PaymentStatusEnum::pending()->value)
                            <span class="badge-warning  mr-3">
                                {{ ucfirst(\Str::replace('_', ' ', $order->payment_status)) }}
                            </span>
                        @elseif($order->payment_status === \App\Enums\PaymentStatusEnum::unpaid()->value)
                            <span class="badge-danger  mr-3">
                                {{ ucfirst(\Str::replace('_', ' ', $order->payment_status)) }}
                            </span>
                        @endif

                        @if($order->shipping_status === \App\Enums\ShippingStatusEnum::delivered()->value)
                            <span class="badge-success  mr-2">
                                {{ ucfirst(\Str::replace('_', ' ', $order->shipping_status)) }}
                            </span>
                        @elseif($order->shipping_status === \App\Enums\ShippingStatusEnum::sent()->value)
                            <span class="badge-warning  mr-2">
                                {{ ucfirst(\Str::replace('_', ' ', $order->shipping_status)) }}
                            </span>
                        @elseif($order->shipping_status === \App\Enums\ShippingStatusEnum::not_sent()->value)
                            <span class="badge-danger mr-2">
                                {{ ucfirst(\Str::replace('_', ' ', $order->shipping_status)) }}
                            </span>
                        @endif

                        <span class="ml-2 ml-sm-3">
                          <i class="tio-date-range"></i> {{ $order->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <div class="mt-2 flex items-center" x-data="{ isOpen: false }" x-cloak>
                        <a class="flex items-center text-gray-900 mr-3" href="javascript:;" onclick="window.print(); return false;">
                            @svg('heroicon-o-printer', ['class' => 'w-[18px] h-[18px] mr-2']) 
                            {{ translate('Print order') }}
                        </a>

                        <button 
                            @click="isOpen = !isOpen" 
                            @keydown.escape="isOpen = false" 
                            class="flex items-center" 
                        >
                            @svg('heroicon-o-chevron-down', ['class' => 'ml-2 w-[18px] h-[18px]'])
                        </button>
                        <ul x-show="isOpen"
                            @click.outside="isOpen = false"
                            class="absolute bg-white z-10 list-none p-0 border rounded mt-10 shadow"
                        >
                            <li>
                                <a class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14" href="#"
                                    target="_blank">
                                    @svg('heroicon-o-document-duplicate', ['class' => 'w-[18px] h-[18px] mr-2']) 
                                    <span class="ml-2">{{ translate('Duplicate') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" target="_blank"
                                    class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14">
                                    @svg('heroicon-o-trash', ['class' => 'w-[18px] h-[18px]'])
                                    <span class="ml-2">{{ translate('Cacnel order') }}</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Unfold -->

                    </div>
                </div>

            </div>
        </div>
        <!-- End Card Body -->
    </div>

    <div class="row mt-3">
        <!-- Order Items -->
        <div class="col-lg-7 mb-3 mb-lg-0">
            <!-- Card -->
            <div class="card w-100 mb-3 mb-lg-5">
                <div class="card-header">
                    <h4 class="card-header-title">{{ translate('Order items') }} <span class="badge badge-soft-dark rounded-circle ml-1">{{ $order_items->count() ?? 0 }}</span></h4>
                    <a class="link" href="javascript:;">{{ translate('Edit') }}</a>
                </div>
                <div class="card-body w-100">
                    @if($order_items->isNotEmpty())
                        @foreach($order_items as $item)
                            @php
                                $subject = $item->subject;
                                $unit = $item->subject->hasMain() ? $item->subject->main->unit : $item->subject->unit;
                                $variant = $item->variant;
                                $name = $item->title;
                                $excerpt = $item->excerpt;
                            @endphp
                            <div id="order-item-{{ $item->id }}-{{ str_replace('\\','-',$item::class) }}"
                                 class="order-item card p-3 d-flex flex-row align-items-start mb-3"
                                 x-data="{
                                        qty: {{ $item->quantity }},
                                        model_id: {{ $item->subject_id }},
                                        model_type: '{!! addslashes($item->subject_type) !!}'
                                 }">
                                <div class="row full-row">

                                    <div class="col-3">
                                        <img src="{{ $subject->getThumbnail(['w'=>100,'h'=>100]) }}" class="border rounded-lg fit-cover" />
                                    </div>

                                    <div class="d-flex flex-column col-6 px-0 pr-3 mt-1">
                                        <strong class="fw-600 text-16 w-100 clamp d-inline-block mb-2" data-clamp-lines="2" style="line-height: 1.2;">
                                            {{ $name }}
                                        </strong>

                                        @if(empty($variant))
                                            <span class="clamp text-12 mb-2" data-clamp-lines="3">{{ $excerpt }}</span>
                                        @else
                                            <ul class="list-style-none d-flex flex-column mb-0 pl-0">
                                                @foreach($variant as $name => $value)
                                                    <li class="text-14"><span>{{ $name }}:</span> <strong>{{ $value }}</strong></li>
                                                @endforeach
                                            </ul>
                                        @endif

                                        @if($item->discount_amount > 0)
                                            <div class="d-flex flex-column align-items-start mt-3">
                                                <span class="badge badge-soft-info mr-3 mb-2">
                                                    {{ translate('Base price') }}: {{ \FX::formatPrice($item->base_price) }}
                                                </span>
                                                <span class="badge badge-soft-warning mr-3">
                                                    {{ translate('Discount') }}: {{ \FX::formatPrice($item->discount_amount) }} ({{ \FX::reductionPercentage($item->base_price, $item->subtotal_price) }}%)
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-flex flex-column align-items-center justify-content-center col-3 pl-0 pr-3 ">
                                        <strong class="text-14">{{ $item->quantity.' '.$unit }}</strong>
                                        <strong class="fw-600 text-14 text-primary mb-0" >
                                            <span class="spinner-border text-primary text-10 square-16 d-none" > </span>
                                            <span >{{ \FX::formatPrice($item->total_price * $item->quantity) }}</span>
                                        </strong>
                                        <div class="text-12">
                                            ({{ \FX::formatPrice($item->total_price) }} {{ translate('per') }} <strong>{{ $unit }}</strong>)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="card-footer">
                    <div class="row justify-content-md-end">
                        <div class="col-md-8 col-lg-7">
                            <dl class="row text-sm-right mb-0">
                                <dt class="col-sm-6">{{ translate('Subtotal') }}:</dt>
                                <dd class="col-sm-6">{{ \FX::formatPrice($order->subtotal_price) }}</dd>
                                <dt class="col-sm-6">{{ translate('Shipping fee') }}:</dt>
                                <dd class="col-sm-6">{{ \FX::formatPrice(0) }}</dd>
                                <dt class="col-sm-6">{{ translate('Tax') }}:</dt>
                                <dd class="col-sm-6">{{ \FX::formatPrice(0) }}</dd>
                                <dt class="col-sm-6">{{ translate('Total') }}:</dt>
                                <dd class="col-sm-6">{{ \FX::formatPrice($order->total_price) }}</dd>
{{--                                <dt class="col-sm-6">{{ translate('Amount Paid') }}:</dt>--}}
{{--                                <dd class="col-sm-6">$65.00</dd>--}}
                            </dl>
                            <!-- End Row -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Order Items -->

        <!-- Order Info -->
        <div class="col-lg-5">
            <!-- Card -->
            <div class="card">
                <!-- Header -->
                <div class="card-header">
                    <h4 class="card-header-title">{{ translate('Order details') }}</h4>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="card-body">
                    @if($user instanceof \App\Models\User)
                        <a class="media align-items-center" href="./ecommerce-customer-details.html">
                            <div class="avatar avatar-circle mr-3">
                                <img class="avatar-img" src="{{ $user->getUpload('avatar') }}" >
                            </div>
                            <div class="media-body">
                                <span class="text-body text-hover-primary">{{ $order->billing_first_name.' '.$order->billing_last_name }}</span>
                            </div>
                            <div class="media-body text-right">
                                <i class="tio-chevron-right text-body"></i>
                            </div>
                        </a>

                        <hr>

{{--                        TODO: Add number of orders this customer made overall --}}
                    @endif

                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="">{{ translate('Contact info') }}</h5>
                        <a class="link" href="javascript:;">{{ translate('Edit') }}</a>
                    </div>

                    <ul class="list-unstyled list-unstyled-py-2">
                        <li class="pb-2 text-14">
                            <i class="tio-online mr-2"></i>
                            {{ $order->email }}
                        </li>
                        <li class="text-14" >
                            <i class="tio-android-phone-vs mr-2"></i>
                            {{ implode(', ', $order->phone_numbers) }}
                        </li>
                    </ul>

                    <hr>

                    @php
                        $shipping_first_name = $order->same_billing_shipping ? $order->billing_first_name : $order->shipping_first_name;
                        $shipping_last_name = $order->same_billing_shipping ? $order->billing_last_name : $order->shipping_last_name;
                        $shipping_company = $order->same_billing_shipping ? $order->billing_company : $order->shipping_company;
                        $shipping_address = $order->same_billing_shipping ? $order->billing_address : $order->shipping_address;
                        $shipping_country = $order->same_billing_shipping ? $order->billing_country : $order->shipping_country;
                        $shipping_state = $order->same_billing_shipping ? $order->billing_state : $order->shipping_state;
                        $shipping_city = $order->same_billing_shipping ? $order->billing_city : $order->shipping_city;
                        $shipping_zip = $order->same_billing_shipping ? $order->billing_zip : $order->shipping_zip;
                    @endphp
                    <div class="">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>{{ translate('Shipping address') }}</h5>
                            <a class="link" href="javascript:;">{{ translate('Edit') }}</a>
                        </div>

                        <div class="d-flex flex-column text-14">
                            <div>
                                <span>{{ translate('Address') }}:</span> <strong>{{ $shipping_address }}</strong>
                            </div>
                            <div>
                                <span>{{ translate('State') }}:</span> <strong>{{ $shipping_state }}</strong>
                            </div>
                            <div>
                                <span>{{ translate('Country') }}:</span> <strong>{{ $shipping_country }}</strong>
                            </div>
                            <div>
                                <span>{{ translate('City') }}:</span> <strong>{{ $shipping_city }}</strong>
                            </div>
                            <div>
                                <span>{{ translate('Zip') }}:</span> <strong>{{ $shipping_zip }}</strong>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>{{ translate('Billing address') }}</h5>
                            <a class="link" href="javascript:;">{{ translate('Edit') }}</a>
                        </div>

                        <div class="d-flex flex-column text-14">
                            <div>
                                <span>{{ translate('Address') }}:</span> <strong>{{ $order->billing_address }}</strong>
                            </div>
                            <div>
                                <span>{{ translate('State') }}:</span> <strong>{{ $order->billing_state }}</strong>
                            </div>
                            <div>
                                <span>{{ translate('Country') }}:</span> <strong>{{ $order->billing_country }}</strong>
                            </div>
                            <div>
                                <span>{{ translate('City') }}:</span> <strong>{{ $order->billing_city }}</strong>
                            </div>
                            <div>
                                <span>{{ translate('Zip') }}:</span> <strong>{{ $order->billing_zip }}</strong>
                            </div>
                        </div>
                    </div>

                    <hr>

{{--                    <div class="">--}}
{{--                        <div class="d-flex justify-content-between align-items-center">--}}
{{--                            <h5>{{ translate('Payment method') }}</h5>--}}
{{--                        </div>--}}

{{--                        <div class="d-flex flex-column text-14 justify-content-start">--}}
{{--                            <div>--}}
{{--                                <span>{{ translate('Method') }}:</span> <strong>{{ $order->payment_method->name }}</strong>--}}
{{--                            </div>--}}
{{--                            @if($order->payment_status === 'unpaid')--}}
{{--                                <form action="{{ route('checkout.execute.payment', ['id' => $order->id]) }}" method="POST">--}}
{{--                                    @csrf--}}
{{--                                    <button type="submit" class="btn btn-primary btn-xs mt-2 mr-auto">--}}
{{--                                        {{ translate('Pay now') }}--}}
{{--                                    </button>--}}
{{--                                </form>--}}
{{--                            @endif--}}

{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
        <!-- END Order Info -->


        <!-- Shipping activity -->
{{--        <div class="card">--}}
{{--            <!-- Header -->--}}
{{--            <div class="card-header">--}}
{{--                <h4 class="card-header-title">--}}
{{--                    Shipping activity--}}
{{--                    <span class="badge badge-soft-dark ml-1">--}}
{{--                    <span class="legend-indicator bg-dark"></span>Marked as fulfilled--}}
{{--                  </span>--}}
{{--                </h4>--}}
{{--            </div>--}}
{{--            <!-- End Header -->--}}

{{--            <!-- Body -->--}}
{{--            <div class="card-body">--}}
{{--                <!-- Step -->--}}
{{--                <ul class="step step-icon-xs">--}}
{{--                    <!-- Step Item -->--}}
{{--                    <li class="step-item">--}}
{{--                        <div class="step-content-wrapper">--}}
{{--                            <small class="step-divider">Wednesday, 19 August</small>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <!-- End Step Item -->--}}

{{--                    <!-- Step Item -->--}}
{{--                    <li class="step-item">--}}
{{--                        <div class="step-content-wrapper">--}}
{{--                            <span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>--}}

{{--                            <div class="step-content">--}}
{{--                                <h5 class="mb-1">--}}
{{--                                    <a class="text-dark" href="#">Delivered</a>--}}
{{--                                </h5>--}}

{{--                                <p class="font-size-sm mb-0">4:17 AM</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <!-- End Step Item -->--}}

{{--                    <!-- Step Item -->--}}
{{--                    <li class="step-item">--}}
{{--                        <div class="step-content-wrapper">--}}
{{--                            <span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>--}}

{{--                            <div class="step-content">--}}
{{--                                <h5 class="mb-1">--}}
{{--                                    <a class="text-dark" href="#">Out for delivery</a>--}}
{{--                                </h5>--}}

{{--                                <p class="font-size-sm mb-0">2:38 AM</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <!-- End Step Item -->--}}

{{--                    <!-- Step Item -->--}}
{{--                    <li class="step-item">--}}
{{--                        <div class="step-content-wrapper">--}}
{{--                            <span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>--}}

{{--                            <div class="step-content">--}}
{{--                                <h5 class="mb-1">--}}
{{--                                    <a class="text-dark" href="#">Package arrived at the final delivery station</a>--}}
{{--                                </h5>--}}

{{--                                <p class="font-size-sm mb-0">2:00 AM</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <!-- End Step Item -->--}}

{{--                    <!-- Step Item -->--}}
{{--                    <li class="step-item">--}}
{{--                        <div class="step-content-wrapper">--}}
{{--                            <small class="step-divider">Tuesday, 18 August</small>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <!-- End Step Item -->--}}

{{--                    <!-- Step Item -->--}}
{{--                    <li class="step-item">--}}
{{--                        <div class="step-content-wrapper">--}}
{{--                            <span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>--}}

{{--                            <div class="step-content">--}}
{{--                                <h5 class="mb-1">--}}
{{--                                    <a class="text-dark" href="#">Tracking number</a>--}}
{{--                                </h5>--}}

{{--                                <a class="link" href="#">3981241023109293</a>--}}
{{--                                <p class="font-size-sm mb-0">6:29 AM</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <!-- End Step Item -->--}}

{{--                    <!-- Step Item -->--}}
{{--                    <li class="step-item">--}}
{{--                        <div class="step-content-wrapper">--}}
{{--                            <span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>--}}

{{--                            <div class="step-content">--}}
{{--                                <h5 class="mb-1">--}}
{{--                                    <a class="text-dark" href="#">Package has dispatched</a>--}}
{{--                                </h5>--}}

{{--                                <p class="font-size-sm mb-0">6:29 AM</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <!-- End Step Item -->--}}

{{--                    <!-- Step Item -->--}}
{{--                    <li class="step-item">--}}
{{--                        <div class="step-content-wrapper">--}}
{{--                            <span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>--}}

{{--                            <div class="step-content">--}}
{{--                                <h5 class="mb-1">--}}
{{--                                    <a class="text-dark" href="#">Order was placed</a>--}}
{{--                                </h5>--}}

{{--                                <p class="font-size-sm mb-0">Order #32543</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <!-- End Step Item -->--}}
{{--                </ul>--}}
{{--                <!-- End Step -->--}}

{{--                <small>Times are shown in the local time zone.</small>--}}
{{--            </div>--}}
{{--            <!-- End Body -->--}}
{{--        </div>--}}
        <!-- END shipping activity -->
    </div>

@endsection

@push('footer_scripts')
    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-sticky-block/dist/hs-sticky-block.min.js', false, true) }}"></script>

    <!-- JS Front -->
    <script src="{{ static_asset('vendor/hs.mask.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.quill.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.sortable.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.flatpickr.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.datatables.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/ev.toast-ui-editor.js', false, true) }}"></script> --}}

@endpush
