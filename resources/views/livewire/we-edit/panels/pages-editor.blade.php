@push('head_scripts')
<script>
    $(function() {
        const sortable =  window.Sortable.create(document.querySelector('.p-pages-editor__sections-list'), {
            sort: true,
            draggable: ".p-pages-editor__sections-list__item",
            chosenClass: 'sortable-chosen',
            onSort: function (event) {
                let list = document.querySelectorAll('.p-pages-editor__sections-list li');
                // let keys = [];
                let map = {};
                list.forEach(function(section, order) {
                    map[section.getAttribute('data-section-index')] = order; // order is basically a JS index
                });
                
                @this.reorderCurrentPreviewSections(map);
            },
        });
    });
    </script>
@endpush

<div class="p-available-sections min-h-full w-full flex flex-col bg-white px-4 py-3" x-data="{
    current_page: @js($current_page),
    current_preview: @js($current_preview),
    pages: @js($all_pages),
    isCurrentPageSelected() {
        if(this.current_preview.content === undefined || this.current_page.content === null) {
            this.current_page.content = {};
        }
        console.log(this.current_page.content );
        return this.current_page !== null && this.current_page !== undefined && Object.values(this.current_page).length > 0;
    },
    errors: [],
}"
@validation-errors.window="errors = $event.detail.errors.general || []; console.log(errors);">
    <div class="w-full">
        <div class="mt-1 relative flex flex-col items-center">
            {{-- Page Selector --}}
            <div class="w-full" x-data="{
                items: pages,
                show: false,
                tag: false,
                multiple: false,
                countSelected() {
                    if(this.current_page === undefined || this.current_page === null) {
                        this.current_page = {};
                    }

                    return this.current_page.id !== undefined ? 1 : 0;
                },
                getPlaceholder() {
                    if(this.countSelected() === 1) {
                        return this.current_page.title || '';
                    } else {
                        return '{{ translate('Edit page...') }}';
                    }
                },
                isSelected(id) {
                    return Number(this.current_page.id) === Number(id);
                },
                select(id, label) {
                    this.current_page = pages.find(x => x.id === id);
                    $wire.changeCurrentPage(this.current_page.id);
                    this.show = false;
                }
            }" >
                <label class="w-full input-label">{{ translate('Select page') }}</label>

                <div class="we-select relative w-full mt-2" x-data="{}" @click.outside="show = false">
                    <div class="we-select__selector select-none w-full flex flex-wrap border pl-3 pt-2 pb-1 pr-6 relative cursor-pointer" 
                         @click="show = !show">
                            @svg('heroicon-o-chevron-down', ['class' => 'we-select__selector-arrow absolute w-[16px] h-[16px] top-[50%] -translate-y-2/4', ':class' => "{'rotate-180': show}"])
    
                        <span class="block text-gray-700" x-text="getPlaceholder()"></span>
                    </div>

                    <div class="we-select__dropdown  absolute bg-white shadow border rounded mt-1  w-full" x-show="show">
                        <ul class="we-select__dropdown-list select-none w-full">
                            <template x-for="item in items">
                                <li class="we-select__dropdown-list-item py-2 px-3 cursor-pointer" 
                                    x-text="item.title"
                                    :class="{'selected': isSelected(item.id) }"
                                    @click="select(item.id, item.title)"></li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- END Page Selector --}}

            <hr class="w-full h-1 mt-4 mb-3" />

            <template x-if="errors.length > 0">
                <div class="w-full bg-red-600 text-white rounded border mb-3 text-center py-2 text-14" x-data="" x-init="">
                    <span x-text="errors[0]"></span>
                </div>
            </template>

            {{-- Sort sections --}}
            @if(!empty($current_preview))
                <div class="w-full" x-data="" x-init="">
                    <h4 class="w-full flex text-16 font-medium mb-3" >
                        <span>{{ translate('Edit') }}</span>
                        <span class="text-blue-500 ml-1 mr-1" x-text="current_page.title"></span>
                        <span>{{ translate('page sections') }}</span>
                    </h4>

                    <ul class="p-pages-editor__sections-list w-full">
                        @if(!empty($current_preview->content))
                            @foreach($current_preview->content as $index => $section)
                                <li data-section-index="{{ $index }}" data-section-order="{{ $section['order'] }}" class="p-pages-editor__sections-list__item cursor-pointer w-full mb-2 relative rounded-lg border border-gray-300 bg-white px-4 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    @svg('lineawesome-bars-solid', ['class' => 'cursor-grabbing w-[20px] h-[20px]'])
                                    <p class="text-sm font-medium ml-3">{{ $section['title'] }}</p>

                                    <div x-data="{
                                            open: false,
                                        }" class="!ml-auto" @click.outside="open = false">
                                        <button type="button"
                                                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-2 py-1 bg-white text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"
                                                @click="open = ! open">
                                          @svg('lineawesome-cog-solid', ['class' => 'cursor-pointer w-[20px] h-[20px]'])
                                        </button>

                                        <div class="z-10 origin-top-right absolute right-0 mt-1 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none" role="menu" 
                                                x-show="open"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-100"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                            >
                                            <div class="py-1" role="none">
                                              <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                                <a href="#" @click="open = false; $dispatch('display-flyout-panel', {'id': 'we-edit-section-panel', 'title': '{{ $section['title'] }}', 'section_uuid': '{{ $section['uuid'] }}', });" class="flex items-center text-gray-700 px-4 py-2 text-sm cursor-pointer hover:bg-gray-100 " role="menuitem" >
                                                    @svg('lineawesome-edit', ['class' => 'w-[18px] h-[18px] mr-3'])
                                                    {{ translate('Edit') }}
                                                </a>
                                                <a href="#" @click="open = false" class="text-gray-700 flex items-center px-4 py-2 text-sm cursor-pointer hover:bg-gray-100 " role="menuitem" wire:click="duplicateSection({{ $index }})">
                                                    @svg('lineawesome-clone', ['class' => 'w-[18px] h-[18px] mr-3'])
                                                    {{ translate('Duplicate') }}
                                                </a>
                                            </div>
                                            <div class="py-1" role="none">
                                                <a href="#" @click="open = false" class="text-gray-700 flex items-center px-4 py-2 text-sm cursor-pointer hover:bg-gray-100 " role="menuitem" wire:click="deleteSectionFromPreview({{ $index }})">
                                                    @svg('lineawesome-trash-solid', ['class' => 'w-[18px] h-[18px] mr-3'])
                                                    {{ translate('Delete') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            @endif
            {{-- END Sort sections --}}
        </div>
    </div>

    <x-we-edit.flyout.flyout-edit-section :currentPreview="$current_preview"></x-we-edit.flyout.flyout-edit-section>
</div>