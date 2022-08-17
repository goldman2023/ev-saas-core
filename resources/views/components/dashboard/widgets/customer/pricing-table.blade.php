<section class="w-full" x-data="{
    pricing_mode: 'year',
    current_plan_mode: '{{ auth()->user()->subscriptions?->first()?->order?->invoicing_period ?? '' }}',
    current_plan_id: {{ auth()->user()->subscriptions?->first()?->items->first()->id ?? 'null' }},
    current_is_trial: {{ $isTrial ? 'true' : 'false' }},
    
}">
    @if((auth()->user()?->isSubscribed() ?? false) && !$hideTitle)
    <h2 class="text-32 text-gray-700 font-semibold mb-5">{{ translate('Explore other plans')}}</h2>
    @endif

    <div class="w-full sm:flex sm:flex-col sm:align-center mb-[40px]">
        {{-- <h1 class="text-5xl font-extrabold text-gray-900 sm:text-center">Pricing Plans</h1>
        <p class="mt-5 text-xl text-gray-500 sm:text-center">Start building for free, then add a site plan to go live.
            Account plans unlock additional features.</p> --}}
        <div class="relative self-center bg-gray-100 rounded-lg p-0.5 flex ">
            <button type="button" @click="pricing_mode = 'month'"
                :class="{'bg-primary text-white':pricing_mode == 'month', 'bg-white gray-900':pricing_mode != 'month'}"
                class="relative w-1/2 border border-transparent rounded-md shadow-sm py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8 mr-2">{{
                translate('Monthly billing') }}</button>
            <button type="button" @click="pricing_mode = 'year'"
                :class="{'bg-primary text-white':pricing_mode == 'year', 'bg-white gray-900':pricing_mode != 'year'}"
                class="ml-0.5 relative w-1/2 border border-transparent rounded-md py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">{{
                translate('Yearly billing') }}</button>
        </div>
    </div>
    <div class="grid sm:gap-6 xl:gap-x-10 xl:gap-y-3 grid-cols-12">
        @if($plans->isNotEmpty())
            @foreach($plans as $plan)
            <div class="bg-white border border-gray-200 hover:border-primary rounded-lg col-span-12 sm:col-span-6 lg:col-span-3 mb-6"
                x-data="{
                        qty: 1,
                        plan_id: {{ $plan->id }},
                        month_price: @js($plan->getTotalPrice(display: true, decimals: 0)),
                        annual_price: @js(\FX::formatPrice($plan->getTotalAnnualPrice() / 12, 0)),
                        is_active() {
                            return this.plan_id == current_plan_id && current_plan_mode == pricing_mode;
                        }
                    }"
                    :class="{'border-2 border-primary':  is_active() }">
                <div
                    class="relative flex flex-col justify-between px-4 py-4 transition-all duration-300 hover:shadow-green h-full"
                    :class="{'pt-[41px]': is_active() }">

                    <template x-if="is_active()">
                        <div
                            class="w-full h-[35px] flex items-center justify-center text-14 py-2 bg-primary text-white text-center absolute top-0 right-0 left-0 ">
                            <span>{{ translate('Current plan') }}:</span>
                            <strong class="pl-1">{{ $plan->name }}</strong>
                        </div>
                    </template>

                    <div class="price-description flex flex-col grow">
                        <template x-if="!is_active()">
                            <h3 class="font-bold text-18 text-gray-700 pb-2">{{ $plan->name }}</h3>
                        </template>

                        @if($plan->non_standard)
                            <div class="flex items-end">
                                <h3 class="text-36 text-dark font-bold mb-0">{{
                                    !empty($plan->getCoreMeta('custom_pricing_label')) ?
                                    $plan->getCoreMeta('custom_pricing_label') : translate('Contact Us') }}</h3>
                            </div>
                        @else
                            <div class="flex items-end">
                                <h3 class="text-36 text-dark font-bold mb-0"
                                    x-text="pricing_mode === 'year' ? annual_price : month_price"></h3>
                                <span class="text-lg2 text-dark font-bold mb-2">/{{ translate('month') }}</span>
                            </div>
                            <div class="w-full text-gray-500 text-14" x-show="pricing_mode === 'year'" x-cloak>
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
                        {{-- @if(get_tenant_setting('multi_item_subscription_enabled'))
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
                            <a href="{{ $plan->getCoreMeta('custom_redirect_url') }}"
                                class="bg-transparent transition-all duration-300 mx-auto block text-center hover:border-none  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2  rounded-lg">
                                {{ !empty($plan->getCoreMeta('custom_cta_label')) ? $plan->getCoreMeta('custom_cta_label') :
                                translate('Contact Us') }}
                            </a>
                        @else
                            <div class="w-full text-danger text-center pb-3 text-14" x-show="pricing_mode === 'year'" x-cloak>
                                {{ str_replace('%d%', \FX::formatPrice(abs($plan->getTotalAnnualPrice(display: false, decimals: 0) -
                                ($plan->getTotalPrice(display: false, decimals: 0) * 12))), translate('You save %d% per year')) }}
                            </div>

                            <div class="flex flex-row gap-4">
                                <template x-if="is_active()">
                                    <a x-bind:href="$getStripeCheckoutPermalink({model_id: {{ $plan->id }}, model_class: '{{ base64_encode($plan::class) }}', interval: pricing_mode})"

                                        class="btn-danger-outline btn-sm inline-block pt-2 text-danger text-14 justify-center w-full text-center">
                                        {{ translate('Cancel plan') }}
                                    </a>
                                </template>
                                <template x-if="!is_active()">
                                    <a
                                        
                                        @if(auth()->user()?->isSubscribed() ?? false)
                                            @click="$dispatch('display-modal', {
                                                id: 'purchase-subscription-with-multiple-items-modal',
                                                interval: pricing_mode,
                                                plan_id: @js($plan->id),
                                                plan_slug: @js($plan->slug),
                                                qty: 1,
                                                month_price: @js($plan->getTotalPrice(display: true, decimals: 0)),
                                                annual_price: @js(\FX::formatPrice($plan->getTotalAnnualPrice(display: false) / 12, 0)),
                                            })"

                                            {{-- x-bind:href="is_active() ? $getStripeCheckoutPermalink({model_id: {{ $plan->id }}, model_class: '{{ base64_encode($plan::class) }}', interval: pricing_mode}) : 'javascript:void(0)'" --}}
                                            {{-- x-on:click="is_active() ? '' : $dispatch('display-modal', {id: 'change-plan-confirmation-modal', subscription_id: {{ auth()->user()?->subscriptions->first()?->id ?? 'null' }}, new_plan: @js($plan->toArray()), interval: pricing_mode })" --}}
                                            {{-- target="_parent" --}}
                                        @else
                                            x-bind:href="$getStripeCheckoutPermalink(
                                                {
                                                    'interval': pricing_mode,
                                                    'items': [
                                                        {
                                                            id: @js($plan->id),
                                                            class: 'App\\Models\\Plan', // TODO: make this universal!
                                                            qty: 1,
                                                            preview: false,
                                                            interval: pricing_mode
                                                        }
                                                    ],
                                                    'previous_subscription_id': null,
                                                })"
                                        @endif
                                        class="flex-1 cursor-pointer bg-transparent transition-all duration-300 mx-auto block text-center  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2 rounded-lg">

                                        {{-- We should support following scenarios:
                                        1. *If trial mode is disabled and no plan is purchased: Buy now
                                        2. *If trial mode is enabled and no plan is purchased: Try for free
                                        3. *If trial mode is disabled and plan is purchased: Upgrade plan
                                        4. If trial mode is enabled(for all plans) and plan is purchased: Upgrade plan (cuz once you
                                        pay for subscription you shouldn't be allowed to use trial mode anywhere)--}}

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
                                </template>
                            </div>
                        @endif



                    </div>
                </div>
            </div>
            @endforeach

            {{-- Multi-item plan subscription --}}
            @if(get_tenant_setting('multi_item_subscription_enabled'))
                {{-- <div class="col-span-12 w-full flex justify-center">
                    <button type="button" class="btn-primary" @click="$dispatch('display-modal', {id: 'purchase-subscription-with-multiple-items-modal'})">
                        {{ translate('Buy multiple licenses') }}
                    </button>
                </div> --}}
            @endif

            <x-dashboard.form.blocks.multiple-items-subscription-form > </x-dashboard.form.blocks.multiple-items-subscription-form>

            {{-- END Multi-item plan subscription --}}
        @else

        @endif
    </div>
</section>
