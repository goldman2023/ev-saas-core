@if($enabled)
    <div class="relative w-full grid grid-cols-1 space-y-3 {{ $class }} " :class="{'opacity-50 pointer-events-none':loading}" x-data="{
        loading: false,
    }">
        <x-ev.loaders.spinner class="absolute-center z-10" x-show="loading" x-cloak>
        </x-ev.loaders.spinner>

        @if($fb_enabled)
            <a href="{{ route('social.login', ['provider' => 'facebook']) }}" @click="loading = true" class=" w-full bg-[#4267B2] flex items-center justify-center rounded-lg shadow border border-[#4267B2] text-white py-2 cursor-pointer">
                @svg('lineawesome-facebook-f', ['class' => 'w-5 h-5 mr-2'])
                <span>{{ translate('Sign in with Facebook') }}</span>
            </a>
        @endif

        @if($google_enabled)
            <a href="{{ route('social.login', ['provider' => 'google']) }}" @click="loading = true" class="w-full bg-[#DB4437] flex items-center justify-center rounded-lg shadow border border-[#DB4437] text-white py-2 cursor-pointer">
                @svg('lineawesome-google', ['class' => 'w-5 h-5 mr-2'])
                <span>{{ translate('Sign in with Google') }}</span>
            </a>
        @endif

        @if($linkedin_enabled)
        <a href="{{ route('social.login', ['provider' => 'linkedin']) }}" @click="loading = true" class="w-full bg-[#006192] flex items-center justify-center rounded-lg shadow border border-[#006192] text-white py-2 cursor-pointer">
            @svg('lineawesome-linkedin-in', ['class' => 'w-5 h-5 mr-2'])
            <span>{{ translate('Sign in with LinkedIn') }}</span>
        </a>
        @endif
    </div>

    {{ $slot }}
@endif
