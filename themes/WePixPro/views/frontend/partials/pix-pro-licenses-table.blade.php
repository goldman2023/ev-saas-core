<div class="w-full pb-5 mb-5 border-b border-gray-200">
    <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
        <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Licenses') }}</h4>

        @if(auth()->user()?->isAdmin() ?? false)
            <button type="button" class="btn-primary" @click="$dispatch('display-modal', {'id': 'pix-pro-create-manual-license'})">
                {{ translate('Add New') }}
            </button>
        @endif

     </div>
    {{-- <h2 class="text-32 text-gray-700 font-semibold mb-1">{{ translate('Licenses')}}</h2> --}}
     @php
        if(empty($user)) {
            $user = \Auth::user();
        }
     @endphp
    <livewire:dashboard.tables.licenses-table :user="$user" :show-search="false" :show-filters="false" :show-filter-dropdown="false" :show-per-page="false" :column-select="false"/>
</div>

@push('modal')
    @include('frontend.partials.pix-pro-license-modals', ['user' => $user])
@endpush
