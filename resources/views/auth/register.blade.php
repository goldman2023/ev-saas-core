@extends('frontend.layouts.' . $globalLayout)

@section('content')
<div class="bg-gray-100 pt-10 pb-10">
    <div
        class="min-h-full flex md:w-full md:max-w-6xl sm:rounded-2xl sm:shadow sm:bg-card mx-auto bg-white">
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <x-tenant.system.image alt="{{ get_site_name() }} logo" class="h-12 w-auto"
                        :image="get_site_logo()">
                    </x-tenant.system.image>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">{{ translate('Sign up') }}</h2>
                    <p class=" mt-2 text-sm text-gray-600">
                        {{ translate('Or') }}
                        <a href="{{ route('user.login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            {{ translate('Already a member? Sign In') }} </a>
                    </p>
                </div>

                <div class="mt-3">
                    <livewire:forms.register-form :ghost-user="!empty($ghost_user ?? null) ? $ghost_user : null" />
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
                @include('auth.benefits.login-benefits')

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
