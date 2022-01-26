@extends('frontend.layouts.' . $globalLayout)

@section('meta_title'){{ translate('Your order is accepted').' - '.\TenantSettings::get('site_name').' | '.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('order, thank you page, checkout, cart, purchase, ecommerce') }}@stop

@section('meta')

@endsection

@section('content')
    <section class="order-received-page position-relative mb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="bg-white rounded card">

                        <div class="card-body">
                            <i class="fas fa-check-circle text-success fa-5x mb-3"></i>
                            <div class="mb-5">
                                <h1 class="h2">{{ translate('Your order is canceled!') }}</h1>
                                <p>{{ translate('If you want to continue shop press the button below.') }}</p>
                            </div>
                            <a class="btn btn-primary btn-pill transition-3d-hover px-5" href="#">{{ translate('Continue Shopping') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection