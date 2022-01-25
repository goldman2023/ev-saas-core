<x-default.global.flyout-panel id="guest-panel" title="{{ translate('Login or Register') }}">

    <h3 class="h4 mb-3 pb-2 border-bottom d-flex align-items-center" x-data="{
        count: {{ $count ?? 0 }},
        text: '{{ translate('You have %x% favorite items.') }}'
    }"
    @refresh-wishlist-items-count.window="count = $event.detail.count;">
        <span>{{ translate('Wishlist') }}</span>
        <span class="badge badge-info d-flex align-items-center px-2 py-1 ml-3 text-12 text-white">
            @svg('lineawesome-heart-solid', ['class' => 'square-14 mr-2'])
            <span x-text="text.replace('%x%', Number(count) > 99 ? '99+':count)"></span>
{{--            {{ str_replace('%x%', $count , translate('You have %x% favorite items.')) }}--}}
        </span>
    </h3>

    <div class="c-flyout-panel__items d-flex flex-column mb-1 flex-grow-1">

    </div>
</x-default.global.flyout-panel>

