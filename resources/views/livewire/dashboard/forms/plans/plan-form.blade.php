@push('pre_head_scripts')
    <script>
        let all_categories = @json(Categories::getAllFormatted());
    </script>
@endpush

<div class="w-full" x-data="{
    status: @js($plan->status ?? App\Enums\StatusEnum::draft()->value),
    base_currency: @js($plan->base_currency),
    discount_type: @js($plan->discount_type),
    yearly_discount_type: @js($plan->yearly_discount_type),
    tax_type: @js($plan->tax_type),
    features: @js($plan->features),
    content: @js($plan->content),
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
            <div class="col-span-4 ">
                <div class="p-4 border border-gray-200 rounded-lg shadow">
                    {{-- Thumbnail --}}
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:pt-3">
                        <label for="photo" class="block text-sm font-medium text-gray-700"> Photo </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="flex items-center">
                                <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </span>
                                <button type="button" class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Change</button>
                            </div>
                        </div>
                    </div>
            
                    {{-- Cover --}}
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                        <label for="cover-photo" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Cover photo </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
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
                </div>
            </div>
        
        </div>
  

            {{-- <!-- Cover -->
            <div class="profile-cover">
                <div class="profile-cover-img-wrapper"
                     x-data="{
                        name: 'plan.cover',
                        imageID: {{ $plan->cover->id ?? 'null' }},
                        imageURL: '{{ $plan->getCover(['w'=>1200]) }}',
                    }"
                     @aiz-selected.window="
                     if(event.detail.name === name) {
                        imageURL = event.detail.imageURL;
                        $wire.set('plan.cover', $('input[name=\'plan.cover\']').val(), true);
                     }"
                     data-toggle="aizuploader"
                     data-type="image">

                    <img id="profileCoverImg" class="profile-cover-img" x-bind:src="imageURL">

                    <!-- Custom File Cover -->
                    <div class="profile-cover-content profile-cover-btn custom-file-manager"
                         data-toggle="aizuploader" data-type="image">
                        <div class="custom-file-btn">
                            <input type="hidden" x-bind:name="name" wire:model.defer="plan.cover" class="selected-files" data-preview-width="1200">

                            <label class="custom-file-btn-label btn btn-sm btn-white shadow-lg d-flex align-items-center" for="profileCoverUploader">
                                @svg('heroicon-o-pencil', ['class' => 'square-16 mr-2'])
                                <span class="d-none d-sm-inline-block">{{ translate('Update post cover') }}</span>
                            </label>
                        </div>
                    </div>
                    <!-- End Custom File Cover -->
                </div>
            </div>
            <!-- End Cover -->

            <!-- Thumbnail -->
            <label class="avatar avatar-xxl avatar-circle avatar-border-lg avatar-uploader mx-auto profile-cover-avatar pointer border p-1" for="avatarUploader"
                   style="margin-top: -60px;"
                   x-data="{
                        name: 'plan.thumbnail',
                        imageID: {{ $plan->thumbnail->id ?? 'null' }},
                        imageURL: '{{ $plan->getThumbnail() }}',
                    }"
                   @aiz-selected.window="
                     if(event.detail.name === name) {
                        imageURL = event.detail.imageURL;
                        $wire.set('plan.thumbnail', $('input[name=\'plan.thumbnail\']').val(), true);
                     }"
                   data-toggle="aizuploader"
                   data-type="image">
                <img id="avatarImg" class="avatar-img" x-bind:src="imageURL" >

                <input type="hidden" x-bind:name="name" wire:model.defer="plan.thumbnail" class="selected-files" data-preview-width="200">

                <span class="avatar-uploader-trigger">
                  <i class="avatar-uploader-icon shadow-soft">
                      @svg('heroicon-o-pencil', ['class' => 'square-16'])
                  </i>
                </span>
            </label>
            <!-- End Thumbnail --> --}}

            <x-system.invalid-msg field="plan.thumbnail"></x-system.invalid-msg>

            <x-system.invalid-msg field="plan.cover"></x-system.invalid-msg>

            
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

            <!-- Meta Title -->
            <div class="row form-group">
                <label for="plan-meta_title" class="col-sm-3 col-form-label input-label">{{ translate('Meta title') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <input type="text" class="form-control @error('plan.meta_title') is-invalid @enderror"
                               name="plan.meta_title"
                               id="plan-meta_title"
                               placeholder="{{ translate('Post SEO/meta title') }}"
                               wire:model.defer="plan.meta_title" />
                    </div>
                </div>

                <x-system.invalid-msg field="plan.meta_title"></x-system.invalid-msg>
            </div>
            <!-- END Meta Title -->

            <!-- Meta Description -->
            <div class="row form-group">
                <label for="plan-meta_description" class="col-sm-3 col-form-label input-label">{{ translate('Meta description') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <textarea type="text" class="form-control @error('plan.meta_description') is-invalid @enderror"
                                  name="plan.meta_description"
                                  id="plan-meta_description"
                                  placeholder="{{ translate('Post SEO/meta description') }}"
                                  wire:model.defer="plan.meta_description">
                        </textarea>
                    </div>
                </div>

                <x-system.invalid-msg field="plan.meta_description"></x-system.invalid-msg>
            </div>
            <!-- END Meta Description -->

            <!-- Meta Keywords -->
            <div class="row form-group">
                <label for="plan-meta_keywords" class="col-sm-3 col-form-label input-label">{{ translate('Meta keywords') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <textarea type="text" class="form-control @error('plan.meta_keywords') is-invalid @enderror"
                                  name="plan.meta_keywords"
                                  id="plan-meta_keywords"
                                  placeholder="{{ translate('Post SEO/meta keywords') }}"
                                  wire:model.defer="plan.meta_keywords">
                        </textarea>
                    </div>
                </div>

                <x-system.invalid-msg field="plan.meta_keywords"></x-system.invalid-msg>
            </div>
            <!-- END Meta Keywords -->

            <!-- Meta Img -->
            <div class="row form-group">
                <div class="col-sm-3 col-form-label input-label">{{ translate('Meta image') }}</div>

                <div class="col-sm-9 d-flex flex-column justify-content-center align-items-start">
                    <label class="card-img-top pointer border rounded p-1 mb-0 mt-0" for="avatarUploader"
                           style="width: 180px; height: 115px;"
                           x-data="{
                                name: 'plan.meta_img',
                                imageID: {{ $plan->meta_img?->id ?? 'null' }},
                                imageURL: '{{ $plan->getUpload('meta_img', ['w'=>220]) }}',
                            }"
                           @aiz-selected.window="
                             if(event.detail.name === name) {
                                imageURL = event.detail.imageURL;
                                $wire.set('plan.meta_img', $('input[name=\'plan.meta_img\']').val(), true);
                             }"
                           data-toggle="aizuploader"
                           data-type="image">
                        <img id="avatarImg" class="avatar-img rounded w-100" x-bind:src="imageURL" >

                        <input type="hidden" x-bind:name="name" wire:model.defer="plan.meta_img" class="selected-files" data-preview-width="200">
                    </label>

                    <x-system.invalid-msg class="mt-1" field="plan.meta_img"></x-system.invalid-msg>
                </div>
            </div>
            <!-- End Meta Img -->

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
