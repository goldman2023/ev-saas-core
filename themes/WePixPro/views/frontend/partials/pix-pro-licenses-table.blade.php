<div class="w-full mb-7">
    <h2 class="text-32 text-gray-700 font-semibold mb-1">{{ translate('Licenses')}}</h2>

    <livewire:dashboard.tables.licenses-table for="me" :show-search="false" :show-filters="false" :show-filter-dropdown="false" :show-per-page="false" :column-select="false"/>
</div>

@push('modal')
<x-system.form-modal id="pix-pro-generate-license" title="Online License Activation" class="!max-w-3xl">
    <livewire:forms.generate-license-form />
</x-system.form-modal>
@endpush