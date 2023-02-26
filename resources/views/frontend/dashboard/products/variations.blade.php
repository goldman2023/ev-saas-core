@extends('frontend.layouts.user_panel')

@section('page_title', $product->getTranslation('name').' - '.translate('Edit Variations'))

@push('head_scripts')
@endpush

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('Variations Management') }}" text="">
            <x-slot name="content">
                <a href="{{ route('product.details', $product->id) }}" class="btn-standard mr-2">
                    @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('Details') }}</span>
                </a>

                <a href="{{ route('product.edit.stocks', $product->id) }}" class="btn-standard" >
                    @svg('heroicon-o-archive-box', ['class' => 'h-4 h-4'])
                    {{ translate('Stock management') }}
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>

        <livewire:dashboard.forms.products.product-variations-table
            class="ev-product-variations-component"
            :emptyMessage="translate('Please generate all variations or add them manually.')"
            :product="$product"
        >
        </livewire:dashboard.forms.products.product-variations-table>
    </section>
@endsection

@push('footer_scripts')
@endpush
