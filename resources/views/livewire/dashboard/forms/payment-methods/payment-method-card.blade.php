<div class="lw-form card rounded {{ $class }} position-relative"
     x-cloak
     x-data="{
        show: false,
        paymentMethod: @entangle('paymentMethod').defer
     }"
    x-init="console.log(paymentMethod.enabled);">

    <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                          wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

    <div class="card-header d-flex align-items-center justify-content-start pointer"  wire:loading.class="opacity-3 " @click="show = !show">
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

        <label class="toggle-switch ml-auto" for="customSwitch">
            <input type="checkbox"
                   class="js-toggle-switch toggle-switch-input"
                   id="customSwitch"
                   wire:model="paymentMethod.enabled"
            >
            <span class="toggle-switch-label">
              <span class="toggle-switch-indicator"></span>
            </span>
        </label>

    </div>

    <div class="card-body container-fluid" x-show="show" wire:loading.class="opacity-3">
        @if($paymentMethod->gateway === 'wire_transfer')
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
            
        @endif
    </div>
</div>
