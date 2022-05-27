<script defer>
    document.addEventListener('alpine:init', () => {
        // Get Stripe Checkout permalink from provided parameters
        Alpine.magic('getStripeCheckoutPermalink', () => {
            @if(auth()->user()->isSubscribed())
                return "{{ route('stripe.portal_session') }}";
            @else
                return (params) => {
                    let data_params = {
                        ...{ model_id: null, model_class: null, qty: 1, preview: false, interval: null }, 
                        ...params
                    };
                    let base_route = new URL("{{ route('stripe.checkout_redirect') }}");
                    var url_params = new URLSearchParams(base_route.search);

                    let data = {
                        'id': data_params.model_id,
                        'class': atob(data_params.model_class), // PASSED VALUE MUST BE base64_encode($model::class) with PHP!!!
                        'qty': data_params.qty,
                        'preview': data_params.preview,
                        'interval': data_params.interval,
                    };
                    console.log(data);

                    url_params.set('data', btoa(JSON.stringify(data)));
                    return base_route.toString()+'?'+url_params.toString();
                }
            @endif
        });
    })
</script>