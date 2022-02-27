<x-panels.flyout-panel id="profile-panel" title="{{ translate('Your Profile') }}" framework="tailwind">
    <h3 class="text-22 mb-3 pb-2 border-b flex items-center" x-data="{
        count: {{ $count ?? 0 }},
        text: '{{ translate('You have %x% favorite items.') }}'
    }" @refresh-wishlist-items-count.window="count = $event.detail.count;">
        <span>{{ translate('Your Profile') }}</span>

    </h3>

    <div class="c-flyout-panel__items flex flex-col mb-1 grow">
        <div class="mt-3">
            {{-- @include('tailwind.panels.sidebar') --}}
        </div>
    </div>
</x-panels.flyout-panel>
