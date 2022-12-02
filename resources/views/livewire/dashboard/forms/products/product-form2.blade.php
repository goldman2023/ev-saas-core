@push('head_scripts')
<script src="{{ static_asset('js/editor.js', false, true, true) }}"></script>
@endpush

<div class="lw-form container-fluid" x-data="{
        thumbnail: @js(toJSONMedia($product->thumbnail)),
        cover: @js(toJSONMedia($product->cover)),
        meta_img: @js(toJSONMedia($product->meta_img)),
        gallery: @js(collect($product->gallery)->map(fn($item, $key) => toJSONMedia($item))),
        pdf: @js(toJSONMedia($product->pdf)),
        video_provider: @js($product->video_provider),
        base_currency: @js($product->base_currency),
        brand_id: @js($product->brand_id),
        tags: @js($product->tags),
        status: @js($product->status ?? App\Enums\StatusEnum::draft()->value),
        type: @js($product->type ?? App\Enums\ProductTypeEnum::standard()->value),
        is_digital: {{ $product->digital === true ? 'true' : 'false' }},
        use_serial: {{ $product->use_serial === true ? 'true' : 'false' }},
        allow_out_of_stock_purchases: {{ $product->allow_out_of_stock_purchases === true ? 'true' : 'false' }},
        discount_type: @js($product->discount_type),
        tax_type: @js($product->tax_type),
        description: @entangle('product.description').defer,
        description_structure: @entangle('wef.content_structure').defer,

        attributes: @js($custom_attributes),
        selected_attribute_values: @js($selected_predefined_attribute_values),
        selected_categories: @js($selected_categories),
        predefined_types: @js(\App\Enums\AttributeTypeEnum::getPredefined() ?? []),
        track_inventory: @js($product->track_inventory),

        core_meta: @js($core_meta),
        wef: @js($wef),

        onSave() {
            $wire.set('product.description', this.description, true);
            $wire.set('wef.content_structure', this.description_structure, true);

            $wire.set('product.thumbnail', this.thumbnail.id, true);
            $wire.set('product.cover', this.cover.id, true);
            $wire.set('product.meta_img', this.meta_img.id, true);
            $wire.set('product.gallery', this.gallery, true);
            $wire.set('product.pdf', this.pdf.id, true);

            $wire.set('product.video_provider', this.video_provider, true);
            $wire.set('product.base_currency', this.base_currency, true);
            $wire.set('product.discount_type', this.discount_type, true);
            $wire.set('product.tax_type', this.tax_type, true);
            $wire.set('product.track_inventory', this.track_inventory, true);
            $wire.set('product.use_serial', this.use_serial, true);
            $wire.set('product.allow_out_of_stock_purchases', this.allow_out_of_stock_purchases, true);
            $wire.set('product.digital', this.is_digital, true);

            $wire.set('product.status', this.status, true);
            $wire.set('product.type', this.type, true);
            $wire.set('product.tags', this.tags, true);
            $wire.set('product.brand_id', this.brand_id, true);

            $wire.set('core_meta', this.core_meta, true);

            $wire.set('selected_categories', this.selected_categories, true);
            $wire.set('selected_predefined_attribute_values', this.selected_attribute_values, true);
            $wire.set('custom_attributes', this.attributes, true);

            // CoreMeta and WEFs
            $wire.set('wef.date_type', this.wef.date_type, true);
            $wire.set('wef.start_date', this.wef.start_date, true);
            $wire.set('wef.end_date', this.wef.end_date, true);
            $wire.set('wef.location_type', this.wef.location_type, true);
            $wire.set('wef.unlockables', this.wef.unlockables, true);
            $wire.set('wef.unlockables_structure', this.wef.unlockables_structure, true);

            $wire.set('wef.course_what_you_will_learn', this.wef.course_what_you_will_learn, true);
            $wire.set('wef.course_requirements', this.wef.course_requirements, true);
            $wire.set('wef.course_target_audience', this.wef.course_target_audience, true);
            $wire.set('wef.course_includes', this.wef.course_includes, true);
            $wire.set('wef.course_intro_video_url', this.wef.course_intro_video_url, true);

        }
    }" 
    @init-product-form.window=""
    @validation-errors.window="console.log($event.detail.errors);" x-cloak>


    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:target="saveProduct"
            wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full" wire:loading.class="opacity-30 pointer-events-none" wire:target="saveProduct">

            <div class="grid grid-cols-12 gap-8 mb-10">
                {{-- Left side --}}
                <div class="col-span-8  ">

                    @if($is_update && $product->type === 'course')
                    <a href="{{ route('product.edit.course', $product->id) }}" class="mb-3 bg-white bg-opacity-50 flex p-6 "
                        aria-current="page" x-state:on="Current" x-state:off="Default"
                        x-state-description="Current: &quot;bg-blue-50 bg-opacity-50&quot;, Default: &quot;hover:bg-blue-50 hover:bg-opacity-50&quot;">
                        <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-blue-gray-400"
                            x-description="Heroicon name: outline/cog" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                            </path>
                        </svg>
                        <div class="ml-3 text-sm">
                            <p class="font-medium text-blue-gray-900">{{ translate('Manage course material') }}</p>
                            <p class="mt-1 text-blue-gray-500">
                                {{ translate('Manage course material, quizes and content') }}
                            </p>
                        </div>
                    </a>
                    @endif

                    {{-- Card Basic --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Basic info') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('This is basic and required
                                info about the product') }}</p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <!-- Title -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Name') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" class="form-standard @error('product.name') is-invalid @enderror"
                                        placeholder="{{ translate('New post title') }}" {{--
                                        @input="generateURL($($el).val())" --}} wire:model.defer="product.name" />

                                    <x-system.invalid-msg field="product.name"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Title -->

                            <!-- Excerpt -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Excerpt') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea type="text"
                                        class="form-standard h-[80px] @error('product.excerpt') is-invalid @enderror"
                                        placeholder="{{ translate('Write a short promo description for this product') }}"
                                        wire:model.defer="product.excerpt">
                                    </textarea>

                                    <x-system.invalid-msg class="w-full" field="product.excerpt"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Excerpt -->

                            <!-- Description -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}" wire:ignore>

                                <label class="col-span-3 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Description') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-3">
                                    <x-dashboard.form.editor-js field="description" structure-field="description_structure" id="product-description-wysiwyg" />

                                    <x-system.invalid-msg class="w-full" field="product.description" />
                                </div>
                            </div>
                            <!-- END Description -->
                        </div>
                    </div>
                    {{-- END Card Basic --}}

                    {{-- Course Meta --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5 sm:mt-8" x-show="type === 'course'">
                        <div class="pb-3 mb-5 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Course Info') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Write more about the course, like what people will learn, what is included in course, requierments etc.') }}</p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-3">
                            <!-- Course Requirements-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start " x-data="{}">
                                <div class="text-sm font-medium text-gray-900 grow-0 flex flex-col mr-3">
                                    <span class="text-14 font-medium text-gray-900 mb-1">{{ translate('Requirements') }}</span>
                                    <p class="text-gray-500 text-14">{{ translate('Describe important requirements students should have.') }}</p>
                                </div>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.text-repeater field="wef.course_requirements" placeholder="{{ translate('Requirement') }}"></x-dashboard.form.text-repeater>
                                </div>
                            </div>
                            <!-- END Course Requirements -->

                            <!-- Course Includes-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                                <div class="text-sm font-medium text-gray-900 grow-0 flex flex-col mr-3">
                                    <span class="text-14 font-medium text-gray-900 mb-1">{{ translate('Course includes') }}</span>
                                    <p class="text-gray-500 text-14">{{ translate('Describe what\'s included in the course.') }}</p>
                                </div>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.text-repeater field="wef.course_includes" placeholder="{{ translate('Includes') }}"></x-dashboard.form.text-repeater>
                                </div>
                            </div>
                            <!-- END Course Includes -->

                            <!-- What users will learn-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                                <div class="text-sm font-medium text-gray-900 grow-0 flex flex-col mr-3">
                                    <span class="text-14 font-medium text-gray-900 mb-1">{{ translate('Learned skills') }}</span>
                                    <p class="text-gray-500 text-14">{{ translate('Describe which skills all students will learn after completing the course. ') }}</p>
                                </div>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.text-repeater field="wef.course_what_you_will_learn" placeholder="{{ translate('Skill') }}"></x-dashboard.form.text-repeater>
                                </div>
                            </div>
                            <!-- END WHat users will learn -->

                            <!-- Course Target Audience-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                                <div class="text-sm font-medium text-gray-900 grow-0 flex flex-col mr-3">
                                    <span class="text-14 font-medium text-gray-900 mb-1">{{ translate('Target audience') }}</span>
                                    <p class="text-gray-500 text-14">{{ translate('Describe target audiences this course is made for.') }}</p>
                                </div>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.text-repeater field="wef.course_target_audience" placeholder="{{ translate('Describe target audience') }}"></x-dashboard.form.text-repeater>
                                </div>
                            </div>
                            <!-- END Course Target Audience -->

                        </div>
                    </div>
                    {{-- END Course Meta --}}

                    {{-- Card Unlockables --}}
                    {{-- <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Locked Content') }}
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('User will be able to access
                                this content once product is purchased') }}</p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <template
                                x-if="wef.unlocakbles != null && wef.unlocakbles.length > 0">
                                <template x-for="item in wef.unlocakbles">
                                    <!-- Title -->
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                        x-data="{}">

                                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            {{ translate('Name') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text"
                                                class="form-standard @error('product.name') is-invalid @enderror"
                                                placeholder="{{ translate('New post title') }}"
                                                wire:model.defer="product.name" />

                                            <x-system.invalid-msg field="product.name"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                    <!-- END Title -->
                                </template>
                            </template>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">


                            <!-- Excerpt -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Excerpt') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea type="text"
                                        class="form-standard h-[80px] @error('product.excerpt') is-invalid @enderror"
                                        placeholder="{{ translate('Write a short promo description for this product') }}"
                                        wire:model.defer="product.excerpt">
                                    </textarea>

                                    <x-system.invalid-msg class="w-full" field="product.excerpt"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Excerpt -->

                            <!-- Description -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}" wire:ignore>

                                <label class="col-span-3 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Description') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-3">
                                    <x-dashboard.form.froala field="description" id="product-description-wysiwyg">
                                    </x-dashboard.form.froala>

                                    <x-system.invalid-msg class="w-full" field="product.description">
                                    </x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Description -->
                        </div>
                    </div> --}}
                    {{-- END Card Unlockables --}}


                    {{-- Card Pricing --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5 sm:mt-8" x-data="{
                            show_tax: {{ !empty($product->tax) ? 'true':'false' }},
                        }">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Pricing') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Product pricing details') }}
                            </p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <!-- Price -->
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Price') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="grid grid-cols-10 gap-3">
                                        <div class="col-span-6">
                                            <input type="number" step="0.01"
                                                class="form-standard @error('product.unit_price') is-invalid @enderror"
                                                placeholder="{{ translate('0.00') }}"
                                                wire:model.defer="product.unit_price" />
                                        </div>

                                        <div class="col-span-4" x-data="{}">
                                            <x-dashboard.form.select :items="\FX::getAllCurrencies(formatted: true)"
                                                selected="base_currency" :nullable="false"></x-dashboard.form.select>
                                        </div>

                                        <x-system.invalid-msg class="col-span-10" field="product.unit_price">
                                        </x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            <!-- END Price -->

                            <!-- Discount and Discount type -->
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Discount') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="grid grid-cols-10 gap-3">
                                        <div class="col-span-6">
                                            <input type="number" step="0.01" min="0"
                                                class="form-standard @error('product.discount') is-invalid @enderror"
                                                placeholder="{{ translate('0.00') }}"
                                                wire:model.defer="product.discount" />
                                        </div>

                                        <div class="col-span-4" x-data="{}">
                                            <x-dashboard.form.select
                                                :items="\App\Enums\AmountPercentTypeEnum::toArray()"
                                                selected="discount_type" :nullable="false"></x-dashboard.form.select>
                                        </div>

                                        <x-system.invalid-msg class="col-span-10" field="product.discount">
                                        </x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            <!-- END Discount and Discount type -->

                            {{-- Additional fee/tax --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Has additional fee?')
                                        }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="show_tax = !show_tax"
                                        :class="{'bg-primary':show_tax, 'bg-gray-200':!show_tax}"
                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                        role="switch">
                                        <span :class="{'translate-x-5':show_tax, 'translate-x-0':!show_tax}"
                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="w-full mt-4" x-show="show_tax">
                                <!-- Tax and Tax type -->
                                <div
                                    class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Additional Fee') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="grid grid-cols-10 gap-3">
                                            <div class="col-span-6">
                                                <input type="number" step="0.01" min="0"
                                                    class="form-standard @error('product.tax') is-invalid @enderror"
                                                    placeholder="{{ translate('Additional fee (fixed or percentage)') }}"
                                                    wire:model.defer="product.tax" />
                                            </div>

                                            <div class="col-span-4" x-data="{}">
                                                <x-dashboard.form.select
                                                    :items="\App\Enums\AmountPercentTypeEnum::toArray()"
                                                    selected="tax_type" :nullable="false"></x-dashboard.form.select>
                                            </div>

                                            <x-system.invalid-msg class="col-span-10" field="product.tax">
                                            </x-system.invalid-msg>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Tax and Tax type -->
                            </div>
                            {{-- Additional fee/tax --}}

                            <!-- Cost per item -->
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Cost per item') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="grid grid-cols-10 gap-3">
                                        <div class="col-span-6">
                                            <input type="number" step="0.01"
                                                class="form-standard @error('product.purchase_price') is-invalid @enderror"
                                                placeholder="{{ translate('0.00') }}"
                                                wire:model.defer="product.purchase_price" />
                                        </div>

                                        <x-system.invalid-msg class="col-span-10" field="product.purchase_price">
                                        </x-system.invalid-msg>

                                        <small class="col-span-10 w-100">
                                            {{ translate('Customers won\'t see this. For your reference and reports
                                            only.') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <!-- END Cost per item -->
                        </div>
                    </div>
                    {{-- END Card Pricing --}}


                    {{-- Card Inventory --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5 sm:mt-8" x-data="{}">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Inventory') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Track your product inventory')
                                }}</p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 "
                                x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Track inventory?')
                                        }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                    <button type="button" @click="track_inventory = !track_inventory"
                                        :class="{'bg-primary':track_inventory, 'bg-gray-200':!track_inventory}"
                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                        role="switch">
                                        <span
                                            :class="{'translate-x-5':track_inventory, 'translate-x-0':!track_inventory}"
                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>


                            <div class="w-full space-y-6 sm:space-y-5" x-show="track_inventory">
                                {{-- SKU --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('SKU') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input type="text"
                                            class="form-standard @error('product.sku') is-invalid @enderror"
                                            placeholder="{{ translate('Product SKU') }}"
                                            wire:model.defer="product.sku" />

                                        <small class="text-muted">{{ translate('Leave empty if you want to add only SKU
                                            of the variations.') }}</small>

                                        <x-system.invalid-msg field="product.sku"></x-system.invalid-msg>
                                    </div>
                                </div>
                                {{-- END SKU --}}

                                {{-- Barcode --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Barcode') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input type="text"
                                            class="form-standard @error('product.barcode') is-invalid @enderror"
                                            placeholder="{{ translate('Product barcode') }}"
                                            wire:model.defer="product.barcode" />

                                        <small class="text-muted">{{ translate('Leave empty if you want to add only
                                            Barcode of the variations.') }}</small>

                                        <x-system.invalid-msg field="product.barcode"></x-system.invalid-msg>
                                    </div>
                                </div>
                                {{-- END Barcode --}}

                                {{-- Use serial numbers --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 "
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Uses serial
                                            numbers?') }}</span>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                        <button type="button" @click="use_serial = !use_serial"
                                            :class="{'bg-primary':use_serial, 'bg-gray-200':!use_serial}"
                                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                            role="switch">
                                            <span :class="{'translate-x-5':use_serial, 'translate-x-0':!use_serial}"
                                                class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                        </button>
                                    </div>
                                </div>
                                {{-- END Use serial numbers --}}

                                {{-- Allow out of stock purchases --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 "
                                    x-data="{}">
                                    <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                        <span class="text-sm font-medium text-gray-900">{{ translate('Allow selling even
                                            when out of stock?') }}</span>
                                    </div>

                                    <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">
                                        <button type="button"
                                            @click="allow_out_of_stock_purchases = !allow_out_of_stock_purchases"
                                            :class="{'bg-primary':allow_out_of_stock_purchases, 'bg-gray-200':!allow_out_of_stock_purchases}"
                                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                            role="switch">
                                            <span
                                                :class="{'translate-x-5':allow_out_of_stock_purchases, 'translate-x-0':!allow_out_of_stock_purchases}"
                                                class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                        </button>
                                    </div>
                                </div>
                                {{-- END Allow out of stock purchases --}}

                                <div class="w-full" x-show="!use_serial">
                                    <!-- Minimum quantity user can purchase -->
                                    <div
                                        class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            {{ translate('Minimum quantity user can purchase') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <div class="grid grid-cols-10 gap-3">
                                                <div class="col-span-6">
                                                    <input type="number" step="0.01"
                                                        class="form-standard @error('product.min_qty') is-invalid @enderror"
                                                        placeholder="{{ translate('0.00') }}"
                                                        wire:model.defer="product.min_qty" />
                                                </div>

                                                <x-system.invalid-msg class="col-span-10" field="product.min_qty">
                                                </x-system.invalid-msg>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Minimum quantity user can purchase -->

                                    <!-- Stock quantity -->
                                    <div
                                        class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4">
                                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            {{ translate('Stock quantity') }}
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <div class="grid grid-cols-10 gap-3">
                                                <div class="col-span-6">
                                                    <input type="number" step="0.01"
                                                        class="form-standard @error('product.current_stock') is-invalid @enderror"
                                                        placeholder="{{ translate('0.00') }}"
                                                        wire:model.defer="product.current_stock" />
                                                </div>

                                                <x-system.invalid-msg class="col-span-10" field="product.current_stock">
                                                </x-system.invalid-msg>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Stock quantity -->
                                </div>

                                {{-- Unit --}}
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Unit') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="grid grid-cols-10 gap-3">
                                            <div class="col-span-6">
                                                <input type="text"
                                                    class="form-standard @error('product.unit') is-invalid @enderror"
                                                    placeholder="{{ translate('Product unit') }}"
                                                    wire:model.defer="product.unit" />
                                            </div>

                                            <x-system.invalid-msg class="col-span-10" field="product.unit">
                                            </x-system.invalid-msg>
                                        </div>
                                    </div>
                                </div>
                                {{-- END Unit --}}

                                <!-- Low stock quantity -->
                                <div
                                    class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Low stock quantity') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="grid grid-cols-10 gap-3">
                                            <div class="col-span-6">
                                                <input type="number" step="0.01" min="0"
                                                    class="form-standard @error('product.low_stock_qty') is-invalid @enderror"
                                                    placeholder="{{ translate('0.00') }}"
                                                    wire:model.defer="product.low_stock_qty" />
                                            </div>

                                            <x-system.invalid-msg class="col-span-10" field="product.low_stock_qty">
                                            </x-system.invalid-msg>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Low stock quantity -->
                            </div>

                        </div>
                    </div>
                    {{-- END Card Inventory --}}


                    {{-- Card Shipping --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5 sm:mt-8" x-data="{}"
                        x-show="type != 'digital' && type != 'event'">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Shipping') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Set available delivery options
                                for your product') }}</p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <!-- Is digital product? -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 "
                                x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900">{{ translate('Is this a digital
                                        product?') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="is_digital = !is_digital"
                                        :class="{'bg-primary':is_digital, 'bg-gray-200':!is_digital}"
                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                        role="switch">
                                        <span :class="{'translate-x-5':is_digital, 'translate-x-0':!is_digital}"
                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>


                            <div class="w-full" x-show="is_digital">
                                {{-- TODO: Add Shipping methods first and then edit this part --}}
                            </div>
                        </div>
                    </div>
                    {{-- END Card Shipping --}}


                    {{-- Card Attributes --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5 sm:mt-8" x-data="{}"
                        wire:ignore>
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Attributes') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Enrich your products with
                                additional data') }}</p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <template x-for="attribute in attributes">
                                <div class="w-full mb-3" x-data="{
                                        getSelectorID() {
                                            return 'attributes_'+this.attribute.id+'_attribute_values';
                                        },
                                        hasCustomProperty(name) {
                                            return this.attribute.custom_properties !== null &&
                                                    this.attribute.custom_properties !== undefined &&
                                                    this.attribute.custom_properties.hasOwnProperty(name);
                                        },
                                        getMinValue() {
                                            return this.hasCustomProperty('min_value') ? this.attribute.custom_properties.min_value : 0;
                                        },
                                        getMaxValue() {
                                            return this.hasCustomProperty('max_value') ? this.attribute.custom_properties.max_value : 999;
                                        },
                                        getMinRows() {
                                            return this.hasCustomProperty('min_rows') ? this.attribute.custom_properties.min_rows : 0;
                                        },
                                        getMaxRows() {
                                            return this.hasCustomProperty('max_rows') ? this.attribute.custom_properties.max_rows : 999;
                                        },
                                    }" x-cloak>

                                    {{-- Dropdown --}}
                                    <template x-if="attribute.type === 'dropdown'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 "
                                            x-data="{
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
                                            }">
                                            <div
                                                class="justify-center h-full col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                                <span class="text-sm font-medium text-gray-900"
                                                    x-text="attribute.name"></span>
                                            </div>

                                            <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full">

                                                <div class="we-select relative w-full" x-data="{}"
                                                    @click.outside="show = false">
                                                    <div class="we-select__selector select-none w-full flex flex-wrap border pl-3 pt-2 pb-1 pr-6 relative cursor-pointer"
                                                        @click="show = !show">
                                                        @svg('heroicon-o-chevron-down', ['class' =>
                                                        'we-select__selector-arrow absolute w-[16px] h-[16px]
                                                        vertical-center', ':class' => "{'rotate-180': show}"])

                                                        <template x-if="!multiple">
                                                            <span class="block pb-1" x-text="getPlaceholder()"></span>
                                                        </template>

                                                        <template x-if="multiple">
                                                            <div class="w-full flex flex-wrap">
                                                                <template x-if="countSelected() > 0">
                                                                    <template x-for="item in items.filter(x => {
                                                                        return selected_items.indexOf(x.id) !== -1;
                                                                    })">
                                                                        <div
                                                                            class="we-select__selector-selected-item rounded mr-2 mb-1 relative">
                                                                            <span
                                                                                class="we-select__selector-selected-item-label pl-1 mr-1"
                                                                                x-text="item.values"></span>
                                                                            <button type="button"
                                                                                class="we-select__selector-selected-item-remove px-2"
                                                                                @click="event.stopPropagation(); select(item.id, item.values)">
                                                                                <span>×</span>
                                                                            </button>
                                                                        </div>
                                                                    </template>
                                                                </template>
                                                                <template x-if="countSelected() <= 0">
                                                                    <span class="block pb-1"
                                                                        x-text="getPlaceholder()"></span>
                                                                </template>
                                                            </div>
                                                        </template>
                                                    </div>

                                                    <div class="we-select__dropdown  absolute bg-white shadow border rounded mt-1  w-full"
                                                        x-show="show">
                                                        <ul class="we-select__dropdown-list select-none w-full">
                                                            <template x-for="item in items">
                                                                <li class="we-select__dropdown-list-item py-2 px-3 cursor-pointer"
                                                                    x-text="item.values"
                                                                    :class="{'selected': isSelected(item.id) }"
                                                                    @click="select(item.id, item.values)"></li>
                                                            </template>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <template
                                                    x-if="hasCustomProperty('multiple') && attribute.custom_properties.multiple">
                                                    <!-- Used for variations? -->
                                                    <div class="flex items-center pt-3 " x-data="{}">
                                                        <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                                            <span class="text-sm font-medium text-gray-900">{{
                                                                translate('Used for variations') }}</span>
                                                        </div>

                                                        <div
                                                            class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                                            <button type="button"
                                                                @click="attribute.for_variations = !attribute.for_variations"
                                                                :class="{'bg-primary':attribute.for_variations, 'bg-gray-200':!attribute.for_variations}"
                                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                                role="switch">
                                                                <span
                                                                    :class="{'translate-x-5':attribute.for_variations, 'translate-x-0':!attribute.for_variations}"
                                                                    class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- END Used for variations? -->
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Dropdown --}}


                                    {{-- Plain Text --}}
                                    <template x-if="attribute.type === 'plain_text'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{}">

                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <input type="text" class="form-standard"
                                                    :id="'attributes_'+attribute.id+'_attribute_values'"
                                                    x-model="attribute.attribute_values[0].values" />
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Plain Text --}}

                                    {{-- Number --}}
                                    <template x-if="attribute.type === 'number'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{}">

                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2 flex rounded-md shadow-sm">
                                                <input type="number"
                                                    :id="'attributes_'+attribute.id+'_attribute_values'"
                                                    x-bind:min="getMinValue()" x-bind:max="getMaxValue()"
                                                    x-model="attribute.attribute_values[0].values"
                                                    class="form-standard !rounded-r-none">

                                                <template x-if="hasCustomProperty('unit')">
                                                    <span x-text="attribute.custom_properties.unit"
                                                        class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm"></span>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Number --}}


                                    {{-- Date --}}
                                    <template x-if="attribute.type === 'date'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{
                                                getDateOptions() {
                                                    let options = {
                                                        mode: 'single',
                                                        enableTime: false,
                                                    };

                                                    if(this.hasCustomProperty('with_time') && this.attribute.custom_properties.with_time) {
                                                        options.enableTime = true;
                                                        options.dateFormat = 'd.m.Y H:i';
                                                    } else {
                                                        options.dateFormat = 'd.m.Y';
                                                    }

                                                    if(this.hasCustomProperty('range') && this.attribute.custom_properties.range) {
                                                        options.mode = 'range';
                                                    }

                                                    return options;
                                                },
                                            }"
                                            x-init="$nextTick(() => { flatpickr('.js-flatpickr', getDateOptions()); });">

                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2 flex rounded-md shadow-sm">
                                                <input x-model="attribute.attribute_values[0].values" type="text"
                                                    class="js-flatpickr flatpickr-custom form-standard"
                                                    placeholder="{{ translate('Pick a date(s)') }}" data-input />
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Date --}}


                                    {{-- Checkbox --}}
                                    <template x-if="attribute.type === 'checkbox'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{}">

                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div
                                                class="mt-1 sm:mt-0 sm:col-span-2 flex flex-col rounded-md shadow-sm space-y-4">
                                                <template
                                                    x-for="(attribute_value, index) in attribute.attribute_values">
                                                    <div class="relative flex items-center "
                                                        :class="{'!mt-0': index === 0}">
                                                        <div class="flex items-center h-6">
                                                            <input type="checkbox"
                                                                x-model="selected_attribute_values['attribute.'+attribute.id]"
                                                                :value="attribute_value.id"
                                                                :id="'attribute_'+attribute_value.id"
                                                                class="form-checkbox-standard">
                                                        </div>
                                                        <div class="ml-3 text-sm">
                                                            <label class="font-medium text-gray-700 cursor-pointer"
                                                                x-text="attribute_value.values"
                                                                :for="'attribute_'+attribute_value.id"></label>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Checkbox --}}

                                    {{-- Radio --}}
                                    <template x-if="attribute.type === 'radio'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{}">

                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div
                                                class="mt-1 sm:mt-0 sm:col-span-2 flex flex-col rounded-md shadow-sm space-y-4">
                                                <template
                                                    x-for="(attribute_value, index) in attribute.attribute_values">
                                                    <div class="relative flex items-center "
                                                        :class="{'!mt-0': index === 0}">
                                                        <div class="flex items-center h-6">
                                                            <input type="radio"
                                                                x-model="selected_attribute_values['attribute.'+attribute.id]"
                                                                :value="attribute_value.id"
                                                                :id="'attribute_'+attribute_value.id"
                                                                class="form-radio-standard">
                                                        </div>
                                                        <div class="ml-3 text-sm">
                                                            <label class="font-medium text-gray-700 cursor-pointer"
                                                                x-text="attribute_value.values"
                                                                :for="'attribute_'+attribute_value.id"></label>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Radio --}}


                                    {{-- Text List --}}
                                    <template x-if="attribute.type === 'text_list'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{
                                                items: attribute.attribute_values.map(x => x.values),
                                                hasID(index) {
                                                    return attribute.attribute_values[index].hasOwnProperty('id') && !isNaN(attribute.attribute_values[index].id) ? true : false;
                                                },
                                                count() {
                                                    if(this.attribute.attribute_values === undefined || this.attribute.attribute_values === null) {
                                                        this.attribute.attribute_values = [{
                                                            values: ''
                                                        }];
                                                    }

                                                    return this.attribute.attribute_values.length;
                                                },
                                                add() {
                                                    if(this.count() < getMaxRows()) {
                                                        this.attribute.attribute_values.push({
                                                            values: ''
                                                        });
                                                    }
                                                },
                                                remove(index) {
                                                    if(this.hasID(index)) {
                                                        $wire.removeAttributeValue(attribute.attribute_values[index].id);
                                                    }

                                                    attribute.attribute_values.splice(index, 1);
                                                },
                                            }" x-init="
                                                if(getMinRows() > 1) {
                                                    for(let i=1; i < getMinRows(); i++) {
                                                        add();
                                                    }
                                                }
                                            ">
                                            {{-- $watch('items', items => {
                                            items.forEach((item, index) => {
                                            if(attribute.attribute_values[index] === undefined ||
                                            attribute.attribute_values[index] === null) {
                                            attribute.attribute_values[index] = {
                                            values: item
                                            };
                                            } else {
                                            attribute.attribute_values[index].values = item;
                                            }
                                            });

                                            let diff = attribute.attribute_values.length - items.length;

                                            if(diff > 0) {
                                            Remove difference between attribute.attribute_values and mapped items.
                                            attribute.attribute_values = attribute.attribute_values.slice(0, -(diff));
                                            }
                                            }); --}}
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <template x-if="count() <= 1">
                                                    <div class="flex w-full">
                                                        <input type="text" class="form-standard "
                                                            placeholder="{{ translate('Value 1') }}"
                                                            x-model="items[0]" />
                                                    </div>
                                                </template>
                                                <template x-if="count() > 1">
                                                    <template
                                                        x-for="(attribute_value, key) in attribute.attribute_values">
                                                        <div class="flex" :class="{'mt-2': key > 0}">
                                                            <input type="text" class="form-standard"
                                                                :id="'attribute-'+attribute.id+'-text-list-input-'+key"
                                                                x-bind:placeholder="'{{ translate('Value') }} '+(Number(key)+1)"
                                                                x-model="attribute_value.values" />
                                                            <template x-if="(key+1) > getMinRows()">
                                                                <span class="ml-2 flex items-center cursor-pointer"
                                                                    @click="remove(key)">
                                                                    @svg('heroicon-o-trash', ['class' => 'w-[22px]
                                                                    h-[22px] text-danger'])
                                                                </span>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </template>

                                                <div href="javascript:;" class="btn-ghost !pl-0 !text-14 mt-1"
                                                    @click="add()" x-show="count() < getMaxRows()">
                                                    @svg('heroicon-o-plus', ['class' => 'h-3 w-3 mr-2'])
                                                    {{ translate('Add new') }}
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Text List --}}

                                    {{-- Image --}}
                                    <template x-if="attribute.type === 'image'">
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                            x-data="{}">

                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
                                                x-text="attribute.name"></label>

                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <div class="w-full" x-data="{
                                                    id: 'attributes_'+attribute.id+'_attribute_values',
                                                    file_name: '',
                                                }" @we-media-selected-event.window="
                                                    if($event.detail.for_id === id) {
                                                        attribute.attribute_values[0].values = $event.detail.selected[0]['id'] || '';
                                                        file_name = $event.detail.selected[0]['file_name'] || '';
                                                    }
                                                ">
                                                    <div class="max-w-lg flex justify-center border-2 border-gray-300 border-dashed rounded-md cursor-pointer"
                                                        :class="{'px-6 pt-5 pb-6': attribute.attribute_values[0].values !== undefined && attribute.attribute_values[0].values !== null && attribute.attribute_values[0].values > 0 }"
                                                        @click="$wire.emit('showMediaLibrary', id, 'image', [{id:attribute.attribute_values[0].values, file_name:file_name}])">

                                                        <template
                                                            x-if="attribute.attribute_values[0].values !== undefined && attribute.attribute_values[0].values !== null && attribute.attribute_values[0].values > 0">
                                                            <div class="h-[200px] w-full rounded cursor-pointer">
                                                                <img class="w-full h-[200px] object-contain"
                                                                    x-bind:src="window.WE.IMG.url(file_name)" />
                                                            </div>
                                                        </template>

                                                        <template
                                                            x-if="!(attribute.attribute_values[0].values !== undefined && attribute.attribute_values[0].values !== null && attribute.attribute_values[0].values > 0)">
                                                            <div class="space-y-1 text-center py-7">
                                                                <svg class="mx-auto h-12 w-12 text-gray-400"
                                                                    stroke="currentColor" fill="none"
                                                                    viewBox="0 0 48 48" aria-hidden="true">
                                                                    <path
                                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" />
                                                                </svg>
                                                                <div class="flex text-sm text-gray-600">
                                                                    <label
                                                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                                        <span>{{ translate('Select a file') }}</span>
                                                                    </label>
                                                                    <p class="pl-1">{{ translate('or drag and drop') }}
                                                                    </p>
                                                                </div>
                                                                <p class="text-xs text-gray-500">{{ translate('PNG, JPG,
                                                                    GIF up to 3MB') }}</p>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- END Image --}}

                                    {{-- TODO: Add wysiwyg, gallery, country type attribute --}}
                                </div>
                            </template>
                        </div>
                    </div>
                    {{-- END Card Attributes --}}


                    {{-- Card Unlockables --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5 sm:mt-8" x-data="{}"
                        wire:ignore>
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Unlockables') }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Content which user unlock when
                                product is purchased') }}</p>
                        </div>

                        <div class="mt-6 sm:mt-3 space-y-6 sm:space-y-5">
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}" wire:ignore>
                                <div class="mt-1 sm:mt-0 sm:col-span-3">
                                    <div class="mt-1 sm:mt-0 sm:col-span-3">
                                        <x-dashboard.form.editor-js 
                                            field="wef.unlockables" 
                                            structure-field="wef.unlockables_structure"
                                            id="product-unlockables-wysiwyg" />

                                        <x-system.invalid-msg class="w-full" field="wef.unlockables">
                                        </x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END Card Unlockables --}}
                </div>
                {{-- END Left side --}}


                {{-- Right side --}}
                <div class="col-span-4">
                    {{-- Actions --}}
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <!-- Status -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                            <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                <span class="mr-2">{{ translate('Status') }}</span>

                                @if($product->status === App\Enums\StatusEnum::published()->value)
                                <span class="badge-success">{{ ucfirst($product->status) }}</span>
                                @elseif($product->status === App\Enums\StatusEnum::draft()->value)
                                <span class="badge-warning">{{ ucfirst($product->status) }}</span>
                                @elseif($product->status === App\Enums\StatusEnum::pending()->value)
                                <span class="badge-info">{{ ucfirst($product->status) }}</span>
                                @elseif($product->status === App\Enums\StatusEnum::private()->value)
                                <span class="badge-dark">{{ ucfirst($product->status) }}</span>
                                @endif
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.select :items="\App\Enums\StatusEnum::toArray('archived')"
                                    selected="status" :nullable="false"></x-dashboard.form.select>
                            </div>
                        </div>
                        <!-- END Status -->


                        <!-- Product Type -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                            <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                <span class="mr-2">{{ translate('Product Type') }}</span>
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.select :items="\App\Enums\ProductTypeEnum::toArray()" selected="type"
                                    :nullable="false"></x-dashboard.form.select>
                            </div>
                        </div>
                        <!-- END Product Type -->

                        <div
                            class="w-full flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                            @if($is_update)
                            <button type="button" class="btn btn-danger btn-sm cursor-pointer">
                                {{ translate('Delete') }}
                            </button>
                            @endif

                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="onSave()"
                                wire:click="saveProduct()">
                                {{ translate('Save') }}
                            </button>
                        </div>
                    </div>
                    {{-- END Actions --}}

                    {{-- Event Meta --}}
                    <div class="p-4 mt-8 border bg-white border-gray-200 rounded-lg shadow" x-show="type === 'event'">
                        <div class="w-100 mt-2">
                            <!-- Location Type-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start " x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Location Type') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.select :items="['remote' => 'Remote', 'offline' => 'Offline']"
                                        selected="wef.location_type"></x-dashboard.form.select>

                                    <x-system.invalid-msg field="wef.location_type"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Location Type -->

                            <!-- Location Address-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                x-data="{}" x-show="wef.location_type === 'offline'">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Location Address') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.input field="wef.location_address">
                                    </x-dashboard.form.input>
                                </div>
                            </div>
                            <!-- END Location Address -->

                            <!-- Location Address-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                x-data="{}" x-show="wef.location_type === 'offline'">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Location Address Map (URL)') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.input field="wef.location_address_map_link">
                                    </x-dashboard.form.input>
                                </div>
                            </div>
                            <!-- END Location Address -->

                            <!-- Location Link-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                x-data="{}" x-show="wef.location_type === 'remote'">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Meet Link') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.input field="wef.location_link">
                                    </x-dashboard.form.input>
                                </div>
                            </div>
                            <!-- END Location Link -->


                            <!-- Date Type-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Date Type') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.select :items="['specific' => 'Specific', 'range' => 'Range']"
                                        selected="wef.date_type"></x-dashboard.form.select>
                                </div>
                            </div>
                            <!-- END Date Type -->

                            <!-- Date Start-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Start') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.date field="wef.start_date" :enable-time="true"
                                        date-format="d.m.Y H:i"></x-dashboard.form.date>
                                </div>
                            </div>
                            <!-- END Date Start -->

                            <!-- Date End-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                                x-data="{}" x-show="wef.date_type === 'range'">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('End') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.date field="wef.end_date" :enable-time="true"
                                        date-format="d.m.Y H:i"></x-dashboard.form.date>
                                </div>
                            </div>
                            <!-- END Date End -->
                        </div>
                    </div>
                    {{-- END Event Meta --}}

                    {{-- Bookable Service Meta --}}
                    <div class="p-4 mt-8 border bg-white border-gray-200 rounded-lg shadow"
                        x-show="type === 'bookable_service'">
                        <div class="w-100 mt-2">
                            <!-- Calendly link-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('Calendly link') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.input field="wef.calendly_link">
                                    </x-dashboard.form.input>
                                </div>
                            </div>
                            <!-- END Calendly link -->
                        </div>
                    </div>
                    {{-- Bookable Service Meta --}}

                    <div class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
                        open: false,
                    }" :class="{'p-4': open}">
                        <livewire:feed.elements.product-card :product="$product"></livewire:feed.elements.product-card>
                    </div>

                    {{-- After purchase CTA Meta --}}
                    <div class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
                        open: false,
                    }" :class="{'p-4': open}">
                        <div class="w-full flex items-center justify-between cursor-pointer" @click="open = !open"
                            :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('After purchase CTA
                                (Thank you page)') }}</h3>
                            @svg('heroicon-o-chevron-down', ['class' => 'h-4 w-4', ':class' => "{'rotate-180':open}"])
                        </div>

                        <div class="w-100 mt-2" x-show="open">
                            <!-- CTA Title (Thank you page) -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start mb-4" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('CTA Title') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.input field="wef.thank_you_cta_custom_title">
                                    </x-dashboard.form.input>
                                </div>
                            </div>
                            <!-- END CTA Title (Thank you page) -->

                            <!-- CTA Text (Thank you page) -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start mb-4" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('CTA Text') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.input field="wef.thank_you_cta_custom_text">
                                    </x-dashboard.form.input>
                                </div>
                            </div>
                            <!-- END CTA Text (Thank you page) -->

                            <!-- CTA URL (Thank you page) -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start mb-4" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('CTA Button URL') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.input field="wef.thank_you_cta_custom_url">
                                    </x-dashboard.form.input>
                                </div>
                            </div>
                            <!-- END CTA URL (Thank you page) -->

                            <!-- CTA URL (Thank you page) -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">
                                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                                    {{ translate('CTA Button Title') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.input field="wef.thank_you_cta_custom_button_title">
                                    </x-dashboard.form.input>
                                </div>
                            </div>
                            <!-- END CTA URL (Thank you page) -->
                        </div>
                    </div>
                    {{-- After purchase CTA Meta --}}


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
                                        <x-dashboard.form.file-selector field="thumbnail"
                                            error-field="product.thumbnail" id="product-thumbnail-image"
                                            :selected-image="$product->thumbnail"></x-dashboard.form.file-selector>

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
                                        <x-dashboard.form.file-selector field="cover" error-field="product.cover"
                                            id="product-cover-image" :selected-image="$product->cover">
                                        </x-dashboard.form.file-selector>

                                        <x-system.invalid-msg field="product.cover"></x-system.invalid-msg>
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
                                            id="product-gallery"
                                            field="gallery"
                                            :file-type="\App\Enums\FileTypesEnum::image()->value"
                                            :selected-image="$product->gallery"
                                            :multiple="true"
                                            add-new-item-label="{{ translate('Add new image') }}"></x-dashboard.form.file-selector>

                                        <x-system.invalid-msg field="product.gallery"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            {{-- END Gallery --}}

                            {{-- Video & Document --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900" id="availability-label">{{
                                        translate('Has Video') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="show_video = !show_video"
                                        :class="{'bg-primary':show_video, 'bg-gray-200':!show_video}"
                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                        role="switch">
                                        <span :class="{'translate-x-5':show_video, 'translate-x-0':!show_video}"
                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="w-100 mt-4" x-show="show_video">
                                <!-- Video Provider -->
                                <div
                                    class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        <span class="mr-2">{{ translate('Video provider') }}</span>
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <x-dashboard.form.select :items="EVS::getMappedVideoProviders()"
                                            selected="video_provider"></x-dashboard.form.select>
                                    </div>
                                </div>
                                <!-- END Video Provider -->

                                <!-- Video Link -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Video link') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input type="text"
                                            class="form-standard @error('product.video_link') is-invalid @enderror"
                                            placeholder="{{ translate('Link to the video...') }}"
                                            wire:model.defer="product.video_link" />

                                        <x-system.invalid-msg field="product.video_link"></x-system.invalid-msg>

                                        <div class="w-full">
                                            <small class="text-warning">
                                                {{ translate('Use proper link without extra parameter. Don\'t use short
                                                share link/embeded iframe code.') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Video Link -->
                            </div>

                            {{-- Specificaion document --}}
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4"
                                x-data="{}">
                                <div class="col-span-3 md:col-span-1 grow-0 flex flex-col mr-3">
                                    <span class="text-sm font-medium text-gray-900" id="availability-label">{{
                                        translate('Has specification document') }}</span>
                                </div>

                                <div class="col-span-3 md:col-span-2 mt-1 sm:mt-0 h-full flex items-center">

                                    <button type="button" @click="show_pdf = !show_pdf"
                                        :class="{'bg-primary':show_pdf, 'bg-gray-200':!show_pdf}"
                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                        role="switch">
                                        <span :class="{'translate-x-5':show_pdf, 'translate-x-0':!show_pdf}"
                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
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
                                            <x-dashboard.form.file-selector field="pdf" id="product-document-pdf"
                                                :selected-image="$product->pdf"></x-dashboard.form.file-selector>

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
                        <div class="w-full flex items-center justify-between cursor-pointer " @click="open = !open"
                            :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
                            <h3
                                class="text-lg leading-6 font-medium text-gray-900 @error('selected_categories') !text-danger @enderror">
                                {{ translate('Categories') }}</h3>
                            @svg('heroicon-o-chevron-down', ['class' => 'h-4 w-4', ':class' => "{'rotate-180':open}"])
                        </div>

                        <div class="w-full" x-show="open">
                            <x-dashboard.form.category-selector> </x-dashboard.form.category-selector>
                        </div>
                    </div>
                    {{-- END Category Selector --}}


                    {{-- Tags --}}
                    <div class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
                            open: tags !== null && tags.length > 0,
                            add(value) {
                                if(tags === undefined || tags === null || tags.length === 0) {
                                    tags = [];
                                }

                                tags.push(value);

                                $refs['product_tags_input'].value = '';
                            },
                            remove(index) {
                                this.tags.splice(index, 1);
                            }
                        }" :class="{'p-4': open}">
                        <div class="w-full flex items-center justify-between cursor-pointer " @click="open = !open"
                            :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Tags') }}</h3>
                            @svg('heroicon-o-chevron-down', ['class' => 'h-4 w-4', ':class' => "{'rotate-180':open}"])
                        </div>

                        <div class="w-full" x-show="open">
                            <!-- Tags -->
                            <div class="flex sm:items-start">
                                <div class="w-full grid grid-cols-10 gap-3">
                                    <div class="col-span-10">
                                        <input type="text"
                                            class="form-standard @error('product.tags') is-invalid @enderror"
                                            placeholder="{{ translate('Write desired tag and press " comma", "space"
                                            or "enter" to insert it') }}" x-ref="product_tags_input"
                                            @keyup.enter="add($el.value)" @keyup.space="add($el.value)"
                                            @keyup="if(event.keyCode == 188) { add($el.value.replaceAll(',','')) };" />
                                    </div>


                                    <div class="col-span-10 flex flex-row flex-wrap "
                                        x-show="tags !== null && tags.length > 0">
                                        <template x-for="(tag, index) in tags">
                                            <span :class="{'!ml-0':index === 0}"
                                                class="mr-2 inline-flex rounded-full items-center py-0.5 pl-2.5 pr-1 mb-2 text-sm font-medium bg-primary text-white">
                                                <span x-text="tag"></span>
                                                <button @click="remove(index)" type="button"
                                                    class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center  focus:outline-none ">
                                                    @svg('heroicon-o-x-mark', ['class' => 'h-3 w-3'])
                                                </button>
                                            </span>
                                        </template>
                                    </div>

                                    <x-system.invalid-msg class="col-span-10" field="product.tags">
                                    </x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Tags -->
                        </div>
                    </div>
                    {{-- END Tags --}}

                    {{-- Core Meta --}}
                    <x-dashboard.form.blocks.core-meta-form></x-dashboard.form.blocks.core-meta-form>
                    {{-- Core Meta --}}

                    {{-- Brand --}}
                    @if(get_tenant_setting('brands_ct_enabled'))
                    <div class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
                                open: false,
                            }" :class="{'p-4': open}">
                        <div class="w-full flex items-center justify-between cursor-pointer " @click="open = !open"
                            :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Brand') }}</h3>
                            @svg('heroicon-o-chevron-down', ['class' => 'h-4 w-4', ':class' => "{'rotate-180':open}"])
                        </div>

                        <div class="w-full" x-show="open">
                            <!-- Brand -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-startsm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Brand') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="grid grid-cols-10 gap-3">
                                        <div class="col-span-10">
                                            <x-dashboard.form.select :items="EVS::getMappedBrands()"
                                                selected="brand_id"></x-dashboard.form.select>
                                        </div>

                                        <x-system.invalid-msg class="col-span-10" field="product.brand_id">
                                        </x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            <!-- END Brand -->
                        </div>
                    </div>
                    @endif
                    {{-- END Brand --}}


                    {{-- SEO --}}
                    <div class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
                            open: false,
                        }" :class="{'p-4': open}">
                        <div class="w-full flex items-center justify-between cursor-pointer " @click="open = !open"
                            :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
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
                                        class="form-standard @error('product.meta_title') is-invalid @enderror" {{--
                                        placeholder="{{ translate('Write meta title...') }}" --}}
                                        wire:model.defer="product.meta_title" />

                                    <x-system.invalid-msg field="product.meta_title"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Meta Title -->

                            <!-- Meta Description -->
                            <div class="flex flex-col sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5" x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ translate('Meta Description') }}
                                </label>

                                <div class="mt-1 sm:mt-0">
                                    <textarea type="text"
                                        class="form-standard h-[80px] @error('product.meta_description') is-invalid @enderror"
                                        {{--
                                        placeholder="{{ translate('Meta description which will be shown when link is shared on social network and') }}"
                                        --}} wire:model.defer="product.meta_description">
                                    </textarea>

                                    <x-system.invalid-msg class="w-full" field="product.meta_description">
                                    </x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Meta Description -->

                            {{-- Meta Image --}}
                            <div class="flex flex-col sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5">
                                <div class="flex flex-col " x-data=" {}">

                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ translate('Meta image') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0">
                                        <x-dashboard.form.file-selector field="meta_img" id="product-meta-image"
                                            :selected-image="$product->meta_img"></x-dashboard.form.file-selector>

                                        <x-system.invalid-msg field="product.meta_img"></x-system.invalid-msg>
                                    </div>
                                </div>
                            </div>
                            {{-- END Meta Image --}}

                        </div>
                    </div>
                    {{-- END SEO --}}

                </div>
                {{-- END Right side --}}
            </div>
        </div>
    </div>
</div>
