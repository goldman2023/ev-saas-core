@push('head_scripts')
<script src="{{ mix('js/editor.js', 'themes/WeTailwind') }}" defer></script>

@endpush

<div class="w-full lw-form" x-data="{
    status: @js($plan->status ?? \App\Enums\StatusEnum::draft()->value),
    thumbnail: @js(toJSONMedia($plan->thumbnail)),
    cover: @js(toJSONMedia($plan->cover)),
    meta_img: @js(toJSONMedia($plan->meta_img)),
    gallery: @js(collect($plan->gallery)->map(fn($item, $key) => toJSONMedia($item))),
    base_currency: @js($plan->base_currency),
    primary: @js($plan->primary ?? false),
    featured: @js($plan->featured ?? false),
    non_standard: @js($plan->non_standard ?? 'false'),
    discount_type: @js($plan->discount_type),
    yearly_discount_type: @js($plan->yearly_discount_type),
    features: @js(array_values($plan->features)),
    content: @entangle('plan.content').defer,
    content_structure: @entangle('wef.content_structure').defer,
    selected_categories: @js($selected_categories),
    attributes: @js($custom_attributes),
    selected_predefined_attribute_values: @js($selected_predefined_attribute_values),
    core_meta: @js($core_meta),
    wef: @js($wef),
    onSave() {
        $wire.set('plan.content', this.content, true);
        $wire.set('wef.content_structure', this.content_structure, true);

        $wire.set('plan.status', this.status, true);
        $wire.set('plan.base_currency', this.base_currency, true);
        $wire.set('plan.discount_type', this.discount_type, true);
        $wire.set('plan.yearly_discount_type', this.yearly_discount_type, true);
        $wire.set('plan.thumbnail', this.thumbnail.id, true);
        $wire.set('plan.gallery', this.gallery, true);
        $wire.set('plan.cover', this.cover.id, true);
        $wire.set('plan.meta_img', this.meta_img.id, true);
        $wire.set('plan.features', this.features, true);
        $wire.set('plan.primary', this.primary, true);
        $wire.set('plan.featured', this.featured, true);
        $wire.set('plan.non_standard', this.non_standard, true);

        $wire.set('core_meta', this.core_meta, true);
        $wire.set('selected_categories', this.selected_categories, true);
        $wire.set('selected_predefined_attribute_values', this.selected_predefined_attribute_values, true);
        $wire.set('custom_attributes', this.attributes, true);

        @do_action('view.plan-form.wire_set')
    }
}"
     @validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
     @init-form.window="features = features.filter(x => x).filter(x => true);"
     x-cloak>
    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                              wire:target="savePlan"
                              wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full"
             wire:loading.class="opacity-30 pointer-events-none"
             wire:target="savePlan"
        >

        <div class="grid grid-cols-12 gap-8 mb-10">
            {{-- Left side --}}
            <div class="col-span-12 sm:col-span-8">
                <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Subscription plan') }}</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Here you can edit all plan basic information') }}</p>
                    </div>

                    <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                        <!-- Title -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">

                            <label for="plan-title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                {{ translate('Title') }}
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <input type="text" class="form-standard @error('plan.name') is-invalid @enderror"
                                        name="plan.name"
                                        id="plan-name"
                                        placeholder="{{ translate('New post title') }}"
                                        {{-- @input="generateURL($($el).val())" --}}
                                        wire:model.defer="plan.name" />

                                <x-system.invalid-msg field="plan.name"></x-system.invalid-msg>
                            </div>
                        </div>
                        <!-- END Title -->

                        <!-- Is Purchasable -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                <span class="mr-2">{{ translate('Requires contact to be purchased?') }}</span>
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2 flex flex-col">
                                <x-dashboard.form.toggle field="non_standard" />

                                <div class="w-full">
                                    <small class="text-info text-12">
                                        {{ translate('If plan is not purchasable, it\'ll lead to a desired URL in order to contact staff.') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!-- END Is purchasable -->

                        <!-- Redirect URL Meta -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-show="non_standard">

                            <label for="plan-title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                {{ translate('CTA Redirect URL') }}
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.input field="wef.custom_redirect_url" />
                            </div>
                        </div>
                        <!-- END Redirect URL Meta -->

                        <!-- Custom CTA Label Meta -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-show="non_standard">
                            <label for="plan-title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                {{ translate('CTA Label') }}
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.input field="wef.custom_cta_label" />
                            </div>
                        </div>
                        <!-- END Custom CTA Label Meta -->

                        <!-- Custom CTA Label Meta -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-show="non_standard">
                            <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                <span class="text-sm font-medium text-gray-900">{{ translate('Custom Pricing Label') }}</span>
                                <p class="text-gray-500 text-12">{{ translate('This text will be used instead of price. Default is `Contact Us`') }}</p>
                            </div>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.input field="wef.custom_pricing_label" />
                            </div>
                        </div>
                        <!-- END Custom CTA Label Meta -->

                        <!-- Price -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-show="!non_standard">
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
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-show="!non_standard">
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
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-show="!non_standard">
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
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}" wire:ignore>

                            <label class="col-span-3 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                {{ translate('Content') }}
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-3">
                                <x-dashboard.form.editor-js field="content" structure-field="content_structure" id="plan-content-wysiwyg"></x-dashboard.form.editor-js>

                                <x-system.invalid-msg class="w-full" field="plan.content"></x-system.invalid-msg>
                            </div>
                        </div>
                        <!-- END Content -->
                    </div>
                </div>

                @do_action('view.dashboard.form.left.end', $plan)
            </div>


            {{-- Right side --}}
            <div class="col-span-12 sm:col-span-4">

                {{-- Actions --}}
                <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                    <!-- Status -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                        <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            <span class="mr-2">{{ translate('Status') }}</span>

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
                            <x-dashboard.form.select :items="\App\Enums\StatusEnum::toArray('archived')" selected="status" :nullable="false"></x-dashboard.form.select>
                        </div>
                    </div>
                    <!-- END Status -->

                    <!-- Primary -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                        <label class="flex items-center text-sm font-medium text-gray-700 ">
                            <span class="mr-2">{{ translate('Primary') }}</span>
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.toggle field="primary" />
                        </div>
                    </div>
                    <!-- END Primary -->

                    <!-- Featured -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                        <label class="flex items-center text-sm font-medium text-gray-700 ">
                            <span class="mr-2">{{ translate('Featured') }}</span>
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.toggle field="featured" />
                        </div>
                    </div>
                    <!-- END Featured -->

                    <div class="w-full flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">

                        <button type="button" class="btn btn-primary ml-auto btn-sm"
                            @click="onSave()"
                            wire:click="savePlan()"
                            >
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
                                    <x-dashboard.form.file-selector field="thumbnail" id="plan-thumbnail-image" :selected-image="$plan->thumbnail"></x-dashboard.form.file-selector>

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
                                    <x-dashboard.form.file-selector field="cover" id="plan-cover-image" :selected-image="$plan->cover"></x-dashboard.form.file-selector>

                                    <x-system.invalid-msg field="plan.cover"></x-system.invalid-msg>
                                </div>
                            </div>
                        </div>
                        {{-- END Cover --}}
                    </div>

                    {{-- Gallery --}}
                    <div class="sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                        <div class="flex flex-col " x-data="{}">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ translate('Gallery') }}
                            </label>

                            <div class="mt-1 sm:mt-0">
                                <x-dashboard.form.file-selector
                                    id="plan-gallery"
                                    field="gallery"
                                    :file-type="\App\Enums\FileTypesEnum::image()->value"
                                    :selected-image="$plan->gallery"
                                    :multiple="true"
                                    add-new-item-label="{{ translate('Add new image') }}"></x-dashboard.form.file-selector>

                                <x-system.invalid-msg field="plan.gallery"></x-system.invalid-msg>
                            </div>
                        </div>
                    </div>
                    {{-- END Gallery --}}

                </div>
                {{-- END Media --}}


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

                {{-- Core Meta --}}
                <x-dashboard.form.blocks.core-meta-form></x-dashboard.form.blocks.core-meta-form>
                {{-- Core Meta --}}

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
                        <div class="flex flex-col sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5">
                            <div class=s"flex flex-col " x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ translate('Meta image') }}
                                </label>

                                <div class="mt-1 sm:mt-0">
                                    <x-dashboard.form.file-selector field="meta_img" id="plan-meta-image" :selected-image="$plan->meta_img"></x-dashboard.form.file-selector>

                                    <x-system.invalid-msg field="plan.meta_img"></x-system.invalid-msg>
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
    </div>
</div>
