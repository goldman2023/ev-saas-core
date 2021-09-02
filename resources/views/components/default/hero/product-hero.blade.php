<div class="position-relative">
    <div class="container space-lg-3 position-relative z-index-2">
        <div class="row align-items-center">
            <div class="col-12 col-lg-9 mb-7 mt-7 mt-md-0 mb-md-0">
                <div class="w-md-60 mb-7">
                    <x-ev.label tag="h2" class="h1" :label="ev_dynamic_translate('Product Heading')">
                    </x-ev.label>
                    <p>
                        <x-ev.label class="div h4" :label="ev_dynamic_translate('Product Description')">
                        </x-ev.label>
                    </p>

                    <div>
                        <x-ev.link-button :href="ev_dynamic_translate('#hero-cta-button')"
                        :label="ev_dynamic_translate('Get Started')"
                        class="ev-button btn btn-primary mr-3">
                        </x-ev.link-button>

                        <x-ev.link-button :href="ev_dynamic_translate('#hero-shop-button')"
                        :label="ev_dynamic_translate('Explore our Catalogue')"
                        class="ev-button btn btn-outline-primary">
                        </x-ev.link-button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <!-- Card -->
                       <x-default.cards.hero-benefit-card id="benefit-card-1">
                       </x-default.cards.hero-benefit-card>
                        <!-- End Card -->
                    </div>

                    <div class="col-md-4 mb-3 mb-md-0">
                        <!-- Card -->
                        <x-default.cards.hero-benefit-card id="benefit-card-2">
                        </x-default.cards.hero-benefit-card>
                        <!-- End Card -->
                    </div>

                    <div class="col-md-4">
                        <!-- Card -->
                        <x-default.cards.hero-benefit-card id="benefit-card-3">

                        </x-default.cards.hero-benefit-card>
                        <!-- End Card -->
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </div>
        <!-- End Row -->
    </div>

    <div class="hero-v1 d-md-block"
        style="background-image: url({{ ev_dynamic_translate('#product-hero-image')->value }});">
        <x-ev.dynamic-image
        :src="ev_dynamic_translate('#product-hero-image')" alt="Product Hero"
        >
        </x-ev.dynamic-image>
    </div>
</div>
