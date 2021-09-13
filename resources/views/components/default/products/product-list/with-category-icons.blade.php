<!-- Nav -->
<div class="container">
    <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-3 mb-md-3">

    </div>
    <div class="row">
        <div class="col-sm-5">
            <x-ev.label tag="h2" class="h1" :label="ev_dynamic_translate('Categories Tabs Title', true)">
            </x-ev.label>

            <p>
                <x-ev.label tag="span" :label="ev_dynamic_translate('Top Categories Description Text', true)">
                </x-ev.label>
            </p>
        </div>
        <div class="col-sm-7">
            <div class="text-right">
                <ul class="nav nav-segment  scrollbar-horizontal mb-7" role="tablist">
                    @foreach ($categories as $key => $category)
                        <li class="nav-item">
                            <a class="nav-link p-3 text-center font-size-3 @if ($key == 0) active @endif"
                                id="pills-with-category-images-{{ $key }}" data-toggle="pill"
                                href="#pills-with-category-images-{{ $key }}-tab" role="tab"
                                aria-controls="pills-with-category-images" aria-selected="true">
                                <div class="mb-2 mt-2">

                                    @if ($category->icon)

                                        <x-tenant.system.image style="height: 60px;" :image="$category->icon">
                                        </x-tenant.system.image>


                                    @else
                                        <x-tenant.system.image style="height: 60px;"
                                            image="/assets/img/placeholder.jpg">
                                        </x-tenant.system.image>
                                    @endif
                                </div>
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>


</div>
<!-- End Nav -->
<div class="container">
    <!-- Tab Content -->
    <div class="tab-content">
        @foreach ($categories as $key => $category)
            <div class="tab-pane fade  @if ($key == 0) show active @endif" id="pills-with-category-images-{{ $key }}-tab"
                role="tabpanel" aria-labelledby="pills-with-category-images-{{ $key }}-tab">
                <div class="row">
                    @foreach ($category->products as $product)
                        <div class="col-sm-4">
                            <x-default.products.cards.product-card :product="$product"
                                style="{{ ev_dynamic_translate('product-card', true)->value }}">
                            </x-default.products.cards.product-card>
                        </div>
                    @endforeach
                </div>


            </div>

        @endforeach


    </div>
</div>
<!-- End Tab Content -->
