<x-livewire-tables::table.cell class="align-middle text-center">
    {{ !empty($license?->data['hardware_id'] ?? null) ? $license?->data['hardware_id'] : '-' }}
</x-livewire-tables::table.cell>