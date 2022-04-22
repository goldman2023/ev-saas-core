@extends('frontend.layouts.user_panel')

@section('page_title', translate('Plans management'))

@push('head_scripts')

@endpush

@section('panel_content')
<section>
    <x-dashboard.section-headers.section-header title="{{ translate('Plans Management') }}"
        text="Workcation is a property rental website. Etiam ullamcorper massa viverra consequat, consectetur id nulla tempus. Fringilla egestas justo massa purus sagittis malesuada.">
        <x-slot name="content">

        </x-slot>
    </x-dashboard.section-headers.section-header>

    @if(auth()->user()->isSubscribed())
        <div class="w-full mb-7">
            <livewire:dashboard.tables.plans-table for="me" />
        </div>
    @endif

    <div class="w-full">
        @if(auth()->user()->isSubscribed())
            <h2 class="text-32 text-gray-700 font-semibold mb-5">{{ translate('Explore other plans')}}</h2>
        @endif
        <div class="grid gap-10 grid-cols-12">
            @if($plans->isNotEmpty())
                @foreach($plans as $plan)
                    <div class="bg-white border border-gray-200 hover:border-primary rounded-lg col-span-12 sm:col-span-6 lg:col-span-3"
                        x-data="{
                            qty: 1
                        }">
                        <div class=" flex flex-col justify-between px-4 py-4 transition-all duration-300 hover:shadow-green"
                            style="height: 505px;">
                            <div class="price-description">
                                <h3 class="font-bold text-18 text-gray-700 pb-2">{{ $plan->name }}</h3>
                                <div class="flex items-end">
                                    <h3 class="text-36 text-dark font-bold mb-0">{{ $plan->getTotalPrice(true) }}</h3>
                                    <span class="text-lg2 text-dark font-bold mb-2">/{{ translate('month') }}</span>
                                </div>
                                <p class=" text-sm text-lightDark py-6 mb-4">
                                    {{ $plan->excerpt }}
                                </p>

                                <div class="w-full space-y-3">
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
                            <div>
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

                                <a href="{{ $plan->getStripeCheckoutPermalink() }}" target="_blank"
                                    class="bg-transparent transition-all duration-300 mx-auto block text-center hover:border-none  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2 px-14 rounded-lg">

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
