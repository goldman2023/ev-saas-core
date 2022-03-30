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
                        <h1 class="text-sm font-semibold uppercase tracking-wide text-indigo-600">{{ translate('Thank
                            you!') }}</h1>
                        <p class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ translate('You have
                            succesfully joined') }} {{ get_site_name() }}
                            <span class="emoji ml-2">🎉</span>
                        </p>
                        <p class="mt-2 text-base text-gray-500">{{ translate('Your profile sucesfully created') }}</p>


                    </div>
                    <div class="grid grid-cols-2 gap-10">
                        <div class="">
                            <dl class="mt-12 mb-6 text-sm font-medium  ">
                                <dt class="text-gray-900">{{ translate('Personal Profile Preview') }}</dt>
                            </dl>
                            <div class="border-t border-gray-200">
                                <x-default.elements.support-card :user="auth()->user()"></x-default.elements.support-card>
                            </div>

                        </div>

                        <div class="">
                            <dl class="mt-12 mb-6 text-sm font-medium  ">
                                <dt class="text-gray-900">{{ translate('Seller Profile Preview') }}</dt>
                            </dl>
                            <div class="border-t border-gray-200">
                                <x-default.elements.support-card :user="auth()->user()"></x-default.elements.support-card>
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
