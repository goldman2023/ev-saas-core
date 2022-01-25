<x-default.global.flyout-panel id="wishlist-panel" title="{{ translate('Wishlist') }}">

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
        @if($wishlist?->isEmpty())
            <!-- Empty Wishlist Section -->
            <div class="container-fluid space-2">
                <div class="text-center mx-md-auto">
                    <figure class="max-w-10rem max-w-sm-15rem mx-auto mb-3">
                        @svg('lineawesome-heart-solid', ['class' => 'text-dark', 'style' => 'width: 72px;'])
                    </figure>
                    <div class="mb-5">
                        <h3 class="h3">{{ translate('Wishlist is empty') }}</h3>
                        <p>{{ translate('Add some products/services to the wishlist in order to see them here.') }}</p>
                    </div>
                    <a class="btn btn-primary btn-pill transition-3d-hover px-5" href="{{ route('search') }}">
                        {{ translate('Go to catalog') }}
                    </a>
                </div>
            </div>
            <!-- End Empty Wishlist Section -->
        @else
            <livewire:tenant.wishlist-flyout></livewire:tenant.wishlist-flyout>
        @endif
    </div>
</x-default.global.flyout-panel>

