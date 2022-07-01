<div class="w-full pb-5 mb-5 border-b border-gray-200">
    <div class="flex justify-between items-center bg-white py-4 px-4 border border-gray-200 rounded-lg">
        <h4 class="text-18 text-gray-900 font-semibold">{{ translate('Licenses') }}</h4>
     </div>
    {{-- <h2 class="text-32 text-gray-700 font-semibold mb-1">{{ translate('Licenses')}}</h2> --}}
     @php
        if(empty($data)) {
            $data = Auth::user();
        }
     @endphp
    <livewire:dashboard.tables.licenses-table :user="$data" :show-search="false" :show-filters="false" :show-filter-dropdown="false" :show-per-page="false" :column-select="false"/>

</div>

@push('modal')
    <x-system.form-modal id="pix-pro-generate-license" title="Online License Activation" class="!max-w-3xl">
        <livewire:forms.generate-license-form />
    </x-system.form-modal>

    @if(auth()->user()?->isAdmin() ?? false)
        <x-system.form-modal id="pix-pro-edit-license" title="Online License Activation" class="!max-w-3xl">
            <livewire:dashboard.forms.licenses.license-form />
        </x-system.form-modal>
    @endif

    @if(auth()->user()?->isAdmin() ?? false)
        <x-system.form-modal id="pix-pro-license-history" title="License History" class="!max-w-3xl">
            <livewire:dashboard.forms.licenses.license-history />
        </x-system.form-modal>
    @endif
@endpush
