@extends('frontend.layouts.user_panel')

@section('page_title', translate('Edit Course Material').': '.$product->getTranslation('name'))

@push('pre_head_scripts')

@endpush

@push('head_scripts')
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet"
    type="text/css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js">
</script>
<script src="{{ static_asset('js/editor.js', false, true, true) }}"></script>
@endpush

@section('panel_content')
<section>
    <x-dashboard.section-headers.section-header title="{{ translate('Edit Course Material') }}" text="">
        <x-slot name="content">
            <a href="{{ route('product.details', $product->id) }}" class="btn-standard mr-2 relative">
                <div
                    class="absolute top-[-15px] left-[-20px] mb-2 px-2 py-1 text-gray-100 text-xs font-semibold bg-indigo-700 rounded-full">
                    {{ translate('New!') }} 🔖
                </div>
                @svg('heroicon-o-eye', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Product Details') }}</span>
            </a>
            <a href="{{ route('products.index') }}" class="btn-standard">
                @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('All products') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    @if($product->type === 'course')
        <livewire:dashboard.forms.products.course-items-form :product="$product" />
    @endif
</section>
@endsection

@push('footer_scripts')

@endpush
