@extends('frontend.layouts.user_panel')

@section('page_title', translate('Add New Product'))

@push('head_scripts')
@endpush

@push('pre_head_scripts')
    <script>
        let all_categories = @json(\Categories::getAllFormatted());
    </script>
@endpush

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('Create Product') }}" text="">
            <x-slot name="content">
                <a href="{{ route('products.index') }}" class="btn-standard">
                    @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('All products') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>

        <livewire:dashboard.forms.products.product-form2 />
    </section>
@endsection

@push('footer_scripts')

@endpush
