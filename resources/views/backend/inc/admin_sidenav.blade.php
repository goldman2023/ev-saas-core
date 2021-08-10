<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="{{ route('admin.dashboard') }}" class="d-block text-left">
                @if(get_setting('system_logo_white') != null)
                    <img class="mw-100" src="{{ uploaded_asset(get_setting('system_logo_white')) }}" class="brand-icon"
                         alt="{{ get_setting('site_name') }}">
                @else
                    <img class="mw-100" src="{{ static_asset('assets/img/logo.png') }}" class="brand-icon"
                         alt="{{ get_setting('site_name') }}">
                @endif
            </a>
        </div>
        <div class="aiz-side-nav-wrap">
            <div class="px-20px mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm text-white" type="text" name=""
                       placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                <li class="aiz-side-nav-item">
                    <a href="{{route('admin.dashboard')}}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Dashboard')}}</span>
                    </a>
                </li>
                {{--                Categories --}}
                <li class="aiz-side-nav-item">

                    <a href="{{route('admin.categories.index')}}"
                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.categories.index', 'admin.categories.create', 'admin.categories.edit'])}}">
                        <i class="las la-boxes aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Category')}}</span>
                    </a>
                </li>


                <!-- POS Addon-->
                @if (\App\Models\Addon::where('unique_identifier', 'pos_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'pos_system')->first()->activated)
                    @if(auth()->user()->isAdmin() || in_array('1', json_decode(auth()->user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-tasks aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('POS System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.pos.index')}}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.pos.index', 'admin.pos.create'])}}">
                                        <span class="aiz-side-nav-text">{{translate('POS Manager')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.pos.activation')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('POS Configuration')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

            <!-- Product -->
                @if(auth()->user()->isAdmin())
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-shopping-cart aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Products')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <!--Submenu-->
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a class="aiz-side-nav-link" href="{{route('admin.products.create')}}">
                                    <span class="aiz-side-nav-text">{{translate('Add New product')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.products.all')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('All Products') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.products')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.products', 'admin.products.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('In House Products') }}</span>
                                </a>
                            </li>
                            @if(\App\Models\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.products.seller')}}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.products.seller', 'admin.products.seller.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Seller Products') }}</span>
                                    </a>
                                </li>
                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{route('digitalproducts.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['digitalproducts.index', 'digitalproducts.create', 'digitalproducts.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Digital Products') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('product_bulk_upload.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Bulk Import') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('product_bulk_export.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Bulk Export')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.brands.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.brands.index', 'admin.brands.create', 'admin.brands.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Brand')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.attributes.slug_index', ['slug' => 'product'])}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.attributes.index','admin.attributes.create','admin.product.attributes.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Attribute')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

            <!-- Sale -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-money-bill aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Sales')}}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        @if(auth()->user()->isAdmin() || in_array('3', json_decode(auth()->user()->staff->role->permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.all_orders.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.all_orders.index', 'admin.all_orders.show'])}}">
                                    <span class="aiz-side-nav-text">{{translate('All Orders')}}</span>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->isAdmin() || in_array('4', json_decode(auth()->user()->staff->role->permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.inhouse_orders.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.inhouse_orders.index', 'admin.inhouse_orders.show'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Inhouse orders')}}</span>
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->isAdmin() || in_array('5', json_decode(auth()->user()->staff->role->permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.seller_orders.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.seller_orders.index', 'admin.seller_orders.show'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Seller Orders')}}</span>
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->isAdmin() || in_array('6', json_decode(auth()->user()->staff->role->permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.pick_up_point.order_index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.pick_up_point.order_index','admin.pick_up_point.order_show'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Pick-up Point Order')}}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                <!-- Refund addon -->
                @if (\App\Models\Addon::where('unique_identifier', 'refund_request')->first() != null && \App\Models\Addon::where('unique_identifier', 'refund_request')->first()->activated)
                    @if(auth()->user()->isAdmin() || in_array('7', json_decode(auth()->user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-backward aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Refunds') }}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.refund_requests_all')}}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.refund_requests_all', 'reason_show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Refund Requests')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.paid_refund')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Approved Refunds')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.rejected_refund')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('rejected Refunds')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.refund_time_config')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Refund Configuration')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

            <!-- Reviews -->
                @if(auth()->user()->isAdmin())
                <li class="aiz-side-nav-item">
                    <a href="{{route('admin.reviews.index')}}" class="aiz-side-nav-link">
                        <i class="las la-star-half-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Reviews')}}</span>
                    </a>
                </li>
                @endif


            <!-- Customers -->
                @if(auth()->user()->isAdmin() || in_array('8', json_decode(auth()->user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-friends aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Customers') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.customers.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Customer list') }}</span>
                                </a>
                            </li>
                            @if(\App\Models\BusinessSetting::where('type', 'classified_product')->first()->value == 1)
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.classified_products')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Classified Products')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.customer_packages.index') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.customer_packages.index', 'admin.customer_packages.create', 'admin.customer_packages.edit'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Classified Packages') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

            <!-- Sellers -->
                @if((auth()->user()->isAdmin() || in_array('9', json_decode(auth()->user()->staff->role->permissions))) && \App\Models\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Sellers') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                @php
                                    $sellers = \App\Models\Seller::where('verification_status', 0)->where('verification_info', '!=', null)->count();
                                @endphp
                                <a href="{{ route('admin.sellers.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.sellers.index', 'admin.sellers.create', 'admin.sellers.edit', 'admin.sellers.payment_history','admin.sellers.approved','admin.sellers.profile_modal','admin.sellers.show_verification_request'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('All Seller') }}</span>
                                    @if($sellers > 0)<span class="badge badge-info">{{ $sellers }}</span> @endif
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.sellers.payment_histories') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Payouts') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('withdraw_requests_all') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Payout Requests') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.business_settings.vendor_commission') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Seller Commission') }}</span>
                                </a>
                            </li>

                            @if (\App\Models\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Models\Addon::where('unique_identifier', 'seller_subscription')->first()->activated)
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.seller_packages.index') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.seller_packages.index', 'admin.seller_packages.create', 'admin.seller_packages.edit'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Seller Packages') }}</span>
                                        @if (env("DEMO_MODE") == "On")
                                            <span class="badge badge-inline badge-danger">Addon</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.seller_verification_form.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Seller Verification Form') }}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.attributes.slug_index', ['slug' => 'sellers'])}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.attributes.index','admin.attributes.create','admin.seller.attributes.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Attribute')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- Events --}}
                @if((auth()->user()->isAdmin() || in_array('9', json_decode(auth()->user()->staff->role->permissions))) && \App\Models\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-tachometer-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Events') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                @php
                                    $events = \App\Models\Event::count();
                                @endphp
                                <a href="{{ route('admin.events.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.events.index', 'admin.events.create', 'admin.events.edit'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('All Events') }}</span>
                                    @if($events > 0)<span class="badge badge-info">{{ $events }}</span> @endif
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.attributes.slug_index', ['slug' => 'events'])}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.attributes.index','admin.attributes.create','admin.event.attributes.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Attribute')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- Jobs --}}
                @if((auth()->user()->isAdmin() || in_array('9', json_decode(auth()->user()->staff->role->permissions))) && \App\Models\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-tachometer-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Jobs') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                @php
                                    $jobs = \App\Models\Job::count();
                                @endphp
                                <a href="{{ route('admin.jobs.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.jobs.index', 'admin.jobs.create', 'admin.jobs.edit'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('All Jobs') }}</span>
                                    @if($jobs > 0)<span class="badge badge-info">{{ $jobs }}</span> @endif
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.attributes.slug_index', ['slug' => 'jobs'])}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.attributes.index','admin.attributes.create','admin.job.attributes.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Attribute')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.seo.index') }}"
                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.seo.index'])}}">
                        <i class="las la-ad aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('SEO') }}</span>
                    </a>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.uploaded-files.index') }}"
                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.uploaded-files.create'])}}">
                        <i class="las la-folder-open aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Uploaded Files') }}</span>
                    </a>
                </li>

                <!-- Reports -->
                @if(auth()->user()->isAdmin() || in_array('10', json_decode(auth()->user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-file-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Reports') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.in_house_sale_report.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.in_house_sale_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('In House Product Sale') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.seller_sale_report.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.seller_sale_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Seller Products Sale') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.stock_report.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.stock_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Products Stock') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.wish_report.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.wish_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Products wishlist') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.user_search_report.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.user_search_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('User Searches') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('commission-log.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Commission History') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.wallet-history.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Wallet Recharge History') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

            <!--Blog System-->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-bullhorn aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Blog System') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.blog.index') }}"
                               class="aiz-side-nav-link {{ areActiveRoutes(['admin.blog.create', 'admin.blog.edit'])}}">
                                <span class="aiz-side-nav-text">{{ translate('All Posts') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- marketing -->
                @if(auth()->user()->isAdmin() || in_array('11', json_decode(auth()->user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-bullhorn aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Marketing') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.affiliate_banner.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.affiliate_banner.index', 'admin.affiliate_banner.create', 'admin.affiliate_banner.edit'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Affiliate Banner') }}</span>
                                </a>
                            </li>
                            @if(auth()->user()->isAdmin() || in_array('2', json_decode(auth()->user()->staff->role->permissions)))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.flash_deals.index') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.flash_deals.index', 'admin.flash_deals.create', 'admin.flash_deals.edit'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Flash deals') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAdmin() || in_array('7', json_decode(auth()->user()->staff->role->permissions)))
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.newsletters.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Newsletters') }}</span>
                                    </a>
                                </li>
                                @if (\App\Models\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('admin.sms.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{ translate('Bulk SMS') }}</span>
                                            @if (env("DEMO_MODE") == "On")
                                                <span class="badge badge-inline badge-danger">Addon</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.subscribers.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Subscribers') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.coupon.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.coupon.index','admin.coupon.create','admin.coupon.edit'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Coupon') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

            <!-- Support -->
                @if(auth()->user()->isAdmin() || in_array('12', json_decode(auth()->user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-link aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Support')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if(auth()->user()->isAdmin() || in_array('13', json_decode(auth()->user()->staff->role->permissions)))
                                @php
                                    $support_ticket = DB::table('tickets')
                                                ->where('viewed', 0)
                                                ->select('id')
                                                ->count();
                                @endphp
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.support_ticket.index') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.support_ticket.index', 'admin.support_ticket.sqho'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Ticket')}}</span>
                                        @if($support_ticket > 0)<span
                                            class="badge badge-info">{{ $support_ticket }}</span>@endif
                                    </a>
                                </li>
                            @endif

                            @php
                                $conversation = \App\Models\Conversation::where('receiver_id', auth()->user()->id)->where('receiver_viewed', '1')->get();
                            @endphp
                            @if(auth()->user()->isAdmin() || in_array('16', json_decode(auth()->user()->staff->role->permissions)))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.conversations.index') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.conversations.index', 'admin.conversations.show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Product Queries')}}</span>
                                        @if (count($conversation) > 0)
                                            <span class="badge badge-info">{{ count($conversation) }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

            <!-- Affiliate Addon -->
                @if (\App\Models\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'affiliate_system')->first()->activated)
                    @if(auth()->user()->isAdmin() || in_array('15', json_decode(auth()->user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-link aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Affiliate System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.affiliate.configs')}}" class="aiz-side-nav-link">
                                        <span
                                            class="aiz-side-nav-text">{{translate('Affiliate Registration Form')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.affiliate.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Affiliate Configurations')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.affiliate.users')}}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.affiliate.users', 'admin.affiliate_users.show_verification_request', 'admin.affiliate_user.payment_history'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Affiliate Users')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('refferals.users')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Referral Users')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.affiliate.withdraw_requests')}}" class="aiz-side-nav-link">
                                        <span
                                            class="aiz-side-nav-text">{{translate('Affiliate Withdraw Requests')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.affiliate.logs.admin')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Affiliate Logs')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

            <!-- Offline Payment Addon-->
                @if (\App\Models\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Models\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                    @if(auth()->user()->isAdmin() || in_array('16', json_decode(auth()->user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-money-check-alt aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Offline Payment System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.manual_payment_methods.index') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.manual_payment_methods.index', 'admin.manual_payment_methods.create', 'admin.manual_payment_methods.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Manual Payment Methods')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.offline_wallet_recharge_request.index') }}"
                                       class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Offline Wallet Recharge')}}</span>
                                    </a>
                                </li>
                                @if(\App\Models\BusinessSetting::where('type', 'classified_product')->first()->value == 1)
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('admin.offline_customer_package_payment_request.index') }}"
                                           class="aiz-side-nav-link">
                                            <span
                                                class="aiz-side-nav-text">{{translate('Offline Customer Package Payments')}}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (\App\Models\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Models\Addon::where('unique_identifier', 'seller_subscription')->first()->activated)
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('admin.offline_seller_package_payment_request.index') }}"
                                           class="aiz-side-nav-link">
                                            <span
                                                class="aiz-side-nav-text">{{translate('Offline Seller Package Payments')}}</span>
                                            @if (env("DEMO_MODE") == "On")
                                                <span class="badge badge-inline badge-danger">Addon</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif

            <!-- Paytm Addon -->
                @if (\App\Models\Addon::where('unique_identifier', 'paytm')->first() != null && \App\Models\Addon::where('unique_identifier', 'paytm')->first()->activated)
                    @if(auth()->user()->isAdmin() || in_array('17', json_decode(auth()->user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-mobile-alt aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Paytm Payment Gateway')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.paytm.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Set Paytm Credentials')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

            <!-- Club Point Addon-->
                @if (\App\Models\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Models\Addon::where('unique_identifier', 'club_point')->first()->activated)
                    @if(auth()->user()->isAdmin() || in_array('18', json_decode(auth()->user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="lab la-btc aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Club Point System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.club_points.configs') }}" class="aiz-side-nav-link">
                                        <span
                                            class="aiz-side-nav-text">{{translate('Club Point Configurations')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.set_product_points')}}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.set_product_points', 'admin.product_club_point.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Set Product Point')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('club_points.index')}}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['admin.club_points.index', 'admin.club_point.details'])}}">
                                        <span class="aiz-side-nav-text">{{translate('User Points')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

            <!--OTP addon -->
                @if (\App\Models\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                    @if(auth()->user()->isAdmin() || in_array('19', json_decode(auth()->user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-phone aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('OTP System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.otp.configconfiguration') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('OTP Configurations')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.otp_credentials.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Set OTP Credentials')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

                @if(\App\Models\Addon::where('unique_identifier', 'african_pg')->first() != null && \App\Models\Addon::where('unique_identifier', 'african_pg')->first()->activated)
                    @if(auth()->user()->isAdmin() || in_array('19', json_decode(auth()->user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-phone aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('African Payment Gateway Addon')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('admin.african.configuration') }}" class="aiz-side-nav-link">
                                        <span
                                            class="aiz-side-nav-text">{{translate('African PG Configurations')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('admin.african_credentials.index')}}" class="aiz-side-nav-link">
                                        <span
                                            class="aiz-side-nav-text">{{translate('Set African PG Credentials')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

            <!-- Website Setup -->
                @if(auth()->user()->isAdmin() || in_array('13', json_decode(auth()->user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-desktop aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Website Setup')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.website.header') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Header')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.website.footer') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Footer')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.website.pages') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.website.pages', 'admin.custom-pages.create' ,'admin.custom-pages.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Pages')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.website.appearance') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Appearance')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                {{--  Activity of user --}}
                <li class="aiz-side-nav-item">
                    {{--  {{ areActiveRoutes(['admin.categories.index', 'admin.categories.create', 'admin.categories.edit'])}} add this in class below so it would highlight the route  --}}
                    <a href="#" class="aiz-side-nav-link {{ areActiveRoutes(['admin.activities.index', 'admin.activities.user.index'])}} ">
                        <i class="las la-undo-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Activity')}}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{route("admin.activities.index")}}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{translate('All Activities')}}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{route("admin.activities.user.index")}}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{translate('My Activities')}}</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- Setup & Configurations -->
                @if(auth()->user()->isAdmin() || in_array('14', json_decode(auth()->user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-dharmachakra aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Setup & Configurations')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.general_setting.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('General Settings')}}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.activation.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Features activation')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.languages.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.languages.index', 'admin.languages.create', 'admin.languages.store', 'admin.languages.show', 'admin.languages.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Languages')}}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.currency.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Currency')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.tax.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.tax.index', 'admin.tax.create', 'admin.tax.store', 'admin.tax.show', 'admin.tax.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Vat & TAX')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.pick_up_points.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.pick_up_points.index','admin.pick_up_points.create','admin.pick_up_points.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Pickup point')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.smtp_settings.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('SMTP Settings')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.payment_method.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Payment Methods')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.file_system.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('File System Configuration')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.social_login.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Social media Logins')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.google_analytics.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Analytics Tools')}}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="javascript:void(0);" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Facebook')}}</span>
                                    <span class="aiz-side-nav-arrow"></span>
                                </a>
                                <ul class="aiz-side-nav-list level-3">
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('admin.facebook_chat.index') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Facebook Chat')}}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('admin.facebook-comment') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{translate('Facebook Comment')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.google_recaptcha.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Google reCAPTCHA')}}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="javascript:void(0);" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Shipping')}}</span>
                                    <span class="aiz-side-nav-arrow"></span>
                                </a>
                                <ul class="aiz-side-nav-list level-3">
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('admin.shipping_configuration.index')}}"
                                           class="aiz-side-nav-link {{ areActiveRoutes(['admin.shipping_configuration.index','admin.shipping_configuration.edit','admin.shipping_configuration.update'])}}">
                                            <span
                                                class="aiz-side-nav-text">{{translate('Shipping Configuration')}}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('admin.countries.index')}}"
                                           class="aiz-side-nav-link {{ areActiveRoutes(['admin.countries.index','admin.countries.edit','admin.countries.update'])}}">
                                            <span class="aiz-side-nav-text">{{translate('Shipping Countries')}}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('admin.cities.index')}}"
                                           class="aiz-side-nav-link {{ areActiveRoutes(['admin.cities.index','admin.cities.edit','admin.cities.update'])}}">
                                            <span class="aiz-side-nav-text">{{translate('Shipping Cities')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </li>
                @endif


            <!-- Staffs -->
                @if(auth()->user()->isAdmin() || in_array('20', json_decode(auth()->user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-tie aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Staffs')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('admin.staffs.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.staffs.index', 'admin.staffs.create', 'admin.staffs.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('All staffs')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('admin.roles.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['admin.roles.index', 'admin.roles.create', 'admin.roles.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Staff permissions')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-user-tie aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('System')}}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.system_update') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{translate('Update')}}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{route('admin.system_server')}}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{translate('Server status')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Addon Manager -->
                @if(auth()->user()->isAdmin() || in_array('21', json_decode(auth()->user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="{{route('admin.addons.index')}}"
                           class="aiz-side-nav-link {{ areActiveRoutes(['admin.addons.index', 'admin.addons.create'])}}">
                            <i class="las la-wrench aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Addon Manager')}}</span>
                        </a>
                    </li>
                @endif
            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->
