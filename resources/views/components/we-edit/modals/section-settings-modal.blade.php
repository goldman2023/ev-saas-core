<div class="fixed z-50 inset-0 overflow-y-auto" x-data="{
      show: false,
  }"
  @display-section-settings-modal.window="show = true;"
  x-show="show">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="oapcity-100"
            x-transition:leave="ease-out duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"></div>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left  shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <div x-data="{
              active_tab: 'spacing',
              bkgColorPicker: null,
              initColorPicker() {
                if(!this.bkgColorPicker) {
                  this.bkgColorPicker = new window.iro.ColorPicker('#section-background-color-picker', {
                    width: 200,
                    color: section.settings.background.color
                  });
                  this.bkgColorPicker.on('input:end', function(color) {
                    section.settings.background.color = color.hexString;
                    {{-- $('#section_settings_background_color_input').val(); --}}
                  });
                }
              }
          }" x-init="$watch('active_tab', value => {
              if(active_tab === 'background') {
                initColorPicker();
              }
            });
            $watch('section.settings.background.color', new_color => {
              if(new_color !== bkgColorPicker.color.hexString) {
                bkgColorPicker.color.hexString = new_color;
                console.log(new_color);
              }
            })
          ">
      
            <div class="border-b border-gray-200 block">
              <nav class="flex space-x-4" aria-label="Tabs">
                <!-- Current: "bg-indigo-100 text-indigo-700", Default: "text-gray-500 hover:text-gray-700" -->
                <a href="#" class="px-3 py-2 font-medium text-sm rounded-md"
                  :class="{'bg-white text-indigo-700': active_tab === 'spacing', 'text-gray-500 hover:text-gray-700': active_tab !== 'spacing'}"
                  @click="active_tab = 'spacing'"> {{ translate('Spacing') }} </a>
          
                <a href="#" class="px-3 py-2 font-medium text-sm rounded-md" 
                  :class="{'bg-white text-indigo-700': active_tab === 'background', 'text-gray-500 hover:text-gray-700': active_tab !== 'background'}"
                  @click="active_tab = 'background'"> {{ translate('Background') }} </a>
          
                <a href="#" class="px-3 py-2 font-medium text-sm rounded-md" 
                  :class="{'bg-white text-indigo-700': active_tab === 'visibility', 'text-gray-500 hover:text-gray-700': active_tab !== 'visibility'}"
                  @click="active_tab = 'visibility'"> {{ translate('Visibility') }} </a>
          
                <a href="#" class="px-3 py-2 font-medium text-sm rounded-md"
                  :class="{'bg-white text-indigo-700': active_tab === 'other', 'text-gray-500 hover:text-gray-700': active_tab !== 'other'}"
                  @click="active_tab = 'other'"> {{ translate('Other') }} </a>
              </nav>
            </div>

            <div class="w-full mt-3">
              {{-- Spacing --}}
              <div class="w-full grid grid-cols-3 gap-4" x-show="active_tab === 'spacing'">
                <div>
                  <label class="flex items-center text-sm font-medium text-gray-700">{{ translate('Mobile padding') }} @svg('heroicon-o-device-mobile', ['class' => 'w-4 h-4'])</label>
                  {{-- Top --}}
                  <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm"> @svg('heroicon-o-arrow-narrow-up', ['class' => 'h-4 w-4']) </span>
                    </div>
                    <input type="number" x-model.lazy="section.settings.spacing.mobile.top" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" step="1">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm" > {{ translate('px') }} </span>
                    </div>
                  </div>
                  {{-- Bottom --}}
                  <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm"> @svg('heroicon-o-arrow-narrow-down', ['class' => 'h-4 w-4']) </span>
                    </div>
                    <input type="number" x-model.lazy="section.settings.spacing.mobile.bottom" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" step="1">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm"> {{ translate('px') }} </span>
                    </div>
                  </div>
                </div>


                <div>
                  <label class="flex items-center text-sm font-medium text-gray-700">{{ translate('Tablet padding') }} @svg('heroicon-o-device-tablet', ['class' => 'w-4 h-4'])</label>
                  {{-- Top --}}
                  <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm"> @svg('heroicon-o-arrow-narrow-up', ['class' => 'h-4 w-4']) </span>
                    </div>
                    <input type="number" x-model.lazy="section.settings.spacing.tablet.top" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" step="1">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm" > {{ translate('px') }} </span>
                    </div>
                  </div>
                  {{-- Bottom --}}
                  <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm"> @svg('heroicon-o-arrow-narrow-down', ['class' => 'h-4 w-4']) </span>
                    </div>
                    <input type="number" x-model.lazy="section.settings.spacing.tablet.bottom" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" step="1">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm"> {{ translate('px') }} </span>
                    </div>
                  </div>
                </div>

                <div>
                  <label class="flex items-center text-sm font-medium text-gray-700">{{ translate('Desktop padding') }} @svg('heroicon-o-desktop-computer', ['class' => 'w-4 h-4'])</label>
                  {{-- Top --}}
                  <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm"> @svg('heroicon-o-arrow-narrow-up', ['class' => 'h-4 w-4']) </span>
                    </div>
                    <input type="number" x-model.lazy="section.settings.spacing.desktop.top" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" step="1">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm" > {{ translate('px') }} </span>
                    </div>
                  </div>
                  {{-- Bottom --}}
                  <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm"> @svg('heroicon-o-arrow-narrow-down', ['class' => 'h-4 w-4']) </span>
                    </div>
                    <input type="number" x-model.lazy="section.settings.spacing.desktop.bottom" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" step="1">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm"> {{ translate('px') }} </span>
                    </div>
                  </div>
                </div>
              </div>

              {{-- Background --}}
              <div class="w-full grid grid-cols-3 gap-4" x-show="active_tab === 'background'">
                <div class="col-span-3" x-data="{
                    background_types: @js(\App\Enums\BackgroundTypeEnum::labels()),
                    show_type_dropdown: false,
                }">
                  <label id="listbox-label" class="block text-sm font-medium text-gray-700">{{ translate('Background type') }}</label>
                  <div class="mt-1 relative">
                    <button type="button" @click="show_type_dropdown = !show_type_dropdown" class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-pointer focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                      <span class="block truncate" x-text="background_types[section.settings.background.type]"></span>
                      <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <!-- Heroicon name: solid/selector -->
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                          <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                      </span>
                    </button>

                    <ul class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                        x-show="show_type_dropdown"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 "
                        x-transition:leave-end="oapcity-0"
                        @click.outside="show_type_dropdown = false"
                    >

                      <template x-for="(type, key) in background_types">
                        <!--
                        Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

                        Highlighted: "text-white bg-indigo-600", Not Highlighted: "text-gray-900"
                        -->
                        <li class="text-gray-900 select-none relative py-2 pl-3 pr-9 cursor-pointer" @click="section.settings.background.type = key; show_type_dropdown= false;">
                          <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                          <span class="font-normal block truncate" 
                                :class="{'font-semibold': key === section.settings.background.type, 'font-normal': key !== section.settings.background.type }"
                                x-text="type">
                          </span>

                          <!--
                            Checkmark, only display for selected option.

                            Highlighted: "text-white", Not Highlighted: "text-indigo-600"
                          -->
                          <span class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4" x-show="key === section.settings.background.type">
                            <!-- Heroicon name: solid/check -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                          </span>
                        </li>
                      </template>
                    </ul>

                    <div class="w-full mt-4" wire:ignore>

                      {{-- Color Picker --}}
                      <div class="w-full" x-show="section.settings.background.type === '{{ \App\Enums\BackgroundTypeEnum::color()->value }}'">
                        <div class="flex justify-center" id="section-background-color-picker"></div>

                        <div class="mt-3">
                          <input type="text" id="section_settings_background_color_input" x-model.lazy="section.settings.background.color" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                      </div>

                      {{-- Image Pickers --}}
                      <div class="w-full mt-4" x-show="section.settings.background.type === '{{ \App\Enums\BackgroundTypeEnum::image()->value }}'">
                      
                        {{-- Mobile image --}}
                        <div class="w-full" x-data="{
                            id: 'section-background-mobile'
                          }" 
                          @we-media-selected-event.window="
                            if($event.detail.for_id === id) {
                              section.settings.background.urls.mobile = $event.detail.selected[0] || '';
                            }
                          "
                        >
                          <label for="cover-photo" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 pb-2"> {{ translate('Mobile image') }} </label>
                          
                          <div class="mt-1 sm:mt-0 sm:col-span-2 cursor-pointer" @click="$wire.emit('showMediaLibrary', 'section-background-mobile', 'image', [section.settings.background.urls.mobile])">
                            <div class="max-w-lg flex justify-center border-2 border-gray-300 border-dashed rounded-md"
                                 :class="{'px-6 pt-5 pb-6':section.settings.background.urls.mobile.length <= 0}">
                              
                              <template x-if="section.settings.background.urls.mobile.length > 0">
                                <div class="h-[200px] w-full rounded cursor-pointer">
                                  <img class="w-full h-[200px] object-cover" x-bind:src="window.WE.IMG.url(section.settings.background.urls.mobile)" />
                                </div>
                              </template>

                              <template x-if="section.settings.background.urls.mobile.length <= 0">
                                <div class="space-y-1 text-center">
                                  <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" />
                                  </svg>
                                  <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                      <span>{{ translate('Upload a file') }}</span>
                                    </label>
                                    <p class="pl-1">{{ translate('or drag and drop') }}</p>
                                  </div>
                                  <p class="text-xs text-gray-500">{{ translate('PNG, JPG, GIF up to 3MB') }}</p>
                                </div>
                              </template>
                              
                            </div>
                          </div>
                        </div>

                        {{-- Tablet image --}}
                        <div class="w-full" x-data="{
                            id: 'section-background-tablet'
                          }" 
                          @we-media-selected-event.window="
                            if($event.detail.for_id === id) {
                              section.settings.background.urls.tablet = $event.detail.selected[0] || '';
                            }
                          "
                        >
                          <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 pb-2"> {{ translate('Tablet image') }} </label>
                          
                          <div class="mt-1 sm:mt-0 sm:col-span-2 cursor-pointer" @click="$wire.emit('showMediaLibrary', 'section-background-tablet', 'image', [section.settings.background.urls.tablet])">
                            <div class="max-w-lg flex justify-center border-2 border-gray-300 border-dashed rounded-md"
                                :class="{'px-6 pt-5 pb-6':section.settings.background.urls.tablet.length <= 0}">
                              
                              <template x-if="section.settings.background.urls.tablet.length > 0">
                                <div class="h-[200px] w-full rounded cursor-pointer">
                                  <img class="w-full h-[200px] object-cover" x-bind:src="window.WE.IMG.url(section.settings.background.urls.tablet)" />
                                </div>
                              </template>

                              <template x-if="section.settings.background.urls.tablet.length <= 0">
                                <div class="space-y-1 text-center">
                                  <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" />
                                  </svg>
                                  <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                      <span>{{ translate('Upload a file') }}</span>
                                    </label>
                                    <p class="pl-1">{{ translate('or drag and drop') }}</p>
                                  </div>
                                  <p class="text-xs text-gray-500">{{ translate('PNG, JPG, GIF up to 3MB') }}</p>
                                </div>
                              </template>
                              
                            </div>
                          </div>
                        </div>


                        {{-- Desktop image --}}
                        <div class="w-full" x-data="{
                            id: 'section-background-desktop'
                          }"
                          @we-media-selected-event.window="
                            if($event.detail.for_id === id) {
                              section.settings.background.urls.desktop = $event.detail.selected[0] || '';
                            }
                          "
                        >
                          <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 pb-2"> {{ translate('Desktop image') }} </label>
                          
                          <div class="mt-1 sm:mt-0 sm:col-span-2 cursor-pointer" @click="$wire.emit('showMediaLibrary', 'section-background-desktop', 'image', [section.settings.background.urls.desktop])">
                            <div class="max-w-lg flex justify-center border-2 border-gray-300 border-dashed rounded-md"
                                :class="{'px-6 pt-5 pb-6':section.settings.background.urls.desktop.length <= 0}">
                              
                              <template x-if="section.settings.background.urls.desktop.length > 0">
                                <div class="h-[200px] w-full rounded cursor-pointer">
                                  <img class="w-full h-[200px] object-cover" x-bind:src="window.WE.IMG.url(section.settings.background.urls.desktop)" />
                                </div>
                              </template>

                              <template x-if="section.settings.background.urls.desktop.length <= 0">
                                <div class="space-y-1 text-center">
                                  <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" />
                                  </svg>
                                  <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                      <span>{{ translate('Upload a file') }}</span>
                                    </label>
                                    <p class="pl-1">{{ translate('or drag and drop') }}</p>
                                  </div>
                                  <p class="text-xs text-gray-500">{{ translate('PNG, JPG, GIF up to 3MB') }}</p>
                                </div>
                              </template>
                              
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                  </div>
                </div>

              </div>

              <div class="w-full grid grid-cols-1 gap-4" x-show="active_tab === 'visibility'">
                
                {{-- Responsive Visibility --}}
                <div class="col-span-3" x-data="{
                    responsive_visibility: @js(\App\Enums\ResponsiveVisibilityEnum::labels()),
                    show_responsive_visibility_dropdown: false,
                  }">
                  <label class="block text-sm font-medium text-gray-700">{{ translate('Responsive visibility') }}</label>
                  <div class="mt-1 relative">
                    <button type="button" @click="show_responsive_visibility_dropdown = !show_responsive_visibility_dropdown" class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-pointer focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                      <span class="block truncate" x-text="responsive_visibility[section.settings.responsive_visibility]"></span>
                      <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        @svg('heroicon-s-selector', ['class' => 'w-5 h-5'])
                      </span>
                    </button>

                    <ul class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                        x-show="show_responsive_visibility_dropdown"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        @click.outside="show_responsive_visibility_dropdown = false">

                      <template x-for="(type, key) in responsive_visibility">
                        <li class="text-gray-900 select-none relative py-2 pl-3 pr-9 cursor-pointer" @click="section.settings.responsive_visibility = key; show_responsive_visibility_dropdown = false;">
                          <span class="font-normal block truncate" 
                                :class="{'font-semibold': key === section.settings.responsive_visibility, 'font-normal': key !== section.settings.responsive_visibility }"
                                x-text="type">
                          </span>

                          <span class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4" 
                                x-show="key === section.settings.responsive_visibility">
                            @svg('heroicon-s-check', ['class' => 'w-5 h-5'])
                          </span>
                        </li>
                      </template>
                    </ul>
                  </div>
                </div>


                {{-- User Visibility --}}
                <div class="col-span-3" x-data="{
                    user_visibility: @js(\App\Enums\UserVisibilityEnum::labels()),
                    show_user_visibility_dropdown: false,
                  }">
                  <label class="block text-sm font-medium text-gray-700">{{ translate('User visibility') }}</label>
                  
                  <div class="mt-1 relative">
                    <button type="button" @click="show_user_visibility_dropdown = !show_user_visibility_dropdown" class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-pointer focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      <span class="block truncate" x-text="user_visibility[section.settings.user_visibility]"></span>
                      <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        @svg('heroicon-s-selector', ['class' => 'w-5 h-5'])
                      </span>
                    </button>

                    <ul class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                        x-show="show_user_visibility_dropdown"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        @click.outside="show_user_visibility_dropdown = false">

                      <template x-for="(type, key) in user_visibility">
                        <li class="text-gray-900 select-none relative py-2 pl-3 pr-9 cursor-pointer" @click="section.settings.user_visibility = key; show_user_visibility_dropdown = false;">
                          <span class="font-normal block truncate" 
                                :class="{'font-semibold': key === section.settings.user_visibility, 'font-normal': key !== section.settings.user_visibility }"
                                x-text="type">
                          </span>

                          <span class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4" 
                                x-show="key === section.settings.user_visibility">
                            @svg('heroicon-s-check', ['class' => 'w-5 h-5'])
                          </span>
                        </li>
                      </template>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="w-full grid grid-cols-1 gap-4" x-show="active_tab === 'other'">

                <div>
                  <label class="flex items-center text-sm font-medium text-gray-700">{{ translate('Extra classes') }}</label>
                  
                  <div class="mt-1 relative rounded-md shadow-sm w-full">                    
                    <input type="text" x-model.lazy="section.settings.extra_classes" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                  </div>
                </div>

              </div>
            </div>

            {{-- Settings Actions --}}
            <div class="w-full">
              <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse border-t border-gray-200 pt-2">
                <button type="button" @click="$wire.saveSectionSettings()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                  {{ translate('Save') }}
                </button>
                <button type="button" @click="show = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                  {{ translate('Cancel') }}
                </button>
              </div>
            </div>

        </div>
      </div>
    </div>
</div>
