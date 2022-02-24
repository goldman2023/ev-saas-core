@push('head_scripts')
<script>
    $(function() {
        const swiper = new Swiper('.p-available-sections .swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: false,
            pagination: false,
            scrollbar: false,
            slidesPerView: 2.2,
            spaceBetween: 15,
    
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
    </script>
@endpush
<div class="p-available-sections min-h-full w-full flex flex-col bg-white px-4 py-3" x-data="{
    current_page: @js($current_page),
    pages: @js($all_pages),
}">
    <div class="w-full">
        <div class="mt-1 relative flex items-center">
            {{-- Page Selector --}}
            <div class="w-full" x-data="{
                items: pages,
                selected_items: [],
                show: false,
                tag: false,
                multiple: false,
                countSelected() {
                    if(this.selected_items === undefined || this.selected_items === null) {
                        this.selected_items = [];
                    }

                    return this.selected_items.length;
                },
                getPlaceholder() {
                    if(this.countSelected() === 1) {
                        return this.items.find(x => {
                            return x.id == this.selected_items[0];
                        }).title || '';
                    } else if(this.countSelected() > 1) {
                        return '';
                    } else {
                        return '{{ translate('Edit page...') }}';
                    }
                },
                isSelected(key) {
                    return this.selected_items.indexOf(key) !== -1 ? true : false;
                },
                select(key, label) {
                    if(this.isSelected(key)) {
                        this.selected_items.splice(this.selected_items.indexOf(key), 1);
                    } else {
                        if(!this.multiple) {
                            this.selected_items = [key];
                        } else {
                            this.selected_items.push(Number(key));
                        }
                    }

                    if(!this.multiple) {
                        this.show = false;
                        this.placeholder = label;
                    }

                    Alpine.store('preview_page', this.items[key]);
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
        </div>
    </div>
</div>