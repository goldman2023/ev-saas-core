@extends('frontend.layouts.user_panel')

@section('panel_content')
<div class="container mb-3">
    <div class="row">
        <div class="col-sm-3 d-none">
            <!-- CTA Section -->
            @guest
            <div class="text-center py-6 bg-white card"
                style="background: url(https://htmlstream.com/preview/front-v3.1.1/assets/svg/components/abstract-shapes-19.svg) center no-repeat;">
                <h2>{{ translate('Do not lose your saved items!') }}</h2>
                <p>{{ translate('Create an account and get notified about discounts and updates about your liked products') }}</p>
                <span class="d-block mt-5">
                    <a class="btn btn-primary transition-3d-hover" href="{{ route('user.registration') }}">{{ 'Create an account' }}</a>
                </span>
            </div>
            <!-- End CTA Section -->
            @else
            @endif
        </div>
        <div class="col-sm-12">
            @if($products->count() > 0)
            <div class="card">
                <div class="card-header">

                    <h5>
                        {{ translate('Your Viewed Items') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($products as $product)

                        <div class="col-4">
                            <x-default.products.cards.product-card :product="$product->subject"
                                style="{{ ev_dynamic_translate('product-card', true)->value }}">
                            </x-default.products.cards.product-card>
                        </div>
                        @endforeach

                    </div>


                </div>
            </div>
            @endif
        </div>
    </div>

</div>


@endsection
