@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Attributes'))

@push('head_scripts')

@endpush

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('All Attributes') }}" text="Workcation is a property rental website. Etiam ullamcorper massa viverra consequat, consectetur id nulla tempus. Fringilla egestas justo massa purus sagittis malesuada.">
            <x-slot name="content">
                <a href="{{ route('attributes.create', base64_encode($content_type)) }}" class="btn-primary">
                    @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('Add new Attribute') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>
  
        <div class="w-full">
            @if($attributes->isNotEmpty())
                <livewire:dashboard.tables.attributes-table></livewire:dashboard.tables.attributes-table>
            @else
                <x-dashboard.empty-states.no-items-in-collection 
                    icon="heroicon-o-document" 
                    title="{{ translate('No attributes yet') }}" 
                    text="{{ translate('Enrich your content with various attributes!') }}"
                    link-href-route="{{ route('attributes.create', base64_encode($content_type)) }}"
                    link-text="{{ translate('Add new attribute') }}">

                </x-dashboard.empty-states.no-items-in-collection>
            @endif
            
        </div>
    </section>
@endsection

@push('footer_scripts')

@endpush
