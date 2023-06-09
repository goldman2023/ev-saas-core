<div class="bg-white shadow mb-6">
    <div class="px-4 sm:px-6 lg:mx-auto lg:px-8">
        <div class="py-6 lg:flex lg:flex-wrap lg:items-center lg:justify-between lg:border-t lg:border-gray-200">
            <div class="flex-1 min-w-0">
                <!-- Profile -->
                <div class="flex items-center relative">
                    <a href="{{ route('my.account.settings') }}" class="relative">
                    <img class="hidden h-16 w-16 rounded-full sm:block ring-2 ring-indigo-400 object-contain" src="{{ Auth::user()->getThumbnail() }}" alt="">
                    <div class="absolute right-[-6px] bottom-[6px] bg-gray-400 p-1 rounded-full">
                        <svg class="w-3 h-3 text-white" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                            </path>
                        </svg>
                    </div>
                    </a>
                    <div>
                        <div class="flex items-center ">
                            <div class="">
                                <a href="{{ route('my.account.settings') }}">
                                    <img class="h-16 w-16 rounded-full sm:hidden"
                                        src="{{ Auth::user()->getThumbnail() }}" alt="">

                                </a>
                            </div>

                            <h1 class="ml-3 text-2xl font-bold leading-7 text-gray-900 sm:leading-9 sm:truncate">
                                <span class="emoji">👋</span>
                                {{ translate('Welcome') }}, {{ Auth::user()->name }}
                            </h1>
                        </div>
                        <dl class="mt-6 flex flex-col sm:ml-3 sm:mt-1 sm:flex-row sm:flex-wrap">
                            @if(MyShop::getShop())
                            <dt class="sr-only">{{ translate('Company') }}</dt>
                            <dd class="flex items-center text-sm text-gray-500 font-medium capitalize sm:mr-6">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                    x-description="Heroicon name: solid/office-building"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ MyShop::getShop()->getPermalink() }}" target="_blank">
                                    {{ MyShop::getShop()->name }}
                                </a>
                            </dd>
                            @else
                            <dd class="flex items-center text-sm text-gray-500 font-medium capitalize sm:mr-6">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                    x-description="Heroicon name: solid/office-building"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('onboarding.step3') }}" target="_blank">
                                    {{ translate('Create a seller profile') }}
                                </a>
                            </dd>
                            @endif
                            <dt class="sr-only">Account status</dt>
                            <dd
                                class="mt-3 flex items-center text-sm text-gray-500 font-medium sm:mr-6 sm:mt-0 capitalize">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400"
                                    x-description="Heroicon name: solid/check-circle" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ auth()->user()->type }} {{ translate('account') }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex space-x-3 lg:mt-0 lg:ml-4">
                @if(MyShop::getShop())
                <a type="button" href="{{ route('product.create') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                    <span class="emoji mr-2">📦 </span> {{ translate("Add Products") }}
                </a>

                <a type="button" href="{{ route('settings.shop_settings') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                    <span class="emoji mr-2">💻 </span> {{ translate("Manage Shop") }}
                </a>
                @else
                <a type="button" href="{{ route('onboarding.step3') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                    <span class="emoji mr-2">📦 </span> {{ translate("Setup your store") }}
                </a>
                @endif
                <a
                href="{{ route('my.plans.management') }}"
                target="_blank"
                type="button" href=" {{ route('my.plans.management') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                    {{ translate('Join') }} {{ get_site_name() }} {{ translate('PRO') }}
                </a>
            </div>
        </div>
    </div>
</div>
