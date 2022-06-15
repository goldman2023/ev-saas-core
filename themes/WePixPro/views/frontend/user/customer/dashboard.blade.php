@extends('frontend.layouts.user_panel')

@section('panel_content')
<section>
    <div class="row">
        <div class="grid w-full">
            <x-dashboard.widgets.user-welcome></x-dashboard.widgets.user-welcome>
        </div>
        <div class="sm:grid sm:grid-cols-6 gap-10 mb-12">

            <div class="col-span-6 sm:col-span-4">
                <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                   <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Invoices') }}</h4>
                   <a href="{{ route('my.orders.all') }}" class="btn-primary">{{ translate('Manage invoices') }}</a>
                </div>
                <livewire:dashboard.tables.recent-invoices-widget-table for="me" :per-page="6" :show-per-page="false" :show-search="false" :column-select="false" />

                <div class="w-full grid col-span-1 sm:grid-cols-2 gap-7 mt-6 sm:mt-8 ">
                    <div class="w-full">
                        <x-dashboard.elements.plan-subscriptions-list class="">
                        </x-dashboard.elements.plan-subscriptions-list>
                    </div>
                    <div class="w-full">

                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-2 flex flex-col">
                <div class="w-full bg-white border border-gray-200 rounded-lg cursor-pointer" @click="window.location.href = '{{ get_tenant_setting('pix_pro_software_download_url', '#') }}'">
                    <div class="border-b border-gray-200 px-4 sm:px-7 py-5">
                        <div class="flex justify-between items-center flex-wrap sm:flex-nowrap">
                            <div class="w-full">
                              <h4 class="font-semibold">
                                    <a href="/page/downloads">
                                    {{ translate('Download Software') }}
                                    </a>

                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 sm:px-7 py-5 flex flex-col items-center text-center">
                        <x-tenant.system.image alt="{{ get_site_name() }} logo" class="h-15 object-cover"
                            :image="get_site_logo()">
                        </x-tenant.system.image>

                        <a href="{{ get_tenant_setting('pix_pro_software_download_url') }}" class="w-full btn-primary mt-5 text-center justify-center">
                            {{ translate('Download') }}
                        </a>
                    </div>
                </div>

                <x-dashboard.elements.support-card class="mt-6 sm:mt-8">
                </x-dashboard.elements.support-card>
            </div>

        </div>
    </div>
</section>

<section class="recently-viewed-products mb-3">
    <div class="">
        <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>
    </div>
</section>
@endsection
