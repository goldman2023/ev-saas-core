@extends('frontend.layouts.user_panel')

@section('page_title', translate('Create New Attribute'))

@push('head_scripts')

@endpush

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('New Attributes') }}" text="">
            <x-slot name="content">
                <a href="{{ route('attributes.index', base64_encode($content_type)) }}" class="btn-standard">
                    @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mrs-2'])
                    <span>{{ translate('All attributes') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>

        <livewire:dashboard.forms.attributes.attribute-form :content_type="$content_type"></livewire:dashboard.forms.attributes.attribute-form>
    </section>

    
@endsection

@push('footer_scripts')

@endpush
