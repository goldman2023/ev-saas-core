@extends('frontend.layouts.' . $globalLayout)

@section('content')
<section class="bg-gray-100 dark:bg-gray-900">
    <div class="container px-4 py-8 mx-auto lg:grid lg:gap-6 lg:py-16 lg:grid-cols-12">
        <div class="flex-col mb-8 justify-between hidden mr-auto lg:flex lg:col-span-5 xl:col-span-6 xl:mb-0">
            <div>
                <a href="/" class="inline-flex items-center mb-6 text-3xl font-semibold text-gray-900 lg:mb-10 dark:text-white">
                    {{-- <img class="w-12 h-12 mr-2" src="{{ get_site_logo() }}" alt="logo"> --}}
                    {{ translate('Welcome to,') }} {{ get_site_name() }} {{ translate('Self Service') }}
                </a>
                <div class="flex">


                    @svg('heroicon-o-adjustments-horizontal', ['class' => 'w-10 h-10 mr-2 text-gray-600 shrink-0'])

                    <div>
                        <h3 class="mb-2 text-xl font-bold leading-none text-gray-900 dark:text-white">
                            {{ translate('Create personalised orders') }}
                        </h3>
                        <p class="mb-2 font-light text-gray-500 dark:text-gray-400">
                            {{ translate('Connect with our team and get a best offer') }}
                        </p>
                    </div>
                </div>
                <div class="flex pt-8">
                    @svg('heroicon-o-document-text', ['class' => 'w-10 h-10 mr-2 text-gray-600 shrink-0'])

                    <div>
                        <h3 class="mb-2 text-xl font-bold leading-none text-gray-900 dark:text-white">
                            {{ translate('Download invoices and documents') }}
                        </h3>
                        <p class="mb-2 font-light text-gray-500 dark:text-gray-400">
                            {{ translate('See your payments information and necessary documents') }}
                        </p>
                    </div>
                </div>
                <div class="flex pt-8">
                    @svg('heroicon-o-bell-alert', ['class' => 'w-10 h-10 mr-2 text-gray-600 shrink-0'])

                    <div>
                        <h3 class="mb-2 text-xl font-bold leading-none text-gray-900 dark:text-white">
                            {{ translate('Track your order') }}
                        </h3>
                        <p class="mb-2 font-light text-gray-500 dark:text-gray-400">
                            {{ translate('Find all information about your orders. Get automatic status updates.') }}
                        </p>
                    </div>
                </div>
            </div>
            <nav>
                <ul class="flex space-x-4">
                    <li>
                        <a href="#" class="text-sm text-gray-500 hover:underline hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">About</a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-gray-500 hover:underline hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Term & Conditions</a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-gray-500 hover:underline hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Contact</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="mb-6 text-center lg:hidden">
            <a href="#" class="inline-flex items-center text-2xl font-semibold text-gray-900 lg:hidden dark:text-white">
                <img class="w-8 h-8 mr-2" src="{{ get_site_logo() }}" alt="logo">
                {{ get_site_name() }}
            </a>
        </div>
        <div class="w-full mx-auto bg-white rounded-lg shadow dark:bg-gray-800 md:mt-0 sm:max-w-lg xl:p-0 lg:col-span-7 xl:col-span-6">
            <div class="p-6 space-y-4 lg:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 sm:text-2xl dark:text-white">
                    {{ translate('Create an account') }}
                </h1>


                <livewire:forms.register-form :ghost-user="!empty($ghost_user ?? null) ? $ghost_user : null" />

            </div>
        </div>
    </div>
  </section>
@endsection
