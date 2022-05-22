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
    <div class="w-full flex py-8 px-5" x-data="{
            
        }">
        <div class="w-full flex flex-col justify-content items-center">
            @svg('heroicon-o-user-group', ['class' => 'w-10 mb-4'])
            <h4 class="mb-1 text-typ-2">{{ translate('Invite a staff member') }}</h4>
            <p class="text-typ-3 mb-6">{{ translate('Invite staff members to your shop.') }}</p>

            <div class="w-full">
                <x-dashboard.form.input field="" placeholder="{{ translate('Enter staff email') }}" class="mb-3" />
                <div class="w-full btn-primary cursor-pointer justify-center">
                    {{ translate('Send an invite') }}
                </div>
            </div>
        </div>
    </div>
</x-system.form-modal>
@endpush

@push('footer_scripts')

@endpush
