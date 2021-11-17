@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Products'))

@section('panel_content')
<div class="card">
    <div class="card-body">
        <livewire:forms.products.product-variations-datatable class="ev-product-variations-component"
            :paginationEnabled="false" :showSearch="false"
            :emptyMessage="translate('Please generate all variations or add them manually.')" :product="$product"
            :variation-attributes="$variations_attributes" wire-target="setVariationsData">
        </livewire:forms.products.product-variations-datatable>
    </div>
</div>
@endsection

@push('footer_scripts')

@endpush
