@extends('frontend.layouts.app')

@section('content')
    <section class="gry-bg py-5">
        <div class="profile">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 mx-auto">
                        <div class="card">
                            <form class="js-validate" role="form" action="{{ route('business.login.submit') }}"
                                method="POST">
                                @csrf

                                <!-- Login -->
                                <div id="login">
                                    <!-- Title -->
                                    <div class="text-center mb-7">
                                        <h3 class="mb-0">{{ translate('Sign In to Business Account') }}</h3>
                                        <p>{{ translate('Login to manage your account.') }}</p>
                                    </div>
                                    <!-- End Title -->

                                    @error('incorrect')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <!-- Input Group -->
                                    <div class="js-form-message mb-4">
                                        <label class="input-label">{{ translate('Email') }}</label>
                                        <div class="input-group input-group-sm mb-2">
                                            @if (\App\Models\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                                <input type="text"
                                                    class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                    value="{{ old('email') }}"
                                                    placeholder="{{ translate('Email Or Phone') }}" name="email"
                                                    data-test="email" id="email">
                                            @else
                                                <input type="email"
                                                    class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                    value="{{ old('email') }}" placeholder="{{ translate('Email') }}"
                                                    name="email" data-test="email">
                                            @endif
                                            @if (\App\Models\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                                <span
                                                    class="opacity-60">{{ translate('Use country code before number') }}</span>
                                            @endif
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- End Input Group -->

                                    <!-- Input Group -->
                                    <div class="js-form-message mb-3">
                                        <label class="input-label">Password</label>
                                        <div class="input-group input-group-sm mb-2">
                                            <input type="password"
                                                class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                placeholder="{{ translate('Password') }}" name="password" id="password"
                                                data-test="password">
                                            @error('password')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- End Input Group -->

                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" name="remember"
                                                    {{ old('remember') ? 'checked' : '' }}>
                                                <span class=opacity-60>{{ translate('Remember Me') }}</span>
                                                <span class="aiz-square-check"></span>
                                            </label>
                                        </div>
                                        <div class="col-6 text-right">
                                            <a href="{{ route('password.request') }}"
                                                class="text-reset opacity-60 fs-14">{{ translate('Forgot password?') }}</a>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit"
                                            class="btn btn-sm btn-primary btn-block">{{ translate('Login') }}</button>
                                    </div>

                                    <div class="text-center mb-3">
                                        <span class="divider divider-text">OR</span>
                                    </div>

                                    @if (get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1)
                                        <div class="separator mb-3">
                                            <span
                                                class="bg-white px-3 opacity-60">{{ translate('Or Login With') }}</span>
                                        </div>
                                        <ul class="list-inline social colored text-center mb-5">

                                            @if (get_setting('google_login') == 1)
                                                <a class="btn btn-sm btn-ghost-secondary btn-block mb-2"  href="{{ route('social.login', ['provider' => 'google']) }}">
                                                    <span class="d-flex justify-content-center align-items-center">
                                                        @svg('grommet-google', ['style' => 'width:16px;margin-right:10px'])
                                                        Sign In with Google
                                                    </span>
                                                </a>
                                            @endif
                                            @if (get_setting('facebook_login') == 1)
                                                <a class="btn btn-sm btn-ghost-secondary btn-block mb-2"  href="{{ route('social.login', ['provider' => 'facebook']) }}">
                                                    <span class="d-flex justify-content-center align-items-center">
                                                        @svg('grommet-facebook', ['style' => 'width:16px;margin-right:10px'])
                                                        Sign In with Facebook
                                                    </span>
                                                </a>
                                            @endif
                                            @if (get_setting('twitter_login') == 1)
                                                <a class="btn btn-sm btn-ghost-secondary btn-block mb-2"  href="{{ route('social.login', ['provider' => 'twitter']) }}">
                                                    <span class="d-flex justify-content-center align-items-center">
                                                        @svg('grommet-twitter', ['style' => 'width:16px;margin-right:10px'])
                                                        Sign In with Twitter
                                                    </span>
                                                </a>
                                            @endif
                                        </ul>
                                    @endif
                                    <div class="text-center">
                                        <span class="small text-muted">Do not have an account?</span>
                                        <a class="js-animation-link small font-weight-bold" href="{{ route('business.register') }}"
                                            data-hs-show-animation-options='{
                                                 "targetSelector": "#signup",
                                                 "groupName": "idForm",
                                                 "animationType": "css-animation",
                                                 "animationIn": "slideInUp",
                                                 "duration": 400
                                               }'>Sign Up
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        function autoFillSeller() {
            $('#email').val('seller@example.com');
            $('#password').val('123456');
        }

        function autoFillCustomer() {
            $('#email').val('customer@example.com');
            $('#password').val('123456');
        }
    </script>
@endsection
