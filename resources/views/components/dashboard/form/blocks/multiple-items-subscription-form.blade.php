<x-system.form-modal id="purchase-subscription-with-multiple-items-modal" title="{{ translate('Buy subscription with multiple items') }}" :prevent-close="true" class="!max-w-5xl" title-class="text-20 font-semibold">
    <div class="w-full">
        <fieldset x-data="{
            processing: false,
            plans_cart: {},
            pricing_mode: 'year',
            plans: @js($plans),
            projected_invoice: null,
            addToSubscriptionCart(plan_id, plan_slug, qty, month_price, annual_price) {
                if(this.plans_cart.hasOwnProperty(plan_slug)) {
                    // Add qty to existing plan in cart
                    this.plans_cart[plan_slug]['qty'] = Number(this.plans_cart[plan_slug]['qty']) + Number(qty);
                } else {
                    this.plans_cart[plan_slug] = {
                        plan_id: plan_id,
                        plan_slug: plan_slug,
                        qty: Number(qty),
                        month_price: month_price,
                        annual_price: annual_price,
                    };
                }
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

                    this.processing = false;
                })
                .catch(error => alert(error.error.msg));
            },
            clearCart() {
                this.plans_cart = {};
                this.projected_invoice = null;
            },
            checkout() {
                {{-- TODO: Compare old subscriptions items with new subscription items AND check if there is less items of same type in new subscription. If there is, prompt a new modal where user must select which licenses/seats will be revoked/removed. --}}
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
                        qty: item.qty,
                        preview: false,
                        interval: this.pricing_mode
                    });
                }

                url_params.set('data', btoa(JSON.stringify(data)));

                window.open(base_route.toString()+'?'+url_params.toString(), '_blank').focus();
            }
        }" x-init="
            $watch('plans_cart', (cart) => getProjectedInvoice(cart));
            $watch('pricing_mode', (mode) => getProjectedInvoice(plans_cart, mode));
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

            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">

                @if($plans->isNotEmpty())
                    @foreach($plans as $plan)
                        <div class="relative bg-white border rounded-lg shadow-sm p-4 flex focus:outline-none" x-data="{
                            plan_id: {{ $plan->id }},
                            plan_slug: '{{ $plan->slug }}',
                            qty: 0,
                            month_price: @js($plan->getTotalPrice(display: true, decimals: 0)),
                            annual_price: @js(\FX::formatPrice($plan->getTotalAnnualPrice(display: false) / 12, 0)),
                        }">
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

                                    <div class="w-full pb-3 mt-5">
                                        <label class="block text-sm font-medium text-gray-700">{{ translate('License quantity') }}</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <x-dashboard.form.input type="number" min="1" step="1" field="qty" :x="true" />
                                        </div>
                                    </div>

                                    <div class="w-full">
                                        <button type="button" class="btn-primary" @click="addToSubscriptionCart(plan_id, plan_slug, qty, month_price, annual_price); qty = 0;" :disabled="qty <= 0"> 
                                            {{ translate('Add') }}
                                        </button>
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
                <div class="px-4" :class="{'opacity-30 pointer-events-none': processing}">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-900">{{ translate('Projected invoice') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">Subscription billing period: <strong x-text="pricing_mode"></strong></p>
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <div class="btn-danger-outline" @click="clearCart()">{{ translate('Clear') }}</div>
                        </div>
                    </div>
                    <div class="-mx-4 mt-8 flex flex-col sm:-mx-6 md:mx-0">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 md:pl-0">{{ translate('Item') }}</th>
                                    <th scope="col" class="hidden py-3.5 px-3 text-right text-sm font-semibold text-gray-900 sm:table-cell">{{ translate('Qty') }}</th>
                                    <th scope="col" class="hidden py-3.5 px-3 text-right text-sm font-semibold text-gray-900 sm:table-cell">{{ translate('Price') }}</th>
                                    <th scope="col" class="py-3.5 pl-3 pr-4 text-right text-sm font-semibold text-gray-900 sm:pr-6 md:pr-0">{{ translate('Tax') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="line in projected_invoice.lines.data">
                                    <tr class="border-b border-gray-200">
                                        <td class="py-4 pl-4 pr-3 text-sm sm:pl-6 md:pl-0">
                                            <div class="font-medium text-gray-900" x-text="line.description"></div>
                                            <div class="mt-0.5 text-gray-500 sm:hidden" x-text="line.description + _.reduce(line.tax_amounts, (sum,  tax) => sum + (tax.amount / 100), 0) + ' {{ translate('tax') }}'"></div>
                                        </td>
                                        <td class="hidden py-4 px-3 text-right text-sm text-gray-500 sm:table-cell" x-text="line.quantity"></td>
                                        <td class="hidden py-4 px-3 text-right text-sm text-gray-500 sm:table-cell" x-text="FX.formatPrice(line.amount_excluding_tax / 100)"></td>
                                        <td class="py-4 pl-3 pr-4 text-right text-sm text-gray-500 sm:pr-6 md:pr-0" x-text="FX.formatPrice(_.reduce(line.tax_amounts, (sum,  tax) => sum + (tax.amount / 100), 0))"></td>
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="row" colspan="3" class="hidden pl-6 pr-3 pt-6 text-right text-sm font-normal text-gray-500 sm:table-cell md:pl-0">{{ translate('Subtotal') }}</th>
                                    <th scope="row" class="pl-4 pr-3 pt-6 text-left text-sm font-normal text-gray-500 sm:hidden">{{ translate('Subtotal') }}</th>
                                    <td class="pl-3 pr-4 pt-6 text-right text-sm text-gray-500 sm:pr-6 md:pr-0" x-text="FX.formatPrice(projected_invoice.subtotal_excluding_tax / 100)"></td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="3" class="hidden pl-6 pr-3 pt-4 text-right text-sm font-normal text-gray-500 sm:table-cell md:pl-0">{{ translate('Tax') }}</th>
                                    <th scope="row" class="pl-4 pr-3 pt-4 text-left text-sm font-normal text-gray-500 sm:hidden">{{ translate('Tax') }}</th>
                                    <td class="pl-3 pr-4 pt-4 text-right text-sm text-gray-500 sm:pr-6 md:pr-0" x-text="FX.formatPrice(projected_invoice.tax / 100)"></td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="3" class="hidden pl-6 pr-3 pt-4 text-right text-sm font-semibold text-gray-900 sm:table-cell md:pl-0">{{ translate('Total') }}</th>
                                    <th scope="row" class="pl-4 pr-3 pt-4 text-left text-sm font-semibold text-gray-900 sm:hidden">{{ translate('Total') }}</th>
                                    <td class="pl-3 pr-4 pt-4 text-right text-sm font-semibold text-gray-900 sm:pr-6 md:pr-0" x-text="FX.formatPrice(projected_invoice.total / 100)"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="w-full flex justify-center mt-4">
                        <div class="btn-primary" @click="checkout()">{{ translate('Proceed to checkout') }}</div>
                    </div>
                </div>
            </template>

            <template x-if="_.get(projected_invoice, 'lines.data', []).length <= 0">
                <div class="w-full flex justify-center text-16 text-gray-500">
                    {{ translate('No plans added yet...') }}
                </div>
            </template>
        </div>
    </div>
</x-system.form-modal>