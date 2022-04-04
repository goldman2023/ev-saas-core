<x-livewire-tables::table.cell class="align-middle p-0">
    <span class="block text-14 mb-0 text-left">{{ $row->serial_number }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    @if($row->trashed())
        <span class="badge-dark">
            {{ translate('Archived') }}
        </span>
    @elseif($row->status === \App\Enums\SerialNumberStatusEnum::in_stock()->value)
        <span class="badge-success">
          {{ \App\Enums\SerialNumberStatusEnum::in_stock()->label }}
        </span>
    @elseif($row->status === \App\Enums\SerialNumberStatusEnum::out_of_stock()->value)
        <span class="badge-danger">
          {{ \App\Enums\SerialNumberStatusEnum::out_of_stock()->label }}
        </span>
    @elseif($row->status === \App\Enums\SerialNumberStatusEnum::reserved()->value)
        <span class="badge-warning">
          {{ \App\Enums\SerialNumberStatusEnum::reserved()->label }}
        </span>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    <span class="block text-14 mb-0 text-center">{{ $row->updated_at?->diffForHumans() }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle">
    <span class="block text-14 mb-0 text-center">{{ $row->created_at?->diffForHumans() }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle static">
    @if(!$row->trashed())
        <div class="flex static justify-center" role="group">
            <span wire:click="archiveSerialNumber({{ $row->id }})" class="cursor-pointer flex items-center mr-2 text-red-500 text-14">
                @svg('heroicon-o-trash', ['class' => 'text-red-500 w-[18px] h-[18px]'])
            </span>
        </div>
    @endif
</x-livewire-tables::table.cell>