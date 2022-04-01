<div class="w-full" x-data="{
        current_tab: 'social',
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
                                        $wire.set('settings.maintenance_mode.value', settings.maintenance_mode.value, true);
                                    "
                                    wire:click="saveGeneral()">
                                {{ translate('Save') }}
                                </button>
                            </div>
                            {{-- END Save general information --}}
                        </div>
                        {{-- END General --}}


                        {{-- Social --}}
                        <div class="w-full px-5" x-show="current_tab === 'social'">
                            {{-- Enable social logins --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-1" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Enable social logins') }}</span>
                                    <p class="text-gray-500 text-sm">{{ translate('If you want enable social logins on your website') }}</p>
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

                            {{-- Facebook settings --}}
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


                            {{-- Save general information --}}
                            <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                <button type="button" class="btn btn-primary ml-auto btn-sm"
                                    @click="
                                        $wire.set('settings.enable_social_logins.value', settings.enable_social_logins.value, true);
                                        $wire.set('settings.google_login.value', settings.google_login.value, true);
                                        $wire.set('settings.facebook_login.value', settings.facebook_login.value, true);
                                        $wire.set('settings.linkedin_login.value', settings.linkedin_login.value, true);
                                        {{-- $wire.set('settings.facebook_app_id.value', settings.facebook_app_id.value, true);
                                        $wire.set('settings.facebook_app_secret.value', settings.facebook_app_secret.value, true);
                                        $wire.set('settings.google_oauth_client_id.value', settings.google_oauth_client_id.value, true);
                                        $wire.set('settings.google_oauth_client_secret.value', settings.google_oauth_client_secret.value, true);
                                        $wire.set('settings.linkedin_client_id.value', settings.linkedin_client_id.value, true);
                                        $wire.set('settings.linkedin_client_secret.value', settings.linkedin_client_secret.value, true); --}}
                                    "
                                    wire:click="saveSocial()">
                                {{ translate('Save') }}
                                </button>
                            </div>
                            {{-- END Save general information --}}
                        </div>
                        {{-- END Social --}}


                    </div>
                    {{-- END Tabs --}}

                    
                </div>
            </div>
        </div>
    </div>
</div>


