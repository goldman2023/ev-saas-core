@extends('frontend.layouts.app')

@section('content')

    <div class="py-6">
        <div class="container">
            <div class="row">
                <div class="col-xxl-5 col-xl-6 col-md-8 mx-auto">
                    <!-- Form -->
                    <form class="js-validate" method="POST" action="{{ route('password.email') }}">
                        <!-- Title -->
                        <div class="mb-5 mb-md-7">
                            <h1 class="h2">{{ translate('Forgot Password?') }}</h1>
                            <p>{{ translate('Enter your email address to recover your password.') }}</p>
                        </div>
                        <!-- End Title -->

                        @csrf
                        <!-- Form Group -->
                        <div class="js-form-message form-group">
                            <label class="input-label" for="signinSrEmailExample2">Email address</label>
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <!-- End Form Group -->

                        <!-- Button -->
                        <div class="row align-items-center mb-5">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <a class="font-size-1 font-weight-bold" href="{{ route('user.login') }}"><i
                                        class="fas fa-angle-left fa-sm mr-1"></i>{{ translate('Back to Login') }}</a>
                            </div>

                            <div class="col-sm-6 text-sm-right">
                                <button type="submit"
                                    class="btn btn-primary transition-3d-hover">{{ translate('Send Password Reset Link') }}</button>
                            </div>
                        </div>
                        <!-- End Button -->
                    </form>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </div>


@endsection
