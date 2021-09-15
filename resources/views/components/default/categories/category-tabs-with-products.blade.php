<!-- Nav -->
<div class="container">
    <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-3 mb-md-3">
        <x-ev.label tag="h2" class="h1" :label="ev_dynamic_translate('Categories Tabs Title', true)">
        </x-ev.label>
    </div>

    <div class="text-center">
        <ul class="nav nav-segment nav-pills scrollbar-horizontal mb-7" role="tablist">
            @foreach ($categories as $key => $category)
                <li class="nav-item">
                    <a class="nav-link @if ($key == 0) active @endif" id="pills-one-code-features-example1-tab"
                        data-toggle="pill" href="#pills-one-code-features-{{ $key }}" role="tab"
                        aria-controls="pills-one-code-features-example1" aria-selected="true">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach

        </ul>
    </div>

</div>
<!-- End Nav -->
<div class="container">
    <!-- Tab Content -->
    <div class="tab-content">
        @foreach ($categories as $key => $category)
            <div class="tab-pane fade  @if ($key == 0) show active @endif" id="pills-one-code-features-{{ $key }}"
                role="tabpanel" aria-labelledby="pills-one-code-features-{{ $key }}-tab">
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
