<script defer>
    document.addEventListener('alpine:init', () => {
        // Get Stripe Checkout permalink from provided parameters
        Alpine.magic('getStripeCheckoutPermalink', () => {
            @if(Auth::check() && auth()->user()->isSubscribed())
                return () => { return "{{ route('stripe.portal_session') }}"};
            @else
                return (params) => {
                    let data_params = {
                        ...{
                            'interval': null,
                            'items': [],
                            'previous_subscription_id': null,
                        },
                        ...params
                    };

                    let base_route = new URL("{{ route('stripe.checkout_redirect') }}");
                    let url_params = new URLSearchParams(base_route.search);
                    console.log(data_params);
                    url_params.set('data', btoa(JSON.stringify(data_params)));

                    return base_route.toString()+'?'+url_params.toString();
                }
            @endif
        });
    })
</script>