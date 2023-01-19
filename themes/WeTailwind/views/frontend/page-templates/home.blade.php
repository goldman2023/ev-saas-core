<div class="relative overflow-hidden">
    <div aria-hidden="true" class="absolute inset-y-0 h-full w-full">
        <div class="relative h-full"><svg width="404" height="784" fill="none" viewBox="0 0 404 784"
                class="absolute right-full transform translate-y-1-3 translate-x-1-4 md:translate-y-1-2 sm:translate-x-1-2 lg:translate-x-full">
                <defs>
                    <pattern id="e229dbec-10e9-49ee-8ec3-0286ca089edf" x="0" y="0" width="20" height="20"
                        patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" fill="currentColor" class="text-gray-200"></rect>
                    </pattern>
                </defs>
                <rect width="404" height="784" fill="url(#e229dbec-10e9-49ee-8ec3-0286ca089edf)"></rect>
            </svg><svg width="404" height="784" fill="none" viewBox="0 0 404 784"
                class="absolute left-full transform -translate-y-3-4 -translate-x-1-4 sm:-translate-x-1-2 md:-translate-y-1-2 lg:-translate-x-3-4">
                <defs>
                    <pattern id="d2a68204-c383-44b1-b99f-42ccff4e5365" x="0" y="0" width="20" height="20"
                        patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" fill="currentColor" class="text-gray-200"></rect>
                    </pattern>
                </defs>
                <rect width="404" height="784" fill="url(#d2a68204-c383-44b1-b99f-42ccff4e5365)"></rect>
            </svg></div>
    </div>
    <div class="relative pt-6 pb-16 sm:pb-24">
        <div>
            <div class="max-w-6xl mx-auto px-4 sm:px-6"></div>
        </div>
        <div class="mt-16 mx-auto max-w-6xl px-4 sm:mt-24 sm:px-6">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-6xl md:text-5xl"><span
                        class="block">Be a master of your</span><span class="block text-indigo-600">business
                        website</span>
                </h1>
                <p
                    class="mt-3 font-medium max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Pressent your customers with world class UX.
                    Your Ideas. Our
                    Brain.<br><br>
                </p>
                <div id="i4hyw"></div>
                <div id="in7ei" class="mt-3"><b><a href="https://twitter.com/we_saas" target="_blank" type="button"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Follow us on Twitter
                            <svg class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </b>
                    <div class="mt-2"> And get latest updates when we launch! </div>
                </div>
                <p></p>
            </div>

            <p class="text-center mt-3 mb-3">
                <span class="block">
                - or -
                </span>
                <br>
                <span class="font-bold mt-3 "> Join our Early bird mailing list! And follow our #buildInPublic journey! </span>
                <br>
                <span class="text-sm">
                (1 email a month 📧)
                </span>
            </p>
            <div class="w-full flex justify-center sm:min-w-[400px] !max-w-[100%]">
                <livewire:forms.newsletter-form />
            </div>

            <p class="text-center max-w-4xl mx-auto mt-8">
                <span class="text-medium">
                    <i id="ihzzk">
                        We are still building BusinessPress. Check updates from our team about product development in a
                        feed bellow
                    </i></span>

            </p>



        </div>
    </div>
    <div class="relative">
        <div aria-hidden="true" class="absolute top-[50vh] flex flex-col">
            <div class="flex-1"></div>
            <div class="flex-1 w-full bg-gray-800"></div>
        </div>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 bg-white mb-8">
            <livewire:feed.feed-list :feed-type="$feed_type ?? 'recent'" />

        </div>
    </div>
