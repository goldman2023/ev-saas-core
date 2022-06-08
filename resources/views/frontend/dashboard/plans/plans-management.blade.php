@extends('frontend.layouts.user_panel')

@section('page_title', translate('Plans management'))

@push('head_scripts')

@endpush

@section('panel_content')
<section>
    <x-dashboard.section-headers.section-header title="{{ translate('Plans Management') }}"
        text="{{ translate('Manage your subscriptions, licenses and billing') }}">
        <x-slot name="content">
            @if(auth()->user()?->isSubscribed() ?? false)
                <a href="{{ route('stripe.portal_session') }}" class="btn-primary" target="_blank">
                        {{ translate('Biling Portal') }}
                </a>
            @endif
        </x-slot>
    </x-dashboard.section-headers.section-header>

    @if(auth()->user()?->isSubscribed() ?? false)
        <div class="w-full pb-5 mb-5 border-b border-gray-200">
            <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
                <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Subscriptions') }}</h4>
            </div>

            <livewire:dashboard.tables.my-subscriptions-table :show-search="false" :show-filters="false" :show-filter-dropdown="false" :show-per-page="false" :column-select="false"/>
        </div>

        @do_action('view.dashboard.plans-management.plans-table.end')
    @endif

    <div class="w-full" x-data="{
            pricing_mode: 'month',
        }">
        @if(auth()->user()?->isSubscribed() ?? false)
            <h2 class="text-32 text-gray-700 font-semibold mb-5">{{ translate('Explore other plans')}}</h2>
        @endif

        <div class="w-full sm:flex sm:flex-col sm:align-center mb-[40px]">
            {{-- <h1 class="text-5xl font-extrabold text-gray-900 sm:text-center">Pricing Plans</h1>
            <p class="mt-5 text-xl text-gray-500 sm:text-center">Start building for free, then add a site plan to go live. Account plans unlock additional features.</p> --}}
            <div class="relative self-center bg-gray-100 rounded-lg p-0.5 flex ">
              <button type="button" @click="pricing_mode = 'month'" :class="{'bg-primary text-white':pricing_mode == 'month', 'bg-white gray-900':pricing_mode != 'month'}" class="relative w-1/2 border border-transparent rounded-md shadow-sm py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8 mr-2">{{ translate('Monthly billing') }}</button>
              <button type="button" @click="pricing_mode = 'annual'" :class="{'bg-primary text-white':pricing_mode == 'annual', 'bg-white gray-900':pricing_mode != 'annual'}" class="ml-0.5 relative w-1/2 border border-transparent rounded-md py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">{{ translate('Yearly billing') }}</button>
            </div>
          </div>

        <div class="grid gap-10 grid-cols-12" >
            @if($plans->isNotEmpty())
                @foreach($plans as $plan)
                    <div class="bg-white border border-gray-200 hover:border-primary rounded-lg col-span-12 sm:col-span-6 lg:col-span-3 @if(auth()->user()?->subscribedTo($plan->slug) ?? null) border-2 border-primary  @endif"
                        x-data="{
                            qty: 1,
                            month_price: @js($plan->getTotalPrice(true)),
                            annual_price: @js(\FX::formatPrice($plan->getTotalAnnualPrice() / 12)),
                        }">
                        <div class="relative  flex flex-col justify-between px-4 py-4 transition-all duration-300 hover:shadow-green h-full @if(auth()->user()?->subscribedTo($plan->slug) ?? null) pt-[41px] @endif">
                            @if(auth()->user()?->subscribedTo($plan->slug) ?? null) 
                                <div class="w-full h-[35px] flex items-center justify-center text-14 py-2 bg-primary text-white text-center absolute top-0 right-0 left-0 ">
                                    <span>{{ translate('Current plan') }}:</span>
                                    <strong class="pl-1">{{ $plan->name }}</strong>
                                </div>
                            @endif

                            <div class="price-description flex flex-col grow">
                                @if(!(auth()->user()?->subscribedTo($plan->slug) ?? null)) 
                                    <h3 class="font-bold text-18 text-gray-700 pb-2">{{ $plan->name }}</h3>
                                @endif

                                @if($plan->non_standard)
                                    <div class="flex items-end">
                                        <h3 class="text-36 text-dark font-bold mb-0">{{  !empty($plan->getCoreMeta('custom_pricing_label')) ? $plan->getCoreMeta('custom_pricing_label') : translate('Contact Us') }}</h3>
                                    </div>
                                @else
                                    <div class="flex items-end">
                                        <h3 class="text-36 text-dark font-bold mb-0" x-text="pricing_mode === 'annual' ? annual_price : month_price"></h3>
                                        <span class="text-lg2 text-dark font-bold mb-2">/{{ translate('month') }}</span>
                                    </div>
                                    <div class="w-full text-gray-500 text-14" x-show="pricing_mode === 'annual'" x-cloak>
                                        {{ translate('Billed annually') }}
                                    </div>
                                @endif
                                <p class=" text-sm text-gray-700 py-4 mb-4">
                                    {{ $plan->excerpt }}
                                </p>

                                <div class="w-full space-y-3 grow overflow-y-auto max-h-[350px]">
                                    @if(!empty($plan->features))
                                        @foreach($plan->features as $feature)
                                        <div class="d-flex mb-2 flex items-center gap-3">
                                            @svg('heroicon-s-check-circle', ['class' => 'w-5 h-5 text-primary'])
                                            <p class="text-sm text-gray-700 mb-0">{{ $feature }}</p>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="pt-4">
                                {{-- @if(get_tenant_setting('multiplan_purchase'))
                                <div class="w-full pb-3">
                                    <label for="account-number" class="block text-sm font-medium text-gray-700">{{
                                        translate('Quantity') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="number" x-model="qty" class="form-standard" min="0" max="10">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            @svg('heroicon-o-chevron-up', ['class' => 'h-5 w-5 text-gray-400 mr-2'])
                                            @svg('heroicon-o-chevron-down', ['class' => 'h-5 w-5 text-gray-400'])
                                        </div>
                                    </div>
                                </div>
                                @endif --}}

                                @if($plan->non_standard)
                                    <a href="{{ $plan->getCoreMeta('custom_redirect_url') }}" class="bg-transparent transition-all duration-300 mx-auto block text-center hover:border-none  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2  rounded-lg">
                                        {{ !empty($plan->getCoreMeta('custom_cta_label')) ? $plan->getCoreMeta('custom_cta_label') : translate('Contact Us') }}
                                    </a>
                                @else
                                    <div class="w-full text-danger text-center pb-3 text-14" x-show="pricing_mode === 'annual'" x-cloak>
                                        {{ str_replace('%d%', \FX::formatPrice(abs($plan->getTotalAnnualPrice() - ($plan->getTotalPrice() * 12))), translate('You save %d% per year')) }}
                                    </div>

                                    <div class="flex flex-row gap-4">
                                        <a x-bind:href="$getStripeCheckoutPermalink({model_id: {{ $plan->id }}, model_class: '{{ base64_encode($plan::class) }}', interval: pricing_mode})" target="_blank"
                                            class="flex-1 cursor-pointer bg-transparent transition-all duration-300 mx-auto block text-center  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2 rounded-lg">
    
                                            {{-- We should support following scenarios:
                                                1. *If trial mode is disabled and no plan is purchased: Buy now
                                                2. *If trial mode is enabled and no plan is purchased: Try for free
                                                3. *If trial mode is disabled and plan is purchased: Upgrade plan
                                                4. If trial mode is enabled(for all plans) and plan is purchased: Upgrade plan (cuz once you pay for subscription you shouldn't be allowed to use trial mode anywhere)--}}
                                            @if(!get_tenant_setting('plans_trial_mode') && !auth()->user()->isSubscribed())
                                                <span>{{ translate('Buy now') }}</span>
                                            @elseif(get_tenant_setting('plans_trial_mode') && !auth()->user()->isSubscribed())
                                                <span>{{ translate('Try for free') }}</span>
                                            @elseif(!get_tenant_setting('plans_trial_mode') && auth()->user()->isSubscribed())
                                                <span>{{ translate('Change plan') }}</span>
                                            @elseif(get_tenant_setting('plans_trial_mode') && auth()->user()->isSubscribed())
                                                <span>{{ translate('Change plan') }}</span>
                                            @endif
                                        </a>
    
                                        @if(auth()->user()?->subscribedTo($plan->slug) ?? null)
                                            <a x-bind:href="$getStripeCheckoutPermalink({model_id: {{ $plan->id }}, model_class: '{{ base64_encode($plan::class) }}', interval: pricing_mode})" target="_blank"
                                                    class="btn-danger btn-sm inline-block pt-2 text-danger text-14 text-center">
                                                {{ translate('Cancel plan') }}
                                            </a>
                                        @endif
                                    </div>
                                    

                                @endif



                            </div>
                        </div>
                    </div>
                @endforeach
            @else
            <x-dashboard.empty-states.no-items-in-collection icon="heroicon-o-document"
                title="{{ translate('No plans yet') }}"
                text="{{ translate('Sorry, there are currently no plans to purchase!') }}">

            </x-dashboard.empty-states.no-items-in-collection>
            @endif
        </div>

    </div>
</section>
@endsection

@push('footer_scripts')
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
--}}
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
--}}
{{-- <script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.js">
</script>--}}
@endpush
