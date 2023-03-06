@extends('frontend.layouts.user_panel')

@section('page_title', translate('Stock Management - ').$product->name)

@push('head_scripts')
@endpush

@section('panel_content')
<section>
    <x-dashboard.section-headers.section-header title="{{ translate('Stock Management') }}" text="">
        <x-slot name="content">
            <a href="{{ route('product.details', ['id' => $product->id]) }}" class="btn-standard">
                @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Product details') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <livewire:dashboard.forms.products.stock-management-form :product="$product"></livewire:dashboard.forms.products.stock-management-form>
</section>

@endsection

@push('footer_scripts')

@endpush
