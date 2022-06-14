@extends('frontend.layouts.user_panel')

@section('page_title', translate('Manage Users'))
@section('meta_title', translate('Manage Users'))

@section('panel_content')
<section>
    @if($user->isSubscribed() ?? false)
    <div class="w-full pb-5 mb-5 border-b border-gray-200">
        <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
            <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Subscriptions') }}</h4>
        </div>

        <livewire:dashboard.tables.my-subscriptions-table :user="$user" :show-search="false" :show-filters="false"
            :show-filter-dropdown="false" :show-per-page="false" :column-select="false" />
    </div>

    @do_action('view.dashboard.plans-management.plans-table.end', $user)
    @endif
</section>
@endsection


@push('footer_scripts')

@endpush
