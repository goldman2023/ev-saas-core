<div x-data="{
    thumbnail: @js(['id' => $category->thumbnail->id ?? null, 'file_name' => $category->thumbnail->file_name ?? '']),
    cover: @js(['id' => $category->cover->id ?? null, 'file_name' => $category->cover->file_name ?? '']),
    meta_img: @js(['id' => $category->meta_img->id ?? null, 'file_name' => $category->meta_img->file_name ?? '']),
    icon: @js(['id' => $category->icon->id ?? null, 'file_name' => $category->icon->file_name ?? '']),
    parent_id: @js($category->parent_id),
    featured: @js($category->featured),
}" x-cloak>
    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                            wire:target="saveCategory"
                            wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full"
            wire:loading.class="opacity-30 pointer-events-none"
            wire:target="saveCategory"
        >

            <div class="grid grid-cols-12 gap-8 mb-10">
                {{-- Left side --}}
                <div class="col-span-8  ">
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Category') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">This information will be displayed publicly so be careful what you share.</p>
                        </div>
                
                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                            <!-- Name -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                    
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Name') }}
                                </label>
                
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" class="form-standard @error('category.name') is-invalid @enderror"
                                            placeholder="{{ translate('New category name') }}"
                                            {{-- @input="generateURL($($el).val())" --}}
                                            wire:model.defer="category.name" />
                                
                                    <x-system.invalid-msg field="category.name"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Name -->

                            <!-- Parent category -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    <span class="mr-2">{{ translate('Parent category') }}</span>
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    @php
                                        $cats = Categories::getAll(true)->keyBy('id')->map(fn($item) => str_repeat('-', $item->level).$item->getTranslation('name'));
                                    @endphp
                                    <x-dashboard.form.select :items="$cats" selected="parent_id"></x-dashboard.form.select>
                                </div>
                            </div>
                            <!-- END Parent category -->


                            <!-- Featured -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900" id="availability-label">{{ translate('Featured') }}</span>
                                    <span class="text-sm text-gray-500" id="availability-description">{{ translate('Category will be featured on the site') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="featured = !featured" 
                                                :class="{'bg-primary':featured, 'bg-gray-200':!featured}" 
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                            <span :class="{'translate-x-5':featured, 'translate-x-0':!featured}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
        
                                    <x-system.invalid-msg field="category.featured"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Featured -->

                            {{-- Icon --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    <span class="mr-2">{{ translate('Icon') }}</span>
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.image-selector field="icon" id="category-icon-image" :selected-image="$category->icon"></x-dashboard.form.image-selector>

                                    <x-system.invalid-msg field="category.icon"></x-system.invalid-msg>
                                </div>
                            </div>
                            {{-- END Icon --}}


                            {{-- Description --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    <span class="mr-2">{{ translate('Description') }}</span>
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea type="text" class="form-standard @error('category.description') is-invalid @enderror"
                                        rows="5"
                                        wire:model.defer="category.description">
                                    </textarea>

                                    <x-system.invalid-msg field="category.description"></x-system.invalid-msg>
                                </div>
                            </div>
                            {{-- END Description --}}
                        </div>
                    </div>
                </div>

                {{-- Right side --}}
                <div class="col-span-4">
                    {{-- Actions --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div class="w-full flex justify-between">
                            @if($is_update)
                                <button type="button" class="btn btn-danger btn-sm" wire:click="removeCategory()">
                                    {{ translate('Delete') }}
                                </button>
                            @endif
                            

                            <button type="button" class="btn btn-primary ml-auto btn-sm"
                                @click="
                                    $wire.set('category.thumbnail', thumbnail.id, true);
                                    $wire.set('category.cover', cover.id, true);
                                    $wire.set('category.meta_img', meta_img.id, true);
                                    $wire.set('category.icon', icon.id, true);
                                    $wire.set('category.parent_id', parent_id, true);
                                    $wire.set('category.featured', featured, true);
                                "
                                wire:click="saveCategory()">
                            {{ translate('Save') }}
                            </button>
                        </div>
                    </div>
                    {{-- END Actions --}}


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
                                        <x-dashboard.form.image-selector field="thumbnail" id="category-thumbnail-image" :selected-image="$category->thumbnail"></x-dashboard.form.image-selector>
                                        
                                        <x-system.invalid-msg field="category.thumbnail"></x-system.invalid-msg>
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
                                        <x-dashboard.form.image-selector field="cover" id="category-cover-image" :selected-image="$category->cover"></x-dashboard.form.image-selector>

                                        <x-system.invalid-msg field="category.cover"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            {{-- END Cover --}}
                        </div>
                        
                    </div>
                    {{-- END Media --}}

                    {{-- SEO --}}
                    <div class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
                            open: false,
                        }" :class="{'p-4': open}">
                        <div class="w-full flex items-center justify-between cursor-pointer " @click="open = !open" :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('SEO') }}</h3>
                            @svg('heroicon-o-chevron-down', ['class' => 'h-4 w-4', ':class' => "{'rotate-180':open}"])
                        </div>
                
                        <div class="w-full" x-show="open">
                            <!-- Meta Title -->
                            <div class="flex flex-col " x-data="{}">
                                        
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ translate('Meta title') }}
                                </label>

                                <div class="mt-1 sm:mt-0">
                                    <input type="text" 
                                            class="form-standard @error('category.meta_title') is-invalid @enderror"
                                            {{-- placeholder="{{ translate('Write meta title...') }}" --}}
                                            wire:model.defer="category.meta_title" />
                                
                                    <x-system.invalid-msg field="category.meta_title"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Meta Title -->

                            <!-- Meta Description -->
                            <div class="flex flex-col sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5" x-data="{}">
                
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ translate('Meta Description') }}
                                </label>
                
                                <div class="mt-1 sm:mt-0">
                                    <textarea type="text" class="form-standard h-[80px] @error('category.meta_description') is-invalid @enderror"
                                                {{-- placeholder="{{ translate('Meta description which will be shown when link is shared on social network and') }}" --}}
                                                wire:model.defer="category.meta_description">
                                    </textarea>
                                
                                    <x-system.invalid-msg class="w-full" field="category.meta_description"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Meta Description -->

                            {{-- Meta Image --}}
                            <div class="flex flex-col sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5">
                                <div class=s"flex flex-col " x-data="{}">
                                            
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ translate('Meta image') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0">
                                        <x-dashboard.form.image-selector field="meta_img" id="category-meta-image" :selected-image="$category->meta_img"></x-dashboard.form.image-selector>
                                        
                                        <x-system.invalid-msg field="category.meta_img"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            {{-- END Meta Image --}}
                            
                        </div>
                    </div>
                    {{-- END SEO --}}
                </div>
            </div>
        </div>
    </div>
</div>
