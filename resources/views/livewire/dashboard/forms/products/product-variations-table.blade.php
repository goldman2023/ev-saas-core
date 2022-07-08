<div class="w-full" x-data="{
    {{-- use_serial: {{ $product->use_serial === true ? 'true' : 'false' }},
    allow_out_of_stock_purchases: {{ $product->allow_out_of_stock_purchases === true ? 'true' : 'false' }},
    stock_visibility_state: @js($product->stock_visibility_state ?? 'quantity'), --}}
}">

    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                            wire:target="saveVariation"
                            wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full"
            wire:loading.class="opacity-30 pointer-events-none"
            wire:target="saveVariation"
        >

            <div class="grid grid-cols-12 gap-8 mb-10">

                {{-- Left panel --}}
                <div class="col-span-12 xl:col-span-8" x-cloak>
                    @foreach($variations as $index => $row)
                        <div class="bg-white shadow rounded-lg divide-y divide-gray-200 mb-4" x-data="{
                            show: @js($index === $last_edited_index ? true : false),
                            variation: @js($row),
                        }" :key="{{ 'product-variation-'.$row->name.'-'.$index }}" wire:key="{{ 'product-variation-'.$row->name.'-'.$index }}">
                            {{-- Variation Header --}}
                            <div class="flex items-center px-4 py-5 sm:px-6 cursor-pointer" @click="show = !show">
                                <img class="inline-block h-12 w-12 object-cover rounded-full mr-3" src="{{ $row->getThumbnail(['w' => 150]) }}" alt="">

                                @if($this->attributes->isNotEmpty())
                                    @php $display_variation_atts = []; @endphp
                                    @foreach($this->attributes as $key => $att) 
                                        @php
                                            $selected_key = array_search($att->id, array_column($row->variant, 'attribute_id'));
                                            $selected = $row->variant[$selected_key] ?? null;

                                            if(empty($selected))
                                                continue;

                                            $display_variation_atts[$att->name] = $att->attribute_values->firstWhere('id', $selected['attribute_value_id'])->values ?? '';
                                        @endphp
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 min-w-[50px]  rounded-md text-14 font-14 bg-gray-100 text-gray-800 mr-3 border">
                                            {{ $att->attribute_values->firstWhere('id', $selected['attribute_value_id'])->values }}
                                        </span>
                                    @endforeach
                                @endif

                                @if($row->id) 
                                    <div class="badge-success">
                                        {{ translate('Active') }}
                                    </div>
                                @else
                                    <div class="badge-danger">
                                        {{ translate('Inactive') }}
                                    </div>
                                @endif

                                @if($row->current_stock > $row->low_stock_qty && $row->current_stock > 0) 
                                    <div class="badge-success ml-2">
                                        {{ translate('In stock') }}
                                    </div>
                                @elseif($row->current_stock <= $row->low_stock_qty && $row->current_stock > 0)
                                    <div class="badge-warning ml-2">
                                        {{ translate('Soon out of stock...') }}
                                    </div>
                                @else
                                    <div class="badge-danger ml-2">
                                        {{ translate('Not in stock') }}
                                    </div>
                                @endif
                            </div>

                            {{-- Variation Body --}}
                            <div class="px-4 py-5 sm:p-6" x-show="show" wire:ignore.self>
                                <div class="grid grid-cols-12 gap-5 w-full">
                                    <div class="col-span-2">     
                                        <x-dashboard.form.image-selector field="variation.thumbnail" 
                                            id="variation-{{ $index }}-thumbnail" template="avatar" />
                                    </div>
                                    <div class="col-span-4 flex flex-col gap-y-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            {{ translate('Price') }}*
                                        </label>

                                        <x-dashboard.form.input type="number" min="0" field="variation.price" :x="true" error-field="variations.{{ $index }}.price"
                                            placeholder="{{ translate('Price') }}" />
                                    </div>
                                    <div class="col-span-3 flex flex-col gap-y-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            {{ translate('Discount') }}
                                        </label>

                                        <x-dashboard.form.input type="number" min="0" field="variation.discount" :x="true" error-field="variations.{{ $index }}.discount"
                                            placeholder="{{ translate('Discount') }}" />
                                    </div>
                                    <div class="col-span-3 flex flex-col gap-y-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            {{ translate('Discount Type') }}
                                        </label>

                                        <x-dashboard.form.select :items="\App\Enums\AmountPercentTypeEnum::toArray()" selected="variation.discount_type"></x-dashboard.form.select>
                                    </div>

                                    <div class="col-span-6 md:col-span-3 flex flex-col gap-y-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            {{ translate('Current quantity') }}*
                                        </label>

                                        <x-dashboard.form.input type="number" min="0" step="1" field="variation.current_stock" :x="true" error-field="variations.{{ $index }}.current_stock"
                                            placeholder="" />
                                    </div>
                                    <div class="col-span-6 md:col-span-3 flex flex-col gap-y-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            {{ translate('Low stock Quantity') }}
                                        </label>

                                        <x-dashboard.form.input type="number" min="0" step="1" field="variation.low_stock_qty" :x="true" error-field="variations.{{ $index }}.low_stock_qty"
                                            placeholder="0" />
                                    </div>
                                    <div class="col-span-12 md:col-span-6 flex flex-col gap-y-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            {{ translate('SKU') }}*
                                        </label>

                                        <x-dashboard.form.input type="text" field="variation.sku" :x="true" error-field="variations.{{ $index }}.sku"
                                            placeholder="{{ translate('SKU') }}" />
                                    </div>
                                </div>

                                
                            </div>

                            {{-- Variation Footer --}}
                            <div class="flex px-4 py-4 sm:px-6" x-show="show" wire:ignore.self>
                                <button type="button" class="btn btn-success ml-auto" @click="
                                    $wire.set('variations.{{ $index }}.thumbnail', _.get(variation.thumbnail, 'id', null), true);
                                    $wire.set('variations.{{ $index }}.price', variation.price, true);
                                    $wire.set('variations.{{ $index }}.discount', variation.discount, true);
                                    $wire.set('variations.{{ $index }}.discount_type', variation.discount_type, true)
                                    $wire.set('variations.{{ $index }}.current_stock', variation.current_stock, true)
                                    $wire.set('variations.{{ $index }}.low_stock_qty', variation.low_stock_qty, true)
                                    $wire.set('variations.{{ $index }}.sku', variation.sku, true);

                                    $wire.saveVariation({{ $index }});
                                ">
                                    {{ translate('Save') }}
                                </button>
                            </div>
                        </div>
  
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- TODO: Create an empty state that will lead to Product Attributes section inside product edit page. --}}
</div>




