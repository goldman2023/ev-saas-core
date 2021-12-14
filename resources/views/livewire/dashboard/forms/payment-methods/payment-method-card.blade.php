<div class="lw-form card rounded {{ $class }} position-relative"
     wire:key="payment-method-{{ $paymentMethod->gateway }}"
     key="payment-method-{{ $paymentMethod->gateway }}"
     x-cloak
     x-data="{
        show: false,
        paymentMethod: @entangle('paymentMethod').defer
     }"
    x-init="console.log(paymentMethod.enabled);">

    <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                          wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

    <div class="card-header d-flex align-items-center justify-content-start pointer"  wire:loading.class="opacity-3 prevent-pointer-events" @click="show = !show">
        @svg('heroicon-o-chevron-right', ['class' => 'square-16 mr-2'])
        <h4 class="h5 mb-0">{{ $paymentMethod->name }}</h4>

        <span class="badge badge-soft-success d-flex align-items-center px-2 py-1 ml-3 text-12 text-success"
              :class="{'d-flex':paymentMethod.enabled}"
              x-show="paymentMethod.enabled">
              {{ translate('active') }}
        </span>

        <span class="badge badge-soft-danger align-items-center px-2 py-1 ml-3 text-12 text-danger"
              :class="{'d-flex':!paymentMethod.enabled}"
              x-show="!paymentMethod.enabled">
              {{ translate('inactive') }}
        </span>

        <label class="toggle-switch ml-auto" for="payment-method-{{ $paymentMethod->gateway }}-enabled" @click="event.stopPropagation();">
            <input type="checkbox"
                   class="js-toggle-switch toggle-switch-input"
                   id="payment-method-{{ $paymentMethod->gateway }}-enabled"
                   wire:model="paymentMethod.enabled"
            >
            <span class="toggle-switch-label">
              <span class="toggle-switch-indicator"></span>
            </span>
        </label>

    </div>

    <div class="card-body container-fluid" x-show="show" wire:loading.class="opacity-3 prevent-pointer-events">
        <div class="row">
            <div class="col-12">
                <x-ev.form.input name="paymentMethod.name" type="text" label="{{ translate('Title') }}" :required="true" placeholder="{{ translate('Payment method name') }}" />
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
        </div>

        @if($paymentMethod->gateway === 'wire_transfer')
            <span class="divider divider-text pt-3 pb-5">{{ translate('Account details:') }}</span>

            <div class="row">
                <div class="col-6">
                    <x-ev.form.input name="paymentMethod.bank_name" type="text" label="{{ translate('Bank name') }}" :required="true" placeholder="{{ translate('Name of your bank') }}" />
                </div>
                <div class="col-6">
                    <x-ev.form.input name="paymentMethod.bank_account_name" type="text" label="{{ translate('Bank account name') }}" :required="true" placeholder="{{ translate('Think of some catchy name...') }}" />
                </div>
                <div class="col-12">
                    <x-ev.form.input name="paymentMethod.bank_account_number" type="text" label="{{ translate('Bank account number') }}" :required="true" placeholder="{{ translate('Your bank account number') }}" />
                </div>
                <div class="col-12">
                    <x-ev.form.input name="paymentMethod.iban" type="text" label="{{ translate('IBAN') }}" :required="true" placeholder="{{ translate('Your international bank account number (IBAN)') }}" />
                </div>
                <div class="col-6">
                    <x-ev.form.input name="paymentMethod.bank_sort_code" type="text" label="{{ translate('Sort code') }}" :required="false" placeholder="{{ translate('Bank sort code') }}" />
                </div>
                <div class="col-6">
                    <x-ev.form.input name="paymentMethod.bank_swift" type="text" label="{{ translate('Swift/BIC') }}" :required="true" placeholder="{{ translate('Your bank SWIFT/BIC code') }}" />
                </div>

                <div class="col-12 d-flex">
                    <button type="button" class="btn btn-primary ml-auto" wire:click="save()">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div>

        @elseif($paymentMethod->gateway === 'paypal')
            {{-- PAYPAL --}}

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
            </div>
            {{-- END PAYPAL --}}
        @elseif($paymentMethod->gateway === 'stripe')
            {{-- STRIPE --}}

            <span class="divider divider-text pt-3 pb-5">{{ translate('Stripe details:') }}</span>

            <div class="row">
                <div class="col-12">
                    <x-ev.form.input name="paymentMethod.stripe_publishable_key" :required="true" type="text" label="{{ translate('Stripe Publishable Key') }}" >
                        <small class="text-muted">{{ translate('Get you Publishable key from your Stripe account') }}</small>
                    </x-ev.form.input>
                </div>
                <div class="col-12">
                    <x-ev.form.input name="paymentMethod.stripe_secret_key" :required="true" type="text" label="{{ translate('Stripe Secret Key') }}" >
                        <small class="text-muted">{{ translate('Get you Secret key from your Stripe account') }}</small>
                    </x-ev.form.input>
                </div>
                <div class="col-12">
                    <x-ev.form.input name="paymentMethod.stripe_statement_descriptor" type="text" label="{{ translate('Statement Descriptor') }}" >
                        <small class="text-muted">{{ translate('*NEEDS NOTE*') }}</small>
                    </x-ev.form.input>
                </div>


                <div class="col-6">
                    <x-ev.form.checkbox name="paymentMethod.stripe_inline_credit_card_form" :items="['stripe_inline_credit_card_form' => translate('Enable')]" label="{{ translate('Use inline credit card form') }}">
                        <small class="text-muted">{{ translate('*NEEDS NOTE*') }}</small>
                    </x-ev.form.checkbox>
                </div>
                <div class="col-6">
                    <x-ev.form.checkbox name="paymentMethod.stripe_capture_charge" :items="['stripe_capture_charge' => translate('Enable')]" label="{{ translate('Capture charge immediately') }}">
                        <small class="text-muted">{{ translate('*NEEDS NOTE*') }}</small>
                    </x-ev.form.checkbox>
                </div>
                <div class="col-6">
                    <x-ev.form.checkbox name="paymentMethod.stripe_saved_cards_payment" :items="['stripe_saved_cards_payment' => translate('Enable')]" label="{{ translate('Payment via saved cards') }}">
                        <small class="text-muted">{{ translate('*NEEDS NOTE*') }}</small>
                    </x-ev.form.checkbox>
                </div>
                <div class="col-6">
                    <x-ev.form.checkbox name="paymentMethod.stripe_payment_request_buttons" :items="['stripe_payment_request_buttons' => translate('Enable')]" label="{{ translate('Payment request buttons') }}">
                        <small class="text-muted">{{ translate('This feature enables Payment request buttons (Apple Pay/Chrome payment etc.). By using Apple Pay, you agree to Stripe and Apple\'s terms of service.') }}</small>
                    </x-ev.form.checkbox>
                </div>

                <div class="col-12 d-flex">
                    <button type="button" class="btn btn-primary ml-auto"
                            @click="
                                $wire.save()
                            ">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div>
            {{-- END STRIPE --}}

        @elseif($paymentMethod->gateway === 'paysera')
            {{-- PAYSERA --}}

            <span class="divider divider-text pt-3 pb-5">{{ translate('Paysera details:') }}</span>

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
            </div>

            {{-- END PAYSERA --}}
        @endif
    </div>
</div>
