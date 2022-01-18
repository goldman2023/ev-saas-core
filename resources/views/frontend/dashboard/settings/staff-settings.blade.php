@extends('frontend.layouts.user_panel')
@section('page_title', translate('Manage Users'))
@section('meta_title', translate('Manage Users'))

@section('panel_content')

    <div class="card mb-3">
        <div class="card-header">
            <h4 class="mb-0 h4">{{ translate('Users/Staff Settings')}}</h4>
        </div>
        <div class="card-body">
            @if($users->isNotEmpty())
                @foreach($users as $key => $user)
                    <livewire:dashboard.forms.users.staff-settings-card
                        :user="$user" :all_roles="$all_roles" class="mb-2">
                    </livewire:dashboard.forms.users.staff-settings-card>
                @endforeach
            @endif
        </div>
    </div>
@endsection


@push('footer_scripts')
    <script src="{{ static_asset('vendor/hs-add-field/dist/hs-add-field.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>

    <!-- JS Front -->
    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>

    <script src="{{ static_asset('js/crud/staff-settings-form.js', false, true, true) }}"></script>
@endpush
