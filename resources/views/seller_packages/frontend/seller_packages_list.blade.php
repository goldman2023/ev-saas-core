@extends('frontend.layouts.app')

@section('content')
    <section class="py-8 bg-soft-primary">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 mx-auto text-center">
                    <h1 class="mb-0 fw-700">{{ translate('Choose Your Subscription') }}</h1>
                    <p>
                        {{ translate('Become a part of something special') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    @php

        @endphp
    <section class="py-4 py-lg-5" style="margin-top: 50px;">
        <div class="container">
            <div class="row row-cols-xxl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 gutters-10 justify-content-center">
                @foreach ($seller_packages as $key => $seller_package)
                    <x-pricing-plan-card :key="$key" :plan="$seller_package" :></x-pricing-plan-card>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@section('modal')
    <!-- Select Payment Type Modal -->
    <div class="modal fade" id="select_payment_type_modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Select Payment Type') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="package_id" name="package_id" value="">
                    <div class="row">
                        <div class="col-md-2">
                            <label>{{ translate('Payment Type') }}</label>
                        </div>
                        <div class="col-md-10">
                            <div class="mb-3">
                                <select class="form-control aiz-selectpicker" onchange="payment_type(this.value)"
                                        data-minimum-results-for-search="Infinity">
                                    <option value="">{{ translate('Select One') }}</option>
                                    <option value="online">{{ translate('Online payment') }}</option>
                                    <option value="offline">{{ translate('Offline payment') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-sm btn-primary transition-3d-hover mr-1"
                                id="select_type_cancel" data-dismiss="modal">{{ translate('Cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Online payment Modal-->
    <div class="modal fade" id="price_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Select Payment Method') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="" id="package_payment_form" action="{{ route('seller_packages.purchase') }}" method="post">
                    <!-- Button Group -->
                    <div style="padding: 10px 20px">
                        <div class="btn-group btn-group-toggle btn-group-segment d-flex form-group"
                             data-toggle="buttons">
                            <label class="btn btn-sm flex-fill focus active">
                                <input type="radio" name="options" id="option1" checked> Credit or Debit card
                            </label>
                            <label class="btn btn-sm flex-fill">
                                <input type="radio" name="options"
                                       id="option2"> {{ translate('Bank Transfer (SWIFT)') }}
                                {{--                                <span class="badge badge-soft-primary w-auto">Coming soon</span>--}}
                            </label>
                        </div>
                    </div>
                    <!-- End Button Group -->

                    @csrf
                    <input type="hidden" name="seller_package_id" value="">
                    <div class="modal-body">
                        <div class="stripe-payment-modal">
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- <label class="pl-3">{{ translate('Secure Payments Processed By Stripe') }}</label> --}}
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        @if (get_setting('payment_method_images') != null)
                                            @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)
                                                <li class="list-inline-item">
                                                    <img src="{{ uploaded_asset($value) }}" height="30"
                                                         class="mw-100 h-auto">
                                                </li>
                                            @endforeach
                                        @endif
                                        <select class="form-control aiz-selectpicker d-none" data-live-search="true"
                                                name="payment_option">
                                            @if (\App\Models\BusinessSetting::where('type', 'paypal_payment')->first()->value == 1)
                                                <option value="paypal">{{ translate('Paypal') }}</option>
                                            @endif
                                            @if (\App\Models\BusinessSetting::where('type', 'stripe_payment')->first()->value == 1)
                                                <option value="stripe">{{ translate('Stripe') }}</option>
                                            @endif
                                            @if (\App\Models\BusinessSetting::where('type', 'sslcommerz_payment')->first()->value == 1)
                                                <option value="sslcommerz">{{ translate('sslcommerz') }}</option>
                                            @endif
                                            @if (\App\Models\BusinessSetting::where('type', 'instamojo_payment')->first()->value == 1)
                                                <option value="instamojo">{{ translate('Instamojo') }}</option>
                                            @endif
                                            @if (\App\Models\BusinessSetting::where('type', 'razorpay')->first()->value == 1)
                                                <option value="razorpay">{{ translate('RazorPay') }}</option>
                                            @endif
                                            @if (\App\Models\BusinessSetting::where('type', 'paystack')->first()->value == 1)
                                                <option value="paystack">{{ translate('PayStack') }}</option>
                                            @endif
                                            @if (\App\Models\BusinessSetting::where('type', 'voguepay')->first()->value == 1)
                                                <option value="voguepay">{{ translate('Voguepay') }}</option>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit"
                                        class="btn btn btn-primary transition-3d-hover mr-1">{{ translate('Pay By Credit Card') }}
                                    <i class="la la-angle-right "></i>
                                </button>
                            </div>
                        </div>

                        <div class="bank-payment-modal">
                            <x-bank-transfer-modal></x-bank-transfer-modal>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- offline payment Modal -->
    <div class="modal fade" id="offline_seller_package_purchase_modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title strong-600 heading-5">{{ translate('Offline Package Payment') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="offline_seller_package_purchase_modal_body"></div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function select_payment_type(id) {
            $('input[name=package_id]').val(id);
            $('#select_payment_type_modal').modal('show');
        }

        function payment_type(type) {
            var package_id = $('#package_id').val();
            if (type == 'online') {
                $("#select_type_cancel").click();
                show_price_modal(package_id);
            } else if (type == 'offline') {
                $("#select_type_cancel").click();
                $.post('{{ route('offline_seller_package_purchase_modal') }}', {
                    _token: '{{ csrf_token() }}',
                    package_id: package_id
                }, function (data) {
                    $('#offline_seller_package_purchase_modal_body').html(data);
                    $('#offline_seller_package_purchase_modal').modal('show');
                });
            }
        }

        function show_price_modal(id) {
            $('input[name=seller_package_id]').val(id);
            $('#price_modal').modal('show');
        }

        function get_free_package(id) {
            $('input[name=seller_package_id]').val(id);
            $('#package_payment_form').submit();
        }

    </script>
@endsection
