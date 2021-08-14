<div class="mt-8">
    <h3 class="text-lg font-medium text-gray-900">Change payment method</h3>
    <div class="mt-2 shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
            {{-- Refreshing this component using an event breaks the Stripe Elements form, so we use a nested component. --}}
            @livewire('current-payment-method')
            <div class="hidden sm:block">
                <div class="py-4">
                    <div class="border-t border-gray-200"></div>
                </div>
            </div>
            <label for="card-holder-name" class="block text-sm font-medium leading-5 text-gray-700">Card holder name
            </label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input id="card-holder-name" type="text" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="Taylor Otwell">
            </div>
            
            <!-- Stripe Elements Placeholder -->
            <div class="mt-2 relative rounded-md shadow-sm">
                <div id="card-element" class="form-input block w-full sm:text-sm sm:leading-5"></div>
            </div>
            <p id="payment-method-message" class="text-sm"></p>
        </div>
        <div class="px-4 sm:px-6 py-2 bg-gray-50 flex justify-end">
            <button id="card-button" data-secret="{{ $intent->client_secret }}" class="py-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue focus:bg-indigo-500 active:bg-indigo-600 transition duration-150 ease-in-out">
                Update payment method
            </button>
        </div>
    </div>
</div>

@push('body')
<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('{{ config('saas.stripe_key') }}');
    
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    
    cardElement.mount('#card-element');
    
    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;
    
    function paymentMethodMessage(message, success) {
        document.getElementById('payment-method-message').innerHTML = message;
        document.getElementById('payment-method-message').classList = 'text-sm mt-4 ' + (success ? 'text-green-500' : 'text-red-500');
    }
    
    cardButton.addEventListener('click', async (e) => {
        const { setupIntent, error } = await stripe.confirmCardSetup(
        clientSecret, {
            payment_method: {
                card: cardElement,
                billing_details: { name: cardHolderName.value }
            }
        }
        );
        
        if (error) {
            paymentMethodMessage(error.message, false);
        } else {
            paymentMethodMessage('Payment method updated successfuly.', true);
            
            @this.set('paymentMethod', setupIntent.payment_method);
            @this.call('save');
        }
    });
</script>
@endpush