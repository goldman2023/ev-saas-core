@extends('frontend.layouts.user_panel')
@section('page_title', translate('Business Profile'))

@push('head_scripts')
  <script src="https://cdn.jsdelivr.net/npm/@jaames/iro@5"></script>
@endpush


@section('panel_content')
  <section>
    <x-dashboard.section-headers.section-header title="{{ translate('Business Profile') }}" text="">
        <x-slot name="content">
            <a href="/" target="_blank" class="btn-primary">
                @svg('heroicon-o-eye', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Preview website') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <livewire:dashboard.forms.settings.business-profile-form></livewire:dashboard.forms.settings.business-profile-form>
  </section>


@endsection
