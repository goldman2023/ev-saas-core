<x-default.global.flyout-panel id="profile-panel" title="{{ translate('Your Profile') }}">

    <h3 class="h4 mb-3 pb-2 border-bottom d-flex align-items-center" x-data="{
        count: {{ $count ?? 0 }},
        text: '{{ translate('You have %x% favorite items.') }}'
    }" @refresh-wishlist-items-count.window="count = $event.detail.count;">
        <span>{{ translate('Your Profile') }}</span>

    </h3>

    <div class="c-flyout-panel__items d-flex flex-column mb-1 flex-grow-1">
        <div class="mt-3">
            @include('frontend.inc.user_side_nav')
        </div>
    </div>
</x-default.global.flyout-panel>
