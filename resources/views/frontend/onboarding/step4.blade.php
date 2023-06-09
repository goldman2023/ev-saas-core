@extends('frontend.layouts.' . $globalLayout)

@section('content')
<div class="col-span-3 bg-gray-100 p-3">
    <div class="container">
        <livewire:onboarding.elements.steps-progress current_step="4">
        </livewire:onboarding.elements.steps-progress>
    </div>

</div>
<section class="container py-10">
    <div class="grid grid-cols-1 md:grid-cols-3 space-2 gap-10">

        <div class="col-span-1 md:col-span-2">
            <div class="bg-white">
                <div class="max-w-3xl mx-auto">
                    <div class="max-w-2xl">
                        <h1 class="text-sm font-semibold uppercase tracking-wide text-indigo-600">
                            {{ translate('Thank you!') }}</h1>
                        <p class="mt-2 text-4xl font-extrabold sm:text-4xl">
                            {{ auth()->user()->name}},
                            {{ translate('congratulations for joining ') }} {{ get_site_name() }} {{ translate('community') }}
                            <span class="emoji ml-2">🦊 👋 💙</span>
                        </p>
                        <p class="mt-6 text-base text-gray-500">{{ translate('Your profile sucesfully created') }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="">
                            <dl class="mt-6 md:mt-12 mb-6 text-sm font-medium">
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ translate('Personal Profile Preview') }}
                                </h2>
                                <p class="x">
                                    {{ translate('This is how your profile will be shown') }}

                                </p>
                            </dl>
                            <div class="border-t border-gray-200">
                                <x-default.elements.user-card :user="auth()->user()"></x-default.elements.user-card>
                            </div>
                            <div class='mt-3 text-sm text-gray-500'>
                                <a href="{{ auth()->user()->getPermalink() }}">
                                  <span class="emoji mr-1">🌎</span>  {{ translate('View your public profile page') }}
                                </a>
                            </div>


                        </div>

                        <div class="">



                        </div>

                    </div>

                </div>
            </div>


        </div>

        <div class="col-span-1 md:col-span-1 mb-1 h-[450px] md:h-auto">
            <div class="max-w-full md:max-w-lg mx-auto mt-0 md:mt-0">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ translate('Get started on ') }} {{ get_site_name() }}
                </h2>
                <p class="mt-0 text-sm text-gray-500">
                    {{ translate('Explore our features and social feed') }}
                </p>
                <ul role="list" class="mt-6 border-t border-b border-gray-200 divide-y divide-gray-200">
                    <li class="hidden">
                        <div class="relative group py-4 flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-sky-500">
                                    @svg('heroicon-o-view-grid', ['class' => 'h-6 w-6 text-white'])
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('dashboard') }}">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ translate('Go to Dashboard') }}
                                    </a>
                                </div>
                                <p class="text-sm text-gray-500">
                                    {{ translate('Manage and set up your account') }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 self-center">
                                <!-- Heroicon name: solid/chevron-right -->
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="relative group py-4 flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-pink-500">
                                    <!-- Heroicon name: outline/speakerphone -->
                                    @svg('heroicon-o-speakerphone', ['class' => 'h-6 w-6 text-white'])
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-md font-medium text-gray-900">
                                    <a href="{{ route('feed.index') }}">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ translate('Explore Feed') }}
                                    </a>
                                </div>
                                <p class="text-sm text-gray-500">
                                    {{ translate('Explore our social knowledge feed') }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 self-center">
                                <!-- Heroicon name: solid/chevron-right -->
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="relative group py-4 flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-purple-500">
                                    <!-- Heroicon name: outline/terminal -->
                                    @svg('heroicon-o-terminal', ['class' => 'h-6 w-6 text-white'])
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-md font-medium text-gray-900">
                                    <a href="{{ route('onboarding.step3') }}">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ translate('Create a Shop/Become a Seller') }}
                                    </a>
                                </div>
                                <p class="text-sm text-gray-500">
                                    {{ translate('Add services and products so you can share your
                                    knowledge and earn') }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 self-center">
                                <!-- Heroicon name: solid/chevron-right -->
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </li>

                    <li class="hidden">
                        <div class="relative group py-4 flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-yellow-500">
                                    <!-- Heroicon name: outline/calendar -->
                                    @svg('heroicon-o-calendar', ['class' => 'h-6 w-6 text-white'])
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('feed.products') }}">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ translate('Events and Courses') }}
                                    </a>
                                </div>
                                <p class="text-sm text-gray-500">
                                    {{ translate('Explore events and courses from FoxAsk community') }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 self-center">
                                <!-- Heroicon name: solid/chevron-right -->
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            {{-- Interested in --}}
            {{-- <livewire:onboarding.elements.categories-of-interest /> --}}

            {{-- END Interested in --}}
            {{-- <x-default.elements.support-card></x-default.elements.support-card> --}}
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
