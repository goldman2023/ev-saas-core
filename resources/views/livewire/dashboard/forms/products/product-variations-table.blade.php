<div class="w-full" x-data="{
    {{-- use_serial: {{ $product->use_serial === true ? 'true' : 'false' }},
    allow_out_of_stock_purchases: {{ $product->allow_out_of_stock_purchases === true ? 'true' : 'false' }},
    stock_visibility_state: @js($product->stock_visibility_state ?? 'quantity'), --}}
}">

    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                            wire:target="updateMainStock"
                            wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full"
            wire:loading.class="opacity-30 pointer-events-none"
            wire:target="updateMainStock"
        >

            <div class="grid grid-cols-12 gap-8 mb-10">

                {{-- Left panel --}}
                <div class="col-span-12 xl:col-span-8">
                    @foreach($variations as $index => $row)
                        @php $index = Str::slug($index); @endphp

                        <div class="bg-white shadow rounded-lg divide-y divide-gray-200 mb-4" x-data="">
                            <div class="flex items-center px-4 py-5 sm:px-6">
                                <img class="inline-block h-12 w-12 rounded-full mr-3" src="{{ $row->getThumbnail(['w'=>70]) }}" alt="">

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
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 min-w-[50px]  rounded-md text-14 font-14 bg-gray-100 text-gray-800 mr-3">
                                            {{ $att->attribute_values->firstWhere('id', $selected['attribute_value_id'])->values }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="px-4 py-5 sm:p-6">

                            </div>
                            <div class="px-4 py-4 sm:px-6">

                            </div>
                        </div>
  
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- TODO: Create an empty state that will lead to Product Attributes section inside product edit page. --}}
</div>




<div class="lw-form table-responsive datatable-custom ev-product-variations-component" x-data="{
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
</div>



