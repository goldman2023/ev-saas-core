<x-panels.flyout-panel id="wishlist-panel" title="{{ translate('Wishlist') }}">

    <h3 class="text-20 mb-3 pb-2 border-b flex items-center" x-data="{
        count: {{ $count ?? 0 }},
        text: '{{ translate('You have %x% favorite items.') }}'
    }"
    @refresh-wishlist-items-count.window="count = $event.detail.count;">
        <span>{{ translate('Wishlist') }}</span>
        <span class="badge-info flex items-center px-2 py-1 ml-3 text-12 text-warning">
            @svg('lineawesome-heart-solid', ['class' => 'w-[14px] h-[14px] mr-2'])
            <span x-text="text.replace('%x%', Number(count) > 99 ? '99+':count)"></span>
{{--            {{ str_replace('%x%', $count , translate('You have %x% favorite items.')) }}--}}
        </span>
    </h3>

    <div class="c-flyout-panel__items flex flex-col mb-1 grow w-full overflow-x-hidden pr-2">
        <livewire:panels.wishlist-flyout></livewire:panels.wishlist-flyout>
    </div>

    <div class="flyout-wishlist__bottom-cta  pt-3 mt-2 pb-0 bottom-0  bg-white border-t">
        <a href="{{ route('my.wishlist.index') }}" class="block px-3 py-2 rounded w-full bg-primary text-white text-center">
            {{ translate('My wishlist') }}
        </a>
    </div>
</x-panels.flyout-panel>