{{-- <div class="lw-form table-responsive datatable-custom ev-product-variations-component" x-data="{
        current: null
    }"
    @display-current-variation.window="current = $event.detail.current; ">

    <div class="d-flex flex-column" id="productVariationsAccordion">
        @foreach($variations as $index => $row)
            @php $index = Str::slug($index); @endphp
            <div class="d-flex flex-column mb-2 position-relative" id="variation-{{$index}}">

                <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                      wire:target="saveVariation({{$index}})"
                                      wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

                <div class="card rounded"
                     wire:target="saveVariation({{$index}})"
                     wire:loading.class="opacity-3">

                    <a class="card-header rounded card-btn btn-block d-flex align-items-center justify-content-start @if(empty($row->id)) bg-soft-dark @endif" data-toggle="collapse"
                       href="#variation_{{ $row->name }}" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"
                       >
                    <span class="avatar avatar-circle mr-3">
                        <img class="avatar-img" src="{{ $row->getThumbnail(['w'=>70]) }}">
                    </span>
                        @php
                            $display_variation_atts = [];
                            if($this->attributes->isNotEmpty()) {
                                foreach($this->attributes as $key => $att) {
                                    $selected_key = array_search($att->id, array_column($row->variant, 'attribute_id'));
                                    $selected = $row->variant[$selected_key] ?? null;

                                    if(empty($selected))
                                        continue;

                                    $display_variation_atts[$att->name] = $att->attribute_values->firstWhere('id', $selected['attribute_value_id'])->values ?? '';
                        @endphp
                        <x-ev.form.select name="variations.{{ $index }}.variant.{{ $selected_key }}.attribute_value_id"
                                          class="m-0 pr-3"
                                          error-bag-name="variations.{{ $index }}"
                                          :items="$att->attribute_values"
                                          value-property="id"
                                          label-property="values"
                                          :multiple="false"
                                          data-attribute-id="{{ $att->id }} "
                                          selected="{{ $selected['attribute_value_id'] }}"
                                          data-type="{{ $att->type }}"
                                          :disabled="true"
                                          :is-wired="false">
                        </x-ev.form.select>
                        @php
                            }
                        }
                        @endphp

                        @if($row->id)
                            <div type="button" class="btn btn-xs btn-soft-success">
                                {{ translate('active') }}
                            </div>

                            <div class="position-relative z-10 ml-auto">
                                <button type="button"
                                        class="btn btn-xs btn-outline-danger"
                                        x-data='{
                                            atts: @json($display_variation_atts)
                                        }'
                                        @click="$dispatch('remove-variation-btn-clicked', {variation_id: {{ $row->id }}, atts: atts})"
                                        data-toggle="modal"
                                        data-target="#remove_product_variation_modal">
                                    {{ translate('Remove') }}
                                </button>
                            </div>
                        @else
                            <div type="button" class="btn btn-xs btn-soft-danger">
                                {{ translate('inactive') }}
                            </div>

                            <div class="position-relative z-10 ml-auto">
                                <button type="button"
                                        class="btn btn-xs btn-success"
                                        onClick="event.stopPropagation(); document.dispatchEvent(new CustomEvent('save-variation', {detail: {component: @this, index: {{ $index }} }}))"
                                >
                                    {{ translate('Save') }}
                                </button>
                            </div>
                        @endif


                    </a>

                    <div class="collapse multi-collapse" id="variation_{{ $row->name }}" data-parent="#productVariationsAccordion"
                        :class="{'show': current === {{ $index ?? 'null' }} }">
                        <div class="card-body container-fluid">
                            <div class="row mb-2">
                                <div class="col-md-2">
                                    <x-ev.form.file-selector name="variations.{{ $index }}.thumbnail"
                                                             label="{{ translate('Image') }}"
                                                             template="avatar"
                                                             selectedFile="{{ $row->thumbnail ?? null }}"
                                                             errorBagName="rows.{{ $row->thumbnail }}"
                                                             :multiple="false"
                                                             :sortable="false"
                                                             wire-type="defer">
                                    </x-ev.form.file-selector>
                                </div>
                                <div class="col-md-4">
                                    <x-ev.form.input name="variations.{{ $index }}.price"
                                                     label="{{ translate('Price') }}"
                                                     :required="true"
                                                     type="number"
                                                     min="0"
                                                     wireType="defer">
                                    </x-ev.form.input>
                                </div>
                                <div class="col-md-3">
                                    <x-ev.form.input name="variations.{{ $index }}.discount"
                                                     type="number"
                                                     :quantity_counter="true"
                                                     label="{{ translate('Discount') }}"
                                                     min="0"
                                                     step="1">
                                    </x-ev.form.input>
                                </div>
                                <div class="col-md-3">
                                    <x-ev.form.select name="variations.{{ $index }}.discount_type"
                                                      :items="['amount'=>translate('Flat'),'percent'=>translate('Percent')]"
                                                      label="{{ translate('Discount type') }}">
                                    </x-ev.form.select>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-3">
                                    <x-ev.form.input name="variations.{{ $index }}.current_stock"
                                                     label="{{ translate('Current Quantity') }}"
                                                     groupclass="mb-0"
                                                     :quantity_counter="true"
                                                     type="number"
                                                     :required="true"
                                                     min="0"
                                                     step="1">
                                    </x-ev.form.input>
                                </div>
                                <div class="col-md-3">
                                    <x-ev.form.input name="variations.{{ $index }}.low_stock_qty"
                                                     label="{{ translate('Low stock quantity') }}"
                                                     groupclass="mb-0"
                                                     :quantity_counter="true"
                                                     type="number"
                                                     :required="true"
                                                     min="0"
                                                     step="1">
                                    </x-ev.form.input>
                                </div>
                                <div class="col-md-6">
                                    <x-ev.form.input groupclass="w-100 mb-0"
                                                     name="variations.{{ $index }}.sku"
                                                     label="{{ translate('SKU') }}"
                                                     type="text"
                                                     :required="true">
                                    </x-ev.form.input>
                                </div>
                            </div>

                            @if($row->id)
                            <div class="row mt-3">
                                <div class="col-md-12 d-flex">
                                    <button type="button"
                                            class="btn btn-sm btn-success ml-auto"
                                            onClick="event.stopPropagation(); document.dispatchEvent(new CustomEvent('save-variation', {detail: {component: @this, index: {{ $index }} }}))"
                                    >
                                        {{ translate('Save') }}
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        @endforeach


    </div>

    <x-ev.modal color="primary"
                id="remove_product_variation_modal"
                x-ref="remove_product_variation_modal"
                :has_trigger="false"
                dialog-class="modal-sm"
                body-class="d-flex flex-column"
                header-title="{{ translate('Remove variation?') }}"
                trigger-wire-click=""
                x-data="{
                    variation_id: null,
                    atts: {}
                }"
                @remove-variation-btn-clicked.window="
                    atts = $event.detail.atts;
                    variation_id = $event.detail.variation_id;
                    console.log(variation_id);
                "
                @removal-modal-hide.window="$('#remove_product_variation_modal').modal('hide');"
    >
        <div class="d-flex flex-column">
            <span class="d-block mb-2">{{ translate('Are you sure you want to remove following variation?') }}</span>
            <template x-for="(text,key) in atts">
                <strong class="d-block mb-1" x-text="key+': '+text"></strong>
            </template>

            <div class="w-100 mt-2 d-flex justify-content-end align-items-center">
                <button type="button"
                        class="btn btn-sm btn-danger mr-2"
                        @click="$wire.removeVariation(variation_id)"
                        wire:target="removeVariation(this.variation_id)"
                        wire:loading.class.remove="btn-danger"
                        wire:loading.class="btn-outline-danger px-4"
                >
                    <x-ev.loaders.spinner class="d-none "
                                          spinner-class="text-8 text-danger square-24"
                                          wire:target="removeVariation(this.variation_id)"
                                          wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

                    <span wire:loading.remove wire:target="removeVariation(this.variation_id)">{{ translate('Remove') }}</span>
                </button>
                <button type="button" class="btn btn-sm btn-soft-dark" data-dismiss="modal" aria-label="Close">
                    {{ translate('Cancel') }}
                </button>
            </div>

        </div>
    </x-ev.modal>
</div> --}}



