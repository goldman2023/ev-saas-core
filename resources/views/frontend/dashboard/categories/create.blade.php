@extends('frontend.layouts.user_panel')

@section('page_title', translate('Add new category'))

@push('head_scripts')

@endpush

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('New category') }}" text="">
            <x-slot name="content">
                <a href="{{ route('categories.index') }}" class="btn-standard">
                    @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('All categories') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>

        <livewire:dashboard.forms.categories.category-form ></livewire:dashboard.forms.categories.category-form>
    </section>
@endsection

@push('footer_scripts')

@endpush
