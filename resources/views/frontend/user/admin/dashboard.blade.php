@extends('frontend.layouts.user_panel')

@section('panel_content')

<section>
    <div class="grid grid-cols-3">
        <div class="col-span-1">
            {{-- <x-default.dashboard.widgets.onboarding-widget></x-default.dashboard.widgets.onboarding-widget> --}}
        </div>

        <div class="col-span-1">
            {{-- <x-default.promo.shop-subscribe></x-default.promo.shop-subscribe> --}}
        </div>
    </div>
</section>

<section>
    <div class="row">
        <div class="grid">
            <x-dashboard.widgets.user-welcome></x-dashboard.widgets.user-welcome>
        </div>
        <div class="grid sm:grid-cols-3 gap-8">
            <div class="col-span-2">
                <div class="sm:grid sm:grid-cols-1 gap-5 mb-12">
                    <div class="sm:grid grid-cols-3 gap-5">
                        <x-dashboard.elements.card>
                            <x-slot name="cardHeader" class="flow-root mt-6">
                                <div class="h5 fw-600">{{ translate('Plans & Subscribers') }} </div>
                            </x-slot>
                            <x-slot name="cardBody" class="">
                                {{-- TODO : make this company name dynamic --}}
                                <p>{{ translate('Manage & organize your licenses and subscriptions') }}</p>

                            </x-slot>
                            <x-slot name="cardFooter">
                                <a href="{{ route('plans.index') }}" class="btn btn-soft-primary">
                                    {{ translate('Manage Plans') }}
                                </a>
                            </x-slot>
                        </x-dashboard.elements.card>

                        <x-dashboard.elements.card>
                            <x-slot name="cardHeader" class="flow-root mt-6">
                                <div class="h5 fw-600">{{ translate('Emails & Newsletter subscribers') }} </div>
                            </x-slot>
                            <x-slot name="cardBody" class="">
                                {{-- TODO : make this company name dynamic --}}
                                <p>{{ translate('Manage & organize your licenses and subscriptions') }}</p>

                            </x-slot>
                            <x-slot name="cardFooter">
                                <a
                                target="_blank"
                                href="{{ translate('https://dashboard.mailerlite.com/dashboard') }}"
                                class="btn btn-soft-primary block text-center">
                                    {{ translate('Manage Newsletters') }}
                                    <br>
                                    <small class="w-full">
                                        {{ translate('via Mailerlite') }}
                                    </small>
                                </a>
                            </x-slot>
                        </x-dashboard.elements.card>

                        <x-dashboard.elements.card>
                            <x-slot name="cardHeader" class="flow-root mt-6">
                                <div class="h5 fw-600">{{ translate('Payments and Invoices') }} </div>
                            </x-slot>
                            <x-slot name="cardBody" class="">
                                {{-- TODO : make this company name dynamic --}}
                                <p>{{ translate('Sell all payments data, download invoces and income reports') }}</p>

                            </x-slot>
                            <x-slot name="cardFooter">
                                <a
                                target="_blank"
                                href="{{ translate('https://dashboard.mailerlite.com/dashboard') }}" class="btn btn-soft-primary block text-center">
                                    {{ translate('Manage Payments') }}
                                   <br>
                                    <small class="w-full block">
                                      {{ translate('via Stripe') }}
                                    </small>
                                </a>
                            </x-slot>
                        </x-dashboard.elements.card>
                    </div>
                    <div>

                        <x-dashboard.elements.support-card class="card mb-3">
                        </x-dashboard.elements.support-card>

                    </div>

                    <div>
                        <x-dashboard.elements.card>
                            <x-slot name="cardHeader" class="flow-root mt-6">
                                <div class="h5 fw-600">{{ translate('Quick Actions') }} </div>
                            </x-slot>
                            <x-slot name="cardBody" class="">
                                {{-- TODO : make this company name dynamic --}}
                                <p>{{ translate('') }}</p>
                            </x-slot>
                            <x-slot name="cardFooter">
                                <div class="overflow-x-auto sm:flex lg:block">
                                    <a href="{{ route('orders.index') }}" class="btn btn-soft-primary mb-3">
                                        🚚 {{ translate('Process Orders') }}
                                    </a>

                                    <a href="https://dashboard.stripe.com/invoices" taget="_blank" class="btn btn-soft-primary mb-3">
                                        📄 {{ translate('Invoices & Payments') }}
                                    </a>

                                    <a href="{{ route('plans.index') }}" class="btn btn-soft-primary mb-3">
                                        📦 {{ translate('Manage Plans') }}
                                    </a>

                                    <a href="{{ route('blog.posts.index') }}" class="btn btn-soft-primary">
                                        🏷️ {{ translate('Manage Blog') }}
                                    </a>
                                </div>
                            </x-slot>
                        </x-dashboard.elements.card>
                    </div>

                    <div class="w-full">
                        <livewire:dashboard.tables.recent-invoices-widget-table for="all" :per-page="6" :show-per-page="false"
                            :show-search="false" :column-select="false" />
                    </div>

                    <div class="w-full">
                        <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>

                    </div>

                </div>
            </div>

            <div class="col-span-1">
                @livewire('dashboard.elements.activity-log')

            </div>
        </div>

    </div>
</section>



<section class="stats mb-3">
    <div class="sm:grid sm:grid-cols-2 gap-5">
        {{-- <x-default.dashboard.widgets.integrations-widget>

        </x-default.dashboard.widgets.integrations-widget> --}}


        <div class="">
            <div class="mt-3">
            </div>
        </div>
    </div>
</section>

<section>

</section>
@endsection
