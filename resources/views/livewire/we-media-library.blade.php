<div class="we-media-library {{ $containerClass }}" x-data="{
    displayModal: @js($displayModal),
    for_id: @entangle('for_id'),
    editorjs_media_wrapper_id: @entangle('editorjs_media_wrapper_id'),
    media: @entangle('media'),
    new_media: @entangle('new_media'),
    media_type: @entangle('media_type'),
    selected: @entangle('selected').defer,
    multiple: @entangle('multiple'),
    sort_by: @entangle('sort_by'),
    search_string: @entangle('search_string'),
    page: @entangle('page'),
    isMediaSelected(file) {
        if(this.selected.filter((item) => {
            return !_.get(item, 'id', false) ? false : Number(item['id']) === Number(file.id); 
        }).length > 0)
            return true;
        else
            return false;
    },
    selectMedia(file) {
        if(this.selected === null || this.selected === undefined) {
            this.selected = [];
        }

        if(!this.isMediaSelected(file)) {
            if(this.multiple) {
                this.selected.push(file);
            } else {
                this.selected[0] = file;
            }
        } else {
            if(this.multiple) {
                this.selected = this.selected.filter((item) => { return Number(item['id']) !== Number(file.id); });
            } else {
                this.selected = [];
            }
        }
    },
    saveSelection() {
        {{-- Send event to element with (for_id) with selected item(s) --}}
        $dispatch('we-media-selected-event', {
            for_id: this.for_id,
            editorjs_media_wrapper_id: this.editorjs_media_wrapper_id,
            selected: this.selected,
            multiple: this.multiple,
        });
    },
    closeLibrary() {
        this.new_media = [];
        this.displayModal = false;
    }
}" 
@display-media-library-modal.window="displayModal = true;" x-show="displayModal" x-cloak>
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="{{ $wrapperClass }}" x-show="displayModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="oapcity-100"
                x-transition:leave="ease-out duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">
                &#8203;
            </span>


            <div class="max-w-[90%] lg:max-w-[1150px]  overflow-hidden relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left  shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:p-6"
                x-show="displayModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-out duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                {{-- Dismiss modal - x button --}}
                <button type="button" class="absolute top-3 right-3" @click="closeLibrary()">
                    @svg('heroicon-o-x-mark', ['class' => 'w-5 h-5 text-gray-500'])
                </button>

                <div class="flex flex-col max-h-[85vh]" x-data="{
                        active_tab: 'select_file',
                    }" x-init="">

                    <div class="border-b border-gray-200 block">
                        <nav class="flex space-x-4" aria-label="Tabs">
                            <a href="#" class="px-3 py-2 font-medium text-sm rounded-md"
                                :class="{'bg-white text-indigo-700': active_tab === 'select_file', 'text-gray-500 hover:text-gray-700': active_tab !== 'select_file'}"
                                @click="active_tab = 'select_file'"> {{ translate('Select file(s)') }} </a>

                            <a href="#" class="px-3 py-2 font-medium text-sm rounded-md"
                                :class="{'bg-white text-indigo-700': active_tab === 'upload_new', 'text-gray-500 hover:text-gray-700': active_tab !== 'upload_new'}"
                                @click="active_tab = 'upload_new'"> {{ translate('Upload new') }} </a>
                        </nav>
                    </div>

                    <div class="w-full mt-3" x-show="active_tab === 'select_file'">
                        {{-- Sort and Search bar --}}
                        <div class="w-full pb-3 mb-3 border-b border-gray-200 flex items-center justify-between">
                            <div x-data="{
                                sort_types: @js(\App\Enums\SortMediaLibraryEnum::labels()),
                                show_sort_dropdown: false,
                                }">
                                <div class="mt-1 relative">
                                    <button type="button" @click="show_sort_dropdown = !show_sort_dropdown"
                                        class="bg-white relative w-[200px] border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                                        <span class="block truncate" x-text="sort_types[sort_by]"></span>
                                        <span
                                            class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                            @svg('heroicon-s-chevron-up-down', ['class' => 'h-5 w-5 text-gray-400']);
                                        </span>
                                    </button>

                                    <ul class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                                        x-show="show_sort_dropdown" x-transition:leave="transition ease-in duration-100"
                                        x-transition:leave-start="opacity-100 " x-transition:leave-end="oapcity-0"
                                        @click.outside="show_sort_dropdown = false">

                                        <template x-for="(type, key) in sort_types">
                                            <li class="text-gray-900 select-none relative py-2 pl-3 pr-9 cursor-pointer"
                                                @click="sort_by = key; show_sort_dropdown= false;">
                                                <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                                                <span class="font-normal block truncate"
                                                    :class="{'font-semibold': key === sort_by, 'font-normal': key !== sort_by }"
                                                    x-text="type">
                                                </span>

                                                <span
                                                    class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4"
                                                    x-show="key === sort_by">
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
                                        <input type="text" x-model.debounce.500ms="search_string"
                                            placeholder="{{ translate('Search your files...') }}"
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md">
                                        <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                                            <kbd
                                                class="inline-flex items-center border border-gray-300 cursor-pointer rounded px-2 text-sm font-sans font-medium text-gray-600">
                                                @svg('lineawesome-search-solid', ['class' => 'w-4 h-4'])
                                            </kbd>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full relative mt-3 grow-0 overflow-y-auto">

                        {{-- Select files(s) --}}
                        <div class="w-full" x-show="active_tab === 'select_file'">

                            {{-- Selectable Files --}}
                            <div class="w-full mb-3">

                                <template x-if="media !== null && media.length > 0">
                                    <ul role="list"
                                        class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8 p-1">
                                        <template x-for="file in media">
                                            <li class="relative cursor-pointer" @click="selectMedia(file)">
                                                <div class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 overflow-hidden"
                                                    :class="{'ring-2 ring-offset-2 ring-offset-gray-100 ring-indigo-500': isMediaSelected(file)}">

                                                    <template x-if="file.type === 'image'">
                                                        <img x-bind:src="window.WE.IMG.url(file.file_name)"
                                                            class="object-contain pointer-events-none group-hover:opacity-75 p-2">
                                                    </template>

                                                    <template x-if="file.type === 'document'">
                                                        <div class="w-full flex items-center justify-center pointer-events-none group-hover:opacity-75 ">
                                                            @svg('heroicon-s-document', ['class' => 'w-[60px] h-[60px] text-gray-700'])
                                                        </div>
                                                    </template>
                                                    
                                                    <button type="button"
                                                        class="absolute inset-0 focus:outline-none"></button>
                                                </div>
                                                <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none"
                                                    x-text="file.file_original_name"></p>
                                                <p class="block text-sm font-medium text-gray-500 pointer-events-none"
                                                    x-text="window.WE.utils.formatSizeUnits(file.file_size)"></p>
                                            </li>
                                        </template>
                                    </ul>
                                </template>


                                {{-- Empty State --}}
                                <template x-if="media === null || media.length <= 0">
                                    <div class="text-center py-6">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" aria-hidden="true">
                                            <path vector-effect="non-scaling-stroke" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ translate('No media') }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">{{ translate('Get started by uploading a
                                            media to library.') }}</p>
                                        <div class="mt-6">
                                            <button type="button" @click="active_tab = 'upload_new'"
                                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                @svg('heroicon-o-plus', ['class' => 'w-5 h-5'])
                                                {{ translate('Add media') }}
                                            </button>
                                        </div>
                                    </div>
                                </template>

                            </div>
                        </div>

                        {{-- Upload New --}}
                        <div class="w-full relative" x-show="active_tab === 'upload_new'">

                            <x-tailwind-ui.system.spinner class="absolute-center z-10 hidden"
                                spinner-class="h-8 w-8 text-primary" wire:loading.class.remove="hidden">
                            </x-tailwind-ui.system.spinner>

                            <div class="w-full relative" wire:loading.class="opacity-0 pointer-events-none">

                                <div class="w-full"
                                    :class="{ 'pb-5 mb-5 border-b pt-3': new_media !== null && new_media.length > 0 }"
                                    wire:loading.class="hidden">
                                    <template x-if="new_media !== null && new_media.length > 0">
                                        <ul role="list"
                                            class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8 p-1">
                                            <template x-for="file in new_media">
                                                <li class="relative cursor-pointer" @click="selectMedia(file)">
                                                    <div class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 overflow-hidden"
                                                        :class="{'ring-2 ring-offset-2 ring-offset-gray-100 ring-indigo-500': isMediaSelected(file)}">
                                                        <img x-bind:src="window.WE.IMG.url(file.file_name)"
                                                            class="object-cover pointer-events-none group-hover:opacity-75">
                                                        <button type="button"
                                                            class="absolute inset-0 focus:outline-none"></button>
                                                    </div>
                                                    <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none"
                                                        x-text="file.file_original_name"></p>
                                                    <p class="block text-sm font-medium text-gray-500 pointer-events-none"
                                                        x-text="window.WE.utils.formatSizeUnits(file.file_size)"></p>
                                                </li>
                                            </template>
                                        </ul>
                                    </template>
                                </div>

                                {{-- New image(s) --}}
                                <div class="w-full relative" x-data="{}">
                                    <div class="py-5 cursor-pointer">

                                        <input type="file"
                                            class="absolute cursor-pointer inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0"
                                            id="we-media-library__new-media-input" wire:model="new_media" multiple>

                                        <label for="we-media-library__new-media-input"
                                            class="mx-auto max-w-lg flex justify-center px-6 pt-5 pb-6 cursor-pointer border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                    fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <span
                                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                        {{ translate('Upload a file(s)') }}
                                                    </span>
                                                    <p class="pl-1">{{ translate('or drag and drop') }}</p>
                                                </div>
                                                <p class="text-xs text-gray-500">{{ translate('PNG, JPG, GIF up to
                                                    10MB') }}</p>
                                            </div>
                                        </label>
                                    </div>

                                    <x-system.invalid-msg field="new_media.*" class="mt-2 mb-4 flex justify-center">
                                    </x-system.invalid-msg>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="w-full shrink-0 flex justify-between border-t border-gray-200 pt-3"
                        wire:loading.class="opacity-50 pointer-events-none">
                        {{-- Pagination --}}
                        <div class="w-full bg-white px-2 flex items-center justify-between sm:px-2">

                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-start">
                                <div class="mr-3">
                                    <p class="text-sm text-gray-700">
                                        <span>{{ translate('Showing') }}</span>
                                        <span class="font-medium">{{ ($page - 1) * $per_page }}</span>
                                        <span>{{ translate('to') }}</span>
                                        <span class="font-medium">{{ $page * $per_page }}</span>
                                        <span>{{ translate('of') }}</span>
                                        <span class="font-medium">{{ $mediaCount }}</span>
                                        <span>{{ translate('results') }}</span>
                                    </p>
                                </div>
                                <div class="">
                                    <div class="flex-1 flex">
                                        @if ($page <= 1) <div
                                            class="mr-2 opacity-50 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                            Previous </div>
                                    @else
                                    <div @click="page -= 1"
                                        class="mr-2 cursor-pointer relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Previous </div>
                                    @endif

                                    @if ($page == $lastPageNumber)
                                    <div
                                        class="mr-2 opacity-50 rml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Next </div>
                                    @else
                                    <div @click="page += 1"
                                        class="cursor-pointer rml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Next </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END Pagination --}}

                    <div class="sm:flex sm:flex-row-reverse pt-2">
                        <button type="button" @click="saveSelection(); closeLibrary();"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                            {{ translate('Save') }}
                        </button>
                        <button type="button" @click="closeLibrary()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:primary sm:mt-0 sm:w-auto sm:text-sm">
                            {{ translate('Cancel') }}
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>