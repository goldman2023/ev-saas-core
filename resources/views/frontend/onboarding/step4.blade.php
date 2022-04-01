@extends('frontend.layouts.' . $globalLayout)

@section('content')
<div class="col-span-3 bg-gray-100 p-3">
    <div class="container">
        <livewire:onboarding.elements.steps-progress current_step="4">
        </livewire:onboarding.elements.steps-progress>
    </div>

</div>
<section class="container py-10">
    <!-- Features Section -->
    <div class="grid grid-cols-3 space-2 gap-10">

        <div class="col-span-2">
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="bg-white">
                <div class="max-w-3xl mx-auto">
                    <div class="max-w-xl">
                        <h1 class="text-sm font-semibold uppercase tracking-wide text-indigo-600">
                            {{ translate('Thank you!') }}</h1>
                        <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('You have
                            succesfully joined') }} {{ get_site_name() }}
                            <span class="emoji ml-2">🎉</span>
                        </p>
                        <p class="mt-6 text-base text-gray-500">{{ translate('Your profile sucesfully created') }}</p>


                    </div>
                    <div class="grid grid-cols-2 gap-10">
                        <div class="">
                            <dl class="mt-12 mb-6 text-sm font-medium  ">
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
                            <!-- This example requires Tailwind CSS v2.0+ -->
                            <div class="max-w-lg mx-auto mt-12">
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ translate('Get started on ') }} {{ get_site_name() }}
                                </h2>
                                <p class="mt-0 text-sm text-gray-500">
                                    {{ translate('Explore our features and social feed') }}
                                </p>
                                <ul role="list" class="mt-6 border-t border-b border-gray-200 divide-y divide-gray-200">
                                    <li>
                                        <div class="relative group py-4 flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <span
                                                    class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-pink-500">
                                                    <!-- Heroicon name: outline/speakerphone -->
                                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-medium text-gray-900">
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
                                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="{{ route('onboarding.step3') }}">
                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                        {{ translate('Create a Shop') }}
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

                                    <li>
                                        <div class="relative group py-4 flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <span
                                                    class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-yellow-500">
                                                    <!-- Heroicon name: outline/calendar -->
                                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
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


                        </div>

                    </div>
                    <div class="mt-5 hidden">

                        <h2 class="sr-only">{{ translate('Your profile')}}</h2>

                        <h3 class="sr-only">Items</h3>

                        <div class="py-10 border-b border-gray-200 flex space-x-6">
                            <img src="{{  auth()->user()->getThumbnail() }}"
                                alt="Glass bottle with black plastic pour top and mesh insert."
                                class="flex-none w-20 h-20 object-center object-cover bg-gray-100 rounded-lg sm:w-40 sm:h-40">
                            <div class="flex-auto flex flex-col">
                                <div>
                                    <h4 class="font-medium text-gray-900">
                                        <a href="#"> {{ auth()->user()->name }} </a>
                                    </h4>
                                    <p class="mt-2 text-sm text-gray-600">This glass bottle comes with a mesh insert for
                                        steeping tea or cold-brewing coffee. Pour from any angle and remove the top for
                                        easy cleaning.</p>
                                </div>
                                <div class="mt-6 flex-1 flex items-end">
                                    <dl class="flex text-sm divide-x divide-gray-200 space-x-4 sm:space-x-6">
                                        <div class="flex">
                                            <dt class="font-medium text-gray-900">{{ translate('Followers') }}</dt>
                                            <dd class="ml-2 text-gray-700">1</dd>
                                        </div>
                                        <div class="pl-4 flex sm:pl-6">
                                            <dt class="font-medium text-gray-900">Price</dt>
                                            <dd class="ml-2 text-gray-700">$32.00</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>


        </div>

        <div class="col-span-1">

            <x-default.elements.support-card></x-default.elements.support-card>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
