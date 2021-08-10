@extends('frontend.layouts.app')

@section('content')

    <!-- 
        Taken From: https://htmlstream.com/front/snippets/ecommerce.html
        Cart Section -->
    <div class="container space-2">
        <div class="w-md-80 w-lg-50 text-center mx-md-auto">
            <i class="fas fa-check-circle text-success fa-5x mb-3"></i>
            <div class="mb-5">
                <h1 class="h2">
                {{ translate('You have succesfully joined B2BWood Club') }}
                </h1>
                <p>Thank you for your order! Your order is being processed and will be completed within 3-6 hours. You will
                    receive an email confirmation when your order is completed.</p>
            </div>
            <a class="btn btn-success btn-pill transition-3d-hover px-5" href="{{ route('Dashboard') }}">
                {{ translate('Visit Company Dashboard') }}
            </a>
        </div>
    </div>
    <!-- End Cart Section -->

@endsection
