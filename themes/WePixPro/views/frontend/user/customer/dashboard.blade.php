@extends('frontend.layouts.user_panel')

@section('panel_content')
<section>

    <div class="row">
        <div class="grid w-full">
            {{-- <x-dashboard.widgets.onboarding-notification></x-dashboard.widgets.onboarding-notification> --}}
        </div>

        <div class="grid w-full">
            {{-- <x-dashboard.widgets.user-welcome></x-dashboard.widgets.user-welcome> --}}
        </div>
        <div class="grid sm:grid-cols-12 gap-8 mb-12">

            @if(auth()->user()?->isSubscribed() ?? false)
            <div class="col-span-12">
                <x-dashboard.widgets.customer.dynamic-stats>
                    </x-dashboard.widgets.business.dynamic-stats>
            </div>
            @endif

            @if(auth()->user()?->hasLicenses())
            <div class="col-span-12 mb-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('My Licenses') }}</h3>

                <livewire:dashboard.tables.licenses-table :user="auth()->user()" :show-search="false"
                    :show-filters="false" :show-filter-dropdown="false" :show-per-page="false" :column-select="false" />
            </div>
            @endif

            @if(auth()->user()?->isSubscribed() ?? false)


            @else
            <div class="col-span-12">
                <div
                    class="p-5 mb-5 border bg-white border-gray-200 rounded-lg sm:flex sm:items-center sm:justify-between">
                    <div class="">
                        <h3 class="text-24 leading-6 font-semibold text-gray-900">{{ translate('Welcome to') }} {{
                            get_site_name() }}</h3>
                        <p class="mt-2 max-w-2xl text-sm text-gray-500">{{ translate('Select your plan and start your
                            free trial') }}</p>
                    </div>

                </div>
                <x-dashboard.widgets.customer.pricing-table>
                </x-dashboard.widgets.customer.pricing-table>
            </div>
            @endif

            <div class="col-span-12 md:col-span-6">
                <x-dashboard.elements.plan-subscriptions-list class="h-full">
                </x-dashboard.elements.plan-subscriptions-list>
            </div>

            <div class="col-span-12 md:col-span-6 flex flex-col">
                <div class="w-full bg-white border border-gray-200 rounded-lg cursor-pointer"
                    @click="window.location.href = '{{ get_tenant_setting('documentation_url', '#') }}'">
                    <div class="border-b border-gray-200 px-4 sm:px-7 py-5">
                        <div class="flex justify-between items-center flex-wrap sm:flex-nowrap">
                            <div class="w-full">
                                <h4 class="font-semibold">
                                    <a href="{{ get_tenant_setting('documentation_url') }}" target="_blank">
                                        {{ translate('Support Channels') }}
                                    </a>

                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 sm:px-7 py-5 flex flex-col items-center text-center">
                        <x-tenant.system.image alt="{{ get_site_name() }} logo" class="h-15 object-cover"
                            :image="get_site_logo()">
                        </x-tenant.system.image>

                        <a href="{{ get_tenant_setting('documentation_url') }}" target="_blank"
                            class="w-full btn-primary mt-5 text-center justify-center">
                            {{ translate('Pixpro support & community') }}
                        </a>
                    </div>
                </div>

                <x-dashboard.elements.support-card class="mt-6 sm:mt-8">
                </x-dashboard.elements.support-card>
            </div>

        </div>
    </div>
</section>

@endsection

@push('modal')
<x-system.form-modal id="pix-pro-generate-license" title="Online License Activation" class="!max-w-3xl">
    <livewire:forms.generate-license-form />
</x-system.form-modal>
@endpush
