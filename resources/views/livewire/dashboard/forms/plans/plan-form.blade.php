@push('pre_head_scripts')
    <script>
        let all_categories = @json(Categories::getAllFormatted());
    </script>
@endpush

<div x-data="{}"
     @validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
     x-cloak>
    <div class="col-lg-12 position-relative">
        <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                              wire:target="savePlan"
                              wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

        <div class=""
             wire:loading.class="opacity-3 prevent-pointer-events"
             wire:target="savePlan"
        >

            <!-- Cover -->
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
            <!-- End Thumbnail -->

            <x-system.invalid-msg field="plan.thumbnail"></x-system.invalid-msg>

            <x-system.invalid-msg field="plan.cover"></x-system.invalid-msg>

            <!-- Title -->
            <div class="row form-group mt-5" x-data="{
{{--                url_template: '{{ route('shop.blog.post.index', ['%shop_slug%', '%slug%'], false) }}',--}}
{{--                url: '',--}}
{{--                generateURL($slug) {--}}
{{--                    this.url = this.url_template.replace('%shop_slug%', '{{ MyShop::getShop()->slug ?? '' }}').replace('%slug%', '<strong>'+$slug.slugify()+'</strong>');--}}
{{--                }--}}
            }"
{{--            @initSlugGeneration.window="this.generateURL($('#plan-title').val())">--}}
                >

                <label for="plan-title" class="col-sm-3 col-form-label input-label">{{ translate('Title') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <input type="text" class="form-control @error('plan.title') is-invalid @enderror"
                               name="plan.title"
                               id="plan-title"
                               placeholder="{{ translate('New post title') }}"
{{--                               @input="generateURL($($el).val())"--}}
                               wire:model.defer="plan.title" />
                    </div>

{{--                    <div class="w-100 d-flex align-items-center mt-2">--}}
{{--                        <strong class="mr-2">{{ translate('URL') }}:</strong>--}}
{{--                        <span x-html="(url !== undefined) ? url : ''"></span>--}}
{{--                    </div>--}}

                    <x-system.invalid-msg field="plan.title"></x-system.invalid-msg>
                </div>
            </div>
            <!-- END Title -->

            <!-- Status -->
            <div class="row form-group mt-5">
                <label for="plan-status" class="col-sm-3 col-form-label input-label d-flex align-items-center">
                    {{ translate('Status') }}
                </label>

                <div class="col-sm-9" x-data="{
                        status: @js($plan->status ?? App\Enums\StatusEnum::draft()->value),
                    }"
                     x-init="
                        $($refs.plan_status_selector).on('select2:select', (event) => {
                          status = event.target.value;
                        });

                        $watch('status', (value) => {
                          $($refs.plan_status_selector).val(value).trigger('change');
                        });
                     ">
                    <select
                        wire:model.defer="plan.status"
                        name="plan.status"
                        x-ref="plan_status_selector"
                        id="blog-post-status-selector"
                        class="js-select2-custom custom-select select2-hidden-accessible"
                        data-hs-select2-options='
                            {"minimumResultsForSearch":"Infinity"}
                        '
                    >
                        @foreach(\App\Enums\StatusEnum::toArray('archived') as $key => $status)
                            <option value="{{ $key }}">
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>

                    <div class="d-flex align-items-center mt-2 pl-1">
                        <span class="mr-2 text-14">{{ translate('Current status:') }}</span>
                        @if($plan->status === App\Enums\StatusEnum::published()->value)
                            <span class="badge badge-soft-success">
                                <span class="legend-indicator bg-success mr-1"></span> {{ ucfirst($plan->status) }}
                            </span>
                        @elseif($plan->status === App\Enums\StatusEnum::draft()->value)
                            <span class="badge badge-soft-warning">
                                <span class="legend-indicator bg-warning mr-1"></span> {{ ucfirst($plan->status) }}
                            </span>
                        @elseif($plan->status === App\Enums\StatusEnum::pending()->value)
                            <span class="badge badge-soft-info">
                                <span class="legend-indicator bg-info mr-1"></span> {{ ucfirst($plan->status) }}
                            </span>
                        @elseif($plan->status === App\Enums\StatusEnum::private()->value)
                            <span class="badge badge-soft-dark">
                                <span class="legend-indicator bg-dark mr-1"></span> {{ ucfirst($plan->status) }}
                            </span>
                        @endif
                    </div>

                    <x-system.invalid-msg field="plan.status"></x-system.invalid-msg>
                </div>
            </div>
            <!-- END Status -->


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

            <!-- Price -->
            <div class="row form-group mt-3">
                <label for="plan-price" class="col-sm-3 col-form-label input-label">{{ translate('Price') }}</label>

                <div class="col-sm-7">
                    <div class="input-group input-group-sm-down-break">
                        <input type="number" step="0.01" class="form-control @error('plan.price') is-invalid @enderror"
                                name="plan.price"
                                id="plan-price"
                                placeholder="{{ translate('Subscription plan price') }}"
                                wire:model.defer="plan.price" />
                    </div>

                    <x-system.invalid-msg field="plan.price"></x-system.invalid-msg>
                </div>

                <div class="col-sm-2" x-data="{
                    base_currency: @js($plan->base_currency),
                }" x-init="
                    $('#plan-base_currency').on('select2:select', (event) => {
                        base_currency = event.target.value;
                    });
                    $watch('base_currency', (value) => {
                        $('#plan-base_currency').val(value).trigger('change');
                    });
                "> 
                    <select class="form-control custom-select" 
                            name="plan.base_currency" 
                            id="plan-base_currency"
                            wire:model.defer="plan.base_currency"
                            data-hs-select2-options='{
                            "minimumResultsForSearch": "Infinity"
                        }'>
                        @foreach(\FX::getAllCurrencies() as $currency)
                            <option value="{{ $currency->code }}" >
                                {{ $currency->code }} ({{ $currency->symbol }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- END Price -->


            <!-- Discount and Discount type -->
            <div class="row form-group mt-3">
                <label for="plan-discount" class="col-sm-3 col-form-label input-label">{{ translate('Monthly plan discount') }}</label>

                <div class="col-sm-7">
                    <div class="input-group input-group-sm-down-break">
                        <input type="number" step="0.01" class="form-control @error('plan.discount') is-invalid @enderror"
                                name="plan.discount"
                                id="plan-discount"
                                placeholder="{{ translate('Subscription plan discount (fixed or percentage) - for monthly payment') }}"
                                wire:model.defer="plan.discount" />
                    </div>

                    <x-system.invalid-msg field="plan.discount"></x-system.invalid-msg>
                </div>

                <div class="col-sm-2" x-data="{
                    discount_type: @js($plan->discount_type)
                }" x-init="
                    $('#plan-discount_type').on('select2:select', (event) => {
                        discount_type = event.target.value;
                    });
                    $watch('discount_type', (value) => {
                        $('#plan-discount_type').val(value).trigger('change');
                    });
                "> 
                    <select class="form-control custom-select" 
                            name="plan.discount_type" 
                            id="plan-discount_type"
                            wire:model.defer="plan.discount_type"
                            data-hs-select2-options='{
                                "minimumResultsForSearch": "Infinity"
                        }'>
                        @foreach(\App\Enums\AmountPercentTypeEnum::toArray() as $type => $label)
                            <option value="{{ $type }}" >
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- END Discount and discount type -->

            <!-- Yearly discount and discount type -->
            <div class="row form-group mt-3">
                <label for="plan-yearly_discount" class="col-sm-3 col-form-label input-label">{{ translate('Annual plan discount') }}</label>

                <div class="col-sm-7">
                    <div class="input-group input-group-sm-down-break">
                        <input type="number" step="0.01" class="form-control @error('plan.yearly_discount') is-invalid @enderror"
                                name="plan.yearly_discount"
                                id="plan-yearly_discount"
                                placeholder="{{ translate('Subscription plan yearly discount (fixed or percentage) - for annual payment') }}"
                                wire:model.defer="plan.yearly_discount" />
                    </div>
                    <small class="text-warning">{{ translate('*Note: If yearly discount is set, standard discount won\'t be applied to each month.') }}</small>

                    <x-system.invalid-msg field="plan.yearly_discount"></x-system.invalid-msg>
                </div>

                <div class="col-sm-2" x-data="{
                    yearly_discount_type: @js($plan->yearly_discount_type)
                }" x-init="
                    $('#plan-yearly_discount_type').on('select2:select', (event) => {
                        yearly_discount_type = event.target.value;
                    });
                    $watch('yearly_discount_type', (value) => {
                        $('#plan-yearly_discount_type').val(value).trigger('change');
                    });
                "> 
                    <select class="form-control custom-select" 
                            name="plan.yearly_discount_type" 
                            id="plan-yearly_discount_type"
                            wire:model.defer="plan.yearly_discount_type"
                            data-hs-select2-options='{
                                "minimumResultsForSearch": "Infinity"
                        }'>
                        @foreach(\App\Enums\AmountPercentTypeEnum::toArray() as $type => $label)
                            <option value="{{ $type }}" >
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- END Yearly discount and discount type -->


            <!-- Tax and Tax type -->
            <div class="row form-group mt-3">
                <label for="plan-tax" class="col-sm-3 col-form-label input-label">{{ translate('Tax') }}</label>

                <div class="col-sm-7">
                    <div class="input-group input-group-sm-down-break">
                        <input type="number" step="0.01" class="form-control @error('plan.tax') is-invalid @enderror"
                                name="plan.tax"
                                id="plan-tax"
                                placeholder="{{ translate('Subscription specific tax (fixed or percentage)') }}"
                                wire:model.defer="plan.tax" />
                    </div>

                    <x-system.invalid-msg field="plan.tax"></x-system.invalid-msg>
                </div>

                <div class="col-sm-2" x-data="{
                    tax_type: @js($plan->tax_type)
                }" x-init="
                    $('#plan-tax_type').on('select2:select', (event) => {
                        tax_type = event.target.value;
                    });
                    $watch('tax_type', (value) => {
                        $('#plan-tax_type').val(value).trigger('change');
                    });
                "> 
                    <select class="form-control custom-select" 
                            name="plan.tax_type" 
                            id="plan-tax_type"
                            wire:model.defer="plan.tax_type"
                            data-hs-select2-options='{
                                "minimumResultsForSearch": "Infinity"
                        }'>
                        @foreach(\App\Enums\AmountPercentTypeEnum::toArray() as $type => $label)
                            <option value="{{ $type }}" >
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- END Tax and Tax type -->


            <!-- Excerpt -->
            <div class="row form-group mt-3">
                <label for="plan-excerpt" class="col-sm-3 col-form-label input-label">{{ translate('Excerpt') }}</label>

                <div class="col-sm-9">
                    <div class="input-group input-group-sm-down-break">
                        <textarea type="text" class="form-control @error('plan.excerpt') is-invalid @enderror"
                                  name="plan.excerpt"
                                  id="plan-excerpt"
                                  placeholder="{{ translate('Write a short description for this subscription plan') }}"
                                  wire:model.defer="plan.excerpt">
                        </textarea>
                    </div>

                    <x-system.invalid-msg field="plan.excerpt"></x-system.invalid-msg>
                </div>
            </div>
            <!-- END Excerpt -->

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

            <!-- Features -->
            <div class="row form-group" x-data="{
                features: @js($plan->features),
                count() {
                    if(this.features === undefined || this.features === null) {
                        this.features = [''];
                    }

                    return this.features.length;
                },
                add() {
                    this.features.push('');
                },
                remove(index) {
                    this.features.splice(index, 1);
                },
             }"
             >
                <label for="plan-features" class="col-sm-3 col-form-label input-label">{{ translate('Features') }}</label>

                <div class="col-sm-9">
                    <template x-if="count() <= 1">
                        <div class="d-flex">
                            <input type="text" class="form-control" name="plan.features[]"
                            placeholder="{{ translate('Feature 1') }}"
                            x-model="features[0]" />
                        </div>
                    </template>
                    <template x-if="count() > 1">
                        <template x-for="[key, value] of Object.entries(features)">
                            <div class="d-flex" :class="{'mt-2': key > 0}">
                                <input type="text" class="form-control" name="plan.features[]"
                                       x-bind:placeholder="'{{ translate('Feature') }} '+(Number(key)+1)"
                                       x-model="features[key]" />
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
                        <i class="tio-add"></i> {{ translate('Add feature') }}
                    </a>

                    <x-system.invalid-msg field="plan.features"></x-system.invalid-msg>
                </div>
            </div>
            <!-- END Features -->
            
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
