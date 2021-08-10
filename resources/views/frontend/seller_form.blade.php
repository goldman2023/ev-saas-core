@extends('frontend.layouts.app')

@section('content')
    <section class="pt-4 mb-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <h1 class="fw-600 h4">{{ translate('Register your shop') }}</h1>
                </div>
                <div class="col-lg-6">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset" href="{{ route('home') }}">
                                {{ translate('Home') }}
                            </a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset"
                                href="{{ route('shops.create') }}">"{{ translate('Register your shop') }}"</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-4 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-xxl-5 col-xl-6 col-md-8 mx-auto">
                    
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript">
        // making the CAPTCHA  a required field for form submission
        $(document).ready(function() {
            // alert('helloman');
            $("#shop").on("submit", function(evt) {
                var response = grecaptcha.getResponse();
                if (response.length == 0) {
                    //reCaptcha not verified
                    alert("please verify you are humann!");
                    evt.preventDefault();
                    return false;
                }
                //captcha verified
                //do the rest of your validations here
                $("#reg-form").submit();
            });
        });

    </script>
@endsection
