@extends('frontend.layouts.user_panel')
@section('meta_title', translate('Manage Payment Methods'))
@section('page_title', translate('Manage Payment Methods'))

@section('panel_content')
    <section class="card">
        <div class="card-header">
            <h4 class="mb-0 h4">{{ translate('Payment methods settings')}}</h4>
        </div>
        <div class="card-body">
            @if(auth()->user()->isAdmin())
                @if($universal_payment_methods->isNotEmpty())
                    @foreach($universal_payment_methods as $key => $payment_method)
                        <livewire:dashboard.forms.payment-methods.payment-method-card
                            :payment-method="$payment_method" type="universal" class="mb-2">
                        </livewire:dashboard.forms.payment-methods.payment-method-card>
                    @endforeach
                @endif

{{-- TODO: Add Universal Payment Methods Seeder which will add all available payment gateways to every new tenant! Available universal payment gateways are on EVSaaS level - not added by each tenant. Each tenant can only fill the `data` needed for gateway and enable/disable availabel gateways! --}}
{{--                <livewire:dashboard.forms.payment-methods.payment-method-form type="universal" class="">--}}
{{--                </livewire:dashboard.forms.payment-methods.payment-method-form>--}}

            {{-- TODO: Custom Payment Gateway --}}
            @elseif(auth()->user()->isSeller() && auth()->user()->isStaff())
                @if($universal_payment_methods->isNotEmpty())
                    @foreach($universal_payment_methods as $payment_method)
                        <livewire:dashboard.forms.payment-methods.payment-method-card
                            :payment-method="$payment_method" class="">
                        </livewire:dashboard.forms.payment-methods.payment-method-card>
                    @endforeach
                @endif
            @endif

        </div>
    </section>

    <x-ev.toast id="payment-method-updated-toast"
                position="bottom-center"
                class="text-white h3"
                :is_x="true"
                x-init="$watch('show', function(value) { value ? setTimeout(() => show = false, 3000) : ''; })"
                @toast.window="if(event.detail.id == 'payment-method-updated-toast') {
                    content = event.detail.content;
                    show = true;
                    type = event.detail.type;
                }"
    ></x-ev.toast>
@endsection

@push('footer_scripts')
    <script src="{{ static_asset('vendor/hs-add-field/dist/hs-add-field.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>

    <!-- JS Front -->
    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>

    <script src="{{ static_asset('js/crud/payment-methods-form.js', false, true, true) }}"></script>
@endpush
