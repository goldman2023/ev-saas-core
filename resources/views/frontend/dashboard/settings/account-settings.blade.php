@extends('frontend.layouts.user_panel')
@section('page_title', translate('My Account Settings'))
@section('meta_title', translate('My Account Settings'))

@section('panel_content')
<section>
    <x-dashboard.section-headers.section-header title="{{ translate('Account settings') }}" text="">
        <x-slot name="content">

        </x-slot>
    </x-dashboard.section-headers.section-header>

    <livewire:dashboard.forms.settings.my-account-form></livewire:dashboard.forms.settings.my-account-form>
</section>
@endsection

@push('footer_scripts')
@endpush
