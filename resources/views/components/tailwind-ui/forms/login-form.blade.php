<!-- Login -->
<div id="login" class="w-full">
    <!-- Title -->
    <div class="text-center mb-3">
        <h3 class="text-20 font-medium mb-0">{{ translate('Sign In as a Customer') }}</h3>
        <p class="text-16">{{ translate('Login to manage your account.') }}</p>
    </div>
    <!-- End Title -->


    @if (get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1)
    <ul class="flex flex-col text-center mb-4">

        @if (get_setting('google_login') == 1)
        <a class="border btn bg-white hover:bg-red-100 hover:text-sky-700 mb-2"
            href="{{ route('social.login', ['provider' => 'google']) }}">
            <span class="flex justify-center items-center text-14">
                @svg('grommet-google', ['style' => 'width:16px;margin-right:10px'])
                {{ translate('Sign In with Google') }}
            </span>
        </a>
        @endif
        @if (get_setting('facebook_login') == 1)
        <a class="border btn btn bg-white hover:bg-red-100 hover:text-sky-700 mb-2"
            href="{{ route('social.login', ['provider' => 'facebook']) }}">
            <span class="flex justify-center items-center text-14">
                @svg('grommet-facebook', ['style' => 'width:16px;margin-right:10px'])
                {{ translate('Sign In with Facebook') }}
            </span>
        </a>
        @endif
        @if (get_setting('twitter_login') == 1)
        <a class="border btn btn bg-white hover:bg-red-100 hover:text-sky-700 mb-2"
            href="{{ route('social.login', ['provider' => 'twitter']) }}">
            <span class="flex justify-center items-center text-14">
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
