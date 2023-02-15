@extends('frontend.layouts.user_panel')

@section('page_title', translate('Edit Product').': '.$product->getTranslation('name'))

@push('pre_head_scripts')

@endpush

@push('head_scripts')
<script src="{{ mix('js/editor.js', 'themes/WeTailwind') }}" defer></script>
@endpush

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('Edit Product') }}" text="">
            <x-slot name="content">
                <a href="{{ route('product.details', $product->id) }}" class="btn-standard mr-2 relative">
                    <div class="absolute top-[-15px] left-[-20px] mb-2 px-2 py-1 text-gray-100 text-xs font-semibold bg-indigo-700 rounded-full">
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

        <livewire:dashboard.forms.products.product-form2 :product="$product"></livewire:dashboard.forms.products.product-form2>
    </section>
@endsection

@push('footer_scripts')

@endpush
