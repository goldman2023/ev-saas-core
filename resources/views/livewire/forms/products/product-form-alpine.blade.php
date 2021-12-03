<div class="lw-form" x-data="{
    product: @entangle('product').defer,
    all_categories: @js($categories),
    selected_categories: @entangle('selected_categories').defer,
    get validation_errors() {
        let errors = $('#productFormErrors').length > 0 ? JSON.parse($('#productFormErrors').html()) : {};
        return (errors[0] !== undefined) ? errors[0] : {};
    }
}">

    @if($errors->hasAny($errors->keys()))
        <script id="productFormErrors" type="application/json">
            @json([$errors->getMessages()])
        </script>
    @endif

    <!-- General -->
    <div class="card container-fluid py-3 " x-ref="product-form__general">
        <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                              wire:target="status"
                              wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

        <!-- Header -->
        <div class="card-header py-2 pl-2">
            <div class="row justify-content-between align-items-center flex-grow-1">
                <div class="col-12 col-md">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-header-title">{{ translate('General') }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header -->

        <!-- Card Body -->
        <div class="card-body container-fluid py-4 pl-2">
            <div class="row justify-content-between align-items-center">
                <div class="col-5">
                    <x-ev.form.input
                        :x="true"
                        name="product.name"
                        type="text"
                        label="{{ translate('Product name') }}"
                        :required="true"
                        placeholder="{{ translate('Think of some catchy name...') }}"></x-ev.form.input>
                </div>
                <div class="col-4">
                    <x-ev.form.select
                        :x="true"
                        name="product.brand_id"
                        :items="EVS::getMappedBrands()"
                        label="{{ translate('Brand') }}"
                        :search="true"
                        placeholder="{{ translate('Select Brand...') }}"></x-ev.form.select>
                </div>
                <div class="col-3">
                    <x-ev.form.select
                        :x="true"
                        name="product.unit"
                        :items="EVS::getMappedUnits()"
                        label="{{ translate('Unit') }}"
                        :required="true"
                        placeholder="{{ translate('Product unit...') }}"></x-ev.form.select>
                </div>
            </div>

            <div class="row justify-content-between align-items-center">
                <div class="col-6">
                    <x-ev.form.categories-selector
                        :x="true"
                        name="selected_categories"
                        label="{{ translate('Categories') }}"
                        :items="$categories"
                        :selected-categories="$this->levelSelectedCategories()"
                        :multiple="true"
                        :required="true"
                        :search="true"
                    ></x-ev.form.categories-selector>
                </div>
                <div class="col-6">
                    <x-ev.form.select
                        :x="true"
                        name="product.tags"
                        :tags="true"
                        label="{{ translate('Tags') }}"
                        :multiple="true"
                        placeholder="{{ translate('Type and hit enter to add a tag...') }}"
                    >
                        <small class="text-muted">{{ translate('This is used for search. Input relevant words by which customer can find this product.') }}</small>
                    </x-ev.form.select>
                </div>
            </div>
        </div>
        <!-- End Card Body -->
    </div>
    <!-- END General -->

</div>


