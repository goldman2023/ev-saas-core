@extends('frontend.layouts.app')

@section('content')
<div class="">

    <section class="relative bg-white overflow-hidden bg-gray-100" style="">

        <div class="relative py-20 pt-4 xl:pt-16 xl:pb-24">
            <div class="container px-4 mx-auto sm:pb-[40px] pb-0 bg-center-top sm:bg-center-bottom pt-32 sm:pt-0" style="background-image: url(https://www.webhuq.com/templates/collabs_team_collaboration_website_12145/assets/img/header-bootom-img.png);
            background-size: 90%;
            background-repeat: no-repeat;
            z-index: 0;">
                <div class="flex flex-wrap items-center">
                    <div class="w-full sm:w-1/2 mb-20 sm:mt-20 sm:mb-0 sm:pr-10">
                        <span
                            class="inline-block mb-4 text-xs leading-4 text-white bg-indigo-500 font-medium uppercase rounded-3xl p-4">
                            {{ translate('FoxAsk Community') }}
                        </span>
                        <h1
                            class="mb-6 text-4xl md:text-4xl lg:text-5xl leading-tight text-coolGray-900 font-bold tracking-tight">
                            {{ translate('Unlock your potential') }}
                        </h1>
                        <p class="mb-8 text-lg md:text-xl leading-7 text-coolGray-500 font-medium">
                            {{ translate(' With our platform, you can quantify your skills, grow in your role and stay
                            relevant on critical topics.') }}
                        </p>
                        <ul>
                            <li class="mb-6 flex items-center">
                                @svg('heroicon-o-check-circle', ['class' => 'text-green-400 h-6 h-6 mr-2'])
                                <p class="text-lg md:text-xl leading-7 text-coolGray-500 font-medium">

                                    {{ translate('Find and share best resources for knowledge') }}
                                </p>
                            </li>
                            <li class="mb-6 flex items-center">
                                @svg('heroicon-o-check-circle', ['class' => 'text-green-400 h-6 h-6 mr-2'])
                                <p class="text-lg md:text-xl leading-7 text-coolGray-500 font-medium">
                                    {{ translate('Get mentoring and consulting from FoxAsk Mentors') }}
                                </p>
                            </li>
                            <li class="flex items-center">
                                @svg('heroicon-o-check-circle', ['class' => 'text-green-400 h-6 h-6 mr-2'])
                                <p class="text-lg md:text-xl leading-7 text-coolGray-500 font-medium">
                                    {{ translate('Take part in online events and courses') }}
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="w-full sm:w-1/2 sm:mt-52">
                        <div
                            class="flex flex-col items-center p-10 xl:px-24 xl:pb-12 bg-white lg:max-w-xl lg:ml-auto rounded-4xl shadow-2xl">
                            <img class="bg-white p-4 relative -top-2 -mt-16 mb-6 h-16 rounded shadow"
                                src="{{ get_site_logo('dark') }}" alt="">
                            <h2 class="mb-4 text-xl md:text-3xl text-coolGray-900 font-bold text-center">
                                {{ translate('Join our community') }}
                            </h2>

                            <x-tailwind-ui.forms.login-form> </x-tailwind-ui.forms.login-form>
                            {{--
                            <a class="mb-4 inline-block py-3 px-7 w-full leading-6 text-blue-50 font-medium text-center bg-indigo-500 hover:bg-indigo-600 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 rounded-md"
                                href="{{ route('user.registration') }}">
                                {{ translate('Get Started') }}
                            </a>

                            <p class="text-sm text-coolGray-400 font-medium text-center">
                                <span>{{ translate('Already have an account?') }}</span>
                                <button class="text-indigo-500 hover:text-indigo-600"
                                    @click="$dispatch('display-flyout-panel', {'id': 'auth-panel'})">
                                    {{ translate('Sign In') }}
                                </button>
                            </p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-transparent overflow-hidden" style="">
        <div class="container px-4 mx-auto">
            <div class="md:max-w-4xl mb-16 md:mb-20">
                <span
                    class="inline-block py-px px-2 mb-4 text-xs leading-5 text-indigo-500 bg-blue-100 font-medium uppercase rounded-full shadow-sm">Features</span>
                <h1 class="mb-4 text-3xl md:text-4xl leading-tight font-bold tracking-tighter">
                    {{ translate('Why you should join') }} {{ get_site_name() }} {{ translate('platform?') }}

                </h1>
                <p class="text-lg md:text-xl text-coolGray-500 font-medium">
                    {{ translate(' You can become smarter and unlock your potential in any topic with best educational
                    material from our community members') }}
                </p>
            </div>
            <div class="flex flex-wrap lg:items-center -mx-4">
                <div class="w-full md:w-1/2 px-4 mb-8 md:mb-0">
                    <div
                        class="flex flex-wrap p-8 text-center md:text-left hover:bg-white rounded-md hover:shadow-xl transition duration-200">
                        <div class="w-full md:w-auto mb-6 md:mb-0 md:pr-6">
                            <div
                                class="inline-flex h-14 w-14 mx-auto items-center justify-center text-white bg-indigo-500 rounded-lg">
                                <svg width="21" height="21" viewbox="0 0 24 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17 18.63H5C4.20435 18.63 3.44129 18.3139 2.87868 17.7513C2.31607 17.1887 2 16.4257 2 15.63V7.63C2 7.36479 1.89464 7.11043 1.70711 6.9229C1.51957 6.73536 1.26522 6.63 1 6.63C0.734784 6.63 0.48043 6.73536 0.292893 6.9229C0.105357 7.11043 0 7.36479 0 7.63L0 15.63C0 16.9561 0.526784 18.2279 1.46447 19.1655C2.40215 20.1032 3.67392 20.63 5 20.63H17C17.2652 20.63 17.5196 20.5246 17.7071 20.3371C17.8946 20.1496 18 19.8952 18 19.63C18 19.3648 17.8946 19.1104 17.7071 18.9229C17.5196 18.7354 17.2652 18.63 17 18.63ZM21 0.630005H7C6.20435 0.630005 5.44129 0.946075 4.87868 1.50868C4.31607 2.07129 4 2.83436 4 3.63V13.63C4 14.4257 4.31607 15.1887 4.87868 15.7513C5.44129 16.3139 6.20435 16.63 7 16.63H21C21.7956 16.63 22.5587 16.3139 23.1213 15.7513C23.6839 15.1887 24 14.4257 24 13.63V3.63C24 2.83436 23.6839 2.07129 23.1213 1.50868C22.5587 0.946075 21.7956 0.630005 21 0.630005ZM20.59 2.63L14.71 8.51C14.617 8.60373 14.5064 8.67813 14.3846 8.7289C14.2627 8.77966 14.132 8.8058 14 8.8058C13.868 8.8058 13.7373 8.77966 13.6154 8.7289C13.4936 8.67813 13.383 8.60373 13.29 8.51L7.41 2.63H20.59ZM22 13.63C22 13.8952 21.8946 14.1496 21.7071 14.3371C21.5196 14.5246 21.2652 14.63 21 14.63H7C6.73478 14.63 6.48043 14.5246 6.29289 14.3371C6.10536 14.1496 6 13.8952 6 13.63V4L11.88 9.88C12.4425 10.4418 13.205 10.7574 14 10.7574C14.795 10.7574 15.5575 10.4418 16.12 9.88L22 4V13.63Z"
                                        fill="currentColor"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="w-full md:flex-1 md:pt-3">
                            <h3 class="mb-4 text-xl md:text-2xl leading-tight text-coolGray-900 font-bold">
                                {{ translate('Interactive real-time knowledge') }}
                            </h3>
                            <p class="text-coolGray-500 font-medium">
                                Explore interesting topic in your personal feed and connect with experts and mentors in
                                real time via FoxAsk messages and video calls
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex flex-wrap p-8 text-center md:text-left hover:bg-white rounded-md hover:shadow-xl transition duration-200">
                        <div class="w-full md:w-auto mb-6 md:mb-0 md:pr-6">
                            <div
                                class="inline-flex h-14 w-14 mx-auto items-center justify-center text-white bg-indigo-500 rounded-lg">
                                <svg width="21" height="21" viewbox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 18H9.24C9.37161 18.0008 9.50207 17.9755 9.62391 17.9258C9.74574 17.876 9.85656 17.8027 9.95 17.71L16.87 10.78L19.71 8C19.8037 7.90704 19.8781 7.79644 19.9289 7.67458C19.9797 7.55272 20.0058 7.42201 20.0058 7.29C20.0058 7.15799 19.9797 7.02728 19.9289 6.90542C19.8781 6.78356 19.8037 6.67296 19.71 6.58L15.47 2.29C15.377 2.19627 15.2664 2.12188 15.1446 2.07111C15.0227 2.02034 14.892 1.9942 14.76 1.9942C14.628 1.9942 14.4973 2.02034 14.3754 2.07111C14.2536 2.12188 14.143 2.19627 14.05 2.29L11.23 5.12L4.29 12.05C4.19732 12.1434 4.12399 12.2543 4.07423 12.3761C4.02446 12.4979 3.99924 12.6284 4 12.76V17C4 17.2652 4.10536 17.5196 4.29289 17.7071C4.48043 17.8946 4.73478 18 5 18ZM14.76 4.41L17.59 7.24L16.17 8.66L13.34 5.83L14.76 4.41ZM6 13.17L11.93 7.24L14.76 10.07L8.83 16H6V13.17ZM21 20H3C2.73478 20 2.48043 20.1054 2.29289 20.2929C2.10536 20.4804 2 20.7348 2 21C2 21.2652 2.10536 21.5196 2.29289 21.7071C2.48043 21.8946 2.73478 22 3 22H21C21.2652 22 21.5196 21.8946 21.7071 21.7071C21.8946 21.5196 22 21.2652 22 21C22 20.7348 21.8946 20.4804 21.7071 20.2929C21.5196 20.1054 21.2652 20 21 20Z"
                                        fill="currentColor"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="w-full md:flex-1 md:pt-3">
                            <h3 class="mb-4 text-xl md:text-2xl leading-tight text-coolGray-900 font-bold">Become a
                                mentor</h3>
                            <p class="text-coolGray-500 font-medium">Add your services, courses and consultations to
                                your FoxAsk profile. Upgrade to FoxAsk PRO to Build your website for taking your
                                personal brand to the next level</p>
                        </div>
                    </div>
                    <div
                        class="flex flex-wrap p-8 text-center md:text-left hover:bg-white rounded-md hover:shadow-xl transition duration-200">
                        <div class="w-full md:w-auto mb-6 md:mb-0 md:pr-6">
                            <div
                                class="inline-flex h-14 w-14 mx-auto items-center justify-center text-white bg-indigo-500 rounded-lg">
                                <svg width="21" height="21" viewbox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10 13H3C2.73478 13 2.48043 13.1054 2.29289 13.2929C2.10536 13.4804 2 13.7348 2 14V21C2 21.2652 2.10536 21.5196 2.29289 21.7071C2.48043 21.8946 2.73478 22 3 22H10C10.2652 22 10.5196 21.8946 10.7071 21.7071C10.8946 21.5196 11 21.2652 11 21V14C11 13.7348 10.8946 13.4804 10.7071 13.2929C10.5196 13.1054 10.2652 13 10 13ZM9 20H4V15H9V20ZM21 2H14C13.7348 2 13.4804 2.10536 13.2929 2.29289C13.1054 2.48043 13 2.73478 13 3V10C13 10.2652 13.1054 10.5196 13.2929 10.7071C13.4804 10.8946 13.7348 11 14 11H21C21.2652 11 21.5196 10.8946 21.7071 10.7071C21.8946 10.5196 22 10.2652 22 10V3C22 2.73478 21.8946 2.48043 21.7071 2.29289C21.5196 2.10536 21.2652 2 21 2V2ZM20 9H15V4H20V9ZM21 13H14C13.7348 13 13.4804 13.1054 13.2929 13.2929C13.1054 13.4804 13 13.7348 13 14V21C13 21.2652 13.1054 21.5196 13.2929 21.7071C13.4804 21.8946 13.7348 22 14 22H21C21.2652 22 21.5196 21.8946 21.7071 21.7071C21.8946 21.5196 22 21.2652 22 21V14C22 13.7348 21.8946 13.4804 21.7071 13.2929C21.5196 13.1054 21.2652 13 21 13ZM20 20H15V15H20V20ZM10 2H3C2.73478 2 2.48043 2.10536 2.29289 2.29289C2.10536 2.48043 2 2.73478 2 3V10C2 10.2652 2.10536 10.5196 2.29289 10.7071C2.48043 10.8946 2.73478 11 3 11H10C10.2652 11 10.5196 10.8946 10.7071 10.7071C10.8946 10.5196 11 10.2652 11 10V3C11 2.73478 10.8946 2.48043 10.7071 2.29289C10.5196 2.10536 10.2652 2 10 2V2ZM9 9H4V4H9V9Z"
                                        fill="currentColor"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="w-full md:flex-1 md:pt-3">
                            <h3 class="mb-4 text-xl md:text-2xl leading-tight text-coolGray-900 font-bold">Video lessons
                                and Livestreams</h3>
                            <p class="text-coolGray-500 font-medium">The first business platform to bring together all
                                of your products from one place.</p>
                        </div>


                    </div>
                    <div class="text-center">

                        <a class="bg-indigo-600  text-white inline-flex items-center justify-center px-7 py-3 h-14 w-full md:w-auto mb-2 md:mb-0 md:mr-4 md:w-auto text-lg leading-7 text-coolGray-800 bg-white hover:bg-coolGray-100 font-medium focus:ring-2 focus:ring-coolGray-200 focus:ring-opacity-50 border border-coolGray-200 border border-coolGray-100 rounded-md shadow-sm"
                            href="/page/business">
                            {{ translate('Explore') }} {{ get_site_name() }} {{ translate('Business')}}
                        </a>
                    </div>
                </div>
                <div class="w-full md:w-1/2 px-4">
                    <div class="relative mx-auto md:mr-0 max-w-max">
                        <img class="absolute z-10 -left-8 -top-8 w-28 md:w-auto text-yellow-400"
                            src="flex-ui-assets/elements/circle3-violet.svg" alt="">
                        <img class="absolute z-10 -right-7 -bottom-8 w-28 md:w-auto text-indigo-500"
                            src="flex-ui-assets/elements/dots3-red.svg" alt="">
                        <img src="https://www.webhuq.com/templates/collabs_team_collaboration_website_12145/assets/img/feature-img1.png"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white overflow-hidden"
        style="background-image: url('flex-ui-assets/elements/pattern-white.svg'); background-position: center;">
        <div class="container px-4 mx-auto">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/2 px-4 mb-20 lg:mb-0">
                    <div class="max-w-md mx-auto">
                        <h2 class="mb-8 text-4xl md:text-5xl font-heading font-bold text-coolGray-900 md:leading-15">
                            Join people from all over the world</h2>
                        <ul class="mb-8">
                            <li class="flex items-center mb-4">
                                <img class="mr-3" src="flex-ui-assets/elements/cta/checkbox-blue.svg" alt="">
                                <span class="text-lg md:text-xl font-heading text-coolGray-500">Share knowlege</span>
                            </li>
                            <li class="flex items-center mb-4">
                                <img class="mr-3" src="flex-ui-assets/elements/cta/checkbox-blue.svg" alt="">
                                <span class="text-lg md:text-xl font-heading text-coolGray-500">Learn via FoxAsk
                                    platform</span>
                            </li>
                            <li class="flex items-center">
                                <img class="mr-3" src="flex-ui-assets/elements/cta/checkbox-blue.svg" alt="">
                                <span class="text-lg md:text-xl font-heading text-coolGray-500">
                                    Connect with likeminded people about any topic</span>
                            </li>
                        </ul>
                        <div class="flex flex-wrap items-center">
                            <a class="inline-flex items-center justify-center px-7 py-3 h-14 w-full md:w-auto mb-2 md:mb-0 md:mr-4 md:w-auto text-lg leading-7 text-coolGray-800 bg-white hover:bg-coolGray-100 font-medium focus:ring-2 focus:ring-coolGray-200 focus:ring-opacity-50 border border-coolGray-200 border border-coolGray-100 rounded-md shadow-sm"
                                href="/page/business">
                                {{ translate('Become a mentor') }}
                            </a>

                            <a class="inline-flex items-center justify-center px-7 py-3 h-14 w-full md:w-auto text-lg leading-7 text-blue-50 bg-indigo-500 hover:bg-indigo-600 font-medium focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 border border-transparent rounded-md shadow-sm"
                                href="{{ route('user.registration') }}">
                                {{ translate('Join') }} {{ get_site_name()
                                }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2 px-4">
                    <div class="relative max-w-max mx-auto">
                        <img class="absolute top-0 right-0 -mt-6 lg:-mt-12 -mr-6 lg:-mr-12 w-20 lg:w-auto z-10"
                            src="flex-ui-assets/elements/circle3-violet.svg" alt="">
                        <img class="absolute bottom-0 left-0 -mb-6 lg:-mb-10-ml-6 lg:-ml-12 w-20 lg:w-auto"
                            src="flex-ui-assets/elements/dots3-red.svg" alt="">
                        <img class="relative" src="images/feature-image.jpeg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>
</section>


@endsection
