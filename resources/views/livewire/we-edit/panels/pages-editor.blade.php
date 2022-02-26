@push('head_scripts')
<script>
    $(function() {
        const sortable =  window.Sortable.create(document.querySelector('.p-pages-editor__sections-list'), {
            sort: true,
            draggable: ".p-pages-editor__sections-list__item",
            chosenClass: 'sortable-chosen',
            onSort: function (event) {
                let list = document.querySelectorAll('.p-pages-editor__sections-list li');
                let keys = [];
                list.forEach(function(section, index) {
                    keys.push(section.getAttribute('data-section-id'));
                });
                
                @this.reorderCurrentPageSections(keys);
            },
        });
    });
    </script>
@endpush

<div class="p-available-sections min-h-full w-full flex flex-col bg-white px-4 py-3" x-data="{
    current_page: @js($current_page),
    pages: @js($all_pages),
    isCurrentPageSelected() {
        if(this.current_page.content === undefined || this.current_page.content === null) {
            this.current_page.content = {};
        }

        return this.current_page !== null && this.current_page !== undefined && Object.values(this.current_page).length > 0;
    }
}">
    <div class="w-full">
        <div class="mt-1 relative flex flex-col items-center" wire:ignore>
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

                    return this.current_page.length;
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
                    $wire.changeCurrentPage(this.current_page);
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

            {{-- Sort sections --}}
            <template x-if="isCurrentPageSelected()">
                <div class="w-full" x-data="" x-init="">
                    <h4 class="w-full flex text-16 font-medium mb-3" >
                        <span>{{ translate('Edit') }}</span>
                        <span class="text-blue-500 ml-1 mr-1" x-text="current_page.title"></span>
                        <span>{{ translate('page sections') }}</span>
                    </h4>

                    <ul class="p-pages-editor__sections-list w-full">
                        <template x-for="[id, section] of Object.entries(current_page.content)">
                            <li :data-section-id="id" class="p-pages-editor__sections-list__item cursor-pointer w-full mb-2 relative rounded-lg border border-gray-300 bg-white px-4 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                @svg('lineawesome-bars-solid', ['class' => 'cursor-grabbing w-[20px] h-[20px]'])
                                <p class="text-sm font-medium ml-3" x-text="section.title">Leslie Alexander</p>
                                {{-- <p class="text-sm text-gray-500 truncate">Co-Founder / CEO</p> --}}
                            </li>
                        <template>
                    </ul>
                </div>
            </template>
            {{-- END Sort sections --}}
        </div>
    </div>
</div>