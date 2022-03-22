@extends('frontend.layouts.user_panel')

@section('panel_content')




<section>
    <div class="row">
        <div class="col-12">
            <h5 class="text-white">{{ translate('Setup your store') }} </h5>
            {{-- <x-default.dashboard.widgets.onboarding-widget></x-default.dashboard.widgets.onboarding-widget> --}}
        </div>

        <div class="col-12 mb-3">
            {{-- <x-default.promo.shop-subscribe></x-default.promo.shop-subscribe> --}}

        </div>
    </div>
</section>

<section>
    <div class="row mb-3 we-horizontal-slider">
        <div class="col-10 col-sm-4">
            {{-- <x-default.dashboard.widgets.products-widget>
                <a href="{{ route('products.index') }}">
                    {{ translate('View all') }}
                </a>
            </x-default.dashboard.widgets.products-widget> --}}

        </div>

        <div class="col-10 col-sm-4">
            {{-- <x-default.dashboard.widgets.orders-widget>
                <a href="{{ route('orders.index') }}">
                    {{ translate('View all') }}
                </a>
            </x-default.dashboard.widgets.orders-widget> --}}
        </div>
        <div class="col-10 col-sm-4">
            {{-- <x-default.dashboard.widgets.leads-widget>

                <a href="{{ route('leads.index') }}">
                    {{ translate('View all') }}
                </a>

            </x-default.dashboard.widgets.leads-widget> --}}
        </div>
    </div>

</section>
<section>
    <div class="row">
        <div class="grid grid-cols-4 gap-12 mb-12">
            <x-dashboard.elements.card>
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                    <x-slot name="cardHeader" class="font-bold mb-3">
                        <div class="mb-3">
                       {{translate('Most popular categories') }}
                        </div>
                    </x-slot>

                    <x-slot name="cardBody" class="flow-root mt-6">
                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                            @for ($i = 0; $i < 3; $i++ )


                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-8 w-8 rounded-full"
                                            src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80"
                                            alt="">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            Category Name
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            321 Views / 123 Sales
                                        </p>
                                    </div>
                                    <div>
                                        <a href="#"
                                            class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </li>
                            @endfor
                        </ul>
                    </x-slot>


                    <x-slot name="cardFooter">
                        <button type="button"
                            class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Advance to offer
                        </button>
                    </x-slot>

                </div>


            </x-dashboard.elements.card>


            <div class="card bg-white p-4 text-center">
                {{-- TODO : make this company name dynamic --}}
                <div class="h5 fw-600">{{ translate('Products') }} </div>
                <p>{{ translate('Manage & organize your inventory and products') }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-soft-primary">{{ translate('Manage Products')
                    }}</a>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card bg-white p-4 text-center">
                {{-- TODO : make this company name dynamic --}}
                <div class="h5 fw-600">{{ translate('Your Website Admin Panel') }} </div>
                <p>{{ translate('Manage & organize your website settings') }}</p>
                <a href="/admin" class="btn btn-soft-primary">{{ translate('Manage your website') }}</a>
            </div>
        </div>

    </div>
</section>
<section>
    <div class="row">
        <div class="col-12 col-sm-6">
            <x-default.dashboard.widgets.integration-stats-widget url="{{ route('product.create') }}"
                title="Add A Product"
                img="https://cdns.iconmonstr.com/wp-content/assets/preview/2019/240/iconmonstr-product-3.png">
                {{ translate('Create a new product') }}
            </x-default.dashboard.widgets.integration-stats-widget>
        </div>

        <div class="col-12 col-sm-6">
            <x-default.dashboard.widgets.integration-stats-widget url="#" title="Post an update"
                img="https://banner2.cleanpng.com/20190914/tca/transparent-market-icon-news-icon-newspaper-icon-5d7ce8e6009aa0.6164315815684671740025.jpg">
                {{ translate('Share an update with your followers and customers') }}
            </x-default.dashboard.widgets.integration-stats-widget>
        </div>
    </div>
</section>
<section>
    <div class="row">
        <div class="col-12 col-sm-6">
            <x-default.dashboard.widgets.integration-stats-widget url="{{ route('analytics.index') }}"
                title="Website Analytics"
                img="https://developers.google.com/analytics/images/terms/logo_lockup_analytics_icon_vertical_black_2x.png?hl=ar">
                {{ translate('Track your website statictics') }}

            </x-default.dashboard.widgets.integration-stats-widget>
        </div>

        <div class="col-12 col-sm-6">
            <x-default.dashboard.widgets.integration-stats-widget url="#" title="Mailchimp"
                img="https://www.drupal.org/files/project-images/MC_Logo.jpg">
                {{ translate('Send Emails and Newsletters') }}

            </x-default.dashboard.widgets.integration-stats-widget>
        </div>
    </div>
</section>

<section class="stats mb-3">
    <div class="row">
        <div class="col-sm-6 col-12">

            <x-default.dashboard.dashboard-summary.admin>
            </x-default.dashboard.dashboard-summary.admin>
        </div>
        <div class="col-12 col-sm-6">
            <div class="row">
                <div class="col-12">
                    <x-default.dashboard.widgets.integrations-widget>

                    </x-default.dashboard.widgets.integrations-widget>
                </div>
            </div>
        </div>
    </div>

</section>

<section>
    <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>
</section>
@endsection
