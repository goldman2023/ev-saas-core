<div x-data="{ show: false }" x-cloak
     x-init="$(document).on('keyup', function(e) { if (e.key == 'Escape' && show) {show = false} });">
    <section
        class="c-flyout-cart position-fixed bg-white shadow-lg"
        :class="{ 'show': show }"
        x-data="{
            targetItem: null,
            has_warnings: false,
            hideWarnings() {
                this.has_warnings = false;
                $($refs['c-flyout-cart__warnings-text']).html('');
            }
        }"
        x-init="$watch('show', (value) => {
            (!value) ? hideWarnings() : '';
        })"
        x-effect="window.initClamp('.c-flyout-cart');"
        @toggle-wishlist.window="show = !show"
        @display-wishlist.window="show = true"
        @cart-processing-ending.window="
            $nextTick(() => { // Wait for qty to be changed and then stop processing
                processing = false; // Turn off the Cart processing now. Reason is that if we change qty after turning processing off, we would run qty watcher again and initiate addToCart again!
            });
        "
    >
        <div class="h-100 d-flex flex-column position-relative p-4" >
            <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                  wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

{{--            TODO: Add loading class to prevent clicking items beneath--}}
            <div class="d-flex flex-column h-100" wire:loading.class="opacity-3 ">
                <div class="c-flyout-cart__close square-32 d-flex align-items-center justify-content-center position-absolute pointer" @click="show = false">
                    @svg('heroicon-o-x', ['class' => 'square-16'])
                </div>

                <!-- Cart Header -->
                <h3 class="h4 mb-3 pb-2 border-bottom d-flex align-items-center">
                    <span>{{ translate('Wishlist') }}</span>
                    <span class="badge badge-soft-warning d-flex align-items-center px-2 py-1 ml-3 text-12 text-warning">
                        @svg('heroicon-s-shopping-bag', ['class' => 'square-14 mr-2'])
                    </span>
                </h3>

                <!-- Cart Warnings -->
                <div class="c-flyout-cart__warnings flex-column mb-3" x-show="has_warnings" :class="{'d-flex':has_warnings}">
                    <div class="bg-danger text-white rounded text-14 p-2" x-ref="c-flyout-cart__warnings-text">

                    </div>
                </div>

                <!-- Cart Items -->
                <div class="c-flyout-cart__items d-flex flex-column mb-1 flex-grow-1">

                        <!-- Empty Cart Section -->
                        <div class="container-fluid space-2">
                            <div class="text-center mx-md-auto">
                                <figure class="max-w-10rem max-w-sm-15rem mx-auto mb-3">
                                    @svg('heroicon-o-heart', ['class' => 'text-dark', 'style' => 'width: 72px;'])
                                </figure>
                                <div class="mb-5">
                                    <h3 class="h3">{{ translate('Your wishlist is currently empty') }}</h3>
                                    <p>{{ translate('Add some products to your shopping cart.') }}</p>
                                </div>
                                <a class="btn btn-primary btn-pill transition-3d-hover px-5" href="{{ route('search') }}">
                                    {{ translate('Explore') }}
                                </a>
                            </div>
                        </div>
                        <!-- End Empty Cart Section -->

                </div>


            </div>
        </div>
    </section>

    <div class="c-flyout-cart__overlay"
         x-show="show"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 "
         x-transition:enter-end="opacity-7 "
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-7 "
         x-transition:leave-end="opacity-0 "
         @click="show = false"
    >
    </div>
</div>
