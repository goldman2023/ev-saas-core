<div class="w-full" x-data="{
        current_tab: 'general',
        settings: @js($settings),
    }" x-init="" @validation-errors.window="$scrollToErrors($event.detail.errors, 700);" x-cloak>

    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:loading.class.remove="hidden">
        </x-ev.loaders.spinner>

        <div class="w-full" wire:loading.class="opacity-30 pointer-events-none">

            <div class="grid grid-cols-12 gap-8 mb-10">
                <div class="col-span-12">

                    <div class="p-0 border bg-white border-gray-200 rounded-lg shadow">

                        {{-- Tabs --}}
                        <div class="w-full mb-5">
                            {{-- <div class="sm:hidden">
                                <label for="tabs" class="sr-only">Select a tab</label>
                                <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                                <select id="tabs" name="tabs"
                                    class="block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                    <option>My Account</option>

                                    <option>Company</option>

                                    <option selected>Team Members</option>

                                    <option>Billing</option>
                                </select>
                            </div> --}}
                            <div class="block pb-5 pt-2">
                                <div class="border-b border-gray-200">
                                    <nav class="-mb-px flex space-x-8 px-5">
                                        <a href="#" @click="current_tab = 'general'"
                                            :class="{'border-primary text-primary':current_tab === 'general', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'general'}"
                                            class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                            @svg('heroicon-o-cog', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                            <span>{{ translate('General') }}</span>
                                        </a>

                                        <a href="#" @click="current_tab = 'features'"
                                            :class="{'border-primary text-primary':current_tab === 'features', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'features'}"
                                            class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                            @svg('heroicon-o-plus', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                            <span>{{ translate('Features') }}</span>
                                        </a>

                                        <a href="#" @click="current_tab = 'design'"
                                            :class="{'border-primary text-primary':current_tab === 'design', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'design'}"
                                            class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                            @svg('heroicon-o-squares-2x2', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                            <span>{{ translate('Design') }}</span>
                                        </a>

                                        <a href="#" @click="current_tab = 'currency'"
                                            :class="{'border-primary text-primary':current_tab === 'currency', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'currency'}"
                                            class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                            @svg('heroicon-o-currency-dollar', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                            <span>{{ translate('Currency') }}</span>
                                        </a>

                                        <a href="#" @click="current_tab = 'language'"
                                            :class="{'border-primary text-primary':current_tab === 'language', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'language'}"
                                            class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                            @svg('heroicon-o-chat-bubble-left-right', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                            <span>{{ translate('Language') }}</span>
                                        </a>

                                        <a href="#" @click="current_tab = 'social'"
                                            :class="{'border-primary text-primary':current_tab === 'social', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'social'}"
                                            class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                            @svg('heroicon-o-share', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                            <span>{{ translate('Social') }}</span>
                                        </a>

                                        <a href="#" @click="current_tab = 'payments'"
                                            :class="{'border-primary text-primary':current_tab === 'payments', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'payments'}"
                                            class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                            @svg('heroicon-o-currency-euro', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                            <span>{{ translate('Payments') }}</span>
                                        </a>

                                        <a href="#" @click="current_tab = 'integrations'"
                                            :class="{'border-primary text-primary':current_tab === 'integrations', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'integrations'}"
                                            class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                            @svg('lineawesome-plug-solid', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                            <span>{{ translate('Integrations') }}</span>
                                        </a>

                                        <a href="#" @click="current_tab = 'advanced'"
                                            :class="{'border-primary text-primary':current_tab === 'advanced', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'advanced'}"
                                            class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                            @svg('heroicon-o-cog', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                            <span>{{ translate('Advanced') }}</span>
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
                                        <x-dashboard.form.file-selector field="settings.site_logo" id="site-logo"
                                            :selected-image="$settings['site_logo']"></x-dashboard.form.file-selector>

                                        <x-system.invalid-msg field="settings.site_logo"></x-system.invalid-msg>
                                    </div>
                                </div>
                                {{-- END Site logo --}}

                                {{-- Site logo Dark --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-2" x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Site logo (Dark)') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.file-selector field="settings.site_logo_dark"
                                            id="site-logo-dark" :selected-image="$settings['site_logo_dark']">
                                        </x-dashboard.form.file-selector>

                                        <x-system.invalid-msg field="settings.site_logo_dark"></x-system.invalid-msg>
                                    </div>
                                </div>
                                {{-- END Site logo Dark--}}

                                {{-- Favicon --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-2" x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Site icon (favicon)') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.file-selector field="settings.site_icon" id="site-site_icon"
                                            :selected-image="$settings['site_icon']"></x-dashboard.form.file-selector>

                                        <x-system.invalid-msg field="settings.site_icon"></x-system.invalid-msg>
                                    </div>
                                </div>
                                {{-- END Favicon --}}

                                {{-- SEO Meta Image --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-2" x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('SEO Meta Image') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.file-selector field="settings.seo_meta_image" id="site-seo_meta_image"
                                            :selected-image="$settings['seo_meta_image']"></x-dashboard.form.file-selector>

                                        <x-system.invalid-msg field="settings.seo_meta_image"></x-system.invalid-msg>
                                    </div>
                                </div>
                                {{-- END SEO Meta Image --}}

                                <!-- Site Name -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Site name') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input type="text"
                                            class="form-standard @error('settings.site_name') is-invalid @enderror"
                                            placeholder="{{ translate('Site name') }}"
                                            wire:model.defer="settings.site_name" />

                                        <x-system.invalid-msg field="settings.site_name"></x-system.invalid-msg>
                                    </div>
                                </div>
                                <!-- END Site Name -->

                                <!-- Site motto -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Site motto') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input type="text"
                                            class="form-standard @error('settings.site_motto') is-invalid @enderror"
                                            placeholder="{{ translate('Site motto') }}"
                                            wire:model.defer="settings.site_motto" />

                                        <x-system.invalid-msg field="settings.site_motto"></x-system.invalid-msg>
                                    </div>
                                </div>
                                <!-- END Site motto -->

                                <!-- Site Contact Email -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Site Contact Email') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.site_contact_email" type="email"
                                            placeholder="{{ translate('Contact email') }}" />
                                    </div>
                                </div>
                                <!-- END Site Contact Email -->

                                {{-- Maintenance mode --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Maintenance mode')
                                            }}</span>
                                        <p class="text-gray-500 text-sm">{{ translate('If you want to enable maintenance
                                            mode and stop users from interacting with site') }}</p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.maintenance_mode" />
                                    </div>
                                </div>
                                {{-- END Maintenance mode --}}

                                {{-- TODO: Move this to dedicated tab --}}
                                {{-- Enable/Disable Brands --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Enable Brands')
                                            }}</span>
                                        <p class="text-gray-500 text-sm">{{ translate('Enable/Disable Brands content
                                            type') }}</p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.brands_ct_enabled" />
                                    </div>
                                </div>
                                {{-- END Enable/Disable Brands --}}

                                {{-- Company Information --}}
                                <div class="mt-7 text-20 font-semibold">
                                    {{ translate('Company Information') }}
                                </div>

                                <!-- Company name -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-2"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company name') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.company_name" />
                                    </div>
                                </div>
                                <!-- END Company name -->

                                <!-- Company number -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company number') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.company_number" />
                                    </div>
                                </div>
                                <!-- END Company number -->

                                <!-- Company vat -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company VAT number') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.company_vat" />
                                    </div>
                                </div>
                                <!-- END Company vat -->

                                <!-- Company tax rate -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company tax rate (decimal percentage)') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input type="number" min="0" max="100"
                                            field="settings.company_tax_rate" />
                                    </div>
                                </div>
                                <!-- END Company tax rate  -->

                                <!-- Include Tax -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="flex flex-col text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        <span>{{ translate('Include tax in prices') }}</span>
                                        <p class="text-gray-500 text-sm">{{ translate('If enabled, all prices across the site will be treated as prices with included tax. This means that product that costs 1000$ actually costs: X + tax. Otherwise, it costs 1000$ and tax will be appended to subtotal in checkout!') }}</p>
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.toggle field="settings.include_tax" />
                                    </div>
                                </div>
                                <!-- END Include Tax  -->

                                <!-- Company email -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company email') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input type="email" field="settings.company_email" />
                                    </div>
                                </div>
                                <!-- END Company number -->

                                <!-- Company address -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company address') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.company_address" />
                                    </div>
                                </div>
                                <!-- END Company address -->

                                <!-- Company city -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company city') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.company_city" />
                                    </div>
                                </div>
                                <!-- END Company city -->

                                <!-- Company postal code -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company postal code') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.company_postal_code" />
                                    </div>
                                </div>
                                <!-- END Company postal code -->

                                <!-- Company country -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company country') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.company_country" />
                                    </div>
                                </div>
                                <!-- END Company country -->

                                <!-- Company Phones -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company phones') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.text-repeater field="settings.company_phones" error-field="settings.company_phones" placeholder="{{ translate('Phone') }}"  limit="3"></x-dashboard.form.text-repeater>
                                    </div>
                                </div>
                                <!-- END Company Phones -->

                                <!-- Company CEO Name -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company CEO name') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.company_ceo_name" />
                                    </div>
                                </div>
                                <!-- Company CEO Name -->

                                <!-- Company Bank Name -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company Bank Name') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.company_bank_name" />
                                    </div>
                                </div>
                                <!-- Company Bank Name -->

                                <!-- Company Bank Account Number -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company Bank Account Number') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.company_bank_account_number" />
                                    </div>
                                </div>
                                <!-- END Company Bank Account Number -->

                                <!-- Company Bank SWIFT -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Company Bank SWIFT') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.company_bank_swift_number" />
                                    </div>
                                </div>
                                <!-- END Company Bank SWIFT -->

                                {{-- END Company Information --}}


                                {{-- POLICIES URLS --}}
                                <div class="mt-7 text-20 font-semibold">
                                    {{ translate('Policies (GDPR, return/refund, shipping etc.)') }}
                                </div>

                                <!-- TOS Url -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-2"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Terms of service URL') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.tos_url" />
                                    </div>
                                </div>
                                <!-- END TOS Url -->

                                <!-- Cookies Url -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Cookies Policy URL') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.cookies_url" />
                                    </div>
                                </div>
                                <!-- END Cookies Url -->

                                <!-- EULA Url -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('EULA URL') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.eula_url" />
                                    </div>
                                </div>
                                <!-- END EULA Url -->

                                <!-- Shipping policy url -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Shipping Policy URL') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.shipping_policy_url" />
                                    </div>
                                </div>
                                <!-- END Shipping policy url -->

                                <!-- Retruns and Refunds url -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Retruns and Refunds URL') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.returns_and_refunds_url" />
                                    </div>
                                </div>
                                <!-- END Retruns and Refunds url -->

                                <!-- Documentaion url -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Documentaion URL') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.documentation_url" />
                                    </div>
                                </div>
                                <!-- END Documentaion url -->

                                @do_action('view.app-settings-form.general.end')

                                {{-- Save general information --}}
                                <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                    x-data="{}">
                                    <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                        $wire.set('settings.site_logo', settings.site_logo?.id, true);
                                        $wire.set('settings.site_logo_dark', settings.site_logo_dark?.id, true);
                                        $wire.set('settings.site_icon', settings.site_icon?.id, true);
                                        $wire.set('settings.seo_meta_image', settings.seo_meta_image?.id, true);
                                        $wire.set('settings.maintenance_mode', settings.maintenance_mode, true);
                                        $wire.set('settings.brands_ct_enabled', settings.brands_ct_enabled, true);
                                        $wire.set('settings.include_tax', settings.include_tax, true);
                                        $wire.set('settings.company_phones', settings.company_phones, true);
                                        @do_action('view.app-settings-form.general.wire_set')
                                    " wire:click="saveGeneral()">
                                        {{ translate('Save') }}
                                    </button>
                                </div>
                                {{-- END Save general information --}}
                            </div>
                            {{-- END General --}}

                            {{-- Design --}}
                            <div class="w-full px-5" x-show="current_tab === 'design'">
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Theme selection')
                                            }}</span>
                                        <p class="text-gray-500 text-sm">{{ translate('If you want to change app theme')
                                            }}</p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <livewire:dashboard.forms.settings.theme-select-form />
                                    </div>
                                </div>

                                <div>
                                    <!-- Product Page Style -->
                                    <!-- Number of decimals -->
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                        x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                            {{ translate('Product Page Style') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text"
                                                class="form-standard @error('settings.product_page_style') is-invalid @enderror"
                                                placeholder="{{ translate('product-single-1') }}"
                                                wire:model.defer="settings.product_page_style" />

                                            <x-system.invalid-msg field="settings.product_page_style">
                                            </x-system.invalid-msg>
                                        </div>
                                    </div>
                                    <!-- Product Page Style -->
                                </div>

                                <div>
                                    <!-- Footer  Style -->
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                        x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                            {{ translate('Footer Style') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text"
                                                class="form-standard @error('settings.footer_style') is-invalid @enderror"
                                                placeholder="{{ translate('footer_01') }}"
                                                wire:model.defer="settings.footer_style" />

                                            <x-system.invalid-msg field="settings.footer_style">
                                            </x-system.invalid-msg>
                                        </div>
                                    </div>
                                    <!-- Footer Style -->
                                </div>

                                <div class="grid grid-cols-12 mb-6  sm:border-t sm:border-gray-200 sm:pt-5 mt-4">
                                    <div class="col-span-6 font-medium text-md">
                                        {{ translate('For generating color variants we recommend using this tool: ') }}
                                        <a href="https://tailwind.simeongriggs.dev/" class="text-indigo-600"
                                            target="_blank">Palette Generator</a>
                                    </div>
                                </div>

                                {{-- Colors --}}
                                @php $i = 0; @endphp
                                @foreach($colors as $color_key => $data_type)
                                @if($loop->first)
                                <div class="bg-indigo-400 p-6 rounded">
                                    @endif
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start {{ $i === 0 ? '':'sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5' }}"
                                        x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                            {{ $color_key }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-1">
                                            <x-dashboard.form.input wire:model.defer="settings.colors.{{ $color_key }}"
                                                field="settings.colors.{{ $color_key }}" />

                                        </div>
                                        <div>
                                            @if($loop->first)
                                            <button class="btn-primary bg-indigo-700" type="button" @click=""
                                                wire:click="generateColorPalette(333)">
                                                Generate Collor palette
                                            </button>
                                            @endif

                                        </div>
                                    </div>
                                    @php $i++; @endphp
                                    @if($loop->first)
                                </div>
                                @endif
                                @endforeach
                                {{-- END Colors --}}

                                {{-- <x-dashboard.form.color-picker field="settings.colors.primary">
                                </x-dashboard.form.color-picker> --}}

                                {{-- Save design --}}
                                <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                    x-data="{}">
                                    <button type="button" class="btn btn-primary ml-auto btn-sm" @click=""
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
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start " x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Feed') }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('If you want to enable social feed page as a homepage') }}
                                        </p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.feed_enabled" />
                                    </div>
                                </div>
                                {{-- END Feed Feature --}}

                                {{-- Chat Feature --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Chat') }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('If you want to enable chat on website') }}
                                        </p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.chat_feature" />
                                    </div>
                                </div>
                                {{-- END Chat Feature --}}

                                {{-- Addresses Feature --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Custmer
                                            Addresses')
                                            }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('If you want to enable addresses for customers') }}
                                        </p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.addresses_feature" />
                                    </div>
                                </div>
                                {{-- END Addresses Feature --}}

                                {{-- Addresses Feature --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Notifications')
                                            }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('If you want to enable notifications for users inside website')
                                            }}
                                        </p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.notifications_feature" />
                                    </div>
                                </div>
                                {{-- END Addresses Feature --}}

                                {{-- Addresses Feature --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Breadcrumbs')
                                            }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('If you want to enable breadcrums in custom pages')
                                            }}
                                        </p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.breadcrumbs_feature" />
                                    </div>
                                </div>
                                {{-- END Addresses Feature --}}

                                {{-- WeEdit Feature --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('WeEdit') }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('Enable/Disable WeEdit page builder') }}
                                        </p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.weedit_feature" />
                                    </div>
                                </div>
                                {{-- END WeEdit Feature --}}

                                {{-- Multiple Subscriptions Feature --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Enable multiple
                                            subscriptions') }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('Allowing users to have multiple subscriptions (needed for
                                            multi-vendor apps AND if you want to allow users to buy different interval
                                            subscriptions') }}
                                        </p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.multiple_subscriptions_enabled" />
                                    </div>
                                </div>
                                {{-- END Multiple Subscriptions Feature --}}

                                {{-- Multi-item Subscription Feature --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Enable multi-item
                                            subscriptions') }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('If you want to enable buying multiple items
                                            (licenses/seats/whatever) under ONE subscription ') }}
                                        </p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.multi_item_subscription_enabled" />
                                    </div>
                                </div>
                                {{-- END Multi-item Subscription Feature --}}

                                {{-- Allow subscription items distribution enabled --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Allow subscription
                                            items distribution') }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('If you want to enable distribution of subscription items to
                                            users/invitees by subscription owner') }}
                                        </p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle
                                            field="settings.subscription_items_distribution_enabled" />
                                    </div>
                                </div>
                                {{-- END Allow subscription items distribution enabled --}}

                                {{-- Login/Registration/Onboarding flow --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">

                                    {{-- Enable registration --}}
                                    <div class="col-span-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start mb-3"
                                        x-data="{}">
                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                            <span class="text-sm font-medium text-gray-900">{{ translate('Disable user registration') }}:</span>
                                            <p class="text-gray-500 text-sm">
                                                {{ translate('Enable/Disable user registration.') }}
                                            </p>
                                        </div>

                                        <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                            <x-dashboard.form.toggle field="settings.disable_user_registration" />
                                        </div>
                                    </div>
                                    {{-- END Enable registration --}}


                                    {{-- Enable entity selection --}}
                                    <div class="col-span-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start mb-3"
                                        x-data="{}">
                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                            <span class="text-sm font-medium text-gray-900">{{ translate('Enable entity
                                                selection') }}:</span>
                                            <p class="text-gray-500 text-sm">
                                                {{ translate('Enable/Disable if users can choose their account type:
                                                individual/company') }}
                                            </p>
                                        </div>

                                        <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                            <x-dashboard.form.toggle field="settings.user_entity_choice" />
                                        </div>
                                    </div>
                                    {{-- END Enable entity selection --}}


                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Onboarding flow')
                                            }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('If you want newly registered users to go through onboarding
                                            flow after registration') }}
                                        </p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.onboarding_flow" />
                                    </div>

                                    {{-- Force email verification --}}
                                    <div class="col-span-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start mb-3"
                                        x-data="{}">
                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                            <span class="text-sm font-medium text-gray-900">{{ translate('Force email
                                                verification') }}:</span>
                                            <p class="text-gray-500 text-sm">
                                                {{ translate('Enable/Disable if users must verify their email address in
                                                order to preform some actions') }}
                                            </p>
                                        </div>

                                        <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                            <x-dashboard.form.toggle field="settings.force_email_verification" />
                                        </div>
                                    </div>
                                    {{-- END Force email verification --}}

                                    <div class="col-span-3">
                                        {{-- Login Dynamic Redirect --}}
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">
                                            <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ translate('Login Dynamic Redirect') }}:</span>
                                                <p class="text-gray-500 text-sm">
                                                    {{ translate('If this is enabled user will go to previous page
                                                    visited.') }}
                                                </p>
                                            </div>

                                            <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                                <x-dashboard.form.toggle field="settings.login_dynamic_redirect" />

                                            </div>
                                        </div>
                                    </div>
                                    {{-- END Login Redirect --}}
                                    <div class="col-span-3">
                                        {{-- Register Dynamic Redirect --}}
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">
                                            <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ translate('Registration Dynamic Redirect') }}:</span>
                                                <p class="text-gray-500 text-sm">
                                                    {{ translate('If this is enabled user will go to previous page
                                                    visited after registration') }}
                                                </p>
                                            </div>

                                            <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                                <x-dashboard.form.toggle field="settings.register_dynamic_redirect" />

                                            </div>
                                        </div>
                                    </div>
                                    {{-- END Register Redirect URL --}}


                                    <div class="col-span-3" x-show="!settings.onboarding_flow">
                                        {{-- Register Redirect URL --}}
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  mb-3" x-data="{}">
                                            <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                                <span class="text-sm font-medium text-gray-900">{{
                                                    translate('Registration Redirect URL') }}:</span>
                                                <p class="text-gray-500 text-sm">
                                                    {{ translate('This is a URL where you want all your newly registered
                                                    users to land after account creation') }}
                                                </p>
                                            </div>

                                            <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                                <x-dashboard.form.input field="settings.register_redirect_url"
                                                    placeholder="{{ translate('Leave empty for email verification page') }}" />
                                            </div>
                                        </div>
                                        {{-- END Register Redirect URL --}}

                                        {{-- Login Redirect URL --}}
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">
                                            <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                                <span class="text-sm font-medium text-gray-900">{{ translate('Login
                                                    Redirect URL') }}:</span>
                                                <p class="text-gray-500 text-sm">
                                                    {{ translate('This is a URL where you want your users to land after
                                                    logging-in') }}
                                                </p>
                                            </div>

                                            <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                                <x-dashboard.form.input field="settings.login_redirect_url"
                                                    placeholder="{{ translate('Leave empty for dashboard') }}" />
                                            </div>
                                        </div>
                                        {{-- END Login Redirect URL --}}


                                    </div>

                                </div>
                                {{-- END Login/Registration/Onboarding flow --}}

                                {{-- Wishlist Feature --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Wishlist')
                                            }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('Enable/Disable wishlists on website') }}
                                        </p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.wishlist_feature" />
                                    </div>
                                </div>
                                {{-- END Wishlist Feature --}}

                                {{-- Vendor Mode Feature --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Vendor Mode')
                                            }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('Enable/Disable single vendor mode (shops can add their domains
                                            and custom pages under multi-vendor platform)') }}
                                        </p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.vendor_mode_feature" />
                                    </div>
                                </div>
                                {{-- END Vendor Mode Feature --}}

                                {{-- Plans Trial Mode --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Plans trial mode')
                                            }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('Allow trial period on all your plans') }}
                                        </p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <x-dashboard.form.toggle field="settings.plans_trial_mode" />
                                    </div>

                                    <div class="col-span-3" x-show="settings.plans_trial_mode">
                                        {{-- Trial duration --}}
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">
                                            <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                                <span class="text-sm font-medium text-gray-900">{{ translate('Trial
                                                    duration (in days)') }}:</span>
                                                <p class="text-gray-500 text-sm">
                                                    {{ translate('If you enable trial mode, you must specify trial
                                                    duration') }}
                                                </p>
                                            </div>

                                            <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                                <x-dashboard.form.input field="settings.plans_trial_duration" min="1"
                                                    type="number"
                                                    placeholder="{{ translate('Number of trial days') }}" />
                                            </div>
                                        </div>
                                        {{-- END Trial duration --}}

                                        {{-- Tasks Enabled --}}
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                            x-data="{}">
                                            <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                                <span class="text-sm font-medium text-gray-900">{{ translate('Enable
                                                    Tasks')
                                                    }}</span>
                                                <p class="text-gray-500 text-sm">
                                                    {{ translate('Enable the tasks feature') }}
                                                </p>
                                            </div>

                                            <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                                <x-dashboard.form.toggle field="settings.tasks_enabled" />
                                            </div>
                                        </div>
                                        {{-- END Tasks Enabled --}}
                                    </div>
                                </div>


                                {{-- Save Features --}}
                                <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                    x-data="{}">
                                    <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                        $wire.set('settings.feed_enabled', settings.feed_enabled, true);
                                        $wire.set('settings.multiple_subscriptions_enabled', settings.multiple_subscriptions_enabled, true);
                                        $wire.set('settings.multi_item_subscription_enabled', settings.multi_item_subscription_enabled, true);
                                        $wire.set('settings.subscription_items_distribution_enabled', settings.subscription_items_distribution_enabled, true);
                                        $wire.set('settings.user_entity_choice', settings.user_entity_choice, true);
                                        $wire.set('settings.disable_user_registration', settings.disable_user_registration, true);
                                        $wire.set('settings.onboarding_flow', settings.onboarding_flow, true);
                                        $wire.set('settings.force_email_verification', settings.force_email_verification, true);
                                        $wire.set('settings.register_dynamic_redirect', settings.register_dynamic_redirect, true);
                                        $wire.set('settings.login_dynamic_redirect', settings.login_dynamic_redirect, true);
                                        $wire.set('settings.chat_feature', settings.chat_feature, true);
                                        $wire.set('settings.addresses_feature', settings.addresses_feature, true);
                                        $wire.set('settings.notifications_feature', settings.notifications_feature, true);
                                        $wire.set('settings.weedit_feature', settings.weedit_feature, true);
                                        $wire.set('settings.wishlist_feature', settings.wishlist_feature, true);
                                        $wire.set('settings.vendor_mode_feature', settings.vendor_mode_feature, true);
                                        $wire.set('settings.plans_trial_mode', settings.plans_trial_mode, true);
                                        $wire.set('settings.tasks_enabled', settings.tasks_enabled, true);
                                    " wire:click="saveFeatures()">
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
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Enable currency
                                            switcher') }}</span>
                                        <p class="text-gray-500 text-sm">{{ translate('If you want enable social
                                            currency switcher on your website') }}</p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <button type="button"
                                            @click="settings.show_currency_switcher = !settings.show_currency_switcher"
                                            :class="{'bg-primary':settings.show_currency_switcher , 'bg-gray-200':!settings.show_currency_switcher}"
                                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                            role="switch">
                                            <span
                                                :class="{'translate-x-5':settings.show_currency_switcher, 'translate-x-0':!settings.show_currency_switcher}"
                                                class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                        </button>
                                    </div>
                                </div>
                                {{-- END Enable Currency switcher --}}

                                <!-- System Default currency -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Default currency') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.select field="settings.system_default_currency.code"
                                            :items="\FX::getAllCurrencies(true, true)"
                                            selected="settings.system_default_currency.code" :nullable="false">
                                        </x-dashboard.form.select>
                                        <x-system.invalid-msg field="settings.system_default_currency.code">
                                        </x-system.invalid-msg>
                                    </div>
                                </div>
                                <!-- System Default currency -->

                                <!-- Number of decimals -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Number of decimals') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input type="number" min="0" max="3"
                                            class="form-standard @error('settings.no_of_decimals') is-invalid @enderror"
                                            placeholder="{{ translate('Decimal numbers') }}"
                                            wire:model.defer="settings.no_of_decimals" />

                                        <x-system.invalid-msg field="settings.no_of_decimals"></x-system.invalid-msg>
                                    </div>
                                </div>
                                <!-- END Number of decimals -->

                                <!-- Decimal separator -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Decimal separator') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.select field="settings.decimal_separator"
                                            :items="['1' => 'Comma', '2' => 'Dot']"
                                            selected="settings.decimal_separator" :nullable="false">
                                        </x-dashboard.form.select>
                                        <x-system.invalid-msg field="settings.decimal_separator"></x-system.invalid-msg>
                                    </div>
                                </div>
                                <!-- END Decimal separator -->

                                <!-- Currency format -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Currency format') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.select field="settings.currency_format"
                                            :items="['1' => translate('Symbol'), '2' => translate('Code')]"
                                            selected="settings.currency_format" :nullable="false">
                                        </x-dashboard.form.select>
                                        <x-system.invalid-msg field="settings.currency_format"></x-system.invalid-msg>
                                    </div>
                                </div>
                                <!-- END Currency format -->

                                <!-- Symbol format -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Symbol format') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.select field="settings.symbol_format"
                                            :items="['1' => translate('Symbol before price'), '2' => translate('Symbol after price')]"
                                            selected="settings.symbol_format" :nullable="false">
                                        </x-dashboard.form.select>
                                        <x-system.invalid-msg field="settings.symbol_format"></x-system.invalid-msg>
                                    </div>
                                </div>
                                <!-- END Symbol format -->

                                {{-- Save Currency --}}
                                <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                    x-data="{}">
                                    <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                        console.log(settings.system_default_currency);
                                        $wire.set('settings.symbol_format', settings.symbol_format, true);
                                        $wire.set('settings.currency_format', settings.currency_format, true);
                                        $wire.set('settings.decimal_separator', settings.decimal_separator, true);
                                        $wire.set('settings.system_default_currency', settings.system_default_currency.code, true);
                                        $wire.set('settings.show_currency_switcher', settings.show_currency_switcher, true);
                                    " wire:click="saveCurrency()">
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
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Enable social
                                            logins') }}</span>
                                        <p class="text-gray-500 text-sm">{{ translate('If you want to enable social
                                            logins on your website') }}</p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <button type="button"
                                            @click="settings.enable_social_logins = !settings.enable_social_logins"
                                            :class="{'bg-primary':settings.enable_social_logins , 'bg-gray-200':!settings.enable_social_logins}"
                                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                            role="switch">
                                            <span
                                                :class="{'translate-x-5':settings.enable_social_logins, 'translate-x-0':!settings.enable_social_logins}"
                                                class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                        </button>
                                    </div>
                                </div>
                                {{-- END Enable social logins --}}

                                {{-- Login settings --}}
                                <div class="w-full " x-show="settings.enable_social_logins">
                                    {{-- Google login --}}
                                    <div
                                        class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5">
                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                            <span class="text-sm font-medium text-gray-900">{{ translate('Google login')
                                                }}</span>
                                            {{-- <p class="text-gray-500 text-sm">{{ translate('If you want enable
                                                social logins on your website') }}</p> --}}
                                        </div>

                                        <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                            <button type="button"
                                                @click="settings.google_login = !settings.google_login"
                                                :class="{'bg-primary':settings.google_login , 'bg-gray-200':!settings.google_login}"
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                role="switch">
                                                <span
                                                    :class="{'translate-x-5':settings.google_login, 'translate-x-0':!settings.google_login}"
                                                    class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                            </button>
                                        </div>
                                    </div>
                                    {{-- END Google login --}}

                                    {{-- Facebook login --}}
                                    <div
                                        class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5">
                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                            <span class="text-sm font-medium text-gray-900">{{ translate('Facebook
                                                login') }}</span>
                                            {{-- <p class="text-gray-500 text-sm">{{ translate('If you want enable
                                                social logins on your website') }}</p> --}}
                                        </div>

                                        <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                            <button type="button"
                                                @click="settings.facebook_login = !settings.facebook_login"
                                                :class="{'bg-primary':settings.facebook_login , 'bg-gray-200':!settings.facebook_login}"
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                role="switch">
                                                <span
                                                    :class="{'translate-x-5':settings.facebook_login, 'translate-x-0':!settings.facebook_login}"
                                                    class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                            </button>
                                        </div>
                                    </div>
                                    {{-- END Facebook login --}}

                                    {{-- Linkedin login --}}
                                    <div
                                        class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5">
                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                            <span class="text-sm font-medium text-gray-900">{{ translate('LinkedIn
                                                login') }}</span>
                                            {{-- <p class="text-gray-500 text-sm">{{ translate('If you want enable
                                                social logins on your website') }}</p> --}}
                                        </div>

                                        <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                            <button type="button"
                                                @click="settings.linkedin_login = !settings.linkedin_login"
                                                :class="{'bg-primary':settings.linkedin_login , 'bg-gray-200':!settings.linkedin_login}"
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                role="switch">
                                                <span
                                                    :class="{'translate-x-5':settings.linkedin_login, 'translate-x-0':!settings.linkedin_login}"
                                                    class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
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
                                                <input type="text"
                                                    class="form-standard @error('settings.facebook_app_id') is-invalid @enderror"
                                                    placeholder="{{ translate('APP ID') }}"
                                                    wire:model.defer="settings.facebook_app_id" />

                                                <x-system.invalid-msg field="settings.facebook_app_id">
                                                </x-system.invalid-msg>
                                            </div>
                                        </div>
                                        <!-- END Facebook APP ID -->

                                        <!-- Facebook APP Secret -->
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                            x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                                {{ translate('Facebook APP Secret') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <input type="text"
                                                    class="form-standard @error('settings.facebook_app_secret') is-invalid @enderror"
                                                    placeholder="{{ translate('APP Secret') }}"
                                                    wire:model.defer="settings.facebook_app_secret" />

                                                <x-system.invalid-msg field="settings.facebook_app_secret">
                                                </x-system.invalid-msg>
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
                                                <input type="text"
                                                    class="form-standard @error('settings.google_oauth_client_id') is-invalid @enderror"
                                                    placeholder="{{ translate('Client ID') }}"
                                                    wire:model.defer="settings.google_oauth_client_id" />

                                                <x-system.invalid-msg field="settings.google_oauth_client_id">
                                                </x-system.invalid-msg>
                                            </div>
                                        </div>
                                        <!-- END Google OAuth Client ID -->

                                        <!-- Google OAuth Client Secret -->
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                            x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                                {{ translate('Google OAuth Client Secret') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <input type="text"
                                                    class="form-standard @error('settings.google_oauth_client_secret') is-invalid @enderror"
                                                    placeholder="{{ translate('Client Secret') }}"
                                                    wire:model.defer="settings.google_oauth_client_secret" />

                                                <x-system.invalid-msg field="settings.google_oauth_client_secret">
                                                </x-system.invalid-msg>
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
                                                <input type="text"
                                                    class="form-standard @error('settings.linkedin_client_id') is-invalid @enderror"
                                                    placeholder="{{ translate('Client ID') }}"
                                                    wire:model.defer="settings.linkedin_client_id" />

                                                <x-system.invalid-msg field="settings.linkedin_client_id">
                                                </x-system.invalid-msg>
                                            </div>
                                        </div>
                                        <!-- END LinkedIn Client ID -->

                                        <!-- LinkedIn Client Secret -->
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                            x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                                {{ translate('LinkedIn Client Secret') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <input type="text"
                                                    class="form-standard @error('settings.linkedin_client_secret') is-invalid @enderror"
                                                    placeholder="{{ translate('Client Secret') }}"
                                                    wire:model.defer="settings.linkedin_client_secret" />

                                                <x-system.invalid-msg field="settings.linkedin_client_secret">
                                                </x-system.invalid-msg>
                                            </div>
                                        </div>
                                        <!-- END LinkedIn Client Secret -->
                                    </div>
                                </div>
                                {{-- END LinkedIn settings --}}


                                {{-- Save Social --}}
                                <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                    x-data="{}">
                                    <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                        $wire.set('settings.enable_social_logins', settings.enable_social_logins, true);
                                        $wire.set('settings.google_login', settings.google_login, true);
                                        $wire.set('settings.facebook_login', settings.facebook_login, true);
                                        $wire.set('settings.linkedin_login', settings.linkedin_login, true);
                                    " wire:click="saveSocial()">
                                        {{ translate('Save') }}
                                    </button>
                                </div>
                                {{-- END Save Social --}}
                            </div>
                            {{-- END Social --}}


                            {{-- Payments --}}
                            <div class="w-full px-5" x-show="current_tab === 'payments'" wire:ignore>
                                {{-- Invoice numbering --}}
                                <div class="mt-2 text-20 font-semibold">
                                    {{ translate('Orders') }}
                                </div>

                                {{-- Installments deposit amount --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-2"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Initial deposit amount (installments)') }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('This is a deposit amount in percentage of total value of the order which customer needs to pay in advance (for orders payed in installments)') }}
                                        </p>
                                    </div>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.installments_deposit_amount" type="number" min="0" max="100" />
                                    </div>
                                </div>
                                {{-- END Installments deposit amount --}}

                                {{-- Allow installments in checkout flow --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-2"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Allow installments in checkout flow') }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('If this setting is enabled, paying in installments in regular checkout flow will be available') }}
                                        </p>
                                    </div>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.toggle field="settings.allow_installments_in_checkout_flow" />
                                    </div>
                                </div>
                                {{-- END Allow installments in checkout flow --}}

                                {{-- Allow installments in checkout flow --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-2"
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Make paying in installments default option in standard checkout flow') }}</span>
                                        <p class="text-gray-500 text-sm">
                                            {{ translate('If this setting is enabled, paying in installments will be selected by default in standard checkout flow') }}
                                        </p>
                                    </div>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.toggle field="settings.are_installments_default_in_checkout_flow" />
                                    </div>
                                </div>
                                {{-- END Allow installments in checkout flow --}}


                                {{-- Invoice numbering --}}
                                <div class="mt-2 text-20 font-semibold sm:pt-5 sm:mt-2">
                                    {{ translate('Invoice numbering') }}
                                </div>

                                <!-- Invoice prefix -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-2"
                                    x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ translate('Invoice prefix') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.invoice_prefix" />
                                    </div>
                                </div>
                                <!-- END Invoice prefix -->

                                {{-- Save Payments --}}
                                <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                    x-data="{}">
                                    <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                        $wire.set('settings.allow_installments_in_checkout_flow', settings.allow_installments_in_checkout_flow, true);
                                        $wire.set('settings.are_installments_default_in_checkout_flow', settings.are_installments_default_in_checkout_flow, true);
                                    "
                                        wire:click="savePayments()">
                                        {{ translate('Save') }}
                                    </button>
                                </div>
                                {{-- END Save Payments --}}

                                {{-- END Invoice numbering --}}


                                {{-- Payments --}}
                                <div class="mt-3 text-20 font-semibold pb-3 mb-5 border-b">
                                    {{ translate('Payments') }}
                                </div>

                                @if($universal_payment_methods->isNotEmpty())
                                    @foreach($universal_payment_methods as $key => $payment_method)
                                        <livewire:dashboard.forms.payment-methods.payment-method-card
                                            :payment-method="$payment_method" type="universal" class="mb-2">
                                        </livewire:dashboard.forms.payment-methods.payment-method-card>
                                    @endforeach
                                @endif

                            </div>
                            {{-- END Payments --}}

                            {{-- Integrations --}}
                            <div class="w-full px-5" x-show="current_tab === 'integrations'">
                                <ul role="list"
                                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                                    {{-- SMTP Mail --}}
                                    <li
                                        class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                        <div class="flex-1 flex flex-col p-8">
                                            <img src="https://wpmailsmtp.com/wp-content/uploads/2020/04/SMTP-com.jpg"
                                                class="h-8 logo-light object-contain">
                                            <h3 class="mt-6 text-gray-900 text-sm font-medium">{{
                                                translate('SMTP Mail') }}</h3>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="w-0 flex-1 flex">
                                                    <a @click="$dispatch('display-modal', {'id': 'app-settings-smtp-mail'})"
                                                        class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                                        <span class="ml-2">{{ translate('Edit') }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <x-system.form-modal id="app-settings-smtp-mail" title="SMTP Mail">
                                        <div class="w-full">
                                            <!-- SMTP Enabled-->
                                            <div class="flex flex-col mb-3" x-data="{}">
                                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                                    {{ translate('Enable SMTP') }}
                                                </label>

                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <x-dashboard.form.toggle field="settings.smtp_mail_enabled" />
                                                </div>
                                            </div>
                                            <!-- END SMTP Enabled -->

                                            <!-- SMTP Host-->
                                            <div class="flex flex-col mb-3" x-data="{}">
                                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                                    {{ translate('SMTP Host') }}
                                                </label>

                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <x-dashboard.form.input field="settings.smtp_mail_host" />
                                                </div>
                                            </div>
                                            <!-- END SMTP Host -->

                                            <!-- SMTP Post-->
                                            <div class="flex flex-col mb-3" x-data="{}">
                                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                                    {{ translate('SMTP Port') }}
                                                </label>

                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <x-dashboard.form.input field="settings.smtp_mail_port" />
                                                </div>
                                            </div>
                                            <!-- END SMTP Post -->

                                            <!-- SMTP Username-->
                                            <div class="flex flex-col mb-3" x-data="{}">
                                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                                    {{ translate('SMTP Username') }}
                                                </label>

                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <x-dashboard.form.input field="settings.smtp_mail_username" />
                                                </div>
                                            </div>
                                            <!-- END SMTP Username -->

                                            <!-- SMTP Password-->
                                            <div class="flex flex-col mb-3" x-data="{}">
                                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                                    {{ translate('SMTP Password') }}
                                                </label>

                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <x-dashboard.form.input type="password"
                                                        field="settings.smtp_mail_password" />
                                                </div>
                                            </div>
                                            <!-- END SMTP Password -->

                                            <!-- Mail From Address-->
                                            <div class="flex flex-col mb-3" x-data="{}">
                                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                                    {{ translate('From Address') }}
                                                </label>

                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <x-dashboard.form.input field="settings.mail_from_address" />
                                                </div>
                                            </div>
                                            <!-- END Mail From Address -->

                                            <!-- Mail From Name-->
                                            <div class="flex flex-col mb-3" x-data="{}">
                                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                                    {{ translate('From Name') }}
                                                </label>

                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <x-dashboard.form.input field="settings.mail_from_name"
                                                        placeholder="{{ translate('Site name is used by default') }}" />
                                                </div>
                                            </div>
                                            <!-- END Mail From Name -->

                                            <!-- Mail ReplyTo Address-->
                                            <div class="flex flex-col mb-3" x-data="{}">
                                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                                    {{ translate('Reply to Address') }}
                                                </label>

                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <x-dashboard.form.input field="settings.mail_reply_to_address" />
                                                </div>
                                            </div>
                                            <!-- END Mail ReplyTo Address -->

                                            <!-- Mail ReplyTo Name-->
                                            <div class="flex flex-col mb-3" x-data="{}">
                                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                                    {{ translate('Reply to Name') }}
                                                </label>

                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <x-dashboard.form.input field="settings.mail_reply_to_name"
                                                        placeholder="{{ translate('Site name is used by default') }}" />
                                                </div>
                                            </div>
                                            <!-- END Mail ReplyTo Name -->
                                        </div>

                                        <div class="w-full flex justify-end mt-4" x-data="{}">
                                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                                $wire.set('settings.smtp_mail_enabled', settings.smtp_mail_enabled, true);
                                            " wire:click="saveIntegrations('integrations.smtp_server')">
                                                {{ translate('Save') }}
                                            </button>
                                        </div>
                                    </x-system.form-modal>
                                    {{-- END SMTP Mail --}}

                                    {{-- MailerLite --}}
                                    <li
                                        class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                        <div class="flex-1 flex flex-col p-8">
                                            <svg data-v-235bc6c6="" viewBox="0 0 200 51" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" class="h-8 dark:hidden">
                                                <g data-v-235bc6c6="" id="mailerlite-light" stroke="none"
                                                    stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g data-v-235bc6c6="" fill-rule="nonzero">
                                                        <g data-v-235bc6c6="" id="mailer"
                                                            transform="translate(0.000000, 18.000000)" fill="#000000">
                                                            <path data-v-235bc6c6="" id="Shape"
                                                                d="M26.0798481,9.13105704 C22.7688413,9.13105704 20.1381784,10.4354938 18.2785718,12.9993866 C17.1900216,11.0202413 15.0129213,9.13105704 11.7019145,9.13105704 C8.30019514,9.13105704 6.3045198,10.6154161 4.89847582,12.1897363 L4.89847582,11.7399305 C4.89847582,10.4354938 3.80992564,9.35595993 2.49459417,9.35595993 C1.1792627,9.35595993 0.136068773,10.4354938 0.136068773,11.7399305 L0.136068773,29.8671028 C0.136068773,31.1715396 1.1792627,32.2060928 2.49459417,32.2060928 C3.80992564,32.2060928 4.89847582,31.1715396 4.89847582,29.8671028 L4.89847582,17.317522 C5.987026,15.5632795 7.61985127,13.5841341 10.568008,13.5841341 C13.380096,13.5841341 14.4686462,14.9335514 14.4686462,18.4420364 L14.4686462,29.8671028 C14.4686462,31.1715396 15.5118401,32.2060928 16.8271716,32.2060928 C18.142503,32.2060928 19.2310532,31.1715396 19.2310532,29.8671028 L19.2310532,17.317522 C20.3196034,15.5632795 21.9524287,13.5841341 24.9005854,13.5841341 C27.7126734,13.5841341 28.8012236,14.9335514 28.8012236,18.4420364 L28.8012236,29.8671028 C28.8012236,31.1715396 29.8444175,32.2060928 31.159749,32.2060928 C32.4750804,32.2060928 33.5636306,31.1715396 33.5636306,29.8671028 L33.5636306,17.6773666 C33.6543431,13.5391535 31.2958177,9.13105704 26.0798481,9.13105704 Z M48.9394019,9.13105704 C46.308739,9.13105704 43.9048573,9.62584339 41.4102632,10.7053772 C40.5484943,11.0652218 40.0042192,11.7849111 40.0042192,12.7295032 C40.0042192,13.8989982 40.9113443,14.7986097 42.0452508,14.7986097 C42.2266758,14.7986097 42.4534571,14.7536291 42.7255946,14.7086485 C44.4037762,14.1688816 45.9912452,13.7190759 48.2590581,13.7190759 C51.9329149,13.7190759 53.4750277,15.0684932 53.5203839,18.3970558 L48.8033332,18.3970558 C42.3627446,18.3970558 38.5528189,21.140871 38.5528189,25.6839092 C38.5528189,30.1369863 42.2720321,32.4759763 45.9458889,32.4759763 C48.8940457,32.4759763 51.4339961,31.5763648 53.5203839,29.8671028 L53.5203839,29.9120834 C53.5203839,31.2165201 54.5635779,32.2510734 55.8789093,32.2510734 C57.1942408,32.2510734 58.282791,31.2165201 58.282791,29.9120834 L58.282791,17.9472501 C58.282791,13.5391535 55.3799905,9.13105704 48.9394019,9.13105704 Z M47.3972892,28.1128604 C44.72127,28.1128604 43.315226,27.1232877 43.315226,25.1891229 C43.315226,24.4694337 43.315226,22.310366 49.302252,22.310366 L53.4750277,22.310366 L53.4750277,25.2341035 C52.2504087,26.5835208 49.9372396,28.1128604 47.3972892,28.1128604 Z M67.6261801,0.674708649 C69.0775803,0.674708649 70.256843,1.84420364 70.256843,3.28358209 L70.256843,3.4635044 C70.256843,4.90288285 69.0775803,6.07237784 67.6261801,6.07237784 L67.3540425,6.07237784 C65.9026423,6.07237784 64.7233796,4.90288285 64.7233796,3.4635044 L64.7233796,3.28358209 C64.7233796,1.84420364 65.9026423,0.674708649 67.3540425,0.674708649 L67.6261801,0.674708649 Z M67.4901113,9.31097935 C68.850799,9.31097935 69.8939929,10.3905132 69.8939929,11.6949499 L69.8939929,29.8221223 C69.8939929,31.126559 68.850799,32.1611122 67.4901113,32.1611122 C66.1747798,32.1611122 65.1315859,31.126559 65.1315859,29.8221223 L65.1315859,11.6949499 C65.1315859,10.3455326 66.1747798,9.31097935 67.4901113,9.31097935 Z M79.6002321,1.77635684e-15 C80.9609198,1.77635684e-15 82.0041137,1.07953384 82.0041137,2.38397056 L82.0041137,29.8221223 C82.0041137,31.126559 80.9609198,32.1611122 79.6002321,32.1611122 C78.2849006,32.1611122 77.2417067,31.126559 77.2417067,29.8221223 L77.2417067,2.38397056 C77.2417067,1.03455326 78.2849006,1.77635684e-15 79.6002321,1.77635684e-15 Z M98.5137915,9.13105704 C95.1120721,9.13105704 92.2999842,10.3905132 90.3950214,12.7744837 C88.7621961,14.8435903 87.8550709,17.6773666 87.8550709,20.7810264 C87.8550709,28.0678798 92.1639154,32.4309957 99.3302041,32.4309957 C103.276199,32.4309957 105.226518,31.5313842 106.995412,30.4968309 C107.857181,30.0020446 108.310743,29.2823553 108.310743,28.5626661 C108.310743,27.3931711 107.358262,26.448579 106.133643,26.448579 C105.770793,26.448579 105.453299,26.4935596 105.181161,26.6734819 C103.911186,27.3481906 102.323717,27.932938 99.6476979,27.932938 C95.6563472,27.932938 93.2978218,26.0887344 92.7081905,22.5802494 L106.632562,22.5802494 C108.038606,22.5802494 109.036443,21.5906768 109.036443,20.2412595 C109.127156,12.5945614 103.639049,9.13105704 98.5137915,9.13105704 Z M98.5137915,13.2692701 C100.509467,13.2692701 103.86583,14.3937845 104.319392,18.5319975 L92.7081905,18.5319975 C93.1617531,14.8885708 95.8831285,13.2692701 98.5137915,13.2692701 Z M125.68219,9.13105704 C126.997521,9.13105704 127.995359,10.1206297 127.995359,11.4250664 C127.995359,12.7295032 126.997521,13.6740953 125.591477,13.6740953 L125.364696,13.6740953 C122.915458,13.6740953 120.738358,14.8885708 119.196245,17.0926191 L119.196245,29.8221223 C119.196245,31.126559 118.107695,32.1611122 116.792363,32.1611122 C115.477032,32.1611122 114.433838,31.126559 114.433838,29.8221223 L114.433838,11.6949499 C114.433838,10.3905132 115.477032,9.31097935 116.792363,9.31097935 C118.107695,9.31097935 119.196245,10.3905132 119.196245,11.6949499 L119.196245,12.2796974 C121.101208,10.2105909 123.187596,9.13105704 125.455408,9.13105704 L125.68219,9.13105704 Z">
                                                            </path>
                                                        </g>
                                                        <g data-v-235bc6c6="" id="lite"
                                                            transform="translate(137.000000, 0.000000)">
                                                            <path data-v-235bc6c6="" id="Shape-path"
                                                                d="M55.9642336,0.364285714 L7.03576642,0.364285714 C3.2649635,0.364285714 0.137956204,3.46071429 0.137956204,7.19464286 L0.137956204,29.9625 L0.137956204,34.425 L0.137956204,50.5901786 L9.65693431,41.2553571 L56.010219,41.2553571 C59.7810219,41.2553571 62.9080292,38.1589286 62.9080292,34.425 L62.9080292,7.19464286 C62.8620438,3.41517857 59.7810219,0.364285714 55.9642336,0.364285714 Z"
                                                                fill="#09C269"></path>
                                                            <path data-v-235bc6c6="" id="Shape-path-3"
                                                                d="M46.9510949,16.2107143 C52.1934307,16.2107143 54.5846715,20.3544643 54.5846715,24.1794643 C54.5846715,25.2267857 53.8029197,25.9553571 52.7452555,25.9553571 L43.0883212,25.9553571 C43.5481752,28.2776786 45.2036496,29.5071429 47.8248175,29.5071429 C49.710219,29.5071429 50.7678832,29.0973214 51.6875912,28.6419643 C51.9175182,28.5053571 52.1474453,28.4598214 52.4233577,28.4598214 C53.3430657,28.4598214 54.0788321,29.1883929 54.0788321,30.0991071 C54.0788321,30.6910714 53.7109489,31.2375 53.0671533,31.6017857 C51.779562,32.3303571 50.4,32.9678571 47.5489051,32.9678571 C42.3985401,32.9678571 39.2715328,29.8258929 39.2715328,24.5892857 C39.2715328,18.4419643 43.410219,16.2107143 46.9510949,16.2107143 Z M31.5919708,13.5241071 C32.189781,13.5241071 32.6036496,13.9794643 32.6036496,14.5714286 L32.6036496,16.4839286 L35.5467153,16.4839286 C36.4664234,16.4839286 37.2021898,17.2125 37.2021898,18.1232143 C37.2021898,19.0339286 36.4664234,19.7625 35.5467153,19.7625 L32.649635,19.7625 L32.649635,28.3232143 C32.649635,29.5526786 33.2934307,29.64375 34.1671533,29.64375 C34.6729927,29.64375 34.9489051,29.5526786 35.2248175,29.5071429 C35.4547445,29.4616071 35.6846715,29.3705357 35.9605839,29.3705357 C36.6963504,29.3705357 37.5240876,29.9625 37.5240876,30.91875 C37.4781022,31.5107143 37.1562044,32.0571429 36.5583942,32.3303571 C35.6846715,32.7401786 34.8109489,32.9223214 33.8452555,32.9223214 C30.6722628,32.9223214 28.9708029,31.4196429 28.9708029,28.5508929 L28.9708029,19.7625 L27.3153285,19.7625 C26.7175182,19.7625 26.3036496,19.3071429 26.3036496,18.7607143 C26.3036496,18.4419643 26.4416058,18.1232143 26.7175182,17.8955357 L30.7642336,13.9339286 C30.8562044,13.8428571 31.1781022,13.5241071 31.5919708,13.5241071 Z M12.9678832,9.79017857 C13.979562,9.79017857 14.8072993,10.6098214 14.8072993,11.6116071 L14.8072993,30.9642857 C14.8072993,31.9660714 13.979562,32.7401786 12.9678832,32.7401786 C11.9562044,32.7401786 11.1744526,31.9205357 11.1744526,30.9642857 L11.1744526,11.6116071 C11.1744526,10.6098214 11.9562044,9.79017857 12.9678832,9.79017857 Z M21.5211679,16.3473214 C22.5328467,16.3473214 23.3605839,17.1669643 23.3605839,18.16875 L23.3605839,30.9642857 C23.3605839,31.9660714 22.5328467,32.7401786 21.5211679,32.7401786 C20.5094891,32.7401786 19.7277372,31.9205357 19.7277372,30.9642857 L19.7277372,18.16875 C19.7277372,17.1669643 20.5094891,16.3473214 21.5211679,16.3473214 Z M46.9970803,19.44375 C45.249635,19.44375 43.410219,20.4910714 43.0883212,22.9044643 L50.9518248,22.9044643 C50.5839416,20.4910714 48.7445255,19.44375 46.9970803,19.44375 Z M21.6131387,10.2455357 C22.7167883,10.2455357 23.5905109,11.1107143 23.5905109,12.2035714 L23.5905109,12.3401786 C23.5905109,13.4330357 22.7167883,14.2982143 21.6131387,14.2982143 L21.4291971,14.2982143 C20.3255474,14.2982143 19.4518248,13.4330357 19.4518248,12.3401786 L19.4518248,12.2035714 C19.4518248,11.1107143 20.3255474,10.2455357 21.4291971,10.2455357 L21.6131387,10.2455357 Z"
                                                                fill="#FFFFFF"></path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                            <h3 class="mt-6 text-gray-900 text-sm font-medium">{{
                                                translate('MailerLite') }}</h3>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="w-0 flex-1 flex">
                                                    <div @click="$dispatch('display-modal', {'id': 'app-settings-mailerlite'})"
                                                        class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                                        <span class="ml-2">{{ translate('Edit') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <x-system.form-modal id="app-settings-mailerlite" title="MailerLite">
                                        <!-- MailerLite API Token-->
                                        <div class="flex flex-col" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('MailerLite API Token') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.input field="settings.mailerlite_api_token" />
                                            </div>
                                        </div>
                                        <!-- END MailerLite API Token -->

                                        <div class="w-full flex justify-end mt-4" x-data="{}">
                                            <button type="button" class="btn btn-primary ml-auto btn-sm"
                                                wire:click="saveIntegrations('integrations.mailerlite')">
                                                {{ translate('Save') }}
                                            </button>
                                        </div>
                                    </x-system.form-modal>
                                    {{-- END MailerLite --}}

                                    {{-- MailerSend --}}
                                    <li
                                        class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                        <div class="flex-1 flex flex-col p-8">
                                            <img src="https://app.mailersend.com/images/logo/mailersend.svg"
                                                class="h-8 logo-light">
                                            <h3 class="mt-6 text-gray-900 text-sm font-medium">{{
                                                translate('MailerSend') }}</h3>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="w-0 flex-1 flex">
                                                    <a @click="$dispatch('display-modal', {'id': 'app-settings-mailersend'})"
                                                        class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                                        <span class="ml-2">{{ translate('Edit') }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <x-system.form-modal id="app-settings-mailersend" title="MailerSend"
                                        class="!max-w-3xl">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:divide-x">
                                            <div class="col-span-1">
                                                <!-- MailerSend API Token-->
                                                <div class="flex flex-col mb-3" x-data="{}">
                                                    <label class="block text-sm font-medium text-gray-900 mb-2">
                                                        {{ translate('MailerSend API Token') }}
                                                    </label>

                                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                        <x-dashboard.form.input field="settings.mailersend_api_token" />
                                                    </div>
                                                </div>
                                                <!-- END MailerSend API Token -->
                                            </div>
                                            <div class="col-span-1 md:pl-5">
                                                {{-- Transactional Emails Templates IDs --}}

                                                {{--
                                                <!-- User Welcome Email-->
                                                <div class="flex flex-col mb-3" x-data="{}">
                                                    <label class="block text-sm font-medium text-gray-900 mb-2">
                                                        {{ translate('User Welcome Email ') }}
                                                    </label>

                                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                        <x-dashboard.form.input
                                                            field="settings.transactional_email_templates_list.user_welcome_email.en" />
                                                    </div>
                                                </div>
                                                <!-- END User Welcome Email- -->

                                                <!-- User Verification Email-->
                                                <div class="flex flex-col mb-3" x-data="{}">
                                                    <label class="block text-sm font-medium text-gray-900 mb-2">
                                                        {{ translate('User Verification Email') }}
                                                    </label>

                                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                        <x-dashboard.form.input
                                                            field="settings.transactional_email_templates_list.user_welcome_email.en" />
                                                    </div>
                                                </div>
                                                <!-- END User Verification Email- --> --}}
                                            </div>
                                        </div>



                                        <div class="w-full flex justify-end mt-4" x-data="{}">
                                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                                $wire.set('settings.transactional_email_templates_list', settings.transactional_email_templates_list, true);
                                            " wire:click="saveIntegrations('integrations.mailersend')">
                                                {{ translate('Save') }}
                                            </button>
                                        </div>
                                    </x-system.form-modal>
                                    {{-- END MailSend --}}

                                    {{-- Google Analytics --}}
                                    <li
                                        class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                        <div class="flex-1 flex flex-col p-8">
                                            <img class="devsite-product-logo h-[32px]" alt="Google Analytics"
                                                src="https://www.gstatic.com/analytics-suite/header/suite/v2/ic_analytics.svg"
                                                loading="lazy">
                                            <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ translate('Google
                                                Analytics') }}</h3>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="w-0 flex-1 flex">
                                                    <div @click="$dispatch('display-modal', {'id': 'app-settings-google-analytics'})"
                                                        class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                                        <span class="ml-2">{{ translate('Edit') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <x-system.form-modal id="app-settings-google-analytics" title="Google Analytics">
                                        <!-- Google Analytics Enabled-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Enable Google Analytics') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.toggle field="settings.google_analytics_enabled" />
                                            </div>
                                        </div>
                                        <!-- END Google Analytics Enabled -->

                                        <!-- Gtag ID-->
                                        <div class="flex flex-col" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Gtag ID') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.input field="settings.gtag_id" />
                                            </div>
                                        </div>
                                        <!-- END Gtag ID -->

                                        <div class="w-full flex justify-end mt-4" x-data="{}">
                                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                            $wire.set('settings.google_analytics_enabled', settings.google_analytics_enabled, true);
                                        " wire:click="saveIntegrations('integrations.google_analytics')">
                                                {{ translate('Save') }}
                                            </button>
                                        </div>
                                    </x-system.form-modal>
                                    {{-- END Google Analytics --}}

                                    {{-- Google ReCaptcha --}}
                                    <li
                                        class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                        <div class="flex-1 flex flex-col p-8">
                                            <img class="mx-auto h-[32px]" alt="Google Analytics"
                                                src="https://www.google.com/recaptcha/about/images/reCAPTCHA-logo@2x.png"
                                                loading="lazy">
                                            <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ translate('Google
                                                Recaptcha') }}</h3>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="w-0 flex-1 flex">
                                                    <div @click="$dispatch('display-modal', {'id': 'app-settings-google-recaptcha'})"
                                                        class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                                        <span class="ml-2">{{ translate('Edit') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <x-system.form-modal id="app-settings-google-recaptcha" title="Google Recaptcha">
                                        <!-- Google Recaptcha Enabled-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Enable Google Recaptcha') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.toggle field="settings.google_recaptcha_enabled" />
                                            </div>
                                        </div>
                                        <!-- END Google Recaptcha Enabled -->

                                        <!-- Google Recaptcha Site Key-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Site Key') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.input field="settings.google_recaptcha_site_key" />
                                            </div>
                                        </div>
                                        <!-- END Google Recaptcha Site Key -->

                                        <!-- Google Recaptcha Secret Key-->
                                        <div class="flex flex-col" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Secret Key') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.input field="settings.google_recaptcha_secret_key" />
                                            </div>
                                        </div>
                                        <!-- END Google Recaptcha Secret Key -->

                                        <div class="w-full flex justify-end mt-4" x-data="{}">
                                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                            $wire.set('settings.google_recaptcha_enabled', settings.google_recaptcha_enabled, true);
                                        " wire:click="saveIntegrations('integrations.google_recaptcha')">
                                                {{ translate('Save') }}
                                            </button>
                                        </div>
                                    </x-system.form-modal>
                                    {{-- END Google ReCaptcha --}}

                                    {{-- WP API --}}
                                    <li
                                        class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                        <div class="flex-1 flex flex-col p-8">
                                            <img class="mx-auto h-[32px]" alt="Google Analytics"
                                                src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://upload.wikimedia.org/wikipedia/commons/thumb/2/20/WordPress_logo.svg/1280px-WordPress_logo.svg.png@webp"
                                                loading="lazy">
                                            <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ translate('WordPress
                                                API')
                                                }}</h3>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="w-0 flex-1 flex">
                                                    <div @click="$dispatch('display-modal', {'id': 'app-settings-wordpress-api'})"
                                                        class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                                        <span class="ml-2">{{ translate('Edit') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <x-system.form-modal id="app-settings-wordpress-api" title="WordPress API">
                                        <!-- WordPress API Enabled-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Enable WordPress API') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.toggle field="settings.wordpress_api_enabled" />
                                            </div>
                                        </div>
                                        <!-- END WordPress API Enabled -->

                                        <!-- WordPress API Route-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('WordPress API Route') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.input field="settings.wordpress_api_route" />
                                            </div>
                                        </div>
                                        <!-- END WordPress API Route -->

                                        <div class="w-full flex justify-end mt-4" x-data="{}">
                                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                                        $wire.set('settings.wordpress_api_enabled', settings.wordpress_api_enabled, true);
                                                    " wire:click="saveIntegrations('integrations.wordpress_api')">
                                                {{ translate('Save') }}
                                            </button>
                                        </div>
                                    </x-system.form-modal>
                                    {{-- END WP API --}}

                                    {{-- Woo Import --}}
                                    <li
                                        class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                        <div class="flex-1 flex flex-col p-8">
                                            <img class="mx-auto h-[32px]" alt="Google Analytics"
                                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/WooCommerce_logo.svg/1200px-WooCommerce_logo.svg.png"
                                                loading="lazy">
                                            <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ translate('WooCommerce
                                                Import') }}</h3>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="w-0 flex-1 flex">
                                                    <div @click="$dispatch('display-modal', {'id': 'app-settings-woo-import'})"
                                                        class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                                        <span class="ml-2">{{ translate('Edit') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <x-system.form-modal id="app-settings-woo-import" title="Woo Import">
                                        <!-- Woo Import Enabled-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Enable WooCommerce Import') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.toggle field="settings.woo_import_enabled" />
                                            </div>
                                        </div>
                                        <!-- END Google Recaptcha Enabled -->

                                        <!-- Google Recaptcha Site Key-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('REST API Key') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.input field="settings.woo_import_api_key" />
                                            </div>
                                        </div>
                                        <!-- END Google Recaptcha Site Key -->

                                        <!-- Google Recaptcha Secret Key-->
                                        <div class="flex flex-col" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Secret Key') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.input
                                                    field="settings.woo_import_rest_api_secret_key" />
                                            </div>
                                        </div>
                                        <!-- END Woo Rest API Secret Key -->

                                        <div class="w-full flex justify-end mt-4" x-data="{}">
                                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                            $wire.set('settings.woo_import_enabled', settings.woo_import_enabled, true);
                                        " wire:click="saveIntegrations('integrations.woo_import')">
                                                {{ translate('Save') }}
                                            </button>
                                        </div>
                                    </x-system.form-modal>
                                    {{-- END Woo Import --}}

                                    {{-- Woo Export --}}
                                    <li
                                        class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                        <div class="flex-1 flex flex-col p-8">
                                            <img class="mx-auto h-[32px]" alt="Google Analytics"
                                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/WooCommerce_logo.svg/1200px-WooCommerce_logo.svg.png"
                                                loading="lazy">
                                            <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ translate('WooCommerce
                                                Export') }}</h3>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="w-0 flex-1 flex">
                                                    <div @click="$dispatch('display-modal', {'id': 'app-settings-woo-export'})"
                                                        class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                                        <span class="ml-2">{{ translate('Edit') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <x-system.form-modal id="app-settings-woo-export" title="Woo Export">
                                        <!-- Woo Import Enabled-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Enable WooCommerce Export') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.toggle field="settings.woo_export_enabled" />
                                            </div>
                                        </div>
                                        <!-- END Google Recaptcha Enabled -->

                                        <!-- Google Recaptcha Site Key-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('REST API Key') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.input field="settings.woo_export_api_key" />
                                            </div>
                                        </div>
                                        <!-- END Google Recaptcha Site Key -->

                                        <!-- Google Recaptcha Secret Key-->
                                        <div class="flex flex-col" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Secret Key') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.input
                                                    field="settings.woo_export_rest_api_secret_key" />
                                            </div>
                                        </div>
                                        <!-- END Woo Rest API Secret Key -->

                                        <div class="w-full flex justify-end mt-4" x-data="{}">
                                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                            $wire.set('settings.woo_import_enabled', settings.woo_import_enabled, true);
                                        " wire:click="saveIntegrations('integrations.woo_export')">
                                                {{ translate('Save') }}
                                            </button>
                                        </div>
                                    </x-system.form-modal>
                                    {{-- END Woo Export --}}


                                    {{-- Facebook Pixel --}}
                                    <li
                                        class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                        <div class="flex-1 flex flex-col p-8">
                                            <img class="mx-auto h-[32px]" alt="Facebook Pixel"
                                                src="https://integrations.clickmeeting.com/wp-content/uploads/2018/03/facebook-pixel-logotyp.png"
                                                loading="lazy">
                                            <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ translate('Facebook
                                                Pixel') }}</h3>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="w-0 flex-1 flex">
                                                    <div @click="$dispatch('display-modal', {'id': 'app-settings-facebook-pixel'})"
                                                        class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                                        <span class="ml-2">{{ translate('Edit') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <x-system.form-modal id="app-settings-facebook-pixel" title="Facebook Pixel">
                                        <!-- Facebook Pixel Facebook PixelEnabled-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Enable Facebook Pixel') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.toggle field="settings.facebook_pixel_enabled" />
                                            </div>
                                        </div>
                                        <!-- END Facebook Pixel Enabled -->

                                        <!-- Facebook Pixel ID-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Pixel ID') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.input field="settings.facebook_pixel_id" />
                                            </div>
                                        </div>
                                        <!-- END Facebook Pixel ID -->

                                        <div class="w-full flex justify-end mt-4" x-data="{}">
                                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                            $wire.set('settings.facebook_pixel_enabled', settings.facebook_pixel_enabled, true);
                                        " wire:click="saveIntegrations('integrations.facebook_pixel')">
                                                {{ translate('Save') }}
                                            </button>
                                        </div>
                                    </x-system.form-modal>
                                    {{-- END Facebook Pixel --}}

                                    {{-- Google Tag Manager --}}
                                    <li
                                        class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                        <div class="flex-1 flex flex-col p-8">
                                            <img class="mx-auto h-[32px]"
                                                src="https://www.gstatic.com/analytics-suite/header/suite/v2/ic_tag_manager.svg"
                                                loading="lazy">
                                            <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ translate('Google Tag
                                                Manager') }}</h3>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="w-0 flex-1 flex">
                                                    <div @click="$dispatch('display-modal', {'id': 'app-settings-google_tag_manager'})"
                                                        class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                                        <span class="ml-2">{{ translate('Edit') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <x-system.form-modal id="app-settings-google_tag_manager"
                                        title="Google Tag Manager">
                                        <!-- Google Tag Manager Pixel Enabled-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Enable Google Tag Manager') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.toggle field="settings.google_tag_manager_enabled" />
                                            </div>
                                        </div>
                                        <!-- END Google Tag Manager Enabled -->

                                        <!-- Google tags manager ID-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Google Tag Manager ID') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.input field="settings.google_tag_manager_id" />
                                            </div>
                                        </div>
                                        <!-- END  Google tags manager ID -->

                                        <div class="w-full flex justify-end mt-4" x-data="{}">
                                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                            $wire.set('settings.google_tag_manager_enabled', settings.google_tag_manager_enabled, true);
                                        " wire:click="saveIntegrations('integrations.google_tag_manager')">
                                                {{ translate('Save') }}
                                            </button>
                                        </div>
                                    </x-system.form-modal>
                                    {{-- END Google Tag Manager --}}


                                    {{-- Hubspot --}}
                                    <li
                                        class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                        <div class="flex-1 flex flex-col p-8">
                                            <img class="devsite-product-logo w-auto" alt="Hubspot logo"
                                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/HubSpot_Logo.svg/2560px-HubSpot_Logo.svg.png"
                                                loading="lazy">
                                            <h3 class="mt-6 text-gray-900 text-sm font-medium">
                                                {{ translate('Hubspot') }}</h3>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="w-0 flex-1 flex">
                                                    <div @click="$dispatch('display-modal', {'id': 'app-settings-hubspot'})"
                                                        class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                                        <span class="ml-2">{{ translate('Edit') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <x-system.form-modal id="app-settings-hubspot" title="Hubspot">
                                        <!-- Google Analytics Enabled-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Enable Hubspot') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.toggle field="settings.hubspot_enabled" />
                                            </div>
                                        </div>
                                        <!-- END Google Analytics Enabled -->

                                        <!-- Gtag ID-->
                                        <div class="flex flex-col" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Hubspot ID') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.input field="settings.hubspot_id" />
                                            </div>
                                        </div>
                                        <!-- END Gtag ID -->

                                        <div class="w-full flex justify-end mt-4" x-data="{}">
                                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                            $wire.set('settings.hubspot_enabled', settings.hubspot_enabled, true);
                                        " wire:click="saveIntegrations('integrations.hubspot')">
                                                {{ translate('Save') }}
                                            </button>
                                        </div>
                                    </x-system.form-modal>
                                    {{-- END Hubspot --}}

                                    {{-- Dokobit --}}
                                    <li
                                        class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                        <div class="flex-1 flex flex-col p-8">
                                            <img class="devsite-product-logo w-auto" alt="Dokobit logo"
                                                src="https://www.dokobit.com/wp-content/uploads/2021/02/Dokobit-logo-media.png"
                                                loading="lazy">
                                            <h3 class="mt-6 text-gray-900 text-sm font-medium">
                                                {{ translate('Dokobit') }}</h3>
                                        </div>
                                        <div>
                                            <div class="-mt-px flex divide-x divide-gray-200">
                                                <div class="w-0 flex-1 flex">
                                                    <div @click="$dispatch('display-modal', {'id': 'app-settings-dokobit'})"
                                                        class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                                        <span class="ml-2">{{ translate('Edit') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <x-system.form-modal id="app-settings-dokobit" title="Dokobit">
                                        <!-- Dokobit Enabled-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Enable Dokobit') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.toggle field="settings.dokobit_enabled" />
                                            </div>
                                        </div>
                                        <!-- END Dokobit Enabled -->

                                        <!-- Dokobit Api Key-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Dokobit Aip Key') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.input field="settings.dokobit_api_key" />
                                            </div>
                                        </div>
                                        <!-- END Dokobit Api Key-->

                                        <!-- Dokobit Sandbox-->
                                        <div class="flex flex-col mb-3" x-data="{}">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                {{ translate('Dokobit Sandbox') }}
                                            </label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <x-dashboard.form.toggle field="settings.dokobit_sandbox" />
                                            </div>
                                        </div>
                                        <!-- END Dokobit Sandbox -->

                                        <div class="w-full flex justify-end mt-4" x-data="{}">
                                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                            $wire.set('settings.dokobit_enabled', settings.dokobit_enabled, true);
                                            $wire.set('settings.dokobit_sandbox', settings.dokobit_sandbox, true);
                                        " wire:click="saveIntegrations('integrations.dokobit')">
                                                {{ translate('Save') }}
                                            </button>
                                        </div>
                                    </x-system.form-modal>
                                    {{-- END Dokobit --}}

                                    @do_action('view.integrations.end')
                                </ul>
                            </div>
                            {{-- END Integrations --}}

                            {{-- Advanced --}}
                            <div class="w-full px-5" x-show="current_tab === 'advanced'">
                                {{-- User meta in use --}}
                                <div class="flex flex-col" x-data="{
                                    all_user_meta: @js(\App\Models\UserMeta::metaDataTypes()),
                                    toggleField(key) {
                                        if(settings.user_meta_fields_in_use == null || settings.user_meta_fields_in_use == undefined) {
                                            settings.user_meta_fields_in_use = {};
                                        }

                                        if(settings.user_meta_fields_in_use.hasOwnProperty(key)) {
                                            delete settings.user_meta_fields_in_use[key];
                                        } else {
                                            settings.user_meta_fields_in_use[key] = {
                                                'required': false,
                                                'onboarding': false,
                                                'registration': false,
                                                'type': this.all_user_meta[key],
                                                'order': 0,
                                                'entity': 'individual'
                                            };
                                        }
                                    },
                                    toggleProperty(key, property) {
                                        if(_.get(settings.user_meta_fields_in_use, key+'.'+property, null) === null) {
                                            _.set(settings.user_meta_fields_in_use, key+'.'+property, false); // if it doesn't exist, set it!
                                        }

                                        if(_.get(settings.user_meta_fields_in_use, key+'.'+property, null) === false) {
                                            _.set(settings.user_meta_fields_in_use, key+'.'+property, true);
                                        } else {
                                            _.set(settings.user_meta_fields_in_use, key+'.'+property, false);
                                        }
                                    },
                                    initFields() {
                                        if(settings.user_meta_fields_in_use != null && typeof settings.user_meta_fields_in_use === 'object') {
                                            for (const key in settings.user_meta_fields_in_use) {
                                                settings.user_meta_fields_in_use[key]['type'] = this.all_user_meta[key];
                                            }
                                        }
                                    }
                                }" x-init="initFields()">
                                    <div class="flex flex-col mb-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('User meta fields
                                            in use') }}</span>
                                        <p class="text-gray-500 text-sm">{{ translate('Here you can enable/disable which
                                            metadata should be visible and editable for all user accounts. You can also
                                            set if specific meta is required or not.') }}</p>
                                    </div>

                                    <div class="flex items-center">
                                        <button type="button"
                                            @click="$dispatch('display-modal', {'id': 'app-settings-user_meta_fields_in_use'})"
                                            class="btn-primary">
                                            {{ translate('Edit fields')}}
                                        </button>
                                    </div>

                                    <x-system.form-modal id="app-settings-user_meta_fields_in_use"
                                        title="User meta fields in use" class="sm:max-w-3xl">
                                        <!-- User meta fields in use-->
                                        <div class="mt-0 flex flex-col">
                                            <div class="overflow-x-auto ">
                                                <div class="inline-block min-w-full py-2 px-1 align-middle">
                                                    <div class="shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                                        <table class="min-w-full divide-y divide-gray-300">
                                                            <thead class="bg-gray-50">
                                                                <tr>
                                                                    <th scope="col"
                                                                        class="py-1 px-3 text-left text-sm font-semibold text-gray-900">
                                                                        {{ translate('Meta') }}</th>
                                                                    <th scope="col"
                                                                        class="px-1 py-1 text-center text-sm font-semibold text-gray-900">
                                                                        {{ translate('Use') }}</th>
                                                                    <th scope="col"
                                                                        class="px-1 py-1 text-center text-sm font-semibold text-gray-900">
                                                                        {{ translate('Required') }}</th>
                                                                    <th scope="col"
                                                                        class="px-1 py-1 text-center text-sm font-semibold text-gray-900">
                                                                        {{ translate('Onboarding') }}</th>
                                                                    <th scope="col"
                                                                        class="px-1 py-1 text-center text-sm font-semibold text-gray-900">
                                                                        {{ translate('Registration') }}</th>
                                                                    <th scope="col"
                                                                        class="px-1 py-1 text-center text-sm font-semibold text-gray-900">
                                                                        {{ translate('Ordering') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200 bg-white">
                                                                <template x-for="(type, key) in all_user_meta">
                                                                    <tr>
                                                                        <td class="whitespace-nowrap py-2 px-3 text-14 font-medium text-gray-900 "
                                                                            x-text="key"></td>
                                                                        <td
                                                                            class="whitespace-nowrap px-1 py-2 text-sm text-gray-500 text-center">
                                                                            <button type="button"
                                                                                @click="toggleField(key)"
                                                                                :class="{'bg-primary': _.get(settings.user_meta_fields_in_use, key, null) !== null , 'bg-gray-200':_.get(settings.user_meta_fields_in_use, key, null) === null}"
                                                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                                                role="switch">
                                                                                <span
                                                                                    :class="{'translate-x-5':_.get(settings.user_meta_fields_in_use, key, null) !== null, 'translate-x-0':_.get(settings.user_meta_fields_in_use, key, null) === null}"
                                                                                    class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                                                            </button>
                                                                        </td>
                                                                        <td
                                                                            class="whitespace-nowrap px-1 py-2 text-sm text-gray-500 text-center">
                                                                            <button type="button"
                                                                                @click="toggleProperty(key, 'required')"
                                                                                x-show="_.get(settings.user_meta_fields_in_use, key, null) !== null"
                                                                                :class="{'bg-primary': _.get(settings.user_meta_fields_in_use, key+'.required', false) !== false , 'bg-gray-200':_.get(settings.user_meta_fields_in_use, key+'.required', false) === false}"
                                                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                                                role="switch">
                                                                                <span
                                                                                    :class="{'translate-x-5':_.get(settings.user_meta_fields_in_use, key+'.required', false) !== false, 'translate-x-0':_.get(settings.user_meta_fields_in_use, key+'.required', false) === false}"
                                                                                    class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                                                            </button>
                                                                        </td>
                                                                        <td
                                                                            class="whitespace-nowrap px-1 py-2 text-sm text-gray-500 text-center">
                                                                            <button type="button"
                                                                                @click="toggleProperty(key, 'onboarding')"
                                                                                x-show="_.get(settings.user_meta_fields_in_use, key, null) !== null"
                                                                                :class="{'bg-primary': _.get(settings.user_meta_fields_in_use, key+'.onboarding', false) !== false , 'bg-gray-200':_.get(settings.user_meta_fields_in_use, key+'.onboarding', false) === false}"
                                                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                                                role="switch">
                                                                                <span
                                                                                    :class="{'translate-x-5':_.get(settings.user_meta_fields_in_use, key+'.onboarding', false) !== false, 'translate-x-0':_.get(settings.user_meta_fields_in_use, key+'.onboarding', false) === false}"
                                                                                    class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                                                            </button>
                                                                        </td>
                                                                        <td
                                                                            class="whitespace-nowrap px-1 py-2 text-sm text-gray-500 text-center">
                                                                            <button type="button"
                                                                                @click="toggleProperty(key, 'registration')"
                                                                                x-show="_.get(settings.user_meta_fields_in_use, key, null) !== null"
                                                                                :class="{'bg-primary': _.get(settings.user_meta_fields_in_use, key+'.registration', false) !== false , 'bg-gray-200':_.get(settings.user_meta_fields_in_use, key+'.registration', false) === false}"
                                                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                                                role="switch">
                                                                                <span
                                                                                    :class="{'translate-x-5':_.get(settings.user_meta_fields_in_use, key+'.registration', false) !== false, 'translate-x-0':_.get(settings.user_meta_fields_in_use, key+'.registration', false) === false}"
                                                                                    class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                                                            </button>
                                                                        </td>
                                                                        <td
                                                                            class="whitespace-nowrap px-1 py-2 text-sm text-gray-500 text-center">
                                                                            {{-- <input type="number" step="1" min="0"
                                                                                class="form-standard max-w-[60px]"
                                                                                x-model="settings.user_meta_fields_in_use[key].order" /> --}}
                                                                        </td>
                                                                    </tr>
                                                                </template>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END User meta fields in use -->

                                        <div class="w-full flex justify-end mt-4" x-data="{}">
                                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                                $wire.set('settings.user_meta_fields_in_use', settings.user_meta_fields_in_use, true);
                                            " wire:click="saveAdvanced('user_meta_fields')">
                                                {{ translate('Save') }}
                                            </button>
                                        </div>
                                    </x-system.form-modal>
                                </div>
                                {{-- END User meta in use --}}

                                <div class="w-full">
                                    {{-- Include phone number in registration --}}
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4"
                                        x-data="{}">
                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                            <span class="text-sm font-medium text-gray-900">
                                                {{ translate('Include phone number in registration') }}
                                            </span>
                                            <p class="text-gray-500 text-sm">
                                                {{ translate('Enable/Disable phone number in registration') }}
                                            </p>
                                        </div>

                                        <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                            <x-dashboard.form.toggle
                                                field="settings.include_phone_number_in_registration" />
                                        </div>
                                    </div>
                                    {{-- END Include phone number in registration --}}

                                    {{-- Require phone number in registration --}}
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-4 pt-5"
                                        x-data="{}">
                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                            <span class="text-sm font-medium text-gray-900">
                                                {{ translate('Require phone number in registration') }}
                                            </span>
                                        </div>

                                        <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                            <x-dashboard.form.toggle
                                                field="settings.require_phone_number_in_registration" />
                                        </div>
                                    </div>
                                    {{-- END Require phone number in registration --}}

                                    {{-- TODO: Add enable_phone_number_login and enable_2fa toggles --}}

                                    {{-- Save Registration settings --}}
                                    <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                        x-data="{}">
                                        <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                            $wire.set('settings.include_phone_number_in_registration', settings.include_phone_number_in_registration, true);
                                            $wire.set('settings.require_phone_number_in_registration', settings.require_phone_number_in_registration, true);
                                            {{-- $wire.set('settings.enable_phone_number_login', settings.enable_phone_number_login, true);
                                            $wire.set('settings.enable_2fa', settings.enable_2fa.code, true); --}}
                                        " wire:click="saveAdvanced('phone_number_registration')">
                                            {{ translate('Save') }}
                                        </button>
                                    </div>
                                    {{-- END Save Registration settings --}}
                                </div>


                            </div>
                            {{-- END Advanced --}}
                        </div>
                        {{-- END Tabs --}}


                    </div>
                </div>
            </div>
        </div>
    </div>
