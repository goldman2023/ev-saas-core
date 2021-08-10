<script src="//voguepay.com/js/voguepay.js"></script>

<script>
    closedFunction=function() {
        alert('window closed');
        location.href = '{{ env('APP_URL') }}'
    }

    successFunction=function(transaction_id) {
        location.href = '{{ env('APP_URL') }}'+'/vogue-pay/success/'+transaction_id
    }
    failedFunction=function(transaction_id) {
         location.href = '{{ env('APP_URL') }}'+'/vogue-pay/success/'+transaction_id
    }
</script>
@if (\App\Models\BusinessSetting::where('type', 'voguepay_sandbox')->first()->value == 1)
    <input type="hidden" id="merchant_id" name="v_merchant_id" value="demo">
@else
    <input type="hidden" id="merchant_id" name="v_merchant_id" value="{{ env('VOGUE_MERCHANT_ID') }}">
@endif

<script>

        window.onload = function(){
            pay3();
        }

        function pay3() {
         Voguepay.init({
             v_merchant_id: document.getElementById("merchant_id").value,
             total: '{{ Session::get('payment_data')['amount'] }}',
             cur: '{{\App\Models\Currency::findOrFail(\App\Models\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code}}',
             merchant_ref: 'ref123',
             loadText:'Custom load text',
             customer: {
                name: '{{ auth()->user()->name }}',

                email: '{{ auth()->user()->email }}',
                phone: '{{ auth()->user()->phone }}'
            },
             closed:closedFunction,
             success:successFunction,
             failed:failedFunction
         });
        }
</script>
