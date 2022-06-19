<x-livewire-tables::table.cell class="align-middle text-center">
    {{ !empty($license?->data['hardware_id'] ?? null) ? $license?->data['hardware_id'] : '-' }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    {{ !empty($license?->data['license_subscription_type'] ?? null) ? $license?->data['license_subscription_type'] : '-' }}
</x-livewire-tables::table.cell>