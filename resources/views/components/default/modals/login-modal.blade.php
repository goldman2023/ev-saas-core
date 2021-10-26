<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-zoom" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title fw-600">{{ translate('Login') }}</h6>
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true"></span>
            </button>
        </div>
        <div class="modal-body">
            <div class="p-3">
                <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        @if (\App\Models\Addon::where('unique_identifier', 'otp_system')->first() != null &&
                        \App\Models\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                        <input type="text"
                            class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                            value="{{ old('email') }}" placeholder="{{ translate('Email Or Phone') }}"
                            name="email" id="email">
                        @else
                        <input type="email"
                            class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                            value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email">
                        @endif
                        @if (\App\Models\Addon::where('unique_identifier', 'otp_system')->first() != null &&
                        \App\Models\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                        <span class="opacity-60">{{ translate('Use country code before number') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" class="form-control h-auto form-control-lg"
                            placeholder="{{ translate('Password') }}">
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="aiz-checkbox">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class=opacity-60>{{ translate('Remember Me') }}</span>
                                <span class="aiz-square-check"></span>
                            </label>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('password.request') }}" class="text-reset opacity-60 fs-14">{{
                                translate('Forgot password?') }}</a>
                        </div>
                    </div>

                    <div class="mb-5">
                        <button type="submit" class="btn btn-primary btn-block fw-600">{{ translate('Login')
                            }}</button>
                    </div>
                </form>

                <div class="text-center mb-3">
                    <p class="text-muted mb-0">{{ translate('Dont have an account?') }}</p>
                    <a href="{{ route('user.registration') }}">{{ translate('Register Now') }}</a>
                </div>
                @if (get_setting('google_login') == 1 || get_setting('facebook_login') == 1 ||
                get_setting('twitter_login') == 1)
                <div class="separator mb-3">
                    <span class="bg-white px-3 opacity-60">{{ translate('Or Login With') }}</span>
                </div>
                <ul class="list-inline social colored text-center mb-5">
                    @if (get_setting('facebook_login') == 1)
                    <li class="list-inline-item">
                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                            <i class="lab la-facebook-f"></i>
                        </a>
                    </li>
                    @endif
                    @if (get_setting('google_login') == 1)
                    <li class="list-inline-item">
                        <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                            <i class="lab la-google"></i>
                        </a>
                    </li>
                    @endif
                    @if (get_setting('twitter_login') == 1)
                    <li class="list-inline-item">
                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                            <i class="lab la-twitter"></i>
                        </a>
                    </li>
                    @endif
                </ul>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
