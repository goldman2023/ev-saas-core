<div class="bg-gray-100">

    <section class="dark:bg-gray-900 container" style="box-sizing: border-box;">
        <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6" style="box-sizing: border-box;">
            <div class="px-4 mx-auto max-w-screen-sm text-center lg:px-6 mb-8 lg:mb-16" style="box-sizing: border-box;">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white"
                    style="box-sizing: border-box;">{{ translate('Contact Us') }}</h2>
                <p class="font-light text-gray-600 dark:text-gray-400 sm:text-xl" style="box-sizing: border-box;">
                    {{ translate('Have questions? We will respond to you with pleasure') }}
                </p>
            </div>
            <div class="grid grid-cols-1 lg:gap-8 lg:grid-cols-3" style="box-sizing: border-box;">
                <div class="col-span-2 mb-8 lg:mb-0" style="box-sizing: border-box;">
                    <livewire:forms.contact-form />
                </div>
                <div class="grid grid-cols-1 col-span-1 gap-8 text-center sm:grid-cols-2 lg:grid-cols-1"
                    style="box-sizing: border-box;">
                    <div id="iivtg" style="box-sizing: border-box;">
                        <div class="flex justify-center items-center mx-auto mb-4 w-10 h-10 bg-gray-100 rounded-lg dark:bg-gray-800 lg:h-16 lg:w-16"
                            style="box-sizing: border-box;"><svg fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-gray-600 lg:w-8 lg:h-8 dark:text-gray-500"
                                style="box-sizing: border-box;">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" style="box-sizing: border-box;"></path>
                            </svg></div>
                        <p class="mb-2 text-xl font-bold text-gray-900 dark:text-white" style="box-sizing: border-box;">
                            Address:</p>
                        <p class="text-gray-500 dark:text-gray-400" style="box-sizing: border-box;">
                            {{ translate('Kaunas') }}, {{ translate('Lithuania') }} <br>
                            States 1941 Late Avenue
                        </p>
                    </div>
                    <div style="box-sizing: border-box;">
                        <div class="flex justify-center items-center mx-auto mb-4 w-10 h-10 bg-gray-100 rounded-lg dark:bg-gray-800 lg:h-16 lg:w-16"
                            style="box-sizing: border-box;"><svg fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-gray-600 lg:w-8 lg:h-8 dark:text-gray-500"
                                style="box-sizing: border-box;">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                    clip-rule="evenodd" style="box-sizing: border-box;"></path>
                            </svg></div>
                        <p class="mb-2 text-xl font-bold text-gray-900 dark:text-white" style="box-sizing: border-box;">
                            {{ translate('Business Details') }}
                        </p>
                        <p class="text-gray-500 dark:text-gray-400" style="box-sizing: border-box;">
                            {{ get_site_name() }}
                            <br style="box-sizing: border-box;">Tax id: USXXXXXX
                        </p>
                    </div>
                    <div style="box-sizing: border-box;">
                        <div class="flex justify-center items-center mx-auto mb-4 w-10 h-10 bg-gray-100 rounded-lg dark:bg-gray-800 lg:h-16 lg:w-16"
                            style="box-sizing: border-box;"><svg fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-gray-600 lg:w-8 lg:h-8 dark:text-gray-500"
                                style="box-sizing: border-box;">
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"
                                    style="box-sizing: border-box;"></path>
                            </svg></div>
                        <p class="mb-2 text-xl font-bold text-gray-900 dark:text-white" style="box-sizing: border-box;">
                            Call
                            us:</p>
                        <p class="mb-3 text-gray-500 dark:text-gray-400" style="box-sizing: border-box;">Call us to
                            speak to
                            a member of our team. We are always happy to help.</p>
                        <p class="font-semibold text-primary-600 dark:text-primary-500" style="box-sizing: border-box;">
                            +1
                            (646) 786-5060</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
