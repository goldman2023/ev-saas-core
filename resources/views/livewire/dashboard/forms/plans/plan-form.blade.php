<div class="w-full" x-data="{
    status: @js($plan->status ?? App\Enums\StatusEnum::draft()->value),
    thumbnail: @js(['id' => $plan->thumbnail->id ?? null, 'file_name' => $plan->thumbnail->file_name ?? '']),
    cover: @js(['id' => $plan->cover->id ?? null, 'file_name' => $plan->cover->file_name ?? '']),
    base_currency: @js($plan->base_currency),
    discount_type: @js($plan->discount_type),
    yearly_discount_type: @js($plan->yearly_discount_type),
    tax_type: @js($plan->tax_type),
    features: @js($plan->features),
    content: @js($plan->content),
    selected_categories: @js($selected_categories)
}"
     @validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
     x-cloak>
    <div class="col-lg-12 position-relative">
        <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                              wire:target="savePlan"
                              wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

        <div class="w-full"
             wire:loading.class="opacity-3 prevent-pointer-events"
             wire:target="savePlan"
        >

        <div class="grid grid-cols-12 gap-8 mb-10">
            <div class="col-span-8  ">
                <div class="p-4 border border-gray-200 rounded-lg shadow">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Profile</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">This information will be displayed publicly so be careful what you share.</p>
                    </div>
            
                    <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                        <!-- Title -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
            
                            <label for="plan-title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                {{ translate('Title') }}
                            </label>
            
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <input type="text" class="form-standard @error('plan.title') is-invalid @enderror"
                                        name="plan.title"
                                        id="plan-title"
                                        placeholder="{{ translate('New post title') }}"
                                        {{-- @input="generateURL($($el).val())" --}}
                                        wire:model.defer="plan.title" />
                            
                                <x-system.invalid-msg field="plan.title"></x-system.invalid-msg>
                            </div>
                        </div>
                        <!-- END Title -->

                        <!-- Status -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                <span class="mr-2">{{ translate('Status') }}</span>

                                <span class="badge-success">{{ ucfirst('published') }}</span>
                                @if($plan->status === App\Enums\StatusEnum::published()->value)
                                    <span class="badge-success">{{ ucfirst($plan->status) }}</span>
                                @elseif($plan->status === App\Enums\StatusEnum::draft()->value)
                                    <span class="badge-warning">{{ ucfirst($plan->status) }}</span>
                                @elseif($plan->status === App\Enums\StatusEnum::pending()->value)
                                    <span class="badge-info">{{ ucfirst($plan->status) }}</span>
                                @elseif($plan->status === App\Enums\StatusEnum::private()->value)
                                    <span class="badge-dark">{{ ucfirst($plan->status) }}</span>
                                @endif
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.select :items="\App\Enums\StatusEnum::toArray('archived')" selected="status"></x-dashboard.form.select>
                            </div>
                        </div>
                        <!-- END Status -->
                
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
                                                class="form-standard @error('plan.price') is-invalid @enderror"
                                                placeholder="{{ translate('Subscription plan price') }}"
                                                wire:model.defer="plan.price" />
                                    </div>

                                    <div class="col-span-4" x-data="{}"> 
                                        <x-dashboard.form.select :items="\FX::getAllCurrencies(formatted: true)" selected="base_currency"></x-dashboard.form.select>
                                    </div>

                                    <x-system.invalid-msg class="col-span-10" field="plan.price"></x-system.invalid-msg>
                                </div>
                            </div>
                        </div>
                        <!-- END Price -->


                        <!-- Discount and Discount type -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                {{ translate('Monthly plan discount') }}
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <div class="grid grid-cols-10 gap-3">
                                    <div class="col-span-6">
                                        <input type="number" 
                                                step="0.01" 
                                                class="form-standard @error('plan.discount') is-invalid @enderror"
                                                placeholder="{{ translate('Subscription plan discount (fixed or percentage) - for monthly payment') }}"
                                                wire:model.defer="plan.discount" />
                                    </div>

                                    <div class="col-span-4" x-data="{}"> 
                                        <x-dashboard.form.select :items="\App\Enums\AmountPercentTypeEnum::toArray()" selected="discount_type"></x-dashboard.form.select>
                                    </div>

                                    <x-system.invalid-msg class="col-span-10" field="plan.discount"></x-system.invalid-msg>
                                </div>
                            </div>
                        </div>
                        <!-- END Discount and discount type -->

                        <!-- Yearly discount and discount type -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                {{ translate('Annual plan discount') }}
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <div class="grid grid-cols-10 gap-3">
                                    <div class="col-span-6">
                                        <input type="number" 
                                                step="0.01" 
                                                class="form-standard @error('plan.yearly_discount') is-invalid @enderror"
                                                placeholder="{{ translate('Subscription plan annual discount (fixed or percentage) - for annual payment') }}"
                                                wire:model.defer="plan.yearly_discount" />
                                    </div>

                                    <div class="col-span-4" x-data="{}"> 
                                        <x-dashboard.form.select :items="\App\Enums\AmountPercentTypeEnum::toArray()" selected="yearly_discount_type"></x-dashboard.form.select>
                                    </div>
                                    
                                    <div class="col-span-10">
                                        <small class="text-warning">
                                            {{ translate('*Note: If yearly discount is set, standard discount won\'t be applied to each month.') }}
                                        </small>
                                    </div>

                                    <x-system.invalid-msg class="col-span-10" field="plan.yearly_discount"></x-system.invalid-msg>
                                </div>
                            </div>
                        </div>
                        <!-- END Yearly discount and discount type -->


                        <!-- Tax and Tax type -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                {{ translate('Tax') }}
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <div class="grid grid-cols-10 gap-3">
                                    <div class="col-span-6">
                                        <input type="number" 
                                                step="0.01" 
                                                class="form-standard @error('plan.tax') is-invalid @enderror"
                                                placeholder="{{ translate('Subscription specific tax (fixed or percentage)') }}"
                                                wire:model.defer="plan.tax" />
                                    </div>

                                    <div class="col-span-4" x-data="{}"> 
                                        <x-dashboard.form.select :items="\App\Enums\AmountPercentTypeEnum::toArray()" selected="tax_type"></x-dashboard.form.select>
                                    </div>
                                    
                                    <div class="col-span-10">
                                        <small class="text-info">
                                            {{ translate('*Note: This is a subscription plan specific tax/fee/commission, not a VAT') }}
                                        </small>
                                    </div>

                                    <x-system.invalid-msg class="col-span-10" field="plan.tax"></x-system.invalid-msg>
                                </div>
                            </div>
                        </div>
                        <!-- END Tax and Tax type  -->

                        <!-- Features -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
            
                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                {{ translate('Features') }}
                            </label>
            
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.text-repeater field="features" placeholder="{{ translate('Feature') }}"></x-dashboard.form.text-repeater>
                            </div>
                        </div>
                        <!-- END Features -->

                        <!-- Excerpt -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
            
                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                {{ translate('Excerpt') }}
                            </label>
            
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <textarea type="text" class="form-standard h-[80px] @error('plan.excerpt') is-invalid @enderror"
                                            placeholder="{{ translate('Write a short promo description for this subscription plan') }}"
                                            wire:model.defer="plan.excerpt">
                                </textarea>
                            
                                <x-system.invalid-msg class="w-full" field="plan.excerpt"></x-system.invalid-msg>
                            </div>
                        </div>
                        <!-- END Excerpt -->

                        <!-- Content -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
            
                            <label class="col-span-3 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                {{ translate('Content') }}
                            </label>
            
                            <div class="mt-1 sm:mt-0 sm:col-span-3">
                                <x-dashboard.form.froala field="content" id="plan-content-wysiwyg"></x-dashboard.form.froala>
                            
                                <x-system.invalid-msg class="w-full" field="plan.content"></x-system.invalid-msg>
                            </div>
                        </div>
                        <!-- END Content -->
                    </div>
                </div>
            </div>

            {{-- Right side --}}
            <div class="col-span-4">
               
                <div class="p-4 border border-gray-200 rounded-lg shadow">
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
                                    <x-dashboard.form.image-selector field="thumbnail" id="plan-thumbnail-image" :selected-image="$plan->thumbnail"></x-dashboard.form.image-selector>
                                    
                                    <x-system.invalid-msg field="plan.thumbnail"></x-system.invalid-msg>
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
                                    <x-dashboard.form.image-selector field="cover" id="plan-cover-image" :selected-image="$plan->cover"></x-dashboard.form.image-selector>

                                    <x-system.invalid-msg field="plan.cover"></x-system.invalid-msg>
                                </div>
                            </div>
                        </div>
                        {{-- END Cover --}}
                    </div>
                    
                </div>
                

                {{-- Category Selector --}}
                <div class="mt-8 border border-gray-200 rounded-lg shadow select-none" x-data="{
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

                {{-- SEO --}}
                <div class="mt-8 border border-gray-200 rounded-lg shadow select-none" x-data="{
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
                                        class="form-standard @error('plan.meta_title') is-invalid @enderror"
                                        {{-- placeholder="{{ translate('Write meta title...') }}" --}}
                                        wire:model.defer="plan.meta_title" />
                            
                                <x-system.invalid-msg field="plan.meta_title"></x-system.invalid-msg>
                            </div>
                        </div>
                        <!-- END Meta Title -->

                        <!-- Meta Description -->
                        <div class="flex flex-col sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5" x-data="{}">
            
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ translate('Meta Description') }}
                            </label>
            
                            <div class="mt-1 sm:mt-0">
                                <textarea type="text" class="form-standard h-[80px] @error('plan.meta_description') is-invalid @enderror"
                                            {{-- placeholder="{{ translate('Meta description which will be shown when link is shared on social network and') }}" --}}
                                            wire:model.defer="plan.meta_description">
                                </textarea>
                            
                                <x-system.invalid-msg class="w-full" field="plan.meta_description"></x-system.invalid-msg>
                            </div>
                        </div>
                        <!-- END Meta Description -->

                        <!-- Meta Keywords -->
                        <div class="flex flex-col sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5" x-data="{}">
            
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ translate('Meta Keywords') }}
                            </label>
            
                            <div class="mt-1 sm:mt-0 ">
                                <textarea type="text" class="form-standard h-[80px] @error('plan.meta_keywords') is-invalid @enderror"
                                            {{-- placeholder="{{ translate('Write a short promo description for this subscription plan') }}" --}}
                                            wire:model.defer="plan.meta_keywords">
                                </textarea>
                            
                                <x-system.invalid-msg class="w-full" field="plan.meta_keywords"></x-system.invalid-msg>
                            </div>
                        </div>
                        <!-- END Meta Keywords -->

                        {{-- Meta Image --}}
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5">
                            
                            <label class="col-span-3 block text-sm font-medium text-gray-700">{{ translate('Meta Image') }}</label>
                            <div class="mt-1 sm:mt-0 sm:col-span-3">
                                <div class="max-w-lg flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END Meta Image --}}
                        
                    </div>
                </div>
                {{-- END SEO --}}

                
            </div>
        
        </div>

            
                {{-- <!-- Title -->
                <div class="row form-group mt-5" x-data="{
                   url_template: '{{ route('shop.blog.post.index', ['%shop_slug%', '%slug%'], false) }}',
                   url: '',
                   generateURL($slug) {
                       this.url = this.url_template.replace('%shop_slug%', '{{ MyShop::getShop()->slug ?? '' }}').replace('%slug%', '<strong>'+$slug.slugify()+'</strong>');
                   }
                }"
               @initSlugGeneration.window="this.generateURL($('#plan-title').val())">
                    >
    
                    <label for="plan-title" class="col-sm-3 col-form-label input-label">{{ translate('Title') }}</label>
    
                    <div class="col-sm-9">
                        <div class="input-group input-group-sm-down-break">
                            <input type="text" class="form-control @error('plan.title') is-invalid @enderror"
                                   name="plan.title"
                                   id="plan-title"
                                   placeholder="{{ translate('New post title') }}"
                                  @input="generateURL($($el).val())"
                                   wire:model.defer="plan.title" />
                        </div>
    
                       <div class="w-100 d-flex align-items-center mt-2">
                           <strong class="mr-2">{{ translate('URL') }}:</strong>
                           <span x-html="(url !== undefined) ? url : ''"></span>
                       </div>
    
                        <x-system.invalid-msg field="plan.title"></x-system.invalid-msg>
                    </div>
                </div>
                <!-- END Title --> --}}




            <!-- Category Selector -->
            <div class="row form-group mt-4">
                <label for="plan-title" class="col-sm-3 col-form-label input-label">{{ translate('Category') }}</label>

                <div class="col-sm-9">
                    <x-ev.form.categories-selector
                        error-bag-name="selected_categories"
                        :items="$categories"
                        :selected-categories="$this->levelSelectedCategories()"
                        :multiple="true"
                        :required="true"
                        :search="true">
                    </x-ev.form.categories-selector>
                </div>
            </div>
            <!-- END Category Selector -->

        


            

            <!-- Content -->
            <!-- TODO: Find out why ONLY THIS FUCKING PART OF FORM DOES NOT WORK AFTER SAVE!!!! WTF???? It works exactly the same in blog-post-form, but doesn't work here! DA FUQ????-->
            {{-- <div class="row form-group mt-3">
                <label for="plan-content" class="col-sm-3 col-form-label input-label">{{ translate('Content') }}</label>
                
                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <div class="toast-ui-editor-custom w-100">
                            <div class="js-toast-ui-editor"
                                 data-ev-toastui-editor-options=""></div>

                            <input type="text"
                                   value=""
                                   data-textarea
                                   id="plan-content"
                                   name="plan.content" style="display: none !important;" wire:model.delay="plan.content"/>
                        </div>
                    </div>

                    <x-system.invalid-msg field="plan.content"></x-system.invalid-msg>
                </div>
            </div> --}}
            <!-- END Content -->

            <hr class="my-4"/>

            
            
            <hr/>

            <h3 class="h4"> {{ translate('SEO') }}</h3>

            

            <hr/>

            <div class="row form-group mb-0">
                <div class="col-12 d-flex">
                    {{-- TODO: Standardize Categories selection for various Content Types --}}
                    <button type="button" class="btn btn-primary ml-auto btn-sm"
                            @click="
                                //$wire.set('plan.content', $('#plan-content').val(), true);
                                $wire.set('plan.status', $('#blog-post-status-selector').val(), true);
                                let $selected_categories = [];
                                $('[name=\'selected_categories\']').each(function(index, item) {
                                    $selected_categories = [...$selected_categories, ...$(item).val()];
                                });
                                $wire.set('selected_categories', $selected_categories, true);
                                $wire.set('plan.base_currency', $('#plan-base_currency').val(), true);
                                $wire.set('plan.discount_type', $('#plan-discount_type').val(), true);
                                $wire.set('plan.yearly_discount_type', $('#plan-yearly_discount_type').val(), true);
                                $wire.set('plan.tax_type', $('#plan-tax_type').val(), true);
                            "
                            wire:click="savePlan()">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div>
            
        </div>

    </div>
</div>
