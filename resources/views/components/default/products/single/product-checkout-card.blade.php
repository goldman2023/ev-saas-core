<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 d-flex flex-column">
                <h2 class="h3">{{ $product->getTranslation('name') }}</h1>

                    <x-default.products.single.product-brand-box :product="$product">
                    </x-default.products.single.product-brand-box>
            </div>
            <div class="col-12 mt-2 mb-2">
                <span class="text-dark font-weight-bold">
                    <div>
                        {{ translate('Price:') }}

                    </div>
                    @if (home_base_price($product->id) !=
                    home_discounted_base_price($product->id))
                    <del class="h3 fw-600 opacity-50 mr-1">{{ home_base_price($product->id)
                        }}</del>
                    @endif
                    <span class="h2 fw-700 text-primary">{{
                        home_discounted_base_price($product->id) }}</span>
                </span>

            </div>

            <div class="col-12">
                <?php echo $product->getTranslation('short_description'); ?>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-8">
                        <a class="btn btn btn-primary d-flex justify-content-center align-items-center">
                            {{ svg('heroicon-o-shopping-cart', ['class' => 'ev-icon__xs mr-2'])
                            }}
                            {{ translate('Add To Cart') }}</a>

                    </div>
                    <div class="col-4">
                        <a
                            class="btn btn-secondary align-items-center d-flex justify-content-center align-items-center">
                            {{ svg('heroicon-o-heart', ['class' => 'ev-icon__xs mr-2']) }}
                            Like
                        </a>
                    </div>
                </div>


                @guest
                <a class="btn btn-sm d-flex mt-3 btn-dark justify-content-center text-center align-items-center">
                    {{ svg('heroicon-o-key', ['class' => 'ev-icon__xs mr-2']) }}
                    {{ translate('Join GunOB') }}

                </a>
                <div class="text-center">
                    <small>
                        {{ translate('Gun Enthusiast Marketplace and social network') }}
                    </small>
                    <br>
                </div>
                @endguest

                <div class="text-center mt-3 d-flex align-items-center justify-content-center">
                    <div class="badge badge-soft-success mr-2 w-auto d-flex align-items-center">
                        {{ svg('heroicon-o-shield-check', ['class' => 'ev-icon__xs text-success
                        mr-2']) }}

                        {{ translate('GunOB Buyers Protection + Escrow') }}
                    </div>
                </div>



            </div>
        </div>

    </div>
</div>
