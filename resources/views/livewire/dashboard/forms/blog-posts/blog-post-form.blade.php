<div class="w-full livewire-form" x-data="{
    status: @js($blogPost->status ?? App\Enums\StatusEnum::draft()->value),
    type: @js($blogPost->type ?? App\Enums\BlogPostTypeEnum::blog()->value),
    thumbnail: @js(toJSONMedia($blogPost->thumbnail)),
    cover: @js(toJSONMedia($blogPost->cover)),
    meta_img: @js(toJSONMedia($blogPost?->meta_img ?? null)),
    gallery: @js(collect($blogPost->gallery)->map(fn($item, $key) => toJSONMedia($item))),
    subscription_only: @js($blogPost->subscription_only === 'true' ? true : false),
    selected_plans: @js($selectedPlans),
    content: @entangle('blogPost.content').defer,
    content_structure: @entangle('blogPost.content_structure').defer,
    selected_categories: @js($selected_categories),
    core_meta: @js($core_meta),
    model_core_meta: @js($model_core_meta),
    onSave() {
        $wire.set('blogPost.thumbnail', this.thumbnail.id, true);
        $wire.set('blogPost.cover', this.cover.id, true);
        $wire.set('blogPost.gallery', this.gallery, true);
        $wire.set('blogPost.meta_img', this.meta_img.id, true);
        $wire.set('blogPost.status', this.status, true);
        $wire.set('blogPost.type', this.type, true);
        $wire.set('blogPost.subscription_only', this.subscription_only, true);
        $wire.set('blogPost.content', this.content, true);
        $wire.set('blogPost.content_structure', this.content_structure, true);
        $wire.set('selected_categories', this.selected_categories, true);
        $wire.set('core_meta', this.core_meta, true);
        {{-- $wire.set('model_core_meta.portfolio_link', this.model_core_meta.portfolio_link, true); --}}
    }
}" @validation-errors.window="$scrollToErrors($event.detail.errors, 700);" x-cloak>
@push('head_scripts')
    <script src="{{ static_asset('js/editor.js', false, true, true) }}"></script>
