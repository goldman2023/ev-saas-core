@extends('frontend.layouts.' . $globalLayout)

@section('content')

<div class="bg-gray-100 pt-10 pb-10">
<div
    class="min-h-full flex md:w-full md:max-w-6xl sm:rounded-2xl sm:shadow overflow-hidden sm:bg-card mx-auto bg-white">
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-lg lg:w-96">
            <div>
                <x-tenant.system.image alt="{{ get_site_name() }} logo" class="h-12 w-auto"
                    :image="get_site_logo()">
                </x-tenant.system.image>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">{{ translate('Login') }}</h2>
                <p class=" mt-2 text-sm text-gray-600">
                    {{ translate('Or') }}
                    <a href="{{ route('user.registration') }}" class="font-medium text-indigo-600 hover:text-indigo-500"> {{ translate('Not a member yet? Sign up to ') }}  {{ get_site_name() }}</a>
                </p>
            </div>

            <div class="mt-2">
                <livewire:forms.login-form></livewire:forms.login-form>
            </div>
        </div>
    </div>
    <div class="hidden lg:block relative w-0 flex-1">
        <div
            class="relative hidden md:flex flex-auto items-start justify-center h-full p-16 lg:px-20 overflow-hidden bg-gray-800 dark:border-l ">
            <svg viewBox="0 0 960 540" width="100%" height="100%" preserveAspectRatio="xMidYMax slice"
                xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 pointer-events-none ">
                <g fill="none" stroke="currentColor" stroke-width="100" class="text-gray-700 opacity-25 ">
                    <circle r="234" cx="196" cy="23" class=""></circle>
                    <circle r="234" cx="790" cy="491" class=""></circle>
                </g>
            </svg><svg viewBox="0 0 220 192" width="220" height="192" fill="none"
                class="absolute -top-16 -right-16 text-gray-700 ">
                <defs class="">
                    <pattern id="837c3e70-6c3a-44e6-8854-cc48c737b659" x="0" y="0" width="20" height="20"
                        patternUnits="userSpaceOnUse" class="">
                        <rect x="0" y="0" width="4" height="4" fill="currentColor" class=""></rect>
                    </pattern>
                </defs>
                <rect width="220" height="192" fill="url(#837c3e70-6c3a-44e6-8854-cc48c737b659)" class="">
                </rect>
            </svg>
            <div class="z-10 relative w-full max-w-2xl">
                <div class="text-5xl font-bold leading-none text-gray-100 ">
                    <div class="">{{ translate('Welcome to')}} </div>
                    <div class="">{{ translate('our community') }}</div>
                </div>
                <div class="mt-6 text-lg leading-6 text-gray-400 ">
                    {{ get_tenant_setting('registration_text', 'Join the global community of likeminded people') }}
                </div>
                <div class="flex items-center mt-8 ">
                    <div class="flex flex-0 items-center -space-x-1.5 ">
                        @for($i = 0; $i < 4; $i++) <img
                            src="/images/male-09.jpeg"
                            class="flex-0 w-10 h-10 rounded-full ring-4 ring-offset-1 ring-gray-800 ring-offset-gray-800 object-cover ">
                            @endfor
                    </div>
                    <div class="ml-6 font-medium text-gray-400 ">
                        {{ translate('More than') }} {{ get_public_user_count() }}
                        {{ translate('people joined us, it\'s your turn') }}</div>
                </div>
            </div>
        </div>
        {{-- <img class="absolute inset-0 h-full w-full object-cover"
            src="https://images.unsplash.com/photo-1505904267569-f02eaeb45a4c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80"
            alt=""> --}}
    </div>
</div>
</div>
@endsection


@section('script')
@if(get_setting( 'google_recaptcha') == 1)
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif
@endsection
