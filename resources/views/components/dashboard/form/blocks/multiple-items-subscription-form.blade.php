<x-system.form-modal id="purchase-subscription-with-multiple-items-modal" title="{{ translate('Select your plan') }}" :prevent-close="true" class="!max-w-5xl" title-class="text-20 font-semibold">
    <div class="w-full">
        <fieldset x-data="{
            processing: true,
            plans_cart: {},
            pricing_mode: 'year',
            plans: @js($plans),
            projected_invoice: null,
            selected_plan_id: null,
            selected_plan_interval: null,
            current_plan_mode: '{{ auth()->user()->subscriptions?->first()?->order?->invoicing_period ?? '' }}',
            current_plan_id: {{ auth()->user()->subscriptions?->first()?->items->first()?->id ?? 'null' }},
            current_is_trial: @js(auth()->user()?->subscriptions?->first()?->isTrial()),
            addToSubscriptionCart(plan_id, plan_slug, qty, month_price, annual_price) {
                if(this.plans_cart.hasOwnProperty(plan_slug)) {
                    // Add qty to existing plan in cart
                    @if(get_tenant_setting('multi_item_subscription_enabled'))
                        {{-- this.plans_cart[plan_slug]['qty'] = Number(this.plans_cart[plan_slug]['qty']) + Number(qty); --}}
                        this.plans_cart[plan_slug]['qty'] = 1;
                    @else
                        this.plans_cart[plan_slug]['qty'] = 1;
                    @endif
                } else {
                    @if(get_tenant_setting('multi_item_subscription_enabled'))
                        this.clearCart(); // TODO: Remove this when multi-items are enabled

                        this.plans_cart[plan_slug] = {
                            plan_id: plan_id,
                            plan_slug: plan_slug,
                            {{-- qty: Number(qty), --}}
                            qty: 1,
                            month_price: month_price,
                            annual_price: annual_price,
                        };
                    @else
                        this.clearCart();

                        this.plans_cart[plan_slug] = {
                            plan_id: plan_id,
                            plan_slug: plan_slug,
                            qty: 1,
                            month_price: month_price,
                            annual_price: annual_price,
                        };
                    @endif
                }

                this.selected_plan_id = plan_id;
            },
            getProjectedInvoice(cart, mode = null) {
                if(cart === null || cart.length <= 0)
                    return;

                if(mode != 'year' && mode != 'month') {
                    mode = this.pricing_mode;
                }
                this.processing = true;

                wetch.post('{{ route('api.dashboard.subscription.calculate-potential-invoice.stripe') }}', {
                    cart: {
                        ...cart
                    },
                    interval: mode,
                })
                .then(data => {
                    if(data.status === 'success') {
                        this.projected_invoice = data.data;
                    } else {
                        alert(translate('Could not create a new invoice projection.'));
                    }

                    this.projected_invoice.total_price_without_prorations = 0;
                    _.get(this.projected_invoice, 'lines.data', []).forEach((item, index) => {
                        if(!item.proration) {
                            this.projected_invoice.total_price_without_prorations += (item.amount + _.get(item, 'tax_amounts.0.amount', 0));
                        }
                    });

                    this.processing = false;
                })
                .catch(error => {
                    alert(error.error.msg);
                    this.processing = false;
                });

                this.selected_plan_interval = mode;
            },
            clearCart() {
                this.plans_cart = {};
                this.projected_invoice = null;
                this.selected_plan_id = null;
            },
            checkout() {
                {{-- TODO: Compare old subscriptions items with new subscription items AND check if there is less items of same type in new subscription. If there is, prompt a new modal where user must select which licenses/seats will be revoked/removed. --}}
                this.processing = true;

                let base_route = new URL('{{ route('stripe.checkout_redirect') }}');
                var url_params = new URLSearchParams(base_route.search);

                let data = {
                    'interval': this.pricing_mode,
                    'items': [],
                    'previous_subscription_id': @js($previous_subscription?->id ?? null),
                };

                for (const item_key in this.plans_cart) {
                    let item = this.plans_cart[item_key];

                    data['items'].push({
                        id: item.plan_id,
                        class: 'App\\Models\\Plan', // TODO: make this universal!
                        @if(get_tenant_setting('multi_item_subscription_enabled'))
                            {{-- qty: item.qty, --}}
                            qty: 1,
                        @else
                            qty: 1,
                        @endif
                        preview: false,
                        interval: this.pricing_mode
                    });
                }

                url_params.set('data', btoa(JSON.stringify(data)));

                // If stripe prorations are enabled and user already has subscriptions and is not on trial
                @if(\Payments::stripe()->stripe_prorations_enabled && !auth()->user()->isOnTrial() && auth()->user()->isSubscribed())

                    wetch.post('{{ route('api.dashboard.subscription.update', auth()->user()->subscriptions?->first()->id) }}', {
                        data: data
                    })
                    .then(data => {
                        if(data.status === 'success') {
                            alert('{{ translate('You successfully changed your plan! Page will refresh to reflect the latest changes.') }}');
                            window.location.reload();
                            return;
                        } else {
                            $dispatch('display-modal', {id: 'failed-subscription-update-modal'});
                        }

                        this.processing = false;
                    })
                    .catch(error => {
                        console.error(error);
                        $dispatch('display-modal', {id: 'failed-subscription-update-modal'});

                        {{-- alert(error.error.msg); --}}
                        this.processing = false;
                    });
                @else
                    window.open(base_route.toString()+'?'+url_params.toString(), '_blank').focus();
                @endif
            },
            selectedIsActive() {
                return this.selected_plan_id === this.current_plan_id && this.current_plan_mode ===  this.pricing_mode;
            }
        }" x-init="
            $watch('plans_cart', (cart) => getProjectedInvoice(cart, pricing_mode));
            $watch('pricing_mode', (mode) => getProjectedInvoice(plans_cart, mode));
        "
        @init-checkout.window="checkout()"
        @display-modal.window="
            if($event.detail.id === 'purchase-subscription-with-multiple-items-modal') {
                pricing_mode = $event.detail.interval;
                addToSubscriptionCart($event.detail.plan_id, $event.detail.plan_slug, $event.detail.qty, $event.detail.month_price, $event.detail.annual_price);
            }
        "
        class="pt-3">
            <div class="w-full sm:flex sm:flex-col sm:align-center mb-5">
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

            <div class="mt-8 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">

                @if($plans->isNotEmpty())
                    @foreach($plans as $plan)
                        <div class="relative bg-white border rounded-lg shadow-sm p-4 flex focus:outline-none" x-data="{
                            plan_id: {{ $plan->id }},
                            plan_slug: '{{ $plan->slug }}',
                            qty: @js(get_tenant_setting('multi_item_subscription_enabled') ? 1 : 1),
                            month_price: @js($plan->getTotalPrice(display: true, decimals: 0)),
                            annual_price: @js(\FX::formatPrice($plan->getTotalAnnualPrice(display: false) / 12, 0)),
                            is_active() {
                                return this.plan_id == current_plan_id && current_plan_mode == pricing_mode;
                            },
                            is_selected() {
                                return this.plan_id == selected_plan_id && selected_plan_interval == pricing_mode;
                            }
                        }" :class="{'border-2 border-primary':  is_active(), 'border-2 border-info': is_selected() }">
                            <template x-if="is_active()">
                                <div class="absolute top-[-15px] right-[15px] bg-white rounded-full border border-primary py-1 px-2 text-12">
                                    <span>{{ translate('Active') }}</span>
                                </div>
                            </template>

                            <template x-if="is_selected()">
                                <div class="absolute top-[-15px] right-[15px] bg-white rounded-full border border-info py-1 px-2 text-12">
                                    <span>{{ translate('Selected') }}</span>
                                </div>
                            </template>

                            <span class="flex-1 flex">
                                <div class="flex flex-col">
                                    <span class="block text-sm font-medium text-gray-900 mb-1 line-clamp-2">{{ $plan->name }}</span>
                                    <span class="flex items-center text-sm text-gray-500 mb-3 line-clamp-2">{{ $plan->excerpt }}</span>

                                    <div class="flex items-end">
                                        <h3 class="text-16 text-dark font-bold mb-0"
                                            x-text="pricing_mode === 'year' ? annual_price : month_price"></h3>
                                        <span class="text-lg2 text-dark font-bold">/{{ translate('month') }}</span>
                                    </div>
                                    <div class="w-full text-gray-500 text-14" x-show="pricing_mode === 'year'" x-cloak>
                                        *{{ translate('Billed annually') }}
                                    </div>

                                    @if(get_tenant_setting('multi_item_subscription_enabled'))
                                        {{-- <div class="w-full pb-3 mt-5">
                                            <label class="block text-sm font-medium text-gray-700">{{ translate('License quantity') }}</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <x-dashboard.form.input type="number" min="1" step="1" field="qty" :x="true" />
                                            </div>
                                        </div> --}}
                                    @else
                                        {{-- <label class="block text-sm font-medium text-gray-700">{{ translate('License quantity') }}</label> --}}
                                        {{-- <div class="mt-1 relative rounded-md shadow-sm">

                                            <x-dashboard.form.input type="number" min="1" step="1" field="qty" :x="true" />
                                        </div> --}}
                                    @endif

                                    <div class="w-full mt-3">
                                        @if(get_tenant_setting('multi_item_subscription_enabled'))
                                            {{-- <button type="button" class="btn-primary" @click="addToSubscriptionCart(plan_id, plan_slug, qty, month_price, annual_price); qty = 0;" :disabled="qty <= 0">
                                                {{ translate('Add') }}
                                            </button> --}}
                                            <button type="button" class="btn-primary w-full" @click="addToSubscriptionCart(plan_id, plan_slug, 1, month_price, annual_price); qty = 1;" :disabled="qty <= 0">
                                                {{ translate('Select plan') }}
                                            </button>
                                        @else
                                            <button type="button" class="btn-primary w-full" @click="addToSubscriptionCart(plan_id, plan_slug, 1, month_price, annual_price); qty = 1;">
                                                {{ translate('Select plan') }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </span>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="w-full relative my-7">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                  <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center">
                  <span class="px-2 bg-white text-20 font-semibold text-gray-500"> {{ translate('Subscription breakdown') }} </span>
                </div>
            </div>

            <template x-if="_.get(projected_invoice, 'lines.data', []).length > 0">
                <div class="px-4" :class="{'pointer-events-none': processing}">
                    <div class="sm:flex sm:items-center" :class="{'opacity-30 pointer-events-none': processing}">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-900">{{ translate('Projected invoice') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">Subscription billing period: <strong x-text="pricing_mode"></strong></p>
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <div class="btn-danger-outline" @click="clearCart()">{{ translate('Clear') }}</div>
                        </div>
                    </div>
                    <div class="-mx-4 mt-8 flex flex-col sm:-mx-6 md:mx-0" :class="{'opacity-30 pointer-events-none': processing}">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 md:pl-0">{{ translate('Item') }}</th>
                                    <th scope="col" class="hidden py-3.5 px-3 text-right text-sm font-semibold text-gray-900 sm:table-cell">{{ translate('Qty') }}</th>
                                    <th scope="col" class="py-3.5 px-3 text-right text-sm font-semibold text-gray-900 sm:pr-6 md:pr-0">{{ translate('Price') }}</th>
                                    <th scope="col" class="py-3.5 pl-3 pr-4 text-right text-sm font-semibold text-gray-900 sm:pr-6 md:pr-0">{{ translate('Tax') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="line in projected_invoice.lines.data">
                                    <tr class="border-b border-gray-200">
                                        <td class="py-4 pl-4 pr-3 text-sm sm:pl-6 md:pl-0">
                                            <div class="font-medium text-gray-900" x-text="line.description"></div>
                                            {{-- <div class="mt-0.5 text-gray-500 sm:hidden" x-text="'{{ translate('Quantity:') }} '+line.quantity"></div> --}}
                                        </td>
                                        <td class="hidden py-4 px-3 text-right text-sm text-gray-500 sm:table-cell" x-text="line.quantity"></td>
                                        <td class="py-4 px-3 text-right text-sm text-gray-500 sm:table-cell" x-text="FX.formatPrice(line.amount_excluding_tax / 100)"></td>
                                        <td class="py-4 pl-3 pr-4 text-right text-sm text-gray-500 sm:pr-6 md:pr-0" x-text="FX.formatPrice(_.reduce(line.tax_amounts, (sum,  tax) => sum + (tax.amount / 100), 0))"></td>
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot>
                                <tr x-show="projected_invoice.subtotal_excluding_tax > 0">
                                    <th scope="row" colspan="3" class="hidden pl-6 pr-3 pt-6 text-right text-sm font-normal text-gray-500 sm:table-cell md:pl-0">{{ translate('Subtotal') }}</th>
                                    <th scope="row" class="pl-4 pr-3 pt-6 text-left text-sm font-normal text-gray-500 sm:hidden">{{ translate('Subtotal') }}</th>
                                    <td class="sm:hidden py-4 px-3 text-right text-sm text-gray-500 table-cell"></td>
                                    <td class="pl-3 pr-4 pt-6 text-right text-sm text-gray-500 sm:pr-6 md:pr-0" x-text="FX.formatPrice(projected_invoice.subtotal_excluding_tax / 100)"></td>
                                </tr>
                                <tr x-show="projected_invoice.tax > 0">
                                    <th scope="row" colspan="3" class="hidden pl-6 pr-3 pt-4 text-right text-sm font-normal text-gray-500 sm:table-cell md:pl-0">{{ translate('Tax') }}</th>
                                    <th scope="row" class="pl-4 pr-3 pt-4 text-left text-sm font-normal text-gray-500 sm:hidden">{{ translate('Tax') }}</th>
                                    <td class="sm:hidden py-4 px-3 text-right text-sm text-gray-500 table-cell"></td>
                                    <td class="pl-3 pr-4 pt-4 text-right text-sm text-gray-500 sm:pr-6 md:pr-0" x-text="FX.formatPrice(projected_invoice.tax / 100)"></td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="3" class="hidden pl-6 pr-3 pt-4 text-right text-sm font-semibold text-gray-900 sm:table-cell md:pl-0">{{ translate('Total due today') }}</th>
                                    <th scope="row" class="pl-4 pr-3 pt-4 text-left text-sm font-semibold text-gray-900 sm:hidden">{{ translate('Total due today') }}</th>
                                    <td class="sm:hidden py-4 px-3 text-right text-sm text-gray-500 table-cell"></td>
                                    <td class="pl-3 pr-4 pt-4 text-right text-sm font-semibold text-gray-900 sm:pr-6 md:pr-0" x-text="FX.formatPrice(projected_invoice.amount_due / 100)"></td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="3" class="hidden pl-6 pr-3 pt-4 text-right text-sm font-semibold text-gray-900 sm:table-cell md:pl-0"
                                        x-text="pricing_mode === 'year' ? '{{ translate('Yearly total') }}' : '{{ translate('Monthly total') }}'"></th>
                                    <th scope="row" class="pl-4 pr-3 pt-4 text-left text-sm font-semibold text-gray-900 sm:hidden"
                                        x-text="pricing_mode === 'year' ? '{{ translate('Yearly total') }}' : '{{ translate('Monthly total') }}'"></th>
                                    <td class="sm:hidden py-4 px-3 text-right text-sm text-gray-500 table-cell"></td>
                                    <td class="pl-3 pr-4 pt-4 text-right text-sm font-semibold text-gray-900 sm:pr-6 md:pr-0" x-text="FX.formatPrice(projected_invoice.total_price_without_prorations / 100)"></td>
                                </tr>
                                <tr>
                                    <td colspan="100%" class="pl-3 pr-4 pt-1 text-right text-sm font-norma; text-gray-500 sm:pr-6 md:pr-0" 
                                        x-text="'{{ translate('What you will pay per') }}'+' '+(pricing_mode)+' {{ translate('starting from') }}'+' '+(DateTime.fromSeconds(projected_invoice.period_start).plus(pricing_mode === 'year' ? { year: 1 } : { month: 1 }).toFormat('DD'))"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <template x-if="!selectedIsActive()">
                        <div class="w-full flex justify-center mt-4">
                            @if(\Payments::stripe()->stripe_prorations_enabled && !auth()->user()->isOnTrial() && auth()->user()->isSubscribed())
                                <div class="btn-primary" @click="$dispatch('display-modal', {'id': 'confirm-subscription-update-modal', 'amount_due': FX.formatPrice(projected_invoice.amount_due / 100), 'total_price_without_prorations': FX.formatPrice(projected_invoice.total_price_without_prorations / 100), 'starting_from':  DateTime.fromSeconds(projected_invoice.period_start).plus(pricing_mode === 'year' ? { year: 1 } : { month: 1 }).toFormat('DD'), interval: pricing_mode });"
                                    :class="{'opacity-30 pointer-events-none': processing}">
                                    {{ translate('Checkout') }}
                                </div>

                                <div class="flex items-center justify-center text-primary pl-4 gap-x-3" x-show="processing">
                                    <svg width="30px" height="30px" version="1.1" id="L7" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                        <path fill="currentColor" d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3
                                         c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z">
                                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                                        </path>
                                        <path fill="currentColor" d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7
                                         c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z">
                                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="-360 50 50" repeatCount="indefinite"></animateTransform>
                                         </path>
                                        <path fill="currentColor" d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5
                                         L82,35.7z">
                                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                                        </path>
                                    </svg>

                                    <strong>{{ translate('Processing...') }}</strong>
                                </div>
                            @else
                                <div class="btn-primary" @click="checkout()" :class="{'opacity-30 pointer-events-none': processing}">
                                    {{ translate('Proceed to checkout') }}
                                </div>
                            @endif
                        </div>
                    </template>
                    
                </div>
            </template>

            <template x-if="_.get(projected_invoice, 'lines.data', []).length <= 0" >
                <div class="w-full flex justify-center text-16 text-gray-500" :class="{'opacity-70 pointer-events-none': processing}">
                    <template x-if="processing">
                        <span>{{ translate('Generating projection...') }}</span>
                    </template>

                    <template x-if="!processing">
                        <span>{{ translate('No plans added yet...') }}</span>
                    </template>
                </div>
            </template>
        </fieldset>
    </div>
</x-system.form-modal>

<x-system.form-modal id="confirm-subscription-update-modal" title="{{ translate('Are you sure you want to change subscription plan?') }}" :prevent-close="true" class="!max-w-2xl !pt-4" title-class="text-20 font-semibold">
    <div class="w-full" 
        x-data="{
            amount_due: null,
            total_price_without_prorations: null,
            starting_from: null,
            interval: null,
        }"    
        @display-modal.window="if($event.detail.id == 'confirm-subscription-update-modal') { 
            amount_due = $event.detail.amount_due;
            total_price_without_prorations = $event.detail.total_price_without_prorations;
            starting_from = $event.detail.starting_from;
            interval = $event.detail.interval;
        }">

        <div class="w-full pb-1">
            <span>{{ translate('You will be charged') }}</span>
            <strong x-text="amount_due"></strong>
            <span>{{ translate('immediately, and then') }}</span>
            <strong x-text="total_price_without_prorations"></strong>
            <span>{{ translate('each') }} <i x-text="interval"></i></span>
            <span>{{ translate('for this subscription, starting on') }} <i x-text="starting_from"></i>.</span>
        </div>

        <div class="w-full pb-5">
            <span class="text-12 text-gray-500">{{ translate('*Note: It may take some time for licenses to be properly updated.') }}</span>
        </div>
        
        <div class="w-full flex gap-x-3 justify-center">
            <div class="btn-primary" @click="$dispatch('init-checkout'); show = false;">
                {{ translate('Confirm') }}
            </div>
            <div class="btn-danger-outline" @click="show = false;">
                {{ translate('Cancel') }}
            </div>
        </div>
    </div>
</x-system.form-modal>

<x-system.form-modal id="failed-subscription-update-modal" title="{{ translate('Could not process the payment...') }}" :prevent-close="true" class="!max-w-2xl !pt-4" title-class="text-danger text-20 font-semibold">
    <div class="w-full pb-4">
        <span>{{ translate('Payment could not be processed. Please go to billing portal and change the default payment method.') }}</span>
    </div>
    <div class="w-full flex gap-x-3 justify-center">
        <a href="{{ route('stripe.portal_session') }}" class="btn-primary" target="_blank">
            {{ translate('Go to Biling Portal') }}
        </a>
        <div class="btn-danger-outline" @click="show = false;">
            {{ translate('Cancel') }}
        </div>
    </div>
</x-system.form-modal>