@endpush
    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:target="saveBlogPost"
            wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full" wire:loading.class="opacity-30 pointer-events-none" wire:target="saveBlogPost">

            <div class="grid grid-cols-12 gap-8 mb-10">

                {{-- Left side --}}
                <div class="col-span-12 md:col-span-8">
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ translate('Blog post content') }}
                            </h3>
                        </div>

                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                            <!-- Title -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Title') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text"
                                        class="form-standard @error('blogPost.name') is-invalid @enderror"
                                        placeholder="{{ translate('') }}" {{-- @input="generateURL($($el).val())" --}}
                                        wire:model.defer="blogPost.name" />

                                    <x-system.invalid-msg field="blogPost.name"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Title -->

                            {{-- Subscription only --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 "
                                x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Subscription only?')
                                        }}</span>
                                    <p class="text-gray-500 text-sm">{{ translate('If you want only subscribers of
                                        certain plans to have full access to this article') }}</p>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="subscription_only = !subscription_only"
                                        :class="{'bg-primary':subscription_only, 'bg-gray-200':!subscription_only}"
                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                        role="switch">
                                        <span
                                            :class="{'translate-x-5':subscription_only, 'translate-x-0':!subscription_only}"
                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>
                            {{-- END Subscription only --}}

                            {{-- TODO: Fix this multiple select --}}
                            <div class="w-full" x-show="subscription_only" wire:ignore>
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 "
                                    x-data="{
                                    items: @js(\App\Models\Plan::published()->get()->map(fn($item) => ['id' => $item->id, 'title' => $item->name])->toArray()),
                                    selected_items: selected_plans,
                                    show: false,
                                    multiple: true,
                                    tag: false,
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
                                            }).values || '';
                                        } else if(this.countSelected() > 1) {
                                            return '';
                                        } else {
                                            return '{{ translate('Choose option(s)') }}';
                                        }
                                    },
                                    isSelected(id) {
                                        if(this.countSelected() > 0) {
                                            for(let i = 0; i < this.countSelected(); i++) {
                                                if(this.selected_items[i]['id'] === id) {
                                                    return true;
                                                }
                                            }
                                        }

                                        return false;
                                    },
                                    select(id, label) {
                                        if(this.isSelected(id)) {
                                            for(let i = 0; i < this.countSelected(); i++) {
                                                if(this.selected_items[i]['id'] === id) {
                                                    delete this.selected_items[i];
                                                }
                                            }
                                        } else {
                                            if(!this.multiple) {
                                                this.selected_items = [
                                                    {'id': id, 'title':label}
                                                ];
                                            } else {
                                                this.selected_items.push({'id': id, 'title':label});
                                            }
                                        }

                                        if(!this.multiple) {
                                            this.show = false;
                                            this.placeholder = label;
                                        }

                                        console.log(this.selected_items);
                                        selected_plans = this.selected_items;
                                    }
                                }" x-init="console.log(items)">
                                    <div
                                        class="justify-center h-full col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Select plans')
                                            }}</span>
                                        <p class="text-gray-500 text-sm">{{ translate('Select plans which can access the
                                            whole article') }}</p>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full">

                                        <div class="we-select relative w-full" x-data="{}"
                                            @click.outside="show = false">
                                            <div class="we-select__selector select-none w-full flex flex-wrap border pl-3 pt-2 pb-1 pr-6 relative cursor-pointer"
                                                @click="show = !show">
                                                @svg('heroicon-o-chevron-down', ['class' => 'we-select__selector-arrow
                                                absolute w-[16px] h-[16px] vertical-center', ':class' => "{'rotate-180':
                                                show}"])

                                                <template x-if="!multiple">
                                                    <span class="block pb-1" x-text="getPlaceholder()"></span>
                                                </template>

                                                <template x-if="multiple">
                                                    <div class="w-full flex flex-wrap">
                                                        <template x-if="countSelected() > 0">
                                                            <template x-for="item in selected_items">
                                                                <div
                                                                    class="we-select__selector-selected-item rounded mr-2 mb-1 relative">
                                                                    <span
                                                                        class="we-select__selector-selected-item-label pl-1 mr-1"
                                                                        x-text="item.title"></span>
                                                                    <button type="button"
                                                                        class="we-select__selector-selected-item-remove px-2"
                                                                        @click="event.stopPropagation(); select(item.id, item.title)">
                                                                        <span>×</span>
                                                                    </button>
                                                                </div>
                                                            </template>
                                                        </template>
                                                        <template x-if="countSelected() <= 0">
                                                            <span class="block pb-1" x-text="getPlaceholder()"></span>
                                                        </template>
                                                    </div>
                                                </template>
                                            </div>

                                            <div class="we-select__dropdown  absolute bg-white shadow border rounded mt-1  w-full"
                                                x-show="show">
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


                            <!-- Excerpt -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Excerpt') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea type="text"
                                        class="form-standard h-[80px] @error('blogPost.excerpt') is-invalid @enderror"
                                        placeholder="{{ translate('Write a short promo description for this article') }}"
                                        wire:model.defer="blogPost.excerpt">
                                </textarea>

                                    <x-system.invalid-msg class="w-full" field="blogPost.excerpt">
                                    </x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Excerpt -->

                            <!-- Content -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}" wire:ignore>

                                <label class="col-span-3 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Content') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-3">

                                    <x-dashboard.form.editor-js field="content" id="blogPost-content-wysiwyg" />


                                    <x-system.invalid-msg class="w-full" field="blogPost.content">
                                    </x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Content -->

                        </div>
                    </div>

                   <x-dashboard.global.meta-fields :page="$blogPost"></x-dashboard.global.meta-fields>
                </div>
                {{-- END Left side --}}

                {{-- Right side --}}
                <div class="col-span-12 md:col-span-4">

                    {{-- Actions --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <!-- Status -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                            <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                <span class="mr-2">{{ translate('Status') }}</span>

                                @if($blogPost->status === App\Enums\StatusEnum::published()->value)
                                <span class="badge-success">{{ ucfirst($blogPost->status) }}</span>
                                @elseif($blogPost->status === App\Enums\StatusEnum::draft()->value)
                                <span class="badge-warning">{{ ucfirst($blogPost->status) }}</span>
                                @elseif($blogPost->status === App\Enums\StatusEnum::pending()->value)
                                <span class="badge-info">{{ ucfirst($blogPost->status) }}</span>
                                @elseif($blogPost->status === App\Enums\StatusEnum::private()->value)
                                <span class="badge-dark">{{ ucfirst($blogPost->status) }}</span>
                                @endif
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.select :items="\App\Enums\StatusEnum::toArray('archived')"
                                    selected="status" :nullable="false"></x-dashboard.form.select>
                            </div>
                        </div>
                        <!-- END Status -->

                        <!-- Type -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                            <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                <span class="mr-2">{{ translate('Type') }}</span>
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.select :items="\App\Enums\BlogPostTypeEnum::toArray()" selected="type" :nullable="false"></x-dashboard.form.select>
                            </div>
                        </div>
                        <!-- END Type -->

                        <div
                            class="w-full flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                            @if($is_update)
                                <button type="button" class="btn btn-danger btn-sm cursor-pointer">
                                    {{ translate('Delete') }}
                                </button>
                            @endif

                            <div class="flex flex-row ml-auto">
                                @if($is_update)
                                    <a href="{{ $blogPost->getPermalink() }}" class="btn-info mr-2" target="_blank">
                                        {{ translate('Preview') }}
                                    </a>
                                @endif
                                <button type="button" class="btn btn-primary ml-auto btn-sm" @click="onSave()"
                                    wire:click="saveBlogPost()">
                                    {{ translate('Save') }}
                                </button>
                            </div>

                        </div>
                    </div>
                    {{-- END Actions --}}

                    {{-- Porfolio Meta --}}
                    <div class="p-4 mt-8 border bg-white border-gray-200 rounded-lg shadow" x-show="type === 'portfolio'">
                        <div class="w-100" >
                            <!-- Portfolio link-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Portfolio link') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.input field="model_core_meta.portfolio_link"></x-dashboard.form.input>
                                </div>
                            </div>
                            <!-- END Portfolio link -->
                        </div>
                    </div>
                    {{-- END Porfolio Meta --}}


                    {{-- Media --}}
                    <div class="mt-8 p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div class="w-full flex items-center justify-between border-b border-gray-200 pb-3 mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Media') }}</h3>
                        </div>

                        <div class="w-full">
                            {{-- Thumbnail --}}
                            <div class="sm:items-start">
                                <div class="flex flex-col " x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ translate('Thumbnail image') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0">
                                        <x-dashboard.form.file-selector field="thumbnail" id="blogPost-thumbnail-image"
                                            :selected-image="$blogPost->thumbnail"></x-dashboard.form.file-selector>

                                        <x-system.invalid-msg field="blogPost.thumbnail"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            {{-- END Thumbnail --}}


                            {{-- Cover --}}
                            <div class="sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                                <div class="flex flex-col " x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ translate('Cover image') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0">
                                        <x-dashboard.form.file-selector field="cover" id="blogPost-cover-image"
                                            :selected-image="$blogPost->cover"></x-dashboard.form.file-selector>

                                        <x-system.invalid-msg field="blogPost.cover"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            {{-- END Cover --}}

                            {{-- Gallery --}}
                            <div class="sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                                <div class="flex flex-col " x-data="{}">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ translate('Gallery') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0">
                                        <x-dashboard.form.file-selector
                                            id="blogPost-gallery-image"
                                            field="gallery"
                                            :file-type="\App\Enums\FileTypesEnum::image()->value"
                                            :selected-image="$blogPost->gallery"
                                            :multiple="true"
                                            add-new-item-label="{{ translate('Add new image') }}"></x-dashboard.form.file-selector>

                                        <x-system.invalid-msg field="blogPost.gallery"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            {{-- END Gallery --}}
                        </div>
                    </div>
                    {{-- END Media --}}


                    {{-- Category Selector --}}
                    <div class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
                        open: true,
                    }" :class="{'p-4': open}">
                        <div class="w-full flex items-center justify-between cursor-pointer " @click="open = !open"
                            :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Categories') }}</h3>
                            @svg('heroicon-o-chevron-down', ['class' => 'h-4 w-4', ':class' => "{'rotate-180':open}"])
                        </div>

                        <div class="w-full" x-show="open">
                            <x-dashboard.form.category-selector> </x-dashboard.form.category-selector>
                        </div>
                    </div>
                    {{-- END Category Selector --}}
                </div>
                {{-- END Right side --}}

            </div>
        </div>
    </div>
</div>
