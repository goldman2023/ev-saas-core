@extends('frontend.layouts.app')

@section('content')
<section class="text-center py-6">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <h1 class="h1 text-3xl font-bold mb-10">
                    {{ translate('Oops. Content not found,') }} 👁️‍🗨️
                </h1>
                <img src="{{ static_asset('assets/img/404.svg') }}" class="max-w-[400px] mx-auto mb-5" height="300">

                <a href="{{ route('home') }}" class="btn btn-soft-primary font-semibold">
                    <span class="emoji mr-2">👈</span> {{ translate('Back to homepage') }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
