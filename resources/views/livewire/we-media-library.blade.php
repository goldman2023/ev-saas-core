<div class="fixed z-50 inset-0 overflow-y-auto" x-data="{
    displayModal: false,
    media: @entangle('media'),
    media_type: @entangle('media_type'),
    selected: @entangle('selected'),
    sort_by: @entangle('sort_by'),
    search_string: @entangle('search_string'),
}"
@display-media-library-modal.window="displayModal = true;"
x-show="displayModal">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
          x-show="displayModal"
          x-transition:enter="ease-out duration-300"
          x-transition:enter-start="opacity-0"
          x-transition:enter-end="oapcity-100"
          x-transition:leave="ease-out duration-300"
          x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"></div>

    <!-- This element is to trick the browser into centering the modal contents. -->
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>


    <div class="max-w-[90%] lg:max-w-[1150px] relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left  shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:p-6"
          x-show="displayModal"
          x-transition:enter="ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave="ease-out duration-200"
          x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
      <div x-data="{
            active_tab: 'select_file',
        }" x-init="">
    
          <div class="border-b border-gray-200 block">
            <nav class="flex space-x-4" aria-label="Tabs">
              <!-- Current: "bg-indigo-100 text-indigo-700", Default: "text-gray-500 hover:text-gray-700" -->
              <a href="#" class="px-3 py-2 font-medium text-sm rounded-md"
                :class="{'bg-white text-indigo-700': active_tab === 'select_file', 'text-gray-500 hover:text-gray-700': active_tab !== 'select_file'}"
                @click="active_tab = 'select_file'"> {{ translate('Select file(s)') }} </a>
        
              <a href="#" class="px-3 py-2 font-medium text-sm rounded-md" 
                :class="{'bg-white text-indigo-700': active_tab === 'upload_new', 'text-gray-500 hover:text-gray-700': active_tab !== 'upload_new'}"
                @click="active_tab = 'upload_new'"> {{ translate('Upload new') }} </a>
            </nav>
          </div>

          <div class="w-full mt-3">

            {{-- Select files(s) --}}
            <div class="w-full" x-show="active_tab === 'select_file'">
                {{-- Sort and Search bar --}}
                <div class="w-full pb-3 mb-3 border-b border-gray-200 flex items-center justify-between"> 
                    <div x-data="{
                            sort_types: @js(\App\Enums\SortMediaLibraryEnum::labels()),
                            show_sort_dropdown: false,
                        }">
                        <div class="mt-1 relative">
                            <button type="button" @click="show_sort_dropdown = !show_sort_dropdown" class="bg-white relative w-[200px] border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                                <span class="block truncate" x-text="sort_types[sort_by]"></span>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <!-- Heroicon name: solid/selector -->
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>
      
                            <ul class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                                x-show="show_sort_dropdown"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 "
                                x-transition:leave-end="oapcity-0"
                                @click.outside="show_sort_dropdown = false">

                                <template x-for="(type, key) in sort_types">
                                    <li class="text-gray-900 select-none relative py-2 pl-3 pr-9 cursor-pointer" @click="sort_by = key; show_sort_dropdown= false;">
                                      <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                                      <span class="font-normal block truncate" 
                                            :class="{'font-semibold': key === sort_by, 'font-normal': key !== sort_by }"
                                            x-text="type">
                                      </span>
            
                                      <span class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4" x-show="key === sort_by">
                                          @svg('heroicon-o-check', ['class' => 'h-5 w-5'])
                                      </span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <div class="" x-data="{}">
                        <div>
                            <div class="mt-1 relative flex items-center">
                                <input type="text" x-model.debounce.500ms="search_string" placeholder="{{ translate('Search your files...') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md">
                                <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                                    <kbd class="inline-flex items-center border border-gray-300 cursor-pointer rounded px-2 text-sm font-sans font-medium text-gray-600">
                                        @svg('lineawesome-search-solid', ['class' => 'w-4 h-4'])
                                    </kbd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Selectable Files --}}
                <div class="w-full mb-3"> 

                  <template x-if="media !== null && media.length > 0">
                    <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                      <template x-for="file in media">
                        <li class="relative">
                          <div class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                            <img x-bind:src="window.WE.IMG.url(file.file_name)" alt="" class="object-cover pointer-events-none group-hover:opacity-75">
                            <button type="button" class="absolute inset-0 focus:outline-none"></button>
                          </div>
                          <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none" x-text="file.file_original_name"></p>
                          <p class="block text-sm font-medium text-gray-500 pointer-events-none" x-text="window.WE.utils.formatSizeUnits(file.file_size)"></p>
                        </li>
                      </template>
                    </ul>
                  </template>
                    
                    
                  {{-- Empty State --}}
                  <template x-if="media === null || media.length <= 0">
                      <div class="text-center py-6">
                          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                              <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                          </svg>
                          <h3 class="mt-2 text-sm font-medium text-gray-900">{{ translate('No media') }}</h3>
                          <p class="mt-1 text-sm text-gray-500">{{ translate('Get started by uploading a media to library.') }}</p>
                          <div class="mt-6">
                              <button type="button" @click="active_tab = 'upload_new'" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                  @svg('heroicon-o-plus', ['class' => 'w-5 h-5'])
                                  {{ translate('Add media') }}
                              </button>
                          </div>
                      </div>
                  </template>
                    
                </div>

            </div>

            <div class="w-full grid grid-cols-3 gap-4" x-show="active_tab === 'upload_new'">

            </div>

          </div>

          <div class="w-full">
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse border-t border-gray-200 pt-2">
              <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                {{ translate('Save') }}
              </button>
              <button type="button" @click="displayModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                {{ translate('Cancel') }}
              </button>
            </div>
          </div>

      </div>
    </div>
  </div>
</div>