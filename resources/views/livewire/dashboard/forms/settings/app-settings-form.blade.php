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

                                    <a href="#" @click="current_tab = 'integrations'" :class="{'border-primary text-primary':current_tab === 'integrations', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'integrations'}" class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                        @svg('lineawesome-plug-solid', ['class' => '-ml-0.5 mr-2 h-5 w-5'])
                                        <span>{{ translate('Integrations') }}</span>
                                    </a>

                                    <a href="#" @click="current_tab = 'advanced'" :class="{'border-primary text-primary':current_tab === 'advanced', 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-300':current_tab !== 'advanced'}" class="border-transparent group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
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
                                    <x-dashboard.form.toggle field="settings.maintenance_mode.value" />
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
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Theme selection') }}</span>
                                    <p class="text-gray-500 text-sm">{{ translate('If you want to change app theme') }}</p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <livewire:dashboard.forms.settings.theme-select-form />
                                </div>
                            </div>

                            <div class="grid grid-cols-12 mb-6  sm:border-t sm:border-gray-200 sm:pt-5 mt-4">
                                <div class="col-span-6 font-medium text-md">
                                    {{ translate('For generating color variants we recommend using this tool: ') }}
                                    <a href="https://tailwind.simeongriggs.dev/" class="text-indigo-600" target="_blank">Palette Generator </a>
                                </div>
                            </div>
                            {{-- Colors --}}
                            @php $i = 0; @endphp
                            @foreach(TenantSettings::settingsDataTypes()['colors'] as $color_key => $data_type)
                            @if($loop->first)
                            <div class="bg-indigo-400 p-6 rounded">
                            @endif
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start {{ $i === 0 ? '':'sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5' }}" x-data="{}">
                                    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                        {{ $color_key }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.input field="settings.colors.value.{{ $color_key }}" />
                                    </div>
                                </div>
                                @php $i++; @endphp
                                @if($loop->first)
                                    </div>
                                @endif
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
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start " x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Feed') }}</span>
                                    <p class="text-gray-500 text-sm">
                                        {{ translate('If you want to enable social feed page as a homepage') }}
                                    </p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <x-dashboard.form.toggle field="settings.feed_enabled.value" />
                                </div>
                            </div>
                            {{-- END Feed Feature --}}

                            {{-- Chat Feature --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Chat') }}</span>
                                    <p class="text-gray-500 text-sm">
                                        {{ translate('If you want to enable chat on website') }}
                                    </p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <x-dashboard.form.toggle field="settings.chat_feature.value" />
                                </div>
                            </div>
                            {{-- END Chat Feature --}}

                            {{-- WeEdit Feature --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('WeEdit') }}</span>
                                    <p class="text-gray-500 text-sm">
                                        {{ translate('Enable/Disable WeEdit page builder') }}
                                    </p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <x-dashboard.form.toggle field="settings.weedit_feature.value" />
                                </div>
                            </div>
                            {{-- END WeEdit Feature --}}

                            {{-- Multiplan Purchase Feature --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Multiplan purchase') }}</span>
                                    <p class="text-gray-500 text-sm">
                                        {{ translate('If you want enable that users can buy multiple plans and distribute them among other accounts via invite') }}
                                    </p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <x-dashboard.form.toggle field="settings.multiplan_purchase.value" />
                                </div>
                            </div>
                            {{-- END Multiplan Purchase Feature --}}

                            {{-- Onboarding flow --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Onboarding flow') }}</span>
                                    <p class="text-gray-500 text-sm">
                                        {{ translate('If you want newly registered users to go through onboarding flow after registration') }}
                                    </p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <x-dashboard.form.toggle field="settings.onboarding_flow.value" />
                                </div>

                                <div class="col-span-3" x-show="!settings.onboarding_flow.value">
                                    {{-- Force email verification --}}
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start mb-3" x-data="{}">
                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                            <span class="text-sm font-medium text-gray-900">{{ translate('Force email verification') }}:</span>
                                            <p class="text-gray-500 text-sm">
                                                {{ translate('Enable/Disable if users must verify their email address in order to preform some actions') }}
                                            </p>
                                        </div>
        
                                        <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                            <x-dashboard.form.toggle field="settings.force_email_verification.value" />
                                        </div>
                                    </div>
                                    {{-- END Force email verification --}}

                                    {{-- Register Redirect URL --}}
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  mb-3" x-data="{}">
                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                            <span class="text-sm font-medium text-gray-900">{{ translate('Registration Redirect URL') }}:</span>
                                            <p class="text-gray-500 text-sm">
                                                {{ translate('This is a URL where you want all your newly registered users to land after account creation') }}
                                            </p>
                                        </div>
        
                                        <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                            <x-dashboard.form.input field="settings.register_redirect_url.value" placeholder="{{ translate('Leave empty for email verification page') }}" />
                                        </div>
                                    </div>
                                    {{-- END Register Redirect URL --}}
    
                                    {{-- Login Redirect URL --}}
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">
                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                            <span class="text-sm font-medium text-gray-900">{{ translate('Login Redirect URL') }}:</span>
                                            <p class="text-gray-500 text-sm">
                                                {{ translate('This is a URL where you want your users to land after logging-in') }}
                                            </p>
                                        </div>
        
                                        <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                            <x-dashboard.form.input field="settings.login_redirect_url.value" placeholder="{{ translate('Leave empty for dashboard') }}"/>
                                        </div>
                                    </div>
                                    {{-- END Login Redirect URL --}}
                                </div>
                                
                            </div>
                            {{-- END Onboarding flow --}}

                            {{-- Wishlist Feature --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Wishlist') }}</span>
                                    <p class="text-gray-500 text-sm">
                                        {{ translate('Enable/Disable wishlists on website') }}
                                    </p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <x-dashboard.form.toggle field="settings.wishlist_feature.value" />
                                </div>
                            </div>
                            {{-- END Wishlist Feature --}}

                            {{-- Vendor Mode Feature --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Vendor Mode') }}</span>
                                    <p class="text-gray-500 text-sm">
                                        {{ translate('Enable/Disable single vendor mode (shops can add their domains and custom pages under multi-vendor platform)') }}
                                    </p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <x-dashboard.form.toggle field="settings.vendor_mode_feature.value" />
                                </div>
                            </div>
                            {{-- END Vendor Mode Feature --}}

                            {{-- Plans Trial Mode --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Plans trial mode') }}</span>
                                    <p class="text-gray-500 text-sm">
                                        {{ translate('Allow trial period on all your plans') }}
                                    </p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <x-dashboard.form.toggle field="settings.plans_trial_mode.value" />
                                </div>

                                <div class="col-span-3" x-show="settings.plans_trial_mode.value">
                                    {{-- Trial duration --}}
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">
                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                            <span class="text-sm font-medium text-gray-900">{{ translate('Trial duration (in days)') }}:</span>
                                            <p class="text-gray-500 text-sm">
                                                {{ translate('If you enable trial mode, you must specify trial duration') }}
                                            </p>
                                        </div>
        
                                        <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                            <x-dashboard.form.input field="settings.plans_trial_duration.value" min="1" type="number" placeholder="{{ translate('Number of trial days') }}" />
                                        </div>
                                    </div>
                                    {{-- END Trial duration --}}

                                </div>
                                
                            </div>
                            {{-- END Plans Trial Mode --}}

                            {{-- Save Features --}}
                            <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                <button type="button" class="btn btn-primary ml-auto btn-sm"
                                    @click="
                                        $wire.set('settings.feed_enabled.value', settings.feed_enabled.value, true);
                                        $wire.set('settings.multiplan_purchase.value', settings.multiplan_purchase.value, true);
                                        $wire.set('settings.onboarding_flow.value', settings.onboarding_flow.value, true);
                                        $wire.set('settings.force_email_verification.value', settings.force_email_verification.value, true);
                                        $wire.set('settings.chat_feature.value', settings.chat_feature.value, true);
                                        $wire.set('settings.weedit_feature.value', settings.weedit_feature.value, true);
                                        $wire.set('settings.wishlist_feature.value', settings.wishlist_feature.value, true);
                                        $wire.set('settings.vendor_mode_feature.value', settings.vendor_mode_feature.value, true);
                                        $wire.set('settings.plans_trial_mode.value', settings.plans_trial_mode.value, true);
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

                        {{-- Integrations --}}
                        <div class="w-full px-5" x-show="current_tab === 'integrations'">
                            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                                {{-- MailerLite --}}
                                <li class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                  <div class="flex-1 flex flex-col p-8">
                                    <svg data-v-235bc6c6="" viewBox="0 0 200 51" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="h-8 dark:hidden"><g data-v-235bc6c6="" id="mailerlite-light" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g data-v-235bc6c6="" fill-rule="nonzero"><g data-v-235bc6c6="" id="mailer" transform="translate(0.000000, 18.000000)" fill="#000000"><path data-v-235bc6c6="" id="Shape" d="M26.0798481,9.13105704 C22.7688413,9.13105704 20.1381784,10.4354938 18.2785718,12.9993866 C17.1900216,11.0202413 15.0129213,9.13105704 11.7019145,9.13105704 C8.30019514,9.13105704 6.3045198,10.6154161 4.89847582,12.1897363 L4.89847582,11.7399305 C4.89847582,10.4354938 3.80992564,9.35595993 2.49459417,9.35595993 C1.1792627,9.35595993 0.136068773,10.4354938 0.136068773,11.7399305 L0.136068773,29.8671028 C0.136068773,31.1715396 1.1792627,32.2060928 2.49459417,32.2060928 C3.80992564,32.2060928 4.89847582,31.1715396 4.89847582,29.8671028 L4.89847582,17.317522 C5.987026,15.5632795 7.61985127,13.5841341 10.568008,13.5841341 C13.380096,13.5841341 14.4686462,14.9335514 14.4686462,18.4420364 L14.4686462,29.8671028 C14.4686462,31.1715396 15.5118401,32.2060928 16.8271716,32.2060928 C18.142503,32.2060928 19.2310532,31.1715396 19.2310532,29.8671028 L19.2310532,17.317522 C20.3196034,15.5632795 21.9524287,13.5841341 24.9005854,13.5841341 C27.7126734,13.5841341 28.8012236,14.9335514 28.8012236,18.4420364 L28.8012236,29.8671028 C28.8012236,31.1715396 29.8444175,32.2060928 31.159749,32.2060928 C32.4750804,32.2060928 33.5636306,31.1715396 33.5636306,29.8671028 L33.5636306,17.6773666 C33.6543431,13.5391535 31.2958177,9.13105704 26.0798481,9.13105704 Z M48.9394019,9.13105704 C46.308739,9.13105704 43.9048573,9.62584339 41.4102632,10.7053772 C40.5484943,11.0652218 40.0042192,11.7849111 40.0042192,12.7295032 C40.0042192,13.8989982 40.9113443,14.7986097 42.0452508,14.7986097 C42.2266758,14.7986097 42.4534571,14.7536291 42.7255946,14.7086485 C44.4037762,14.1688816 45.9912452,13.7190759 48.2590581,13.7190759 C51.9329149,13.7190759 53.4750277,15.0684932 53.5203839,18.3970558 L48.8033332,18.3970558 C42.3627446,18.3970558 38.5528189,21.140871 38.5528189,25.6839092 C38.5528189,30.1369863 42.2720321,32.4759763 45.9458889,32.4759763 C48.8940457,32.4759763 51.4339961,31.5763648 53.5203839,29.8671028 L53.5203839,29.9120834 C53.5203839,31.2165201 54.5635779,32.2510734 55.8789093,32.2510734 C57.1942408,32.2510734 58.282791,31.2165201 58.282791,29.9120834 L58.282791,17.9472501 C58.282791,13.5391535 55.3799905,9.13105704 48.9394019,9.13105704 Z M47.3972892,28.1128604 C44.72127,28.1128604 43.315226,27.1232877 43.315226,25.1891229 C43.315226,24.4694337 43.315226,22.310366 49.302252,22.310366 L53.4750277,22.310366 L53.4750277,25.2341035 C52.2504087,26.5835208 49.9372396,28.1128604 47.3972892,28.1128604 Z M67.6261801,0.674708649 C69.0775803,0.674708649 70.256843,1.84420364 70.256843,3.28358209 L70.256843,3.4635044 C70.256843,4.90288285 69.0775803,6.07237784 67.6261801,6.07237784 L67.3540425,6.07237784 C65.9026423,6.07237784 64.7233796,4.90288285 64.7233796,3.4635044 L64.7233796,3.28358209 C64.7233796,1.84420364 65.9026423,0.674708649 67.3540425,0.674708649 L67.6261801,0.674708649 Z M67.4901113,9.31097935 C68.850799,9.31097935 69.8939929,10.3905132 69.8939929,11.6949499 L69.8939929,29.8221223 C69.8939929,31.126559 68.850799,32.1611122 67.4901113,32.1611122 C66.1747798,32.1611122 65.1315859,31.126559 65.1315859,29.8221223 L65.1315859,11.6949499 C65.1315859,10.3455326 66.1747798,9.31097935 67.4901113,9.31097935 Z M79.6002321,1.77635684e-15 C80.9609198,1.77635684e-15 82.0041137,1.07953384 82.0041137,2.38397056 L82.0041137,29.8221223 C82.0041137,31.126559 80.9609198,32.1611122 79.6002321,32.1611122 C78.2849006,32.1611122 77.2417067,31.126559 77.2417067,29.8221223 L77.2417067,2.38397056 C77.2417067,1.03455326 78.2849006,1.77635684e-15 79.6002321,1.77635684e-15 Z M98.5137915,9.13105704 C95.1120721,9.13105704 92.2999842,10.3905132 90.3950214,12.7744837 C88.7621961,14.8435903 87.8550709,17.6773666 87.8550709,20.7810264 C87.8550709,28.0678798 92.1639154,32.4309957 99.3302041,32.4309957 C103.276199,32.4309957 105.226518,31.5313842 106.995412,30.4968309 C107.857181,30.0020446 108.310743,29.2823553 108.310743,28.5626661 C108.310743,27.3931711 107.358262,26.448579 106.133643,26.448579 C105.770793,26.448579 105.453299,26.4935596 105.181161,26.6734819 C103.911186,27.3481906 102.323717,27.932938 99.6476979,27.932938 C95.6563472,27.932938 93.2978218,26.0887344 92.7081905,22.5802494 L106.632562,22.5802494 C108.038606,22.5802494 109.036443,21.5906768 109.036443,20.2412595 C109.127156,12.5945614 103.639049,9.13105704 98.5137915,9.13105704 Z M98.5137915,13.2692701 C100.509467,13.2692701 103.86583,14.3937845 104.319392,18.5319975 L92.7081905,18.5319975 C93.1617531,14.8885708 95.8831285,13.2692701 98.5137915,13.2692701 Z M125.68219,9.13105704 C126.997521,9.13105704 127.995359,10.1206297 127.995359,11.4250664 C127.995359,12.7295032 126.997521,13.6740953 125.591477,13.6740953 L125.364696,13.6740953 C122.915458,13.6740953 120.738358,14.8885708 119.196245,17.0926191 L119.196245,29.8221223 C119.196245,31.126559 118.107695,32.1611122 116.792363,32.1611122 C115.477032,32.1611122 114.433838,31.126559 114.433838,29.8221223 L114.433838,11.6949499 C114.433838,10.3905132 115.477032,9.31097935 116.792363,9.31097935 C118.107695,9.31097935 119.196245,10.3905132 119.196245,11.6949499 L119.196245,12.2796974 C121.101208,10.2105909 123.187596,9.13105704 125.455408,9.13105704 L125.68219,9.13105704 Z"></path></g> <g data-v-235bc6c6="" id="lite" transform="translate(137.000000, 0.000000)"><path data-v-235bc6c6="" id="Shape-path" d="M55.9642336,0.364285714 L7.03576642,0.364285714 C3.2649635,0.364285714 0.137956204,3.46071429 0.137956204,7.19464286 L0.137956204,29.9625 L0.137956204,34.425 L0.137956204,50.5901786 L9.65693431,41.2553571 L56.010219,41.2553571 C59.7810219,41.2553571 62.9080292,38.1589286 62.9080292,34.425 L62.9080292,7.19464286 C62.8620438,3.41517857 59.7810219,0.364285714 55.9642336,0.364285714 Z" fill="#09C269"></path> <path data-v-235bc6c6="" id="Shape-path-3" d="M46.9510949,16.2107143 C52.1934307,16.2107143 54.5846715,20.3544643 54.5846715,24.1794643 C54.5846715,25.2267857 53.8029197,25.9553571 52.7452555,25.9553571 L43.0883212,25.9553571 C43.5481752,28.2776786 45.2036496,29.5071429 47.8248175,29.5071429 C49.710219,29.5071429 50.7678832,29.0973214 51.6875912,28.6419643 C51.9175182,28.5053571 52.1474453,28.4598214 52.4233577,28.4598214 C53.3430657,28.4598214 54.0788321,29.1883929 54.0788321,30.0991071 C54.0788321,30.6910714 53.7109489,31.2375 53.0671533,31.6017857 C51.779562,32.3303571 50.4,32.9678571 47.5489051,32.9678571 C42.3985401,32.9678571 39.2715328,29.8258929 39.2715328,24.5892857 C39.2715328,18.4419643 43.410219,16.2107143 46.9510949,16.2107143 Z M31.5919708,13.5241071 C32.189781,13.5241071 32.6036496,13.9794643 32.6036496,14.5714286 L32.6036496,16.4839286 L35.5467153,16.4839286 C36.4664234,16.4839286 37.2021898,17.2125 37.2021898,18.1232143 C37.2021898,19.0339286 36.4664234,19.7625 35.5467153,19.7625 L32.649635,19.7625 L32.649635,28.3232143 C32.649635,29.5526786 33.2934307,29.64375 34.1671533,29.64375 C34.6729927,29.64375 34.9489051,29.5526786 35.2248175,29.5071429 C35.4547445,29.4616071 35.6846715,29.3705357 35.9605839,29.3705357 C36.6963504,29.3705357 37.5240876,29.9625 37.5240876,30.91875 C37.4781022,31.5107143 37.1562044,32.0571429 36.5583942,32.3303571 C35.6846715,32.7401786 34.8109489,32.9223214 33.8452555,32.9223214 C30.6722628,32.9223214 28.9708029,31.4196429 28.9708029,28.5508929 L28.9708029,19.7625 L27.3153285,19.7625 C26.7175182,19.7625 26.3036496,19.3071429 26.3036496,18.7607143 C26.3036496,18.4419643 26.4416058,18.1232143 26.7175182,17.8955357 L30.7642336,13.9339286 C30.8562044,13.8428571 31.1781022,13.5241071 31.5919708,13.5241071 Z M12.9678832,9.79017857 C13.979562,9.79017857 14.8072993,10.6098214 14.8072993,11.6116071 L14.8072993,30.9642857 C14.8072993,31.9660714 13.979562,32.7401786 12.9678832,32.7401786 C11.9562044,32.7401786 11.1744526,31.9205357 11.1744526,30.9642857 L11.1744526,11.6116071 C11.1744526,10.6098214 11.9562044,9.79017857 12.9678832,9.79017857 Z M21.5211679,16.3473214 C22.5328467,16.3473214 23.3605839,17.1669643 23.3605839,18.16875 L23.3605839,30.9642857 C23.3605839,31.9660714 22.5328467,32.7401786 21.5211679,32.7401786 C20.5094891,32.7401786 19.7277372,31.9205357 19.7277372,30.9642857 L19.7277372,18.16875 C19.7277372,17.1669643 20.5094891,16.3473214 21.5211679,16.3473214 Z M46.9970803,19.44375 C45.249635,19.44375 43.410219,20.4910714 43.0883212,22.9044643 L50.9518248,22.9044643 C50.5839416,20.4910714 48.7445255,19.44375 46.9970803,19.44375 Z M21.6131387,10.2455357 C22.7167883,10.2455357 23.5905109,11.1107143 23.5905109,12.2035714 L23.5905109,12.3401786 C23.5905109,13.4330357 22.7167883,14.2982143 21.6131387,14.2982143 L21.4291971,14.2982143 C20.3255474,14.2982143 19.4518248,13.4330357 19.4518248,12.3401786 L19.4518248,12.2035714 C19.4518248,11.1107143 20.3255474,10.2455357 21.4291971,10.2455357 L21.6131387,10.2455357 Z" fill="#FFFFFF"></path></g></g></g></svg>
                                    <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ translate('MailerLite') }}</h3>
                                  </div>
                                  <div>
                                    <div class="-mt-px flex divide-x divide-gray-200">
                                      <div class="w-0 flex-1 flex">
                                        <div @click="$dispatch('display-modal', {'id': 'app-settings-mailerlite'})" class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
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
                                            <x-dashboard.form.input field="settings.mailerlite_api_token.value" />
                                        </div>
                                    </div>
                                    <!-- END MailerLite API Token -->

                                    <div class="w-full flex justify-end mt-4" x-data="{}">
                                        <button type="button" class="btn btn-primary ml-auto btn-sm" wire:click="saveIntegrations()">
                                            {{ translate('Save') }}
                                        </button>
                                    </div>
                                </x-system.form-modal>
                                {{-- END MailerLite --}}

                                {{-- MailSend --}}
                                <li class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                    <div class="flex-1 flex flex-col p-8">
                                        <img src="https://app.mailersend.com/images/logo/mailersend.svg"  class="h-8 logo-light">
                                        <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ translate('MailerSend') }}</h3>
                                    </div>
                                    <div>
                                      <div class="-mt-px flex divide-x divide-gray-200">
                                        <div class="w-0 flex-1 flex">
                                          <a @click="$dispatch('display-modal', {'id': 'app-settings-mailersend'})" class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                            @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                            <span class="ml-2">{{ translate('Edit') }}</span>
                                          </a>
                                        </div>
                                      </div>
                                    </div>
                                </li>
                                <x-system.form-modal id="app-settings-mailersend" title="MailerSend">
                                    <!-- MailerSend API Token-->
                                    <div class="flex flex-col mb-3" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 mb-2">
                                            {{ translate('MailerSend API Token') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <x-dashboard.form.input field="settings.mailersend_api_token.value" />
                                        </div>
                                    </div>
                                    <!-- END MailerSend API Token -->

                                    <!-- Mail From Address-->
                                    <div class="flex flex-col mb-3" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 mb-2">
                                            {{ translate('From Address') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <x-dashboard.form.input field="settings.mail_from_address.value" />
                                        </div>
                                    </div>
                                    <!-- END Mail From Address -->

                                    <!-- Mail From Name-->
                                    <div class="flex flex-col mb-3" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 mb-2">
                                            {{ translate('From Name') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <x-dashboard.form.input field="settings.mail_from_name.value" placeholder="{{ translate('Site name is used by default') }}"/>
                                        </div>
                                    </div>
                                    <!-- END Mail From Name -->

                                    <!-- Mail ReplyTo Address-->
                                    <div class="flex flex-col mb-3" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 mb-2">
                                            {{ translate('Reply to Address') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <x-dashboard.form.input field="settings.mail_reply_to_address.value" />
                                        </div>
                                    </div>
                                    <!-- END Mail ReplyTo Address -->

                                    <!-- Mail ReplyTo Name-->
                                    <div class="flex flex-col mb-3" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 mb-2">
                                            {{ translate('Reply to Name') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <x-dashboard.form.input field="settings.mail_reply_to_name.value" placeholder="{{ translate('Site name is used by default') }}"/>
                                        </div>
                                    </div>
                                    <!-- END Mail ReplyTo Name -->

                                    <div class="w-full flex justify-end mt-4" x-data="{}">
                                        <button type="button" class="btn btn-primary ml-auto btn-sm" wire:click="saveIntegrations()">
                                            {{ translate('Save') }}
                                        </button>
                                    </div>
                                </x-system.form-modal>
                                {{-- END MailSend --}}

                                {{-- Google Analytics --}}
                                <li class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                    <div class="flex-1 flex flex-col p-8">
                                        <img class="devsite-product-logo h-[32px]" alt="Google Analytics" src="https://www.gstatic.com/analytics-suite/header/suite/v2/ic_analytics.svg" loading="lazy">
                                        <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ translate('Google Analytics') }}</h3>
                                    </div>
                                    <div>
                                      <div class="-mt-px flex divide-x divide-gray-200">
                                        <div class="w-0 flex-1 flex">
                                          <div @click="$dispatch('display-modal', {'id': 'app-settings-google-analytics'})" class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
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
                                            <x-dashboard.form.toggle field="settings.google_analytics_enabled.value" />
                                        </div>
                                    </div>
                                    <!-- END Google Analytics Enabled -->

                                    <!-- Gtag ID-->
                                    <div class="flex flex-col" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 mb-2">
                                            {{ translate('Gtag ID') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <x-dashboard.form.input field="settings.gtag_id.value" />
                                        </div>
                                    </div>
                                    <!-- END Gtag ID -->

                                    <div class="w-full flex justify-end mt-4" x-data="{}">
                                        <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                            $wire.set('settings.google_analytics_enabled.value', settings.google_analytics_enabled.value, true);
                                        "  wire:click="saveIntegrations()">
                                            {{ translate('Save') }}
                                        </button>
                                    </div>
                                </x-system.form-modal>
                                  {{-- END Google Analytics --}}

                                {{-- Google ReCaptcha --}}
                                <li class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
                                    <div class="flex-1 flex flex-col p-8">
                                        <img class="mx-auto h-[32px]" alt="Google Analytics" src="https://www.google.com/recaptcha/about/images/reCAPTCHA-logo@2x.png" loading="lazy">
                                        <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ translate('Google Recaptcha') }}</h3>
                                    </div>
                                    <div>
                                      <div class="-mt-px flex divide-x divide-gray-200">
                                        <div class="w-0 flex-1 flex">
                                          <div @click="$dispatch('display-modal', {'id': 'app-settings-google-recaptcha'})" class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
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
                                            <x-dashboard.form.toggle field="settings.google_recaptcha_enabled.value" />
                                        </div>
                                    </div>
                                    <!-- END Google Recaptcha Enabled -->

                                    <!-- Google Recaptcha Site Key-->
                                    <div class="flex flex-col mb-3" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 mb-2">
                                            {{ translate('Site Key') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <x-dashboard.form.input field="settings.google_recaptcha_site_key.value" />
                                        </div>
                                    </div>
                                    <!-- END Google Recaptcha Site Key -->

                                    <!-- Google Recaptcha Secret Key-->
                                    <div class="flex flex-col" x-data="{}">
                                        <label class="block text-sm font-medium text-gray-900 mb-2">
                                            {{ translate('Secret Key') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <x-dashboard.form.input field="settings.google_recaptcha_secret_key.value" />
                                        </div>
                                    </div>
                                    <!-- END Google Recaptcha Secret Key -->

                                    <div class="w-full flex justify-end mt-4" x-data="{}">
                                        <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                            $wire.set('settings.google_recaptcha_enabled.value', settings.google_recaptcha_enabled.value, true);
                                        "  wire:click="saveIntegrations()">
                                            {{ translate('Save') }}
                                        </button>
                                    </div>
                                </x-system.form-modal>
                                {{-- END Google ReCaptcha --}}
                            </ul>
                        </div>
                        {{-- END Integrations --}}

                        {{-- Advanced --}}
                        <div class="w-full px-5" x-show="current_tab === 'advanced'">
                            {{-- User meta in use --}}
                            <div class="flex flex-col" x-data="{
                                all_user_meta: @js(\App\Models\UserMeta::metaDataTypes()),
                                toggleField(key) {
                                    if(settings.user_meta_fields_in_use.value == null || settings.user_meta_fields_in_use.value == undefined) {
                                        settings.user_meta_fields_in_use.value = {};
                                    }

                                    if(settings.user_meta_fields_in_use.value.hasOwnProperty(key)) {
                                        delete settings.user_meta_fields_in_use.value[key];
                                    } else {
                                        settings.user_meta_fields_in_use.value[key] = {
                                            'required': false,
                                            'onboarding': false,
                                        };
                                    }
                                },
                                toggleProperty(key, property) {
                                    if(_.get(settings.user_meta_fields_in_use.value, key+'.'+property, null) === null) {
                                        _.set(settings.user_meta_fields_in_use.value, key+'.'+property, false); // if it doesn't exist, set it!
                                    }

                                    if(_.get(settings.user_meta_fields_in_use.value, key+'.'+property, null) === false) {
                                        _.set(settings.user_meta_fields_in_use.value, key+'.'+property, true);
                                    } else {
                                        _.set(settings.user_meta_fields_in_use.value, key+'.'+property, false);
                                    }
                                },
                            }">
                                <div class="flex flex-col mb-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('User meta fields in use') }}</span>
                                    <p class="text-gray-500 text-sm">{{ translate('Here you can enable/disable which metadata should be visible and editable for all user accounts. You can also set if specific meta is required or not.') }}</p>
                                </div>

                                <div class="flex items-center">
                                    <button type="button" @click="$dispatch('display-modal', {'id': 'app-settings-user_meta_fields_in_use'})"
                                            class="btn-primary" >
                                            {{ translate('Edit fields')}}
                                    </button>
                                </div>

                                <x-system.form-modal id="app-settings-user_meta_fields_in_use" title="User meta fields in use" class="sm:max-w-2xl">
                                    <!-- User meta fields in use-->
                                    <div class="mt-0 flex flex-col">
                                        <div class="overflow-x-auto ">
                                          <div class="inline-block min-w-full py-2 px-1 align-middle">
                                            <div class="shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                              <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                  <tr>
                                                    <th scope="col" class="py-1 px-3 text-left text-sm font-semibold text-gray-900">{{ translate('Meta') }}</th>
                                                    <th scope="col" class="px-1 py-1 text-center text-sm font-semibold text-gray-900">{{ translate('Use') }}</th>
                                                    <th scope="col" class="px-1 py-1 text-center text-sm font-semibold text-gray-900">{{ translate('Required') }}</th>
                                                    <th scope="col" class="px-1 py-1 text-center text-sm font-semibold text-gray-900">{{ translate('Onboarding') }}</th>
                                                  </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 bg-white">
                                                    <template x-for="(type, key) in all_user_meta">
                                                        <tr>
                                                            <td class="whitespace-nowrap py-2 px-3 text-14 font-medium text-gray-900 " x-text="key"></td>
                                                            <td class="whitespace-nowrap px-1 py-2 text-sm text-gray-500 text-center">
                                                                <button type="button" @click="toggleField(key)"
                                                                            :class="{'bg-primary': _.get(settings.user_meta_fields_in_use.value, key, null) !== null , 'bg-gray-200':_.get(settings.user_meta_fields_in_use.value, key, null) === null}"
                                                                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                                                        <span :class="{'translate-x-5':_.get(settings.user_meta_fields_in_use.value, key, null) !== null, 'translate-x-0':_.get(settings.user_meta_fields_in_use.value, key, null) === null}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                                                </button>
                                                            </td>
                                                            <td class="whitespace-nowrap px-1 py-2 text-sm text-gray-500 text-center">
                                                                <button type="button" @click="toggleProperty(key, 'required')" x-show="_.get(settings.user_meta_fields_in_use.value, key, null) !== null"
                                                                            :class="{'bg-primary': _.get(settings.user_meta_fields_in_use.value, key+'.required', false) !== false , 'bg-gray-200':_.get(settings.user_meta_fields_in_use.value, key+'.required', false) === false}"
                                                                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                                                        <span :class="{'translate-x-5':_.get(settings.user_meta_fields_in_use.value, key+'.required', false) !== false, 'translate-x-0':_.get(settings.user_meta_fields_in_use.value, key+'.required', false) === false}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                                                </button>
                                                            </td>
                                                            <td class="whitespace-nowrap px-1 py-2 text-sm text-gray-500 text-center">
                                                                <button type="button" @click="toggleProperty(key, 'onboarding')" x-show="_.get(settings.user_meta_fields_in_use.value, key, null) !== null"
                                                                            :class="{'bg-primary': _.get(settings.user_meta_fields_in_use.value, key+'.onboarding', false) !== false , 'bg-gray-200':_.get(settings.user_meta_fields_in_use.value, key+'.onboarding', false) === false}"
                                                                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                                                        <span :class="{'translate-x-5':_.get(settings.user_meta_fields_in_use.value, key+'.onboarding', false) !== false, 'translate-x-0':_.get(settings.user_meta_fields_in_use.value, key+'.onboarding', false) === false}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                                                </button>
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
                                        <button type="button" class="btn btn-primary ml-auto btn-sm" 
                                            @click="
                                                $wire.set('settings.user_meta_fields_in_use.value', settings.user_meta_fields_in_use.value, true);
                                            "
                                            wire:click="saveAdvanced('user_meta_fields')">
                                            {{ translate('Save') }}
                                        </button>
                                    </div>
                                </x-system.form-modal>
                            </div>
                            {{-- END User meta in use --}}
                        </div>
                        {{-- END Advanced --}}
                    </div>
                    {{-- END Tabs --}}


                </div>
            </div>
        </div>
    </div>
</div>


