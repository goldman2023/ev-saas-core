@extends('frontend.layouts.user_panel')

@section('page_title', translate('Add New Product Addon'))

@push('pre_head_scripts')
@endpush

@push('head_scripts')
<script src="{{ mix('js/editor.js', 'themes/WeTailwind') }}" defer></script>
@endpush


@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('Create Product Addon') }}" text="">
            <x-slot name="content">
                <a href="{{ route('product-addons.index') }}" class="btn-standard">
                    @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('All product addons') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>

        <livewire:dashboard.forms.products.product-addon-form />
    </section>
@endsection

@push('footer_scripts')

@endpush
