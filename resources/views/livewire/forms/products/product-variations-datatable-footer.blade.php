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
