@extends('frontend.layouts.app')

@section('content')
<div class="">

    <section class="relative bg-white overflow-hidden" style="">
        <div class="bg-transparent">


        </div>
        <div class="relative py-20 xl:pt-16 xl:pb-24">
            <div class="container px-4 mx-auto" style="background-image: url(https://www.webhuq.com/templates/collabs_team_collaboration_website_12145/assets/img/header-bootom-img.png);
            background-position: bottom center;
            background-size: 90%;
            background-repeat: no-repeat;
            padding-bottom: 250px;
            margin-bottom: -100px;
            z-index: 0;">
                <div class="flex flex-wrap items-center">
                    <div class="w-full lg:w-1/2 mb-20 lg:mb-0 pr-10">
                        <span
                            class="inline-block mb-4 text-xs leading-4 text-white bg-blue-500 font-medium uppercase rounded-3xl p-4">
                            {{ translate('FoxAsk Community') }}
                        </span>
                        <h1
                            class="mb-6 text-2xl md:text-4xl lg:text-5xl leading-tight text-coolGray-900 font-bold tracking-tight">
                            Unlock your potential
                        </h1>
                        <p class="mb-8 text-lg md:text-xl leading-7 text-coolGray-500 font-medium">
                            With our platform,
                            you can quantify your skills, grow in your role and stay relevant on critical topics.</p>
                        <ul>
                            <li class="mb-6 flex items-center">
                                <img class="mr-3" src="flex-ui-assets/elements/checkbox-green.svg">
                                <p class="text-lg md:text-xl leading-7 text-coolGray-500 font-medium">Find and share
                                    best resources for knowledge</p>
                            </li>
                            <li class="mb-6 flex items-center">
                                <img class="mr-3" src="flex-ui-assets/elements/checkbox-green.svg">
                                <p class="text-lg md:text-xl leading-7 text-coolGray-500 font-medium">Get mentoring and
                                    consulting from FoxAsk Mentors</p>
                            </li>
                            <li class="flex items-center">
                                <img class="mr-3" src="flex-ui-assets/elements/checkbox-green.svg">
                                <p class="text-lg md:text-xl leading-7 text-coolGray-500 font-medium">Take part in
                                    online events and courses</p>
                            </li>
                        </ul>
                    </div>
                    <div class="w-full lg:w-1/2">
                        <div
                            class="flex flex-col items-center p-10 xl:px-24 xl:pb-12 bg-white lg:max-w-xl lg:ml-auto rounded-4xl shadow-2xl">
                            <img class="relative -top-2 -mt-16 mb-6 h-16"
                                src="images/1638973485-Screenshot-2021-10-18-at-14-37-53-3.webp" alt="">
                            <h2 class="mb-4 text-xl md:text-3xl text-coolGray-900 font-bold text-center">Join our
                                community</h2>
                            <h3 class="mb-7 text-base md:text-lg text-coolGray-500 font-medium text-center">Free to join
                            </h3>




                            <a class="mb-4 w-full text-coolGray-500 hover:text-coolGray-600 font-medium text-center border border-coolGray-200 hover:border-coolGray-300 rounded-md shadow-sm"
                                href="#">
                                <div class="flex items-center justify-center py-3 px-3 leading-5">
                                    <svg class="mr-3" width="24" height="24" viewbox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M22.6025 10.0039C22.5608 9.77329 22.4395 9.56462 22.2597 9.41434C22.0799 9.26405 21.853 9.18169 21.6186 9.18164H12.2002C12.0689 9.1816 11.9388 9.20745 11.8175 9.25769C11.6962 9.30793 11.5859 9.38159 11.493 9.47446C11.4002 9.56732 11.3265 9.67757 11.2763 9.79891C11.226 9.92026 11.2002 10.0503 11.2002 10.1816V14.0498C11.2002 14.1811 11.226 14.3112 11.2763 14.4325C11.3265 14.5539 11.4002 14.6641 11.493 14.757C11.5859 14.8498 11.6962 14.9235 11.8175 14.9737C11.9388 15.024 12.0689 15.0498 12.2002 15.0498H16.1626C15.8803 15.5264 15.4932 15.9324 15.0308 16.2373C14.1856 16.7731 13.2006 17.0464 12.2002 17.0225C11.1627 17.0106 10.1553 16.672 9.3212 16.0549C8.4871 15.4377 7.86873 14.5734 7.55398 13.5847L7.55369 13.583C7.20342 12.5564 7.20342 11.4426 7.55369 10.416L7.55393 10.4143C7.86891 9.42585 8.48736 8.56175 9.32145 7.94479C10.1555 7.32782 11.1628 6.98938 12.2002 6.97754C12.7766 6.96431 13.35 7.06508 13.8873 7.27406C14.4247 7.48304 14.9155 7.79612 15.3315 8.19531C15.5205 8.37587 15.7726 8.47533 16.0339 8.47241C16.2953 8.46949 16.5451 8.36443 16.73 8.17969L19.5981 5.31152C19.6931 5.21662 19.7681 5.10354 19.8184 4.97904C19.8687 4.85454 19.8935 4.72116 19.8911 4.58689C19.8887 4.45262 19.8593 4.3202 19.8046 4.19755C19.7499 4.0749 19.671 3.96453 19.5727 3.87305C17.5769 2.00175 14.936 0.97261 12.2002 0.999999C10.1602 0.993963 8.15897 1.55801 6.42235 2.62854C4.68572 3.69906 3.28272 5.23349 2.37156 7.05878L2.37009 7.06055C1.59761 8.59231 1.19683 10.2845 1.20022 12C1.20265 13.7148 1.60313 15.4057 2.37014 16.9394L2.37161 16.9412C3.28276 18.7665 4.68576 20.3009 6.42237 21.3714C8.15899 22.442 10.1602 23.006 12.2002 23C14.8856 23.068 17.4953 22.1067 19.4949 20.313L19.4956 20.3125L19.4964 20.3117L19.4966 20.3115L19.4967 20.3114C20.5805 19.2688 21.4343 18.011 22.0032 16.6188C22.5722 15.2266 22.8437 13.7309 22.8003 12.2275C22.8008 11.4819 22.7346 10.7378 22.6025 10.0039ZM12.2002 3C14.0713 2.98179 15.8982 3.56854 17.4087 4.67285L15.955 6.126C14.8528 5.36305 13.5406 4.96171 12.2002 4.97754C10.9764 4.98383 9.77645 5.31613 8.72375 5.94022C7.67105 6.56432 6.80368 7.45767 6.21091 8.52832L5.1417 7.69958L4.5567 7.24591C5.36147 5.94375 6.48668 4.8697 7.82486 4.12636C9.16303 3.38301 10.6695 2.99521 12.2002 3ZM3.67966 14.9033C3.04034 13.0206 3.04034 10.9794 3.67966 9.09668L5.46189 10.4785C5.23402 11.4797 5.23402 12.5193 5.46189 13.5205L3.67966 14.9033ZM12.2002 21C10.6694 21.0048 9.16298 20.6169 7.8248 19.8736C6.48661 19.1302 5.36139 18.0561 4.55662 16.7539L4.93503 16.4604L6.21091 15.4707C6.80341 16.5416 7.6707 17.4353 8.72344 18.0596C9.77618 18.6839 10.9763 19.0162 12.2002 19.0225C13.3459 19.0359 14.4785 18.7787 15.5059 18.2717L17.1976 19.585C15.7098 20.5436 13.9697 21.0363 12.2002 21ZM18.7261 18.2393L18.5431 18.0973L17.1657 17.028C17.8879 16.2477 18.3734 15.2782 18.5654 14.2325C18.5923 14.0881 18.587 13.9396 18.55 13.7976C18.5129 13.6555 18.4451 13.5233 18.3512 13.4104C18.2573 13.2975 18.1397 13.2067 18.0068 13.1444C17.8739 13.0821 17.7288 13.0498 17.582 13.0498H13.2002V11.1816H20.749C20.7832 11.5273 20.8003 11.8769 20.8003 12.2275C20.8588 14.4164 20.1218 16.5522 18.726 18.2393H18.7261Z"
                                            fill="black"></path>
                                    </svg>
                                    <span>Sign in with Google</span>
                                </div>
                            </a>
                            <a class="mb-4 w-full text-coolGray-500 hover:text-coolGray-600 font-medium text-center border border-coolGray-200 hover:border-coolGray-300 rounded-md shadow-sm"
                                href="#">
                                <div class="flex items-center justify-center py-3 px-3 leading-5">
                                    <svg class="mr-3" width="24" height="24" viewbox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20.9 2H3.1C2.80826 2 2.52847 2.11589 2.32218 2.32218C2.11589 2.52847 2 2.80826 2 3.1V20.9C2 21.0445 2.02845 21.1875 2.08373 21.321C2.13901 21.4544 2.22004 21.5757 2.32218 21.6778C2.42433 21.78 2.54559 21.861 2.67905 21.9163C2.81251 21.9715 2.95555 22 3.1 22H12.68V14.25H10.08V11.25H12.68V9C12.6261 8.47176 12.6885 7.93813 12.8627 7.43654C13.0369 6.93495 13.3188 6.47755 13.6885 6.09641C14.0582 5.71528 14.5068 5.41964 15.0028 5.23024C15.4989 5.04083 16.0304 4.96225 16.56 5C17.3383 4.99521 18.1163 5.03528 18.89 5.12V7.82H17.3C16.04 7.82 15.8 8.42 15.8 9.29V11.22H18.8L18.41 14.22H15.8V22H20.9C21.0445 22 21.1875 21.9715 21.321 21.9163C21.4544 21.861 21.5757 21.78 21.6778 21.6778C21.78 21.5757 21.861 21.4544 21.9163 21.321C21.9715 21.1875 22 21.0445 22 20.9V3.1C22 2.95555 21.9715 2.81251 21.9163 2.67905C21.861 2.54559 21.78 2.42433 21.6778 2.32218C21.5757 2.22004 21.4544 2.13901 21.321 2.08373C21.1875 2.02845 21.0445 2 20.9 2Z"
                                            fill="#1877F2"></path>
                                    </svg>
                                    <span>Sign in with Facebook</span>
                                </div>
                            </a>
                            <div class="flex items-center mb-4 w-full text-xs text-coolGray-400">
                                <div class="flex-1 h-px bg-coolGray-100"></div>
                                <span class="px-2 font-medium">OR</span>
                                <div class="flex-1 h-px w-24 bg-coolGray-100"></div>
                            </div>

                            <label class="hidden mb-4 flex flex-col w-full">
                                <span class="mb-1 text-coolGray-800 font-medium">Email</span>
                                <input
                                    class="py-3 px-3 leading-5 w-full text-coolGray-400 font-normal border border-coolGray-200 outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-lg shadow-sm"
                                    type="text" placeholder="Enter your email address">
                            </label>
                            <a class="mb-4 inline-block py-3 px-7 w-full leading-6 text-blue-50 font-medium text-center bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md"
                                href="{{ route('user.registration') }}">
                                {{ translate('Get Started') }}
                            </a>

                            <p class="text-sm text-coolGray-400 font-medium text-center">
                                <span>{{ translate('Already have an account?') }}</span>
                                <button class="text-blue-500 hover:text-blue-600"
                                    @click="$dispatch('display-flyout-panel', {'id': 'auth-panel'})">
                                    {{ translate('Sign In') }}
                                </button>
                            </p>
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
                    class="inline-block py-px px-2 mb-4 text-xs leading-5 text-blue-500 bg-blue-100 font-medium uppercase rounded-full shadow-sm">Features</span>
                <h1 class="mb-4 text-3xl md:text-4xl leading-tight font-bold tracking-tighter">Why you should join
                    FoxAsk social network?</h1>
                <p class="text-lg md:text-xl text-coolGray-500 font-medium">With FoxAsk you can become smarter and
                    unlock your potential in any topic with best educational material from our community members</p>
            </div>
            <div class="flex flex-wrap lg:items-center -mx-4">
                <div class="w-full md:w-1/2 px-4 mb-8 md:mb-0">
                    <div
                        class="flex flex-wrap p-8 text-center md:text-left hover:bg-white rounded-md hover:shadow-xl transition duration-200">
                        <div class="w-full md:w-auto mb-6 md:mb-0 md:pr-6">
                            <div
                                class="inline-flex h-14 w-14 mx-auto items-center justify-center text-white bg-blue-500 rounded-lg">
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
                                Interactive real-time knowledge</h3>
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
                                class="inline-flex h-14 w-14 mx-auto items-center justify-center text-white bg-blue-500 rounded-lg">
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
                                class="inline-flex h-14 w-14 mx-auto items-center justify-center text-white bg-blue-500 rounded-lg">
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
                </div>
                <div class="w-full md:w-1/2 px-4">
                    <div class="relative mx-auto md:mr-0 max-w-max">
                        <img class="absolute z-10 -left-8 -top-8 w-28 md:w-auto text-yellow-400"
                            src="flex-ui-assets/elements/circle3-violet.svg" alt="">
                        <img class="absolute z-10 -right-7 -bottom-8 w-28 md:w-auto text-blue-500"
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
                                href="{{ route('user.registration') }}">
                                {{ translate('Become a mentor') }}
                            </a>

                            <a class="inline-flex items-center justify-center px-7 py-3 h-14 w-full md:w-auto text-lg leading-7 text-blue-50 bg-blue-500 hover:bg-blue-600 font-medium focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 border border-transparent rounded-md shadow-sm"
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
