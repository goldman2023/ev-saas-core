@php
$categories = App\Models\Category::where('level', 0)
->whereHas('products')
->orderBy('order_level', 'desc')
->get();
@endphp

<div class="container space-top-1">
    <div class="row">
        <div class="col-sm-3">
            <x-default.categories.list.category-list :categories="$categories">
            </x-default.categories.list.category-list>
        </div>
        <div class="col-sm-9">
            <x-default.brands.brands-list>
            </x-default.brands.brands-list>
            <div class="row">
                <div class="col-sm-8">
                    <img class="w-100"
                        src="https://images.ev-saas.com/insecure/fill/400/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/5469dff5-3707-417d-b152-d9950de45daf/1645470823_Screenshot%202022-02-21%20at%2021.12.41.png@webp" />

                </div>
                <div class="col-sm-4">
                    <div class="card bg-transparent p-3">
                        <div class="">
                            <div class="mb-3">
                                {{ translate("Special Deals") }}
                            </div>
                            @php
                            $products = App\Models\Product::paginate(8);
                            @endphp
                            <div class="row d-flex no-gutters we-horizontal-slider__desktop">
                                @foreach($products as $product)
                                <div class="col-12 mr-3">
                                    <x-default.products.cards.product-card :product="$product">
                                    </x-default.products.cards.product-card>
                                </div>

                                @endforeach
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>
</div>
