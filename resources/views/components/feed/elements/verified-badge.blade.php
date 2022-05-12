<div>
    @if($item->isVerified())
    <p class="mt-3 max-w-2xl text-sm text-gray-500 flex items-center">
        <span class="h-4 w-4 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white mr-3">
            <!-- Heroicon name: solid/check -->
            @svg('heroicon-s-check', ['class' => 'w-3 h-3 text-white'])
        </span>
        <span class="text-indigo-600 font-medium">
            {{ translate('Verified profile') }}
        </span>
    </p>
    @endif
</div>
