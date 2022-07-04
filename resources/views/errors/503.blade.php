@extends('frontend.layouts.app')

@section('content')
<section class="align-items-center d-flex h-100 bg-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto text-center py-4">
                <img src="{{ static_asset('assets/img/maintainance.svg') }}" class="w-[400px] mx-auto img-fluid ">
                <h3 class="font-medium fw-600 mt-5">{{translate('We are Under Maintenance.')}}</h3>
                <div class="lead">{{translate('We will be back soon!')}}</div>
            </div>
        </div>
    </div>
</section>
@endsection
