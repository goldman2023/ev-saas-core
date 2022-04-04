@extends('frontend.layouts.user_panel')

@section('page_title', translate('Edit Product').': '.$product->getTranslation('name'))

@push('pre_head_scripts')

@endpush

@push('head_scripts')
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
@endpush

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('Edit Product') }}" text="">
            <x-slot name="content">
                <a href="{{ route('products.index') }}" class="btn-standard">
                    @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('All products') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>

        <livewire:dashboard.forms.products.product-form2 :product="$product"></livewire:dashboard.forms.products.product-form2>
    </section>
@endsection

@push('footer_scripts')
  
@endpush
