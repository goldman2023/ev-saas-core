<div class="aiz-user-sidenav-wrap pt-4 position-relative z-1 shadow-sm">
    <div class="absolute-top-right d-xl-none">
        <button class="btn btn-sm p-2" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav"
                data-same=".mobile-side-nav-thumb">
            <i class="las la-times la-2x"></i>
        </button>
    </div>
    <div class="absolute-top-left d-xl-none">
        <a class="btn btn-sm p-2" href="{{ route('logout') }}">
            <i class="las la-sign-out-alt la-2x"></i>
        </a>
    </div>
    <div class="aiz-user-sidenav rounded overflow-hidden  c-scrollbar-light">
        <div class="px-4 text-center mb-4">
            <span class="avatar avatar-md mb-3">
                <img class="img-fluid" src="{{ auth()->user()->shop->get_company_logo() }}"
                     alt="{{ auth()->user()->shop->name }}">
            </span>

            @if (auth()->user()->isCustomer())
                <h4 class="h5 fw-600">{{ auth()->user()->seller->shop->name }}</h4>
            @else
                <h4 class="h5 fw-600">{{ auth()->user()->shop->name }}
                    <span class="ml-2">
                        @if (auth()->user()->seller->verification_status == 1)
                            <i class="las la-check-circle" style="color:green"></i>
                        @else
                            <i class="las la-times-circle" style="color:red"></i>
                        @endif
                    </span>
                </h4>
            @endif
        </div>

        <div class="sidemnenu mb-3">
            <ul class="aiz-side-nav-list" data-toggle="aiz-side-menu">

                <li class="aiz-side-nav-item">
                    <a href="{{ route('dashboard') }}"
                       class="aiz-side-nav-link {{ areActiveRoutes(['dashboard']) }}">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Dashboard') }}</span>
                    </a>
                </li>

                @php
                    $delivery_viewed = App\Models\Order::where('user_id', auth()->user()->id)
                        ->where('delivery_viewed', 0)
                        ->get()
                        ->count();
                    $payment_status_viewed = App\Models\Order::where('user_id', auth()->user()->id)
                        ->where('payment_status_viewed', 0)
                        ->get()
                        ->count();
                @endphp


                @php
                    $refund_request_addon = \App\Models\Addon::where('unique_identifier', 'refund_request')->first();
                    $club_point_addon = \App\Models\Addon::where('unique_identifier', 'club_point')->first();
                @endphp
                {{-- @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('customer_refund_request') }}" class="aiz-side-nav-link {{ areActiveRoutes(['customer_refund_request'])}}">
                            <i class="las la-backward aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Sent Refund Request') }}</span>
                        </a>
                    </li>
                @endif --}}

                {{-- <li class="aiz-side-nav-item">
                    <a href="{{ route('wishlists.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['wishlists.index'])}}">
                        <i class="la la-heart-o aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Wishlist') }}</span>
                    </a>
                </li> --}}



                @if (\App\Models\BusinessSetting::where('type', 'classified_product')->first()->value == 1)
                    {{-- <li class="aiz-side-nav-item">
                        <a href="{{ route('customer_products.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['customer_products.index', 'customer_products.create', 'customer_products.edit'])}}">
                            <i class="lab la-sketch aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Classified Products') }}</span>
                        </a>
                    </li> --}}
                @endif

                @if (auth()->user()->isSeller())
                    @if (\App\Models\Addon::where('unique_identifier', 'pos_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'pos_system')->first()->activated)
                        @if (\App\Models\BusinessSetting::where('type', 'pos_activation_for_seller')->first() != null && \App\Models\BusinessSetting::where('type', 'pos_activation_for_seller')->first()->value != 0)
                            {{-- <li class="aiz-side-nav-item">
                                <a href="{{ route('poin-of-sales.seller_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['poin-of-sales.seller_index'])}}">
                                    <i class="las la-fax aiz-side-nav-icon"></i>
                                    <span class="aiz-side-nav-text">{{ translate('POS Manager') }}</span>
                                </a>
                            </li> --}}
                        @endif
                    @endif

                    @php

                    @endphp
                    {{-- <li class="aiz-side-nav-item">
                        <a href="{{ route('orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['orders.index'])}}">
                            <i class="las la-money-bill aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Orders') }}</span>
                            @if ($orders > 0)<span class="badge badge-inline badge-success">{{ $orders }}</span>@endif
                        </a>
                    </li> --}}

                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                        {{-- <li class="aiz-side-nav-item">
                            <a href="{{ route('vendor_refund_request') }}" class="aiz-side-nav-link {{ areActiveRoutes(['vendor_refund_request','reason_show'])}}">
                                <i class="las la-backward aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Received Refund Request') }}</span>
                            </a>
                        </li> --}}
                    @endif

                        @if (\App\Models\BusinessSetting::where('type', 'conversation_system')->first()->value == 1)
                            @php
                                $conversation = \App\Models\Conversation::where('sender_id', Auth::user()->id)
                                    ->where('sender_viewed', 0)
                                    ->get();
                            @endphp
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('conversations.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['conversations.index', 'conversations.show']) }}">
                                    <i class="las la-comment aiz-side-nav-icon"></i>
                                    <span class="aiz-side-nav-text">{{ translate('Messages') }}</span>
                                    @if (count($conversation) > 0)
                                        <span class="badge badge-success">({{ count($conversation) }})</span>
                                    @endif
                                </a>
                            </li>
                        @endif

                    <li class="aiz-side-nav-item">
                        <a href="{{ route('shops.index') }}"
                           class="aiz-side-nav-link {{ areActiveRoutes(['shops.index']) }}">
                            <i class="las la-cog aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Company Data') }}</span>
                        </a>
                    </li>

                    @if (auth()->user()->isSeller())
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('attributes') }}"
                               class="aiz-side-nav-link {{ areActiveRoutes(['attributes']) }}">
                                <i class="las la-user aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">
                                    {{ translate('Business Profile') }}
                                </span>
                            </a>
                        </li>
                    @endif

                    {{-- <li class="aiz-side-nav-item">
                        <a href="{{ route('withdraw_requests.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['withdraw_requests.index'])}}">
                            <i class="las la-money-bill-wave-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Money Withdraw') }}</span>
                        </a>
                    </li> --}}

                    {{-- <li class="aiz-side-nav-item">
                        <a href="{{ route('commission-log.index') }}" class="aiz-side-nav-link">
                            <i class="las la-file-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Commission History') }}</span>
                        </a>
                    </li> --}}

                @endif


                @if (\App\Models\BusinessSetting::where('type', 'conversation_system')->first()->value == 1)
                    {{--    @php
                           $conversation = \App\Models\Conversation::where('sender_id', auth()->user()->id)
                               ->where('sender_viewed', 0)
                               ->get();
                       @endphp
                       <li class="aiz-side-nav-item">
                           <a href="{{ route('conversations.index') }}"
                               class="aiz-side-nav-link {{ areActiveRoutes(['conversations.index', 'conversations.show']) }}">
                               <i class="las la-comment aiz-side-nav-icon"></i>
                               <span class="aiz-side-nav-text">{{ translate('Requests') }}</span>
                               @if (count($conversation) > 0)
                                   <span class="badge badge-success">({{ count($conversation) }})</span>
                               @endif
                           </a>
                       </li>
                       --}}
                @endif


                @if (\App\Models\BusinessSetting::where('type', 'wallet_system')->first()->value == 1)
                    {{-- <li class="aiz-side-nav-item">
                        <a href="{{ route('wallet.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['wallet.index'])}}">
                            <i class="las la-dollar-sign aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('My Wallet')}}</span>
                        </a>
                    </li> --}}
                @endif

                @if ($club_point_addon != null && $club_point_addon->activated == 1)
                    {{-- <li class="aiz-side-nav-item">
                        <a href="{{ route('earnng_point_for_user') }}" class="aiz-side-nav-link {{ areActiveRoutes(['earnng_point_for_user'])}}">
                            <i class="las la-dollar-sign aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Earning Points')}}</span>
                        </a>
                    </li> --}}
                @endif

                @if (\App\Models\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'affiliate_system')->first()->activated && auth()->user()->affiliate_user != null && auth()->user()->affiliate_user->status)
                    {{-- <li class="aiz-side-nav-item">
                        <a href="javascript:void(0);" class="aiz-side-nav-link {{ areActiveRoutes(['affiliate.user.index', 'affiliate.payment_settings'])}}">
                            <i class="las la-dollar-sign aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Affiliate') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('affiliate.user.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Affiliate System') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('affiliate.user.payment_history') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Payment History') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('affiliate.user.withdraw_request_history') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Withdraw request history') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                @endif

                @php
                    $support_ticket = DB::table('tickets')
                        ->where('client_viewed', 0)
                        ->where('user_id', auth()->user()->id)
                        ->count();
                @endphp

                {{-- <li class="aiz-side-nav-item">
                    <a href="{{ route('support_ticket.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['support_ticket.index'])}}">
                        <i class="las la-atom aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Support Ticket')}}</span>
                        @if ($support_ticket > 0)<span class="badge badge-inline badge-success">{{ $support_ticket }}</span> @endif
                    </a>
                </li> --}}

                <li class="aiz-side-nav-item">
                    <a href="{{ route('profile') }}" class="aiz-side-nav-link {{ areActiveRoutes(['profile']) }}">
                        <i class="las la-user aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('User Settings') }}</span>
                    </a>
                </li>

                @if (auth()->user()->isSeller())
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('documentgallery.index') }}"
                           class="aiz-side-nav-link {{ areActiveRoutes(['documentgallery.index']) }}">
                            <i class="las la-user aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Company Gallery') }}</span>
                        </a>
                    </li>
                @endif

                <li class="aiz-side-nav-item d-none">
                    <a href="{{ route('payments.index') }}"
                       class="aiz-side-nav-link {{ areActiveRoutes(['payments.index']) }}">
                        <i class="las la-history aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Invoices') }}</span>
                    </a>
                </li>

                @php
                    $review_count = auth()->user()->seller->reviews->count();
                @endphp
                <li class="aiz-side-nav-item d-none">
                    <a href="{{ route('reviews.seller') }}"
                       class="aiz-side-nav-link {{ areActiveRoutes(['reviews.seller']) }}">
                        <i class="las la-star-half-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Reviews') }}</span>
                        @if ($review_count > 0)<span
                            class="badge badge-inline badge-success">{{ $review_count }}</span>@endif
                    </a>
                </li>
                @if (auth()->user()->isSeller())
                    <li class="aiz-side-nav-item d-none">
                        <a href="{{ route('seller.products') }}"
                           class="aiz-side-nav-link {{ areActiveRoutes(['seller.products', 'seller.products.upload', 'seller.products.edit']) }}">
                            <i class="lab la-sketch aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Products') }}</span>
                        </a>
                    </li>
                    <li class="aiz-side-nav-item d-none">
                        <a href="{{ route('product_bulk_upload.index') }}"
                           class="aiz-side-nav-link {{ areActiveRoutes(['product_bulk_upload.index']) }}">
                            <i class="las la-upload aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Product Bulk Upload') }}</span>
                        </a>
                    </li>
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('seller.digitalproducts') }}"
                           class="aiz-side-nav-link {{ areActiveRoutes(['seller.digitalproducts', 'seller.digitalproducts.upload', 'seller.digitalproducts.edit']) }}">
                            <i class="lab la-sketch aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Products') }}</span>
                        </a>
                    </li>

                    <li class="aiz-side-nav-item">
                        <a href="{{ route('orders.index') }}"
                           class="aiz-side-nav-link {{ areActiveRoutes(['orders.index'])}}">
                            <i class="las la-money-bill aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Orders') }}</span>
                        </a>
                    </li>

                    <li class="aiz-side-nav-item">
                        <a href="{{ route('seller.events') }}" class="aiz-side-nav-link {{ areActiveRoutes(['seller.events', 'seller.events.create', 'seller.events.edit']) }}">
                            <i class="las la-tachometer-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Events') }}</span>
                        </a>
                    </li>
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('seller.jobs') }}"
                            class="aiz-side-nav-link {{ areActiveRoutes(['seller.jobs', 'seller.jobs.upload', 'seller.jobs.edit']) }}">
                            <i class="las la-industry aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Jobs') }}</span>
                        </a>
                    </li>
                @endif

                <hr>
                <li class="aiz-side-nav-item">
                    <a href="{{ route('purchase_history.index') }}"
                       class="aiz-side-nav-link {{ areActiveRoutes(['purchase_history.index'])}}">
                        <i class="las la-file-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Purchase History') }}</span>
                        @if ($delivery_viewed > 0 || $payment_status_viewed > 0)<span
                            class="badge badge-inline badge-success">{{ translate('New') }}</span>@endif
                    </a>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="{{ route('digital_purchase_history.index') }}"
                       class="aiz-side-nav-link {{ areActiveRoutes(['digital_purchase_history.index'])}}">
                        <i class="las la-download aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Downloads') }}</span>
                    </a>
                </li>

                @if (get_setting('wallet_system') == 1)
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('wallet.index') }}"
                           class="aiz-side-nav-link {{ areActiveRoutes(['wallet.index']) }}">
                            <i class="las la-dollar-sign aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('My Wallet') }}</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
        @if (\App\Models\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1 && auth()->user()->isCustomer())
            <div>
                <a href="{{ route('shops.create') }}" class="btn btn-block btn-soft-primary rounded-0">
                    </i>{{ translate('Register your company') }}
                </a>
            </div>
        @endif
        @if (auth()->user()->isSeller())
            {{-- <hr> --}}


            <div class="">
                @if (auth()->user()->products->count() > 0)

                    <x-balance-widget-shop></x-balance-widget-shop>
                @endif
            </div>

            <x-credit-report-box :company="auth()->user()->shop"></x-credit-report-box>
        @endif

    </div>


</div>
