<li>
    <button type="button" class="w-full  flex items-center px-3 py-3 pr-4 text-gray-900 text-14" 
            @click="$dispatch('display-modal', {'id': 'pix-pro-generate-license', 'serial_number' : '{{ $license?->serial_number ?? '' }}'})"
    >
        @svg('heroicon-o-document-download', ['class' => 'w-[18px] h-[18px] mr-2']) 
        <span class="ml-2">{{ translate('Generate License') }}</span>
    </button>
</li>

@if(empty($license?->data['hardware_id'] ?? null))
    <li class="border-t border-gray-200">
        <button type="button" class="w-full flex items-center px-3 py-3 pr-4 text-gray-900 text-14 hover:bg-danger hover:text-white">
            @svg('heroicon-o-x', ['class' => 'w-[18px] h-[18px] mr-2']) 
            <span class="ml-2">{{ translate('Disconnect') }}</span>
        </button>
    </li>
@endif