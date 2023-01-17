@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Products'))

@section('panel_content')

<section>

    <x-dashboard.section-headers.section-header title="{{ translate('All products') }}" text="Manage and create new products">
        <x-slot name="content">
            <a href="{{ route('product.create') }}" class="btn-primary">
                <span>{{ translate('Add new product') }}</span>
                @svg('heroicon-o-plus', ['class' => 'h-4 h-4 ml-2'])
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="mb-6">
        <x-dashboard.widgets.business.dynamic-k-p-i></x-dashboard.widgets.business.dynamic-k-p-i>
        </div>

    <div class="w-full">
        @if($products->isNotEmpty())
            <livewire:dashboard.tables.products-table></livewire:dashboard.tables.products-table>
        @else
            <x-dashboard.empty-states.no-items-in-collection
                icon="heroicon-o-document"
                title="{{ translate('No products yet') }}"
                text="{{ translate('Get your business going by creating your first product!') }}"
                link-href-route="product.create"
                link-text="{{ translate('Add new Product') }}">

            </x-dashboard.empty-states.no-items-in-collection>
        @endif
    </div>
</section>
@endsection
