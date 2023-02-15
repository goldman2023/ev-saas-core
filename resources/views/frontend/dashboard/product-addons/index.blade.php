@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Product Addons'))

@section('panel_content')

<section>

    <x-dashboard.section-headers.section-header title="{{ translate('All product addons') }}" text="{{ translate('Manage and create new product addons') }}">
        <x-slot name="content">
            <a href="{{ route('product-addon.create') }}" class="btn-primary">
                <span>{{ translate('Add new product addon') }}</span>
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 ml-2'])
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    {{-- <div class="mb-6">
        <x-dashboard.widgets.business.dynamic-k-p-i></x-dashboard.widgets.business.dynamic-k-p-i>
    </div> --}}

    <div class="w-full">
        @if($product_addons_count > 0)
            <livewire:dashboard.tables.product-addons-table />
        @else
            <x-dashboard.empty-states.no-items-in-collection
                icon="heroicon-o-document"
                title="{{ translate('No product addons yet') }}"
                text="{{ translate('Add product addons to your products!') }}"
                link-href-route="product-addon.create"
                link-text="{{ translate('Add new Product Addon') }}">

            </x-dashboard.empty-states.no-items-in-collection>
        @endif
    </div>
</section>
@endsection
