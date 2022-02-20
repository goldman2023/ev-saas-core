<form class="js-validate" role="form" action="{{ route('business.login.submit') }}"
method="POST">
@csrf

<!-- Login -->
<div id="login" class="">
    <!-- Title -->
    <div class="text-center mb-3">
        <h3 class="mb-0">{{ translate('Sign In as a Customer') }}</h3>
        <p>{{ translate('Login to manage your account.') }}</p>
    </div>
    <!-- End Title -->

    @error('incorrect')
    <small class="text-danger">{{ $message }}</small>
    @enderror



    @if (get_setting('google_login') == 1 || get_setting('facebook_login') == 1 ||
    get_setting('twitter_login') == 1)
    <ul class="list-inline social colored text-center mb-4">

        @if (get_setting('google_login') == 1)
        <a class="border btn btn-sm btn-ghost-secondary btn-block mb-2"
            href="{{ route('social.login', ['provider' => 'google']) }}">
            <span class="d-flex justify-content-center align-items-center">
                @svg('grommet-google', ['style' => 'width:16px;margin-right:10px'])
                {{ translate('Sign In with Google') }}
            </span>
        </a>
        @endif
        @if (get_setting('facebook_login') == 1)
        <a class="border btn btn-sm btn-ghost-secondary btn-block mb-2"
            href="{{ route('social.login', ['provider' => 'facebook']) }}">
            <span class="d-flex justify-content-center align-items-center">
                @svg('grommet-facebook', ['style' => 'width:16px;margin-right:10px'])
                {{ translate('Sign In with Facebook') }}
            </span>
        </a>
        @endif
        @if (get_setting('twitter_login') == 1)
        <a class="border btn btn-sm btn-ghost-secondary btn-block mb-2"
            href="{{ route('social.login', ['provider' => 'twitter']) }}">
            <span class="d-flex justify-content-center align-items-center">
                @svg('grommet-twitter', ['style' => 'width:16px;margin-right:10px'])
                {{ translate('Sign In with Twitter') }}
            </span>
        </a>
        @endif
    </ul>
    @endif

    <div class="text-center mb-3">
        <span class="divider divider-text">{{ translate('OR') }}</span>
    </div>

    <livewire:forms.login-form></livewire:forms.login-form>
</div>
</form>
