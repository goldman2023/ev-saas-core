@auth
    @if(auth()->user()?->bought($product) && !isset($showing_single_course_item))
        <div class="w-full flex justify-between py-2 border-y border-gray-200 mb-5" >
            <div class="badge-success">
                {{ translate('You bought this course!') }}
            </div>

            <div class="">
                <a href="{{ route(\App\Models\CourseItem::getRouteName(), [
                    'product_slug' => $product->slug, 
                    'slug' => $course_items->first()?->slug ?? ' ',
                ]) }}" class="btn-success">
                    {{ translate('View course') }}
                </a>
            </div>
        </div>                            
    @elseif(!auth()->user()?->bought($product))
        {{-- Price and Buy --}}
        <div class="w-full flex justify-between py-2 border-y border-gray-200 mb-5" >
            <livewire:tenant.product.price :model="$product" :with_label="true" :with-discount-label="true"
                original-price-class="text-body text-16" base-price-class="text-16" total-price-class="text-20 fw-700 text-primary">
            </livewire:tenant.product.price>

            <div class="">
                @if(\Payments::isStripeEnabled() && \Payments::isStripeCheckoutEnabled())
                    <x-system.buy-now-button :model="$product" class="" label="{{ translate('Buy now') }}"
                        label-not-in-stock="{{ translate('Not in stock') }}">
                    </x-system.buy-now-button>
                @else
                    <x-system.add-to-cart-button :model="$product" class="" label="{{ translate('Add to cart') }}"
                        label-not-in-stock="{{ translate('Not in stock') }}">
                    </x-system.add-to-cart-button>
                @endif
            </div>
        </div>
    @endif
@endauth

@guest
    <div class="w-full flex justify-between py-2 border-y border-gray-200 mb-5" >
        <livewire:tenant.product.price :model="$product" :with_label="true" :with-discount-label="true"
            original-price-class="text-body text-16" base-price-class="text-16" total-price-class="text-20 fw-700 text-primary">
        </livewire:tenant.product.price>

        <div class="">
            <a href="{{ route('user.login') }}" class="btn-primary">
                {{ translate('Log in') }}
            </a>
            <a href="{{ route('user.registration') }}" class="btn-primary-outline">
                {{ translate('Join now') }}
            </a>
        </div>
    </div>
@endguest