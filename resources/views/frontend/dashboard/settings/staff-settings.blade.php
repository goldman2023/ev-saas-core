@extends('frontend.layouts.user_panel')

@section('page_title', translate('Manage Users'))
@section('meta_title', translate('Manage Users'))

@section('panel_content')
    <section>
        <x-dashboard.section-headers.section-header title="{{ translate('Staff Settings') }}" text="{{ translate('You can manage your staff settings and their access rights and permissions for certain areas of the admin platform.') }}">
            <x-slot name="content">
                <a href="#" @click="$dispatch('display-modal', {'id':'invite-new-staff-member'})" class="btn-primary">
                    @svg('heroicon-o-plus', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('Invite new staff member') }}</span>
                </a>
            </x-slot>
        </x-dashboard.section-headers.section-header>

        <div class="w-full">
            <livewire:dashboard.tables.users-table for="staff"></livewire:dashboard.tables.users-table>
        </div>
    </section>
@endsection

@push('modal')
<x-system.form-modal title="{{ translate('Invite new staff') }}" id="invite-new-staff-member"> 
    <livewire:dashboard.forms.users.invite-staff-form />
</x-system.form-modal>
@endpush

@push('footer_scripts')

@endpush
