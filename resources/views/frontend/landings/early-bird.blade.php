@extends('frontend.layouts.app')

@section('content')
    <div class="hero">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-5 intro">
                    <h1 class="text-white font-weight-bold mb-4 aos-init aos-animate" data-aos="fade-up"
                        data-aos-delay="0">
                        {{ __('Join B2BWood Club') }}
                    </h1>
                    <p class="text-white mb-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">Join early
                        bird version of B2BWood Club and improve your comany visibility and transparency.</p>
                    <form action="#" class="sign-up-form d-flex aos-init aos-animate" data-aos="fade-up"
                          data-aos-delay="200">
                        <input type="text" class="form-control" placeholder="Enter email address">
                        <input type="submit" class="btn btn-primary" value="Sign up">
                    </form>
                </div>
            </div>
            <div class="hero_img aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                <img src="https://preview.colorlib.com/theme/easy/images/hero_img.png" alt="Image" class="img-fluid">
            </div>
        </div>
        <div class="slant"
             style="background-image: url('https://preview.colorlib.com/theme/easy/images/slant.svg');"></div>
    </div>


    {{--  Logos section  --}}
    <div class="py-3">
        <div class="container">
            <div class="row">
                <div class="col aos-init aos-animate" data-aos="fade-up" data-aos-delay="0">
                    <img src="https://preview.colorlib.com/theme/easy/images/logo-puma.png" alt="Image"
                         class="img-fluid">
                </div>
                <div class="col aos-init aos-animate" data-aos="fade-up" data-aos-delay="0">
                    <img src="https://preview.colorlib.com/theme/easy/images/logo-puma.png" alt="Image"
                         class="img-fluid">
                </div>
                <div class="col aos-init aos-animate" data-aos="fade-up" data-aos-delay="0">
                    <img src="https://preview.colorlib.com/theme/easy/images/logo-puma.png" alt="Image"
                         class="img-fluid">
                </div>
                <div class="col aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                    <img src="https://preview.colorlib.com/theme/easy/images/logo-adobe.png" alt="Image"
                         class="img-fluid">
                </div>
                <div class="col aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                    <img src="https://preview.colorlib.com/theme/easy/images/logo-google.png" alt="Image"
                         class="img-fluid">
                </div>
                <div class="col aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                    <img src="https://preview.colorlib.com/theme/easy/images/logo-paypal.png" alt="Image"
                         class="img-fluid">
                </div>
            </div>
        </div>
    </div>


    @include('frontend.landings.components.features')
    @include('frontend.landings.components.signup-cta')
@endsection
