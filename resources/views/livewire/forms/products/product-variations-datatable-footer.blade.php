@if($dataType === "product_variations")
    <div class="w-100 d-flex mt-3">
        <div class="btn btn-primary ml-auto"
             onClick="document.dispatchEvent(new CustomEvent('set-variations-data', {detail: {component: @this, target: '.product-variations-wrapper'} }))">
            {{ translate('Save variations') }}
        </div>
    </div>
@endif

<!-- Product Variations Toast -->
<x-ev.toast id="product-variations-toast"
            icon="heroicon-o-save"
            class="bg-success border-success text-white h4"></x-ev.toast>

<!-- Product Variations Datatable Bulk Actions Modals -->
<x-ev.modal id="{{ $bulkActionSetPricesID }}"
            header-title="{{ translate('Set Prices') }}"
            :has-trigger="false"
            content-class="border shadow-lg"
            :has-close="false"
            :no-animation="true"
            x-data="{
                price: 0
            }"
            >
    <!-- TODO: Add Currency to input (as append icon) -->
    <x-ev.form.input id="{{ $bulkActionSetPricesID.'__val' }}" type="number" label="{{ translate('Price') }}" :required="true" min="0" step="0.01"
                     x-model="price"
                     wire:ignore></x-ev.form.input>
    <button type="button" class="btn btn-primary"
            onClick="$('#{{ $bulkActionSetPricesID }}').modal('hide');"
            x-on:click="$wire.setAllVariationsPrice(price)"
    >
        {{ translate('Update') }}
    </button>

    <button type="button" class="btn btn-light rounded"
            onClick="$('#{{ $bulkActionSetPricesID }}').modal('hide');"
    >
        {{ translate('Cancel') }}
    </button>
</x-ev.modal>
