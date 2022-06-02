<button 
    @click="$dispatch('display-modal', {'id': 'pix-pro-generate-license', 'serial_number' : '{{ $license->serial_number }}'})"
    class="flex items-center btn" 
>
    @svg('heroicon-o-document-download', ['class' => 'w-[18px] h-[18px] mr-2'])
    {{ translate('Generate License') }}
</button>