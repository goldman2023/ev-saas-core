<x-default.global.flyout-panel id="guest-panel" title="{{ translate('Login or Register') }}">

    <h3 class="h4 mb-3 pb-2 border-bottom d-flex align-items-center" x-data="{
        count: {{ $count ?? 0 }},
        text: '{{ translate('You have %x% favorite items.') }}'
    }" @refresh-wishlist-items-count.window="count = $event.detail.count;">
        <span>{{ translate('Login or Register') }}</span>

    </h3>

    <div class="c-flyout-panel__items d-flex flex-column mb-1 flex-grow-1">
        <div class="mt-3">
            <x-default.global.login-form> </x-default.global.login-form>
        </div>
    </div>
</x-default.global.flyout-panel>
