<div wire:click="fireSocialAction()" class="inline-flex items-center text-sm">
    <button type="button" class="inline-flex items-center">
        @if($added)
            @svg('heroicon-s-hand-thumb-up', ['class' => 'w-5 h-5 text-primary mr-2'])
            <span class="font-medium text-primary text-14">{{ $count }} {{ translate('Likes') }} </span>
        @else
            @svg('heroicon-o-hand-thumb-up', ['class' => 'w-5 h-5 text-typ-3 mr-2'])
            <span class="font-medium text-typ-3 text-14">{{ $count }} {{ translate('Likes') }} </span>
        @endif
    </button>
</div>
