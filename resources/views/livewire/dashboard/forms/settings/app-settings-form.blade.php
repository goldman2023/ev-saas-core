<div class="w-full" x-data="{
        current_tab: 'general',
        settings: @js($settings),
    }"
    x-init=""
    @validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
    x-cloak>

    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                            wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full"
            wire:loading.class="opacity-30 pointer-events-none"
        >

        <div class="grid grid-cols-12 gap-8 mb-10">
            <div class="col-span-12">

                <div class="p-0 border bg-white border-gray-200 rounded-lg shadow">

                    {{-- Tabs --}}
                    <div class="w-full mb-5">
                        {{-- <div class="sm:hidden">
                            <label for="tabs" class="sr-only">Select a tab</label>
                            <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                            <select id="tabs" name="tabs" class="block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                <option>My Account</option>

                                <option>Company</option>

                                <option selected>Team Members</option>

                                <option>Billing</option>
                            </select>
                        </div> --}}
                        <div class="block pb-5 pt-2">
                            <div class="border-b border-gray-200">
                                <nav class="-mb-px flex space-x-8 px-5">
                                    <a href="#" @click="current_tab = 'general'" :class="{'border-primary text-primary':current_tab === 'general', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'general'}" class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                        @svg('heroicon-o-cog', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                        <span>{{ translate('General') }}</span>
                                    </a>

                                    <a href="#" @click="current_tab = 'features'" :class="{'border-primary text-primary':current_tab === 'features', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'features'}" class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                        @svg('heroicon-o-plus-sm', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                        <span>{{ translate('Features') }}</span>
                                    </a>

                                    <a href="#" @click="current_tab = 'design'" :class="{'border-primary text-primary':current_tab === 'design', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'design'}" class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                        @svg('heroicon-s-template', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                        <span>{{ translate('Design') }}</span>
                                    </a>

                                    <a href="#" @click="current_tab = 'menus'" :class="{'border-primary text-primary':current_tab === 'menus', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'menus'}" class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                        @svg('heroicon-o-menu', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                        <span>{{ translate('Menus') }}</span>
                                    </a>

                                    <a href="#" @click="current_tab = 'currency'" :class="{'border-primary text-primary':current_tab === 'currency', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'currency'}" class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                        @svg('heroicon-o-currency-dollar', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                        <span>{{ translate('Currency') }}</span>
                                    </a>

                                    <a href="#" @click="current_tab = 'language'" :class="{'border-primary text-primary':current_tab === 'language', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'language'}" class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                        @svg('heroicon-o-chat-alt-2', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                        <span>{{ translate('Language') }}</span>
                                    </a>

                                    <a href="#" @click="current_tab = 'social'" :class="{'border-primary text-primary':current_tab === 'social', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'social'}" class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                        @svg('heroicon-o-share', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                        <span>{{ translate('Social') }}</span>
                                    </a>

                                    <a href="#" @click="current_tab = 'payments'" :class="{'border-primary text-primary':current_tab === 'payments', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'payments'}" class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                        @svg('heroicon-o-currency-euro', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                        <span>{{ translate('Payments') }}</span>
                                    </a>

                                    <a href="#" @click="current_tab = 'checkout'" :class="{'border-primary text-primary':current_tab === 'checkout', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'checkout'}" class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                        @svg('heroicon-o-credit-card', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                        <span>{{ translate('Checkout') }}</span>
                                    </a>
                                </nav>
                            </div>
                        </div>

                        {{-- General --}}
                        <div class="w-full px-5" x-show="current_tab === 'general'">
                            {{-- Site logo --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-2" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Site logo') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.image-selector field="settings.site_logo.value" id="site-logo" :selected-image="$settings['site_logo']['value']"></x-dashboard.form.image-selector>

                                    <x-system.invalid-msg field="settings.site_logo.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            {{-- END Site logo --}}

                            {{-- Site logo Dark --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-2" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Site logo (Dark)') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.image-selector field="settings.site_logo_dark.value" id="site-logo-dark" :selected-image="$settings['site_logo_dark']['value']"></x-dashboard.form.image-selector>

                                    <x-system.invalid-msg field="settings.site_logo_dark.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            {{-- END Site logo Dark--}}

                            <!-- Site Name -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Site name') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" class="form-standard @error('settings.site_name') is-invalid @enderror"
                                            placeholder="{{ translate('Site name') }}"
                                            wire:model.defer="settings.site_name.value" />

                                    <x-system.invalid-msg field="settings.site_name.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Site Name -->

                            <!-- Site motto -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">

                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Site motto') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" class="form-standard @error('settings.site_motto') is-invalid @enderror"
                                            placeholder="{{ translate('Site motto') }}"
                                            wire:model.defer="settings.site_motto.value" />

                                    <x-system.invalid-msg field="settings.site_motto.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Site motto -->

                            {{-- Maintenance mode --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Maintenance mode') }}</span>
                                    <p class="text-gray-500 text-sm">{{ translate('If you want to enable maintenance mode and stop users from interacting with site') }}</p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="settings.maintenance_mode.value = !settings.maintenance_mode.value"
                                                :class="{'bg-primary':settings.maintenance_mode.value , 'bg-gray-200':!settings.maintenance_mode.value}"
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                            <span :class="{'translate-x-5':settings.maintenance_mode.value, 'translate-x-0':!settings.maintenance_mode.value}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>
                            {{-- END Maintenance mode --}}

                            {{-- Save general information --}}
                            <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                <button type="button" class="btn btn-primary ml-auto btn-sm"
                                    @click="
                                        $wire.set('settings.site_logo.value', settings.site_logo.value?.id, true);
                                        $wire.set('settings.site_logo_dark.value', settings.site_logo_dark.value?.id, true);
                                        $wire.set('settings.maintenance_mode.value', settings.maintenance_mode.value, true);
                                    "
                                    wire:click="saveGeneral()">
                                {{ translate('Save') }}
                                </button>
                            </div>
                            {{-- END Save general information --}}
                        </div>
                        {{-- END General --}}

                        {{-- Design --}}
                        <div class="w-full px-5" x-show="current_tab === 'design'">
                            {{-- Colors --}}
                            @php $i = 0; @endphp
                            @foreach(TenantSettings::settingsDataTypes()['colors'] as $color_key => $data_type)
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start {{ $i === 0 ? '':'sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5' }}" x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ $color_key }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.colors.value.{{ $color_key }}" />
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @endforeach
                            {{-- END Colors --}}
                            
                            {{-- <x-dashboard.form.color-picker field="settings.colors.value.primary"></x-dashboard.form.color-picker> --}}

                            {{-- Save design --}}
                            <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                <button type="button" class="btn btn-primary ml-auto btn-sm"
                                    @click=""
                                    wire:click="saveDesign()">
                                {{ translate('Save') }}
                                </button>
                            </div>
                            {{-- END Save design --}}
                        </div>
                        {{-- END Design --}}

                        {{-- Features --}}
                        <div class="w-full px-5" x-show="current_tab === 'features'">
                             {{-- Feed Feature --}}
                             <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Feed') }}</span>
                                    <p class="text-gray-500 text-sm">
                                        {{ translate('If you want to enable social feed page as a homepage') }}
                                    </p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <button type="button" @click="settings.feed_enabled.value = !settings.feed_enabled.value"
                                                :class="{'bg-primary':settings.feed_enabled.value , 'bg-gray-200':!settings.feed_enabled.value}"
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                            <span :class="{'translate-x-5':settings.feed_enabled.value, 'translate-x-0':!settings.feed_enabled.value}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>
                            {{-- END Feed Feature --}}

                            {{-- Save Features --}}
                            <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                <button type="button" class="btn btn-primary ml-auto btn-sm"
                                    @click="
                                        $wire.set('settings.feed_enabled.value', settings.feed_enabled.value, true);
                                    "
                                    wire:click="saveFeatures()">
                                {{ translate('Save') }}
                                </button>
                            </div>
                            {{-- END Save Features --}}
                        </div>
                        {{-- END Features --}}

                        {{-- Currency --}}
                        <div class="w-full px-5" x-show="current_tab === 'currency'">
                            {{-- Enable Currency switcher --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-1" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Enable currency switcher') }}</span>
                                    <p class="text-gray-500 text-sm">{{ translate('If you want enable social currency switcher on your website') }}</p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <button type="button" @click="settings.show_currency_switcher.value = !settings.show_currency_switcher.value"
                                                :class="{'bg-primary':settings.show_currency_switcher.value , 'bg-gray-200':!settings.show_currency_switcher.value}"
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                            <span :class="{'translate-x-5':settings.show_currency_switcher.value, 'translate-x-0':!settings.show_currency_switcher.value}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>
                            {{-- END Enable Currency switcher --}}

                            <!-- System Default currency -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Default currency') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.select field="settings.system_default_currency.value" :items="\FX::getAllCurrencies(true, true)" selected="settings.system_default_currency.value.code" :nullable="false"></x-dashboard.form.select>
                                    <x-system.invalid-msg field="settings.system_default_currency.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- System Default currency -->

                            <!-- Number of decimals -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Number of decimals') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="number" min="0" max="3" class="form-standard @error('settings.no_of_decimals') is-invalid @enderror"
                                            placeholder="{{ translate('Decimal numbers') }}"
                                            wire:model.defer="settings.no_of_decimals.value" />

                                    <x-system.invalid-msg field="settings.no_of_decimals.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Number of decimals -->

                            <!-- Decimal separator -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Decimal separator') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.select field="settings.decimal_separator.value" :items="['1' => 'Comma', '2' => 'Dot']" selected="settings.decimal_separator.value" :nullable="false"></x-dashboard.form.select>
                                    <x-system.invalid-msg field="settings.decimal_separator.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Decimal separator -->

                            <!-- Currency format -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Currency format') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.select field="settings.currency_format.value" :items="['1' => translate('Symbol'), '2' => translate('Code')]" selected="settings.currency_format.value" :nullable="false"></x-dashboard.form.select>
                                    <x-system.invalid-msg field="settings.currency_format.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Currency format -->

                            <!-- Symbol format -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Symbol format') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.select field="settings.symbol_format.value" :items="['1' => translate('Symbol before price'), '2' => translate('Symbol after price')]" selected="settings.symbol_format.value" :nullable="false"></x-dashboard.form.select>
                                    <x-system.invalid-msg field="settings.symbol_format.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Symbol format -->

                            {{-- Save Currency --}}
                            <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                <button type="button" class="btn btn-primary ml-auto btn-sm"
                                    @click="
                                        $wire.set('settings.symbol_format.value', settings.symbol_format.value, true);
                                        $wire.set('settings.currency_format.value', settings.currency_format.value, true);
                                        $wire.set('settings.decimal_separator.value', settings.decimal_separator.value, true);
                                        $wire.set('settings.system_default_currency.value', settings.system_default_currency.value.code, true);
                                        $wire.set('settings.show_currency_switcher.value', settings.show_currency_switcher.value, true);
                                    "
                                    wire:click="saveCurrency()">
                                {{ translate('Save') }}
                                </button>
                            </div>
                            {{-- END Save Currency --}}
                        </div>
                        {{-- END Currency --}}


                        {{-- Social --}}
                        <div class="w-full px-5" x-show="current_tab === 'social'">
                            {{-- Enable social logins --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-1" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Enable social logins') }}</span>
                                    <p class="text-gray-500 text-sm">{{ translate('If you want to enable social logins on your website') }}</p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <button type="button" @click="settings.enable_social_logins.value = !settings.enable_social_logins.value"
                                                :class="{'bg-primary':settings.enable_social_logins.value , 'bg-gray-200':!settings.enable_social_logins.value}"
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                            <span :class="{'translate-x-5':settings.enable_social_logins.value, 'translate-x-0':!settings.enable_social_logins.value}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>
                            {{-- END Enable social logins --}}

                            {{-- Login settings --}}
                            <div class="w-full " x-show="settings.enable_social_logins.value">
                                {{-- Google login --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Google login') }}</span>
                                        {{-- <p class="text-gray-500 text-sm">{{ translate('If you want enable social logins on your website') }}</p> --}}
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <button type="button" @click="settings.google_login.value = !settings.google_login.value"
                                                    :class="{'bg-primary':settings.google_login.value , 'bg-gray-200':!settings.google_login.value}"
                                                    class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                                <span :class="{'translate-x-5':settings.google_login.value, 'translate-x-0':!settings.google_login.value}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                        </button>
                                    </div>
                                </div>
                                {{-- END Google login --}}

                                {{-- Facebook login --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Facebook login') }}</span>
                                        {{-- <p class="text-gray-500 text-sm">{{ translate('If you want enable social logins on your website') }}</p> --}}
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <button type="button" @click="settings.facebook_login.value = !settings.facebook_login.value"
                                                    :class="{'bg-primary':settings.facebook_login.value , 'bg-gray-200':!settings.facebook_login.value}"
                                                    class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                                <span :class="{'translate-x-5':settings.facebook_login.value, 'translate-x-0':!settings.facebook_login.value}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                        </button>
                                    </div>
                                </div>
                                {{-- END Facebook login --}}

                                {{-- Linkedin login --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('LinkedIn login') }}</span>
                                        {{-- <p class="text-gray-500 text-sm">{{ translate('If you want enable social logins on your website') }}</p> --}}
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <button type="button" @click="settings.linkedin_login.value = !settings.linkedin_login.value"
                                                    :class="{'bg-primary':settings.linkedin_login.value , 'bg-gray-200':!settings.linkedin_login.value}"
                                                    class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                                <span :class="{'translate-x-5':settings.linkedin_login.value, 'translate-x-0':!settings.linkedin_login.value}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                        </button>
                                    </div>
                                </div>
                                {{-- END Linkedin login --}}
                            </div>
                            {{-- END Login settings --}}

                            {{-- Facebook settings --}}
                            <div class="w-full mt-5">
                                <h4 class="">{{ translate('Facebook settings') }}</h4>
                                <div class="w-full sm:border-t sm:border-gray-400 sm:pt-4 sm:mt-2">
                                    <!-- Facebook APP ID -->
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start " x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                            {{ translate('Facebook APP ID') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text" class="form-standard @error('settings.facebook_app_id') is-invalid @enderror"
                                                    placeholder="{{ translate('APP ID') }}"
                                                    wire:model.defer="settings.facebook_app_id.value" />

                                            <x-system.invalid-msg field="settings.facebook_app_id.value"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                    <!-- END Facebook APP ID -->

                                    <!-- Facebook APP Secret -->
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                            {{ translate('Facebook APP Secret') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text" class="form-standard @error('settings.facebook_app_secret') is-invalid @enderror"
                                                    placeholder="{{ translate('APP Secret') }}"
                                                    wire:model.defer="settings.facebook_app_secret.value" />

                                            <x-system.invalid-msg field="settings.facebook_app_secret.value"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                    <!-- END Facebook APP Secret -->
                                </div>
                            </div>
                            {{-- END Facebook settings --}}

                            {{-- Google OAuth settings --}}
                            <div class="w-full mt-5">
                                <h4 class="">{{ translate('Google OAuth Client settings') }}</h4>
                                <div class="w-full sm:border-t sm:border-gray-400 sm:pt-4 sm:mt-2">
                                    <!-- Google OAuth Client ID -->
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start " x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                            {{ translate('Google OAuth Client ID') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text" class="form-standard @error('settings.google_oauth_client_id') is-invalid @enderror"
                                                    placeholder="{{ translate('Client ID') }}"
                                                    wire:model.defer="settings.google_oauth_client_id.value" />

                                            <x-system.invalid-msg field="settings.google_oauth_client_id.value"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                    <!-- END Google OAuth Client ID -->

                                    <!-- Google OAuth Client Secret -->
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                            {{ translate('Google OAuth Client Secret') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text" class="form-standard @error('settings.google_oauth_client_secret') is-invalid @enderror"
                                                    placeholder="{{ translate('Client Secret') }}"
                                                    wire:model.defer="settings.google_oauth_client_secret.value" />

                                            <x-system.invalid-msg field="settings.google_oauth_client_secret.value"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                    <!-- END Google OAuth Client Secret -->
                                </div>
                            </div>
                            {{-- END Google OAuth settings --}}

                            {{-- LinkedIn settings --}}
                            <div class="w-full mt-5">
                                <h4 class="">{{ translate('LinkedIn Client settings') }}</h4>
                                <div class="w-full sm:border-t sm:border-gray-400 sm:pt-4 sm:mt-2">
                                    <!-- LinkedIn Client ID -->
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start " x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                            {{ translate('LinkedIn Client ID') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text" class="form-standard @error('settings.linkedin_client_id') is-invalid @enderror"
                                                    placeholder="{{ translate('Client ID') }}"
                                                    wire:model.defer="settings.linkedin_client_id.value" />

                                            <x-system.invalid-msg field="settings.linkedin_client_id.value"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                    <!-- END LinkedIn Client ID -->

                                    <!-- LinkedIn Client Secret -->
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                            {{ translate('LinkedIn Client Secret') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text" class="form-standard @error('settings.linkedin_client_secret') is-invalid @enderror"
                                                    placeholder="{{ translate('Client Secret') }}"
                                                    wire:model.defer="settings.linkedin_client_secret.value" />

                                            <x-system.invalid-msg field="settings.linkedin_client_secret.value"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                    <!-- END LinkedIn Client Secret -->
                                </div>
                            </div>
                            {{-- END LinkedIn settings --}}


                            {{-- Save Social --}}
                            <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                <button type="button" class="btn btn-primary ml-auto btn-sm"
                                    @click="
                                        $wire.set('settings.enable_social_logins.value', settings.enable_social_logins.value, true);
                                        $wire.set('settings.google_login.value', settings.google_login.value, true);
                                        $wire.set('settings.facebook_login.value', settings.facebook_login.value, true);
                                        $wire.set('settings.linkedin_login.value', settings.linkedin_login.value, true);
                                    "
                                    wire:click="saveSocial()">
                                {{ translate('Save') }}
                                </button>
                            </div>
                            {{-- END Save Social --}}
                        </div>
                        {{-- END Social --}}


                        {{-- Payments --}}
                        <div class="w-full px-5" x-show="current_tab === 'payments'" wire:ignore>
                            @if($universal_payment_methods->isNotEmpty())
                                @foreach($universal_payment_methods as $key => $payment_method)
                                    <livewire:dashboard.forms.payment-methods.payment-method-card
                                        :payment-method="$payment_method" type="universal" class="mb-2">
                                    </livewire:dashboard.forms.payment-methods.payment-method-card>
                                @endforeach
                            @endif

                            {{-- Stripe Test & Live api keys --}}
                            {{-- <div class="w-full mt-1">
                                <h4 class="">{{ translate('Stripe API settings') }}</h4>

                                <div class="w-full sm:border-t sm:border-gray-400 sm:pt-4 sm:mt-2">
                                    <!-- Stripe Publishable Test Key  -->
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start " x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                            {{ translate('Stripe Publishable Test Key') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text" class="form-standard @error('settings.stripe_pk_test_key') is-invalid @enderror"
                                                    placeholder="{{ translate('PK Test') }}"
                                                    wire:model.defer="settings.stripe_pk_test_key.value" />

                                            <x-system.invalid-msg field="settings.stripe_pk_test_key.value"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                    <!-- END Stripe Publishable Test Key -->

                                    <!-- Stripe Secret Test Key -->
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                            {{ translate('Stripe Secret Test Key') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text" class="form-standard @error('settings.stripe_sk_test_key') is-invalid @enderror"
                                                    placeholder="{{ translate('SK Test') }}"
                                                    wire:model.defer="settings.stripe_sk_test_key.value" />

                                            <x-system.invalid-msg field="settings.stripe_sk_test_key.value"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                    <!-- END Stripe Secrets Test Key -->

                                    <!-- Stripe Publishable Live Key  -->
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                            {{ translate('Stripe Publishable Live Key') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text" class="form-standard @error('settings.stripe_pk_live_key') is-invalid @enderror"
                                                    placeholder="{{ translate('PK Live') }}"
                                                    wire:model.defer="settings.stripe_pk_live_key.value" />

                                            <x-system.invalid-msg field="settings.stripe_pk_live_key.value"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                    <!-- END Stripe Publishable Live Key -->

                                    <!-- Stripe Secrets Live Key  -->
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                            {{ translate('Stripe Secrets Live Key') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text" class="form-standard @error('settings.stripe_sk_live_key') is-invalid @enderror"
                                                    placeholder="{{ translate('SK Live') }}"
                                                    wire:model.defer="settings.stripe_sk_live_key.value" />

                                            <x-system.invalid-msg field="settings.stripe_sk_live_key.value"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                    <!-- END Stripe Secrets Live Key -->
                                </div>
                            </div> --}}
                            {{-- END Stripe Test & Live api keys --}}

                            {{-- Save Payments --}}
                            {{-- <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                <button type="button" class="btn btn-primary ml-auto btn-sm"
                                    @click=""
                                    wire:click="savePayments()">
                                {{ translate('Save') }}
                                </button>
                            </div> --}}
                            {{-- END Save Payments --}}
                        </div>
                        {{-- END Payments --}}
                    </div>
                    {{-- END Tabs --}}


                </div>
            </div>
        </div>
    </div>
</div>


