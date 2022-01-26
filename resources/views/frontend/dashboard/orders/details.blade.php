@extends('frontend.layouts.user_panel')

@section('page_title', translate('Order #').($order->id??'').translate('details'))

@push('head_scripts')

@endpush

@section('panel_content')
    <!-- Card -->
    <div class="card">
        <!-- Card Body -->
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">

                    <nav class="mb-2">
                        <a href="{{ route('orders.index') }}" class="text-14 d-inline-flex align-items-center">
                            @svg('heroicon-o-chevron-left', ['class' => 'square-14 mr-1'])
                            <span>{{ translate('Go back to Orders') }}</span>
                        </a>
                    </nav>

                    <div class="d-sm-flex align-items-sm-center">
                        <h1 class="page-header-title text-24 mr-3">{{ translate('Order') }} #{{ $order->id }}</h1>

                        @if($order->payment_status === App\Models\Order::PAYMENT_STATUS_PAID)
                            <span class="badge badge-soft-success mr-3">
                              <span class="legend-indicator bg-success mr-1"></span> {{ ucfirst(\Str::replace('_', ' ', $order->payment_status)) }}
                            </span>
                        @elseif($order->payment_status === App\Models\Order::PAYMENT_STATUS_PENDING)
                            <span class="badge badge-soft-warning  mr-3">
                              <span class="legend-indicator bg-warning mr-1"></span> {{ ucfirst(\Str::replace('_', ' ', $order->payment_status)) }}
                            </span>
                        @elseif($order->payment_status === App\Models\Order::PAYMENT_STATUS_UNPAID)
                            <span class="badge badge-soft-danger  mr-3">
                              <span class="legend-indicator bg-danger mr-1"></span> {{ ucfirst(\Str::replace('_', ' ', $order->payment_status)) }}
                            </span>
                        @endif

                        @if($order->shipping_status === App\Models\Order::SHIPPING_STATUS_DELIVERED)
                            <span class="badge badge-soft-success  mr-2">
                              <span class="legend-indicator bg-success mr-1"></span> {{ ucfirst(\Str::replace('_', ' ', $order->shipping_status)) }}
                            </span>
                        @elseif($order->shipping_status === App\Models\Order::SHIPPING_STATUS_SENT)
                            <span class="badge badge-soft-warning  mr-2">
                              <span class="legend-indicator bg-warning mr-1"></span> {{ ucfirst(\Str::replace('_', ' ', $order->shipping_status)) }}
                            </span>
                        @elseif($order->shipping_status === App\Models\Order::SHIPPING_STATUS_NOT_SENT)
                            <span class="badge badge-soft-danger mr-2">
                              <span class="legend-indicator bg-danger mr-1"></span> {{ ucfirst(\Str::replace('_', ' ', $order->shipping_status)) }}
                            </span>
                        @endif

                        <span class="ml-2 ml-sm-3">
{{--                            TODO: Fix datetime display --}}
                          <i class="tio-date-range"></i> {{ $order->created_at }}
                        </span>
                    </div>

                    <div class="mt-2">
                        <a class="text-body mr-3" href="javascript:;" onclick="window.print(); return false;">
                            <i class="tio-print mr-1"></i> {{ translate('Print order') }}
                        </a>

                        <!-- Unfold -->
{{--                        TODO: Fix unfold --}}
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker text-body" href="javascript:;" data-hs-unfold-options='{
                               "target": "#moreOptionsDropdown",
                               "type": "css-animation"
                            }' data-hs-unfold-target="#moreOptionsDropdown" data-hs-unfold-invoker="">
                                {{ translate('More options') }} <i class="tio-chevron-down"></i>
                            </a>

                            <div id="moreOptionsDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu mt-1 hs-unfold-hidden hs-unfold-content-initialized hs-unfold-css-animation animated" data-hs-target-height="195.984" data-hs-unfold-content="" data-hs-unfold-content-animation-in="slideInUp" data-hs-unfold-content-animation-out="fadeOut" style="animation-duration: 300ms;">
                                <a class="dropdown-item" href="#">
                                    <i class="tio-copy dropdown-item-icon"></i> {{ translate('Duplicate') }}
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="tio-clear dropdown-item-icon"></i> {{ translate('Cancel order') }}
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="tio-archive dropdown-item-icon"></i> {{ translate('Archive') }}
                                </a>
                            </div>
                        </div>
                        <!-- End Unfold -->
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
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
    <script src="{{ static_asset('vendor/ev.toast-ui-editor.js', false, true) }}"></script>

@endpush
