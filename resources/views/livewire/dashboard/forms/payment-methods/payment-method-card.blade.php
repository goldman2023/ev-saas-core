<div class="shadow rounded border border-gray-200 {{ $class }} relative"
     wire:key="payment-method-{{ $paymentMethod->gateway }}"
     key="payment-method-{{ $paymentMethod->gateway }}"
     x-cloak
     x-data="{
        show: false,
        enabled: @entangle('paymentMethod.enabled').defer,
        paymentMethod: @js($paymentMethod),
     }"
    >

    <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                          wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

    <div class="flex items-center justify-start cursor-pointer p-5"  wire:loading.class="opacity-30 pointer-events-none" @click="show = !show">
        @svg('heroicon-o-chevron-right', ['class' => 'w-[16px] h[16px] mr-2', ':style' => "show && {transform: 'rotate(90deg)'}"])
        <h4 class="h5 mb-0">{{ $paymentMethod->name }}</h4>

        
        <span class="badge-success flex align-center px-2 py-1 ml-3 text-12 text-success"
              :class="{'flex':enabled}"
              x-show="enabled">
              {{ translate('active') }}
        </span>

        <span class="badge-danger items-center px-2 py-1 ml-3 text-12 text-danger"
              :class="{'flex':!enabled}"
              x-show="!enabled">
              {{ translate('inactive') }}
        </span>

        <button type="button" @click="$wire.toggle(!enabled); show = true;"
                    :class="{'bg-primary':enabled , 'bg-gray-200':!enabled}"
                    class="relative inline-flex flex-shrink-0 h-6 w-11 ml-auto border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                <span :class="{'translate-x-5':enabled, 'translate-x-0':!enabled}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
        </button>

        {{-- <label class="toggle-switch ml-auto" for="payment-method-{{ $paymentMethod->gateway }}-enabled" @click="event.stopPropagation();">
            <input type="checkbox"
                   class="js-toggle-switch toggle-switch-input"
                   id="payment-method-{{ $paymentMethod->gateway }}-enabled"
                   @click="$wire.toggle(!paymentMethod.enabled); show = true;"
                   wire:model.defer="paymentMethod.enabled"
            >
            <span class="toggle-switch-label">
              <span class="toggle-switch-indicator"></span>
            </span>
        </label> --}}

    </div>

    <div class="w-full pt-0 p-5 " x-show="show" wire:loading.class="opacity-30 pointer-events-none">
        <!-- Name -->
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 ">
                {{ translate('Title') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <input type="text" class="form-standard @error('paymentMethod.name') is-invalid @enderror"
                        placeholder="{{ translate('Title') }}"
                        wire:model.defer="paymentMethod.name" />

                <x-system.invalid-msg field="paymentMethod.name"></x-system.invalid-msg>
            </div>
        </div>
        <!-- END Name -->

        <!-- Description -->
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 ">
                {{ translate('Description') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <textarea class="form-standard @error('paymentMethod.description') is-invalid @enderror" 
                            placeholder="{{ translate('Description') }}"
                            wire:model.defer="paymentMethod.description"
                            rows="3">
                </textarea>
                
                <x-system.invalid-msg field="paymentMethod.description"></x-system.invalid-msg>
            </div>
        </div>
        <!-- END Description -->

        <!-- Instructions -->
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 ">
                {{ translate('Instructions') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <textarea class="form-standard @error('paymentMethod.instructions') is-invalid @enderror" 
                            placeholder="{{ translate('Instructions') }}"
                            wire:model.defer="paymentMethod.instructions"
                            rows="3">
                </textarea>
                
                <x-system.invalid-msg field="paymentMethod.instructions"></x-system.invalid-msg>
            </div>
        </div>
        <!-- END Instructions -->

        {{-- <div class="w-full ">
            <div class="col-12">
                
            </div>
            <div class="col-12">
                <x-ev.form.textarea name="paymentMethod.description" label="{{ translate('Description') }}" >
                    <small class="text-muted">{{ translate('Description that the customer will see on your checkout.') }}</small>
                </x-ev.form.textarea>
            </div>
            <div class="col-12">
                <x-ev.form.textarea name="paymentMethod.instructions" label="{{ translate('Instructions') }}" >
                    <small class="text-muted">{{ translate('Instructions that will be added to the thank you page and emails.') }}</small>
                </x-ev.form.textarea>
            </div>
        </div> --}}

        @if($paymentMethod->gateway === 'wire_transfer')
            <div class="w-full mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                      </div>
                      <div class="relative flex justify-start">
                        <span class="pr-3 bg-white text-lg font-medium text-gray-900 border rounded-lg border-gray-400 px-3"> {{ translate('Account details:') }} </span>
                    </div>
                </div>
                
                <div class="w-full mt-3 ">
                    <!-- Bank Name -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:pt-1" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Bank name') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="paymentMethod.bank_name" :required="true"/>
                        </div>
                    </div>
                    <!-- END Bank Name -->

                    <!-- Bank Account Name -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Bank account name') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="paymentMethod.bank_account_name" :required="true"/>
                        </div>
                    </div>
                    <!-- END Bank Account Name -->

                    <!-- Bank Account Number -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Bank account number') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="paymentMethod.bank_account_number" :required="true"/>
                        </div>
                    </div>
                    <!-- END Bank Account Number -->

                    <!-- IBAN -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('IBAN') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="paymentMethod.iban" :required="true" />
                        </div>
                    </div>
                    <!-- END IBAN -->

                    <!-- SWIFT/BIC -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('SWIFT/BIC') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="paymentMethod.bank_swift" :required="true" />
                        </div>
                    </div>
                    <!-- END SWIFT/BIC -->

                    <!-- Sort code -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Sort code') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="paymentMethod.bank_sort_code" />
                        </div>
                    </div>
                    <!-- END Sort code -->

                    {{-- Save Wire Transfer --}}
                    <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                        <button type="button" class="btn btn-primary ml-auto btn-sm"
                            @click=""
                            wire:click="save()">
                        {{ translate('Save') }}
                        </button>
                    </div>
                    {{-- END Save Wire Transfer --}}
                </div>
            </div>
       
        @elseif($paymentMethod->gateway === 'paypal')
            {{-- PAYPAL --}}
            {{-- <div class="w-full mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                      </div>
                      <div class="relative flex justify-start">
                        <span class="pr-3 bg-white text-lg font-medium text-gray-900">{{ translate('Paypal details') }}</span>
                    </div>
                </div>
                
                <div class="w-full mt-3">
                   
                </div>
            </div>

            <span class="divider divider-text pt-3 pb-5">{{ translate('Paypal details:') }}</span>

            <div class="row">
                <div class="col-12">
                    <x-ev.form.input name="paymentMethod.paypal_email" type="text" label="{{ translate('Paypal email') }}" :required="true">
                        <small class="text-muted">{{ translate('Please enter your PayPal email address; this is needed in order to take payment.') }}</small>
                    </x-ev.form.input>
                </div>

                <div class="col-5">
                    <x-ev.form.checkbox name="paymentMethod.paypal_ipn_email_notifications" :items="['paypal_ipn_email_notifications' => translate('Enable')]" label="{{ translate('IPN Email notifications') }}">
                        <small class="text-muted">{{ translate('Send notifications when an IPN is received from PayPal indicating refunds, chargebacks and cancellations.') }}</small>
                    </x-ev.form.checkbox>
                </div>
                <div class="col-7">
                    <x-ev.form.input name="paymentMethod.paypal_receiver_email" type="text" label="{{ translate('Paypal receiver email') }}" >
                        <small class="text-muted">{{ translate('If your main PayPal email differs from the PayPal email entered above, input your main receiver email for your PayPal account here. This is used to validate IPN requests.') }}</small>
                    </x-ev.form.input>
                </div>


                <div class="col-12">
                    <x-ev.form.input name="paymentMethod.paypal_identity_token" type="text" label="{{ translate('Paypal identity token') }}">
                        <small class="text-muted">{{ translate('Optionally enable "Payment Data Transfer" (Profile > Profile and Settings > My Selling Tools > Website Preferences) and then copy your identity token here. This will allow payments to be verified without the need for PayPal IPN.') }}</small>
                    </x-ev.form.input>
                </div>


                <div class="col-5">
                    <x-ev.form.input name="paymentMethod.paypal_invoice_prefix" type="text" label="{{ translate('Paypal invoice prefix') }}" >
                        <small class="text-muted">{{ translate('Please enter a prefix for your invoice numbers. If you use your PayPal account for multiple stores ensure this prefix is unique as PayPal will not allow orders with the same invoice number.') }}</small>
                    </x-ev.form.input>
                </div>
                <div class="col-7">
                    <x-ev.form.checkbox name="paymentMethod.paypal_use_shipping_details" :items="['paypal_use_shipping_details' => translate('Enable')]" label="{{ translate('Use shipping details') }}">
                        <small class="text-muted">{{ translate('PayPal allows us to send one address. If you are using PayPal for shipping labels you may prefer to send the shipping address rather than billing. Turning this option off may prevent PayPal Seller protection from applying.') }}</small>
                    </x-ev.form.checkbox>
                </div>

                <div class="col-4">
                    <x-ev.form.select name="paymentMethod.paypal_payment_action" :items="App\Models\PaymentMethodUniversal::getPaypalPaymentActions()" label="{{ translate('Paypal payment action') }}" >
                        <small class="text-muted">{{ translate('Choose whether you wish to capture funds immediately or authorize payment only.') }}</small>
                    </x-ev.form.select>
                </div>
                <div class="col-8">
                    <x-ev.form.input name="paymentMethod.paypal_image_url" type="text" label="{{ translate('Paypal image URL') }}" >
                        <small class="text-muted">{{ translate('Optionally enter the URL to a 150x50px image displayed as your logo in the upper left corner of the PayPal checkout pages.') }}</small>
                    </x-ev.form.input>
                </div>
            </div>

            <span class="divider divider-text pt-3 pb-5">{{ translate('Paypal API:') }}</span>

            <div class="row">
                <div class="col-12">
                    <x-ev.form.input name="paymentMethod.paypal_live_api_username" type="text" label="{{ translate('Paypal API username') }}" >
                        <small class="text-muted">{{ translate('Get you API username from Paypal') }}</small>
                    </x-ev.form.input>
                </div>
                <div class="col-12">
                    <x-ev.form.input name="paymentMethod.paypal_live_api_password" type="text" label="{{ translate('Paypal API password') }}" >
                        <small class="text-muted">{{ translate('Get you API password from Paypal') }}</small>
                    </x-ev.form.input>
                </div>
                <div class="col-12">
                    <x-ev.form.input name="paymentMethod.paypal_live_api_signature" type="text" label="{{ translate('Paypal API signature') }}" >
                        <small class="text-muted">{{ translate('Get you API signature from Paypal') }}</small>
                    </x-ev.form.input>
                </div>

                <div class="col-12 d-flex">
                    <button type="button" class="btn btn-primary ml-auto"
                            @click="
                                $wire.set('paymentMethod.paypal_payment_action', $('select[name=\'paymentMethod.paypal_payment_action\']').val(), true);
                                $wire.save()
                            ">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div> --}}
            {{-- END PAYPAL --}}
        @elseif($paymentMethod->gateway === 'stripe')
            {{-- STRIPE --}}
            <div class="w-full mt-6">        
                <div class="relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                      </div>
                      <div class="relative flex justify-start">
                        <span class="pr-3 bg-white text-lg font-medium text-gray-900 border rounded-lg border-gray-400 px-3"> {{ translate('Stripe API settings') }}: </span>
                    </div>
                </div>
                
                <div class="w-full mt-6 ">
                    <!-- Stripe Mode -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center " x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Stripe mode') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.select field="paymentMethod.stripe_mode" :items="['live' => translate('Live'), 'test' => translate('Test')]" selected="paymentMethod.stripe_mode" :nullable="false"></x-dashboard.form.select>
                        </div>
                    </div>
                    <!-- END Stripe Mode -->

                    <!-- Stripe Publishable Test Key  -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Publishable Test Key') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="paymentMethod.stripe_pk_test_key" :required="true"/>
                        </div>
                    </div>
                    <!-- END Stripe Publishable Test Key -->

                    <!-- Stripe Secret Test Key -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Secret Test Key') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="paymentMethod.stripe_sk_test_key" :required="true"/>
                        </div>
                    </div>
                    <!-- END Stripe Secrets Test Key -->

                    <!-- Stripe Webhooks Test Endpoint Secret Key  -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Webhook Endpoint (TEST) Secret Key') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="paymentMethod.stripe_webhook_test_secret" />
                        </div>
                    </div>
                    <!-- END Stripe Webhooks Test Endpoint Secret Key -->

                    {{-- ---------------------- --}}

                    <!-- Stripe Publishable Live Key  -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Publishable Live Key') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="paymentMethod.stripe_pk_live_key"/>
                        </div>
                    </div>
                    <!-- END Stripe Publishable Live Key -->

                    <!-- Stripe Secrets Live Key  -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Secrets Live Key') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="paymentMethod.stripe_sk_live_key" />
                        </div>
                    </div>
                    <!-- END Stripe Secrets Live Key -->

                    <!-- Stripe Webhooks Live Endpoint Secret Key  -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Webhook Endpoint (Live) Secret Key') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="paymentMethod.stripe_webhook_live_secret" />
                        </div>
                    </div>
                    <!-- END Stripe Webhooks Live Endpoint Secret Key -->

                    <div class="col-span-3 flex flex-row mt-5">
                        <strong class="mr-2 text-14 text-gray-600">{{ translate('Webhooks URL') }}:</strong>
                        <small class="text-14 text-gray-500">{{ route('webhooks.stripe') }}</small>
                    </div>
                </div>

                {{-- Other Stripe settings --}}
                <div class="relative mt-6 ">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-400"></div>
                      </div>
                      <div class="relative flex justify-start">
                        <span class="pr-3 bg-white text-lg font-medium text-gray-900 border rounded-lg border-gray-400 px-3"> {{ translate('Stripe other settings') }}: </span>
                    </div>
                </div>

                <div class="w-full mt-6 ">
                    <!-- Stripe Statement Descriptor  -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center " x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Statement Descriptor') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="paymentMethod.stripe_statement_descriptor" :required="true"/>
                        </div>
                    </div>
                    <!-- END Stripe Statement Descriptor -->

                    <!-- Stripe Enable Stripe Checkout -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Enable Stripe Checkout') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.toggle field="paymentMethod.stripe_checkout_enabled" />
                        </div>
                    </div>
                    <!-- END Enable Stripe Checkout  -->

                    <!-- Stripe Enable Stripe Automatic Tax -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Enable Stripe Automatic Tax') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.toggle field="paymentMethod.stripe_automatic_tax_enabled" />
                        </div>
                    </div>
                    <!-- END Enable Stripe Automatic Tax  -->

                    <!-- Stripe Price Tax Behavior -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}" x-show="paymentMethod.stripe_automatic_tax_enabled">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Include tax in prices?') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.select field="paymentMethod.stripe_price_tax_behavior" :items="['inclusive' => translate('Yes'), 'exclusive' => translate('No')]" selected="paymentMethod.stripe_price_tax_behavior" :nullable="false"></x-dashboard.form.select>
                        </div>
                    </div>
                    <!-- END Price Tax Behavior  -->

                    <!-- Stripe Inline Credit Card Mode -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Inline Credit Card Mode') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.toggle field="paymentMethod.stripe_inline_credit_card_form" />
                        </div>
                    </div>
                    <!-- END Inline Credit Card Mode -->

                    <!-- Stripe Capture charge -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Capture charge') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.toggle field="paymentMethod.stripe_capture_charge" />
                        </div>
                    </div>
                    <!-- END Capture charge -->

                    <!-- Saved Cards Payment -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Saved cards payment') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.toggle field="paymentMethod.stripe_saved_cards_payment" />
                        </div>
                    </div>
                    <!-- END Saved Cards Payment-->
                    
                    <!-- Stripe Payment request buttons -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                        <label class="block text-sm font-medium text-gray-900 ">
                            {{ translate('Payment request buttons') }}
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.toggle field="paymentMethod.stripe_payment_request_buttons" />
                        </div>
                    </div>
                    <!-- END Payment request buttons -->
                </div>

                {{-- Save Stripe --}}
                <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                    <button type="button" class="btn btn-primary ml-auto btn-sm"
                        @click="
                            $wire.set('paymentMethod.stripe_mode', paymentMethod.stripe_mode, true);
                            $wire.set('paymentMethod.stripe_checkout_enabled', paymentMethod.stripe_checkout_enabled, true);
                            $wire.set('paymentMethod.stripe_automatic_tax_enabled', paymentMethod.stripe_automatic_tax_enabled, true);
                            $wire.set('paymentMethod.stripe_price_tax_behavior', paymentMethod.stripe_price_tax_behavior, true);
                            $wire.set('paymentMethod.stripe_inline_credit_card_form', paymentMethod.stripe_inline_credit_card_form, true);
                            $wire.set('paymentMethod.stripe_capture_charge', paymentMethod.stripe_capture_charge, true);
                            $wire.set('paymentMethod.stripe_saved_cards_payment', paymentMethod.stripe_saved_cards_payment, true);
                            $wire.set('paymentMethod.stripe_payment_request_buttons', paymentMethod.stripe_payment_request_buttons, true);
                        "
                        wire:click="save()">
                    {{ translate('Save') }}
                    </button>
                </div>
                {{-- END Save Stripe --}}
            </div>
            {{-- END STRIPE --}}

        @elseif($paymentMethod->gateway === 'paysera')
            {{-- PAYSERA --}}

            {{-- <span class="divider divider-text pt-3 pb-5">{{ translate('Paysera details:') }}</span>

            <div class="row">
                <div class="col-12">
                    <x-ev.form.input name="paymentMethod.paysera_project_id" :required="true" type="text" label="{{ translate('Paysera Project ID') }}">
                        <small class="text-muted">{{ translate('Type your Paysera project ID (projectid)') }}</small>
                    </x-ev.form.input>
                </div>
                <div class="col-12">
                    <x-ev.form.input name="paymentMethod.paysera_project_password" :required="true" type="text" label="{{ translate('Paysera Project Password') }}">
                        <small class="text-muted">{{ translate('Type your Paysera project password (sign_password)') }}</small>
                    </x-ev.form.input>
                </div>

                <div class="col-12 d-flex">
                    <button type="button" class="btn btn-primary ml-auto"
                            @click="$wire.save()">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div> --}}

            {{-- END PAYSERA --}}
        @endif
    </div>
</div>
