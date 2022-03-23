<div x-data="{
        thumbnail: @js(['id' => $product->thumbnail->id ?? null, 'file_name' => $product->thumbnail->file_name ?? '']),
        cover: @js(['id' => $product->cover->id ?? null, 'file_name' => $product->cover->file_name ?? '']),
        meta_img: @js(['id' => $product->meta_img->id ?? null, 'file_name' => $product->meta_img->file_name ?? '']),
        pdf: @js(['id' => $product->pdf->id ?? null, 'file_name' => $product->pdf->file_name ?? '']),
        gallery: @js($product->gallery?->map(fn($item) => ['id' => $item->id ?? null, 'file_name' => $item->file_name ?? '']) ?? []),
        video_provider: @js($product->video_provider),
        base_currency: @js($product->base_currency),

        status: @js($product->status ?? App\Enums\StatusEnum::draft()->value),
        is_digital: {{ $product->digital === true ? 'true' : 'false' }},
        use_serial: {{ $product->use_serial === true ? 'true' : 'false' }},
        
        discount_type: @js($product->discount_type),
        tax_type: @js($product->tax_type),
        description: @js($product->description),
        attributes: @js($attributes),
        selected_attribute_values: @js($selected_predefined_attribute_values),
        selected_categories: @js($selected_categories),
        predefined_types: @js(\App\Enums\AttributeTypeEnum::getPredefined() ?? []),
        onSave() {
            $wire.set('product.description', $('[name=\'product.description\']').val(), true);
            $wire.set('product.thumbnail', $('[name=\'product.thumbnail\']').val(), true);
            $wire.set('product.gallery', $('[name=\'product.gallery\']').val(), true);
            $wire.set('product.pdf', $('[name=\'product.pdf\']').val(), true);
            $wire.set('product.video_provider', getSafe(fn => $('[name=\'product.video_provider\']').select2('data')[0].id, null), true);
            $wire.set('product.base_currency', getSafe(fn => $('[name=\'product.base_currency\']').select2('data')[0].id, null), true);
            $wire.set('product.discount_type', getSafe(fn => $('[name=\'product.discount_type\']').select2('data')[0].id, null), true);
            $wire.set('product.tax_type', getSafe(fn => $('[name=\'product.tax_type\']').select2('data')[0].id, null), true);
            $wire.set('product.use_serial', this.use_serial, true);
            $wire.set('product.digital', this.is_digital, true);
            $wire.set('selected_predefined_attribute_values', this.selected_attribute_values, true);
            $wire.set('attributes', this.attributes, true);
            $wire.set('product.meta_img', $('[name=\'product.meta_img\']').val(), true);
            $wire.set('product.status', this.status, true);
            $wire.set('product.tags', $('[name=\'product.tags\']').select2('data').map(x => x.id), true);
            let $selected_categories = [];
            $('[name=\'selected_categories\']').each(function(index, item) {
                $selected_categories = [...$selected_categories, ...$(item).select2('data').map(x => x.id)];
            });
            $wire.set('selected_categories', $selected_categories, true);
            $wire.set('product.brand_id', getSafe(fn => $('[name=\'product.brand_id\']').select2('data')[0].id, null), true);
        }
    }"
     class="lw-form container-fluid"
     @init-product-form.window=""
     @validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
     x-cloak>


     <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                              wire:target="saveProduct"
                              wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full"
             wire:loading.class="opacity-30 pointer-events-none"
             wire:target="saveProduct"
        >

            <div class="grid grid-cols-12 gap-8 mb-10">
                {{-- Left side --}}
                <div class="col-span-8  ">

                    {{-- Card Basic --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Basic info') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('This is basic and required info about the product') }}</p>
                        </div>
                
                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <!-- Title -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Name') }}
                                </label>
                
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" class="form-standard @error('product.name') is-invalid @enderror"
                                            placeholder="{{ translate('New post title') }}"
                                            {{-- @input="generateURL($($el).val())" --}}
                                            wire:model.defer="product.name" />
                                
                                    <x-system.invalid-msg field="product.name"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Title -->

                            <!-- Excerpt -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Excerpt') }}
                                </label>
                
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea type="text" class="form-standard h-[80px] @error('product.excerpt') is-invalid @enderror"
                                                placeholder="{{ translate('Write a short promo description for this product') }}"
                                                wire:model.defer="product.excerpt">
                                    </textarea>
                                
                                    <x-system.invalid-msg class="w-full" field="product.excerpt"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Excerpt -->

                            <!-- Description -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}" wire:ignore>
                
                                <label class="col-span-3 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Description') }}
                                </label>
                
                                {{-- <div class="mt-1 sm:mt-0 sm:col-span-3">
                                    <x-dashboard.form.froala field="description" id="product-description-wysiwyg"></x-dashboard.form.froala>
                                
                                    <x-system.invalid-msg class="w-full" field="product.description"></x-system.invalid-msg>
                                </div> --}}
                            </div>
                            <!-- END Description -->
                        </div>
                    </div>
                    {{-- END Card Basic --}}

                    
                    {{-- Card Pricing --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5 sm:mt-8" x-data="{
                            show_tax: {{ !empty($product->tax) ? 'true':'false' }},
                        }">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Pricing') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Product pricing details') }}</p>
                        </div>
                
                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <!-- Price -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Price') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="grid grid-cols-10 gap-3">
                                        <div class="col-span-6">
                                            <input type="number" 
                                                    step="0.01" 
                                                    class="form-standard @error('product.unit_price') is-invalid @enderror"
                                                    placeholder="{{ translate('0.00') }}"
                                                    wire:model.defer="product.unit_price" />
                                        </div>

                                        <div class="col-span-4" x-data="{}"> 
                                            <x-dashboard.form.select :items="\FX::getAllCurrencies(formatted: true)" selected="base_currency" :nullable="false"></x-dashboard.form.select>
                                        </div>

                                        <x-system.invalid-msg class="col-span-10" field="product.unit_price"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            <!-- END Price -->

                            <!-- Discount and Discount type -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Discount') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="grid grid-cols-10 gap-3">
                                        <div class="col-span-6">
                                            <input type="number" 
                                                    step="0.01" 
                                                    min="0"
                                                    class="form-standard @error('product.discount') is-invalid @enderror"
                                                    placeholder="{{ translate('0.00') }}"
                                                    wire:model.defer="product.discount" />
                                        </div>

                                        <div class="col-span-4" x-data="{}"> 
                                            <x-dashboard.form.select :items="\App\Enums\AmountPercentTypeEnum::toArray()" selected="discount_type" :nullable="false"></x-dashboard.form.select>
                                        </div>

                                        <x-system.invalid-msg class="col-span-10" field="product.discount"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            <!-- END Discount and Discount type -->

                            {{-- Additional fee/tax --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Has additional fee?') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="show_tax = !show_tax" 
                                                :class="{'bg-primary':show_tax, 'bg-gray-200':!show_tax}" 
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                            <span :class="{'translate-x-5':show_tax, 'translate-x-0':!show_tax}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="w-full mt-4" x-show="show_tax">
                                <!-- Tax and Tax type -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Additional Fee') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="grid grid-cols-10 gap-3">
                                            <div class="col-span-6">
                                                <input type="number" 
                                                        step="0.01" 
                                                        min="0"
                                                        class="form-standard @error('product.tax') is-invalid @enderror"
                                                        placeholder="{{ translate('Additional fee (fixed or percentage)') }}"
                                                        wire:model.defer="product.tax" />
                                            </div>

                                            <div class="col-span-4" x-data="{}"> 
                                                <x-dashboard.form.select :items="\App\Enums\AmountPercentTypeEnum::toArray()" selected="tax_type" :nullable="false"></x-dashboard.form.select>
                                            </div>

                                            <x-system.invalid-msg class="col-span-10" field="product.tax"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Tax and Tax type -->
                            </div>
                            {{-- Additional fee/tax --}}

                            <!-- Cost per item -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Cost per item') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="grid grid-cols-10 gap-3">
                                        <div class="col-span-6">
                                            <input type="number" 
                                                    step="0.01" 
                                                    class="form-standard @error('product.purchase_price') is-invalid @enderror"
                                                    placeholder="{{ translate('0.00') }}"
                                                    wire:model.defer="product.purchase_price" />
                                        </div>

                                        <x-system.invalid-msg class="col-span-10" field="product.purchase_price"></x-system.invalid-msg>

                                        <small class="col-span-10 w-100">
                                            {{ translate('Customers won\'t see this. For your reference and reports only.') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <!-- END Cost per item -->
                        </div>
                    </div>
                    {{-- END Card Pricing --}}
                    

                    {{-- Card Inventory --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5 sm:mt-8" x-data="{
                        show_tax: {{ !empty($product->tax) ? 'true':'false' }},
                    }">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Pricing') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Product pricing details') }}</p>
                        </div>
                
                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <!-- Price -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Price') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="grid grid-cols-10 gap-3">
                                        <div class="col-span-6">
                                            <input type="number" 
                                                    step="0.01" 
                                                    class="form-standard @error('product.unit_price') is-invalid @enderror"
                                                    placeholder="{{ translate('0.00') }}"
                                                    wire:model.defer="product.unit_price" />
                                        </div>

                                        <div class="col-span-4" x-data="{}"> 
                                            <x-dashboard.form.select :items="\FX::getAllCurrencies(formatted: true)" selected="base_currency" :nullable="false"></x-dashboard.form.select>
                                        </div>

                                        <x-system.invalid-msg class="col-span-10" field="product.unit_price"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            <!-- END Price -->

                            <!-- Discount and Discount type -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Discount') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="grid grid-cols-10 gap-3">
                                        <div class="col-span-6">
                                            <input type="number" 
                                                    step="0.01" 
                                                    min="0"
                                                    class="form-standard @error('product.discount') is-invalid @enderror"
                                                    placeholder="{{ translate('0.00') }}"
                                                    wire:model.defer="product.discount" />
                                        </div>

                                        <div class="col-span-4" x-data="{}"> 
                                            <x-dashboard.form.select :items="\App\Enums\AmountPercentTypeEnum::toArray()" selected="discount_type" :nullable="false"></x-dashboard.form.select>
                                        </div>

                                        <x-system.invalid-msg class="col-span-10" field="product.discount"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            <!-- END Discount and Discount type -->

                            {{-- Additional fee/tax --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Has additional fee?') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="show_tax = !show_tax" 
                                                :class="{'bg-primary':show_tax, 'bg-gray-200':!show_tax}" 
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                            <span :class="{'translate-x-5':show_tax, 'translate-x-0':!show_tax}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="w-full mt-4" x-show="show_tax">
                                <!-- Tax and Tax type -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Additional Fee') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="grid grid-cols-10 gap-3">
                                            <div class="col-span-6">
                                                <input type="number" 
                                                        step="0.01" 
                                                        min="0"
                                                        class="form-standard @error('product.tax') is-invalid @enderror"
                                                        placeholder="{{ translate('Additional fee (fixed or percentage)') }}"
                                                        wire:model.defer="product.tax" />
                                            </div>

                                            <div class="col-span-4" x-data="{}"> 
                                                <x-dashboard.form.select :items="\App\Enums\AmountPercentTypeEnum::toArray()" selected="tax_type" :nullable="false"></x-dashboard.form.select>
                                            </div>

                                            <x-system.invalid-msg class="col-span-10" field="product.tax"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Tax and Tax type -->
                            </div>
                            {{-- Additional fee/tax --}}

                            <!-- Cost per item -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Cost per item') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="grid grid-cols-10 gap-3">
                                        <div class="col-span-6">
                                            <input type="number" 
                                                    step="0.01" 
                                                    class="form-standard @error('product.purchase_price') is-invalid @enderror"
                                                    placeholder="{{ translate('0.00') }}"
                                                    wire:model.defer="product.purchase_price" />
                                        </div>

                                        <x-system.invalid-msg class="col-span-10" field="product.purchase_price"></x-system.invalid-msg>

                                        <small class="col-span-10 w-100">
                                            {{ translate('Customers won\'t see this. For your reference and reports only.') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <!-- END Cost per item -->
                        </div>
                    </div>
                    {{-- END Card Inventory --}}
                </div>

                {{-- Right side --}}
                <div class="col-span-4">
                    {{-- Actions --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div class="w-full flex">
                        
                            <button type="button" class="btn btn-primary ml-auto btn-sm"
                                @click=""
                                wire:click="savePlan()">
                            {{ translate('Save') }}
                            </button>
                        </div>
                    </div>
                    {{-- END Actions --}}

                    {{-- Card Media --}}
                    <div class="p-4 mt-8 border bg-white border-gray-200 rounded-lg shadow">
                        <div class="w-full flex items-center justify-between border-b border-gray-200 pb-3 mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Media') }}</h3>
                        </div>
                
                        <div class="w-full" x-data="{
                            show_video: {{ !empty($product->video_link) ? 'true':'false' }},
                            show_pdf: {{ !empty($product->pdf) ? 'true':'false' }},
                        }">
                            {{-- Thumbnail --}}
                            <div class="sm:items-start">
                                <div class="flex flex-col " x-data="{}">
                                            
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ translate('Thumbnail image') }}
                                    </label>
    
                                    <div class="mt-1 sm:mt-0">
                                        <x-dashboard.form.image-selector field="thumbnail" id="product-thumbnail-image" :selected-image="$product->thumbnail"></x-dashboard.form.image-selector>
                                        
                                        <x-system.invalid-msg field="product.thumbnail"></x-system.invalid-msg>
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
                                        <x-dashboard.form.image-selector field="cover" id="product-cover-image" :selected-image="$product->cover"></x-dashboard.form.image-selector>
    
                                        <x-system.invalid-msg field="product.cover"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            {{-- END Cover --}}

                            {{-- Video & Document --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900" id="availability-label">{{ translate('Has Video') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="show_video = !show_video" 
                                                :class="{'bg-primary':show_video, 'bg-gray-200':!show_video}" 
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                            <span :class="{'translate-x-5':show_video, 'translate-x-0':!show_video}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="w-100 mt-4" x-show="show_video">
                                <!-- Video Provider -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        <span class="mr-2">{{ translate('Video provider') }}</span>
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.select :items="EVS::getMappedVideoProviders()" selected="video_provider"></x-dashboard.form.select>
                                    </div>
                                </div>
                                <!-- END Video Provider -->

                                <!-- Video Link -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                                    
                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Video link') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input type="text" class="form-standard @error('product.video_link') is-invalid @enderror"
                                                placeholder="{{ translate('Link to the video...') }}"
                                                wire:model.defer="product.video_link" />
                                    
                                        <x-system.invalid-msg field="product.video_link"></x-system.invalid-msg>

                                        <div class="w-full">
                                            <small class="text-warning">
                                                {{ translate('Use proper link without extra parameter. Don\'t use short share link/embeded iframe code.') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Video Link -->
                            </div>

                            {{-- Specificaion document --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4" x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900" id="availability-label">{{ translate('Has specification document') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="show_pdf = !show_pdf" 
                                                :class="{'bg-primary':show_pdf, 'bg-gray-200':!show_pdf}" 
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                                            <span :class="{'translate-x-5':show_pdf, 'translate-x-0':!show_pdf}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="w-100 mt-4" x-show="show_pdf">
                                <div class="sm:items-start">
                                    <div class="flex flex-col " x-data="{}">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ translate('PDF Specification (optional)') }}
                                        </label>
        
                                        <div class="mt-1 sm:mt-0">
                                            <x-dashboard.form.image-selector field="pdf" id="product-document-pdf" :selected-image="$product->pdf"></x-dashboard.form.image-selector>
                                            
                                            <x-system.invalid-msg field="product.pdf"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- END Specificaion document --}}

                        </div>
                    </div>
                    {{-- END Card Media --}}

                    {{-- Category Selector --}}
                    <div class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
                        open: true,
                    }" :class="{'p-4': open}">
                        <div class="w-full flex items-center justify-between cursor-pointer " @click="open = !open" :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Categories') }}</h3>
                            @svg('heroicon-o-chevron-down', ['class' => 'h-4 w-4', ':class' => "{'rotate-180':open}"])
                        </div>
                
                        <div class="w-full" x-show="open">
                            <x-dashboard.form.category-selector> </x-dashboard.form.category-selector>
                        </div>
                    </div>
                    {{-- END Category Selector --}}
                </div>


            </div>
        </div>
     </div>

    <div class="position-relative">
        <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                              wire:target="saveProduct"
                              wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

        {{-- FIXME: The opacity issue --}}
        <div class="row w-100"
            wire:loading.class="opacity-6 prevent-pointer-events"
            wire:target="saveProduct">

            {{-- Left column --}}
            <div class="col-12 col-md-8">


                {{-- Card Inventory --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Inventory') }}</h5>

                        <div class="w-100">
                            <div class="row form-group mt-0 mb-0">
                                <div class="col-12 col-sm-6">
                                    <x-ev.form.input name="product.sku" class="form-control-sm" groupclass="mb-0" type="text" label="{{ translate('SKU (Stock keeping unit)') }}" placeholder="{{ translate('SKU of the main product (not variations).') }}" >
                                        <small class="text-muted">{{ translate('Leave empty if you want to add only SKU of the variations.') }}</small>
                                    </x-ev.form.input>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <x-ev.form.input name="product.barcode" class="form-control-sm" groupclass="mb-0" type="text" label="{{ translate('Barcode (ISBN, UPC, GTIN, etc.)') }}" placeholder="{{ translate('Barcode of the main product (not variations).') }}" >
                                        <small class="text-muted">{{ translate('Leave empty if you want to add only Barcode of the variations.') }}</small>
                                    </x-ev.form.input>
                                </div>
                            </div>
                        </div>

                        <!-- Uses Serial -->
                        <div class="w-100 pt-3 d-flex">
                            <label class="toggle-switch mr-3">
                                <input type="checkbox" x-model="use_serial" class="js-toggle-switch toggle-switch-input">
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>

                                <span class="ml-3">{{ translate('Uses serial numbers?') }}</span>
                            </label>
                        </div>
                        <!-- END Uses Serial -->

                        <!-- Allow out of stock purchases -->
                        <div class="w-100 pt-2 d-flex">
                            <label class="toggle-switch mr-3">
                                <input type="checkbox" wire:model.defer="product.allow_out_of_stock_purchases" class="js-toggle-switch toggle-switch-input">
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>

                                <span class="ml-3">{{ translate('Allow selling even when out of stock?') }}</span>
                            </label>
                        </div>
                        <!-- END Allow out of stock purchases -->

                        <!-- Standard Inventory tracking -->
                        <div class="w-100 pt-3" :class="{'d-none': use_serial}">
                            <x-ev.form.input name="product.min_qty" class="form-control-sm"  type="number" label="{{ translate('Minimum quantity user can purchase') }}" :required="true" min="1" step="1">
                                <small class="text-muted">{{ translate('This is the minimum quantity user can purchase.') }}</small>
                            </x-ev.form.input>

                            <x-ev.form.input name="product.current_stock" class="form-control-sm" groupclass="mb-0" type="number" label="{{ translate('Stock quantity') }}" :required="true"  min="0" step="1">
                                <small class="text-muted">{{ translate('This is the current stock quantity.') }}</small>
                            </x-ev.form.input>
                        </div>
                        <!-- END Standard Inventory tracking -->

                        <!-- Low stock quantity warning threshold -->
                        <div class="w-100 pt-3">
                            <x-ev.form.input name="product.unit" class="form-control-sm" type="text" label="{{ translate('Unit') }}" placeholder="{{ translate('pc/kg/m/per meter/gram etc.') }}">
                            </x-ev.form.input>

                            <x-ev.form.input name="product.low_stock_qty" class="form-control-sm" groupclass="mb-0" type="number" label="{{ translate('Low stock quantity warning threshold') }}"  min="0" step="1">
                            </x-ev.form.input>
                        </div>
                        <!-- END ow stock quantity warning threshold -->
                    </div>
                </div>
                {{-- END Card Inventory --}}


                {{-- Card Shipping --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Shipping') }}</h5>

                        <div class="w-100">
                            <!-- Is digital product? -->
                            <div class="w-100 d-flex">
                                <label class="toggle-switch mr-3">
                                    <input type="checkbox" x-model="is_digital" class="js-toggle-switch toggle-switch-input">
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>

                                    <span class="ml-3">{{ translate('Is this a digital product?') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="w-100" :class="{'d-none': is_digital}">
                        {{-- TODO: Add Shipping methods first and then edit this part --}}
                        </div>
                    </div>
                </div>
                {{-- END Card Shipping --}}


                {{-- Card Attributes --}}
                <div class="card mb-3 mb-lg-5" x-data="" wire:ignore>
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Attributes') }}</h5>

                        <template x-for="attribute in attributes" >
                            <div class="w-100 mb-3" x-data="{
                                    getSelectorID() { 
                                        return 'attributes_'+this.attribute.id+'_attribute_values'; 
                                    },
                                    hasCustomProperty(name) {
                                        return this.attribute.custom_properties !== null &&
                                                this.attribute.custom_properties !== undefined &&
                                                this.attribute.custom_properties.hasOwnProperty(name);
                                    },
                                }" x-cloak >

                                {{-- Dropdown --}}
                                <template x-if="attribute.type === 'dropdown'">
                                    <div class="w-100" x-data="{
                                            items: attribute.attribute_values,
                                            selected_items: selected_attribute_values['attribute.'+attribute.id],
                                            show: false,
                                            multiple: hasCustomProperty('multiple') && attribute.custom_properties.multiple,
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
        
                                                selected_attribute_values['attribute.'+attribute.id] = this.selected_items;
                                            }
                                        }" >
                                            <label class="w-100 input-label" x-text="attribute.name"></label>

                                            <div class="we-select position-relative w-100" x-data="{}" @click.outside="show = false">
                                                <div class="we-select__selector noselect w-100 d-flex flex-wrap border pl-3 pt-2 pb-1 pr-6 position-relative pointer" 
                                                     @click="show = !show">
                                                    @svg('heroicon-o-chevron-down', ['class' => 'we-select__selector-arrow position-absolute square-16 vertical-center', ':class' => "{'rotate-180deg': show}"])
                                
                                                    <template x-if="!multiple">
                                                        <span class="d-block pb-1" x-text="getPlaceholder()"></span>
                                                    </template>

                                                    <template x-if="multiple">
                                                        <div class="w-100 d-flex flex-wrap">
                                                            <template x-if="countSelected() > 0">
                                                                <template x-for="item in items.filter(x => {
                                                                    return selected_items.indexOf(x.id) !== -1;
                                                                  })">
                                                                    <div class="we-select__selector-selected-item rounded mr-2 mb-1 position-relative">
                                                                        <span class="we-select__selector-selected-item-label pl-1 mr-1" x-text="item.values"></span>
                                                                        <button type="button" class="we-select__selector-selected-item-remove px-2" 
                                                                                @click="event.stopPropagation(); select(item.id, item.values)">
                                                                            <span>×</span>
                                                                        </button>
                                                                    </div>
                                                                </template>
                                                            </template>
                                                            <template x-if="countSelected() <= 0">
                                                                <span class="d-block pb-1" x-text="getPlaceholder()"></span>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </div>
                
                                                <div class="we-select__dropdown  position-absolute bg-white shadow border rounded mt-1  w-100" x-show="show">
                                                    <ul class="we-select__dropdown-list noselect w-100">
                                                        <template x-for="item in items">
                                                            <li class="we-select__dropdown-list-item py-2 px-3 pointer" 
                                                                x-text="item.values"
                                                                :class="{'selected': isSelected(item.id) }"
                                                                @click="select(item.id, item.values)"></li>
                                                        </template>
                                                    </ul>
                                                </div>
                                            </div>

                                            {{-- <select class="form-control custom-select custom-select-sm"
                                                    :id="'attributes_'+attribute.id+'_attribute_values'"
                                                    x-bind:multiple="isMultiple(attribute)"
                                                    x-model="selected_attribute_values['attribute.'+attribute.id]"
                                                    data-hs-select2-options='{
                                                        "minimumResultsForSearch": "Infinity",
                                                        "selectionCssClass": "custom-select-sm",
                                                        "placeholder": "{{ translate('Select value') }}"
                                                }'>
                                                    <option></option>
                                                    <template x-for="attribute_value in attribute.attribute_values">
                                                        <option :value="attribute_value.id" x-text="attribute_value.values">
                                                        </option>
                                                    </template>
                                            </select> --}}

                                            <template x-if="hasCustomProperty('multiple') && attribute.custom_properties.multiple">
                                                <div class="w-100 d-flex mt-2 mb-2">
                                                    <label class="toggle-switch mr-3">
                                                        <input type="checkbox" x-model="attribute.for_variations" class="js-toggle-switch toggle-switch-input">
                                                        <span class="toggle-switch-label">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>

                                                        <span class="ml-3">{{ translate('Used for variations') }}</span>
                                                    </label>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                                {{-- END Dropdown --}}

                                {{-- Plain Text --}}
                                <template x-if="attribute.type === 'plain_text'">
                                    <div class="w-100" x-data="{}" x-init="">
                                        <label class="w-100 input-label" x-text="attribute.name"></label>

                                        <input type="text"
                                            class="form-control form-control-sm"
                                            :id="'attributes_'+attribute.id+'_attribute_values'"
                                            x-model="attribute.attribute_values[0].values" />
                                    </div>
                                </template>
                                {{-- END Plain Text --}}

                                {{-- Number --}}
                                <template x-if="attribute.type === 'number'">
                                    <div class="w-100" x-data="{
                                        getMinValue() { 
                                            return this.hasCustomProperty(this.attribute, 'min_value') ? this.attribute.custom_properties.min_value : 0; 
                                        },
                                        getMaxValue() { 
                                            return this.hasCustomProperty(this.attribute, 'max_value') ? this.attribute.custom_properties.max_value : 999; 
                                        },
                                    }" x-init="">
                                        <label class="w-100 input-label" x-text="attribute.name"></label>

                                        <div class="input-group" :class="{'input-group-merge': !hasCustomProperty('unit')}">

                                            <input type="number"
                                            class="form-control form-control-sm"
                                            :id="'attributes_'+attribute.id+'_attribute_values'"
                                            x-bind:min="getMinValue()"
                                            x-bind:max="getMaxValue()"
                                            x-model="attribute.attribute_values[0].values" />

                                            <template x-if="hasCustomProperty('unit')">
                                                <div class="input-group-append">
                                                    <span class="input-group-text input-group-text-sm" x-text="attribute.custom_properties.unit"></span>
                                                </div>
                                            </template>
                                        </div>

                                    </div>
                                </template>
                                {{-- END Number --}}


                                {{-- Date --}}
                                <template x-if="attribute.type === 'date'">
                                    <div class="w-100" x-data="{
                                            getDateOptions() {
                                                let options = {
                                                    mode: 'single',
                                                    enableTime: false,
                                                };
                                    
                                                if(this.hasCustomProperty('with_time') && this.attribute.custom_properties.with_time) {
                                                    options.enableTime = true;
                                                    options.dateFormat = 'd.m.Y H:i';
                                                }
                                    
                                                if(this.hasCustomProperty('range') && this.attribute.custom_properties.range) {
                                                    options.mode = 'range';
                                                }
                                    
                                                return JSON.stringify(options);
                                            },
                                        }" x-init="">
                                        <label class="w-100 input-label" x-text="attribute.name"></label>

                                        <input x-model="attribute.attribute_values[0].values"
                                                    type="text"
                                                    class="js-flatpickr form-control form-control-sm flatpickr-custom"
                                                    placeholder="{{ translate('Pick date') }}"
                                                    :data-hs-flatpickr-options='getDateOptions()'
                                                    data-input />

                                    </div>
                                </template>
                                {{-- END Date --}}


                                {{-- Checkbox --}}
                                <template x-if="attribute.type === 'checkbox'">
                                    <div class="w-100" x-data="{}" >
                                        <label class="w-100 input-label" x-text="attribute.name"></label>

                                        <template x-for="attribute_value in attribute.attribute_values">
                                            <div class="form-control form-control-sm mb-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input x-model="selected_attribute_values['attribute.'+attribute.id]"
                                                        type="checkbox"
                                                        :value="attribute_value.id"
                                                        :id="'attribute_'+attribute_value.id"
                                                        class="custom-control-input">

                                                    <label class="custom-control-label" x-text="attribute_value.values" :for="'attribute_'+attribute_value.id">
                                                    </label>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                {{-- END Checkbox --}}

                                {{-- Radio --}}
                                <template x-if="attribute.type === 'radio'">
                                    <div class="w-100" x-data="{}">
                                        <label class="w-100 input-label" x-text="attribute.name"></label>

                                        <template x-for="attribute_value in attribute.attribute_values">
                                            <div class="form-control form-control-sm mb-2">
                                                <div class="custom-control custom-radio">
                                                    <input x-model="selected_attribute_values['attribute.'+attribute.id]"
                                                        type="radio"
                                                        :value="attribute_value.id"
                                                        :id="'attribute_'+attribute_value.id"
                                                        class="custom-control-input">

                                                    <label class="custom-control-label" x-text="attribute_value.values" :for="'attribute_'+attribute_value.id">
                                                    </label>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                {{-- END Radio --}}


                                {{-- Text List --}}
                                <template x-if="attribute.type === 'text_list'">
                                    <div class="w-100" x-data="{
                                            items: attribute.attribute_values.map(x => x.values),
                                            hasID(index) {
                                                return attribute.attribute_values[index].hasOwnProperty('id') && !isNaN(attribute.attribute_values[index].id) ? true : false;
                                            },
                                            count() {
                                                if(this.items === undefined || this.items === null) {
                                                    this.items = [''];
                                                }
                                    
                                                return this.items.length;
                                            },
                                            add() {
                                                this.items.push('');
                                            },
                                            remove(index) {
                                                if(this.hasID(index)) {
                                                    $wire.removeAttributeValue(attribute.attribute_values[index].id);
                                                }

                                                this.items.splice(index, 1);
                                            },
                                        }" x-init="
                                            $watch('items', items => {
                                                items.forEach((item, index) => {
                                                    if(attribute.attribute_values[index] === undefined || attribute.attribute_values[index] === null) {
                                                        attribute.attribute_values[index] = { 
                                                            values: item
                                                        };
                                                    } else {
                                                        attribute.attribute_values[index].values = item;
                                                    }
                                                });

                                                let diff = attribute.attribute_values.length - items.length;

                                                if(diff > 0) {
                                                    {{-- Remove difference between attribute.attribute_values and mapped items. --}}
                                                    attribute.attribute_values = attribute.attribute_values.slice(0, -(diff));
                                                }
                                            });
                                        ">
                                        <label class="w-100 input-label" x-text="attribute.name"></label>
                                        {{-- FIX: There's an 'cannot acces X of undefined' error when removing item, but it doesn't fuck up the logic  --}}
                                        <div class="row form-group" x-data="{}">
                                        <div class="col-12 col-sm-9">
                                            <template x-if="count() <= 1">
                                                <div class="d-flex">
                                                    <input type="text"
                                                            class="form-control"
                                                            placeholder="{{ translate('Value 1') }}"
                                                            :id="'attribute-'+attribute.id+'-text-list-input-'+key"
                                                            x-model="items[0]" />
                                                </div>
                                            </template>
                                            <template x-if="count() > 1">
                                                <template x-for="[key, value] of Object.entries(items)">
                                                    <div class="d-flex" :class="{'mt-2': key > 0}">
                                                        <input type="text"
                                                            class="form-control"
                                                            :id="'attribute-'+attribute.id+'-text-list-input-'+key"
                                                            x-bind:placeholder="'{{ translate('Value') }} '+(Number(key)+1)"
                                                            x-model="items[key]" />
                                                        <template x-if="key > 0">
                                                            <span class="ml-2 d-flex align-items-center pointer" @click="remove(key)">
                                                                @svg('heroicon-o-trash', ['class' => 'square-22 text-danger'])
                                                            </span>
                                                        </template>
                                                    </div>
                                                </template>
                                            </template>

                                            <a href="javascript:;"
                                                class="js-create-field form-link btn btn-xs btn-no-focus btn-ghost-primary" @click="add()">
                                                <i class="tio-add"></i> {{ translate('Add value') }}
                                            </a>
                                        </div>
                                    </div>
                                </template>
                                {{-- END Text List --}}

                                {{-- TODO: Add wysiwyg, image, gallery, country type attribute --}}

                                {{-- Image --}}
                                {{-- <template x-if="attribute.type === 'image'">
                                    <div class="w-100" x-data="{}" x-init="
                                        $nextTick(() => {
                                            console.log($('#attribute_'+attribute.id));
                                            $('#attribute_'+attribute.id).on('change', function() {
                                                console.log('asdasd');
                                            });
                                        });

                                    ">
                                        <label class="w-100 input-label" x-text="attribute.name"></label>

                                        <div class="input-group" data-toggle="aizuploader"
                                            data-type="image"
                                            data-is-sortable="false"
                                            data-template="input">

                                            <div class="input-group-prepend">
                                                <div class="input-group-text input-group-text-sm bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control form-control-sm file-amount">{{ translate('Choose image') }}</div>

                                            <input type="hidden" :id="'attribute_'+attribute.id" class="selected-files" x-model="attribute.attribute_values[0].values">
                                        </div>
                                    </div>
                                </template> --}}
                                {{-- END Image --}}
                            </div>
                        </template>
                    </div>
                </div>
                {{-- END Card Attributes --}}

                {{-- Card SEO --}}
                <div class="card mb-3 mb-lg-5" x-data="{
                        collapse: true,
                    }">
                    <div class="card-body position-relative pt-0 pb-0">
                        <h5 class="mb-0 pt-4 d-flex justify-content-between pointer" :class="{'pb-4': collapse, 'pb-3': !collapse}" @click="collapse = !collapse">
                            {{ translate('SEO') }}

                            @svg('heroicon-o-chevron-down', ['class' => 'square-20', ':class' => "{'rotate-180': !collapse}"])
                        </h5>

                        <div class="w-100 pt-3 border-top" :class="{'d-none': collapse}">
                            <!-- SEO Meta Title -->
                            <x-ev.form.input name="product.meta_title" class="form-control-sm" type="text" label="{{ translate('Meta Title') }}" placeholder="{{ translate('Meta title is used for Meta, OpenGraph, Twitter...') }}" >
                                <small class="text-muted">{{ translate('This title will be used for SEO and Social. Real product title will be used as fallback if this is empty.') }}</small>
                            </x-ev.form.input>

                            <!-- SEO Meta Description -->
                            <x-ev.form.textarea name="product.meta_description" rows="4" label="{{ translate('Meta Description') }}" placeholder="{{ translate('Meta description is used for Meta, OpenGraph, Twitter...') }}">
                                <small class="text-muted">{{ translate('Have in mind that description should be between 70 and max 200 characters. Facebook up to 200 chars, Twitter up to 150 chars max.') }}</small>
                            </x-ev.form.textarea>

                            <!-- SEO Meta Image -->
                            <x-ev.form.file-selector name="product.meta_img" label="{{ translate('Meta image') }}" data_type="image" placeholder="Choose file..."></x-ev.form.file-selector>
                        </div>
                    </div>
                </div>
                {{-- END Card SEO --}}
            </div>
            {{-- END Left column --}}

            {{-- Right column --}}
            <div class="col-12 col-md-4">
                {{-- Card Actions --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative ">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Actions') }}</h5>

                        <div class="w-100 d-flex justify-content-between">
                            {{-- <div type="button" class="btn btn-danger btn-sm pointer"
                                wire:click="">
                                {{ translate('Delete') }}
                            </div> --}}

                            <div type="button"
                            data-test="we-product-submit"
                            class="btn btn-primary btn-sm pointer ml-auto"
                                    @click="onSave()"
                                    wire:click="saveProduct()">
                                {{ translate('Save') }}
                            </div>
                        </div>

                    </div>
                </div>
                {{-- Card Actions --}}

                {{-- Card Status --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Status') }}</h5>

                        <div class="w-100">
                            <div class="w-100"
                                x-init="
                                    $($refs.status_selector).on('select2:select', (event) => {
                                        status = event.target.value;
                                    });

                                    $watch('status', (value) => {
                                        $($refs.status_selector).val(value).trigger('change');
                                    });
                                ">
                                <select
                                    wire:model.defer="product.status"
                                    name="product.status"
                                    x-ref="status_selector"
                                    id="status_selector"
                                    class="js-select2-custom custom-select select2-hidden-accessible"
                                    data-hs-select2-options='
                                        {"minimumResultsForSearch":"Infinity"}
                                    '
                                >
                                    @foreach(\App\Enums\StatusEnum::toArray() as $key => $status)
                                        <option value="{{ $key }}">
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="d-flex align-items-center mt-2 pl-1">
                                    <span class="mr-2 text-14">{{ translate('Current status:') }}</span>

                                    @if($product->status === App\Enums\StatusEnum::published()->value)
                                        <span class="badge badge-soft-success">
                                            <span class="legend-indicator bg-success mr-1"></span> {{ ucfirst($product->status) }}
                                        </span>
                                    @elseif($product->status === App\Enums\StatusEnum::draft()->value)
                                        <span class="badge badge-soft-warning">
                                            <span class="legend-indicator bg-warning mr-1"></span> {{ ucfirst($product->status) }}
                                        </span>
                                    @elseif($product->status === App\Enums\StatusEnum::pending()->value)
                                        <span class="badge badge-soft-info">
                                            <span class="legend-indicator bg-info mr-1"></span> {{ ucfirst($product->status) }}
                                        </span>
                                    @elseif($product->status === App\Enums\StatusEnum::archived()->value)
                                        <span class="badge badge-soft-danger">
                                            <span class="legend-indicator bg-danger mr-1"></span> {{ ucfirst($product->status) }}
                                        </span>
                                    @elseif($product->status === App\Enums\StatusEnum::private()->value)
                                        <span class="badge badge-soft-dark">
                                            <span class="legend-indicator bg-dark mr-1"></span> {{ ucfirst($product->status) }}
                                        </span>
                                    @endif
                                </div>

                                <x-system.invalid-msg field="product.status" type="slim"></x-system.invalid-msg>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END Card Status --}}

                {{-- Card Categories and Tags --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Categories and Tags') }}</h5>

                        <div class="w-100">
                            <x-ev.form.categories-selector class="mb-3" error-bag-name="selected_categories" :items="$this->categories" :selected-categories="$this->levelSelectedCategories()" label="{{ translate('Categories') }}" :multiple="true" :required="true" :search="true" />

                            <x-ev.form.select name="product.tags" class="mb-0" :tags="true" label="{{ translate('Tags') }}" :multiple="true" placeholder="{{ translate('Type and hit enter to add a tag...') }}">
                                <small class="text-muted">{{ translate('This is used for search. Input relevant words by which customer can find this product.') }}</small>
                            </x-ev.form.select>
                        </div>
                    </div>
                </div>
                {{-- END Card Categories and Tags --}}

                {{-- Card Brand --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative">
                        <h5 class="pb-2 mb-3 border-bottom">{{ translate('Brand') }}</h5>

                        <div class="w-100">
                            <x-ev.form.select name="product.brand_id" :items="EVS::getMappedBrands()" class="mb-1" :search="true" placeholder="{{ translate('Select Brand...') }}" />
                        </div>
                    </div>
                </div>
                {{-- END Card Brand --}}


                {{-- Card Actions --}}
                <div class="card mb-3 mb-lg-5" x-data="{}">
                    <div class="card-body position-relative d-flex">
                        <div type="button" class="btn btn-primary btn-sm pointer ml-auto"
                                @click="onSave()"
                                wire:click="saveProduct()">
                            {{ translate('Save') }}
                        </div>
                    </div>
                </div>
                {{-- Card Actions --}}
            </div>
            {{-- END Right column --}}
        </div>


    </div>
</div>

