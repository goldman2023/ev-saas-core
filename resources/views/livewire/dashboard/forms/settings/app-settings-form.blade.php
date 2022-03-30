<div class="w-full" x-data="{
        current_tab: 'general',
        settings: @entangle('settings').defer,
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
                        <div class="w-full px-5">
                            <!-- Site Name -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
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
                
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
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
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 mt-4" x-data="{
                                toggle() {
                                    if(settings.maintenance_mode.value) {
                                        settings.maintenance_mode.value = false;
                                    } else {
                                        settings.maintenance_mode.value = true;
                                    }
                                }
                            }">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Maintenance mode') }}</span>
                                    <p class="text-gray-500 text-sm">{{ translate('If you want enable maintenance mode and stop users from interacting with site') }}</p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="toggle()"
                                                :class="{'bg-primary':settings.maintenance_mode.value , 'bg-gray-200':settings.maintenance_mode.value}" 
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                            <span :class="{'translate-x-5':settings.maintenance_mode.value, 'translate-x-0':!settings.maintenance_mode.value}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>
                            {{-- END Maintenance mode --}}
                        </div>
                        {{-- END General --}}
                    </div>
                    {{-- END Tabs --}}

                    
                </div>
            </div>
        </div>
    </div>
</div>


