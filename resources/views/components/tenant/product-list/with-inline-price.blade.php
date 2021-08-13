<div class="bg-white">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">{{ __('Customers also purchased') }}</h2>

        <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach($products as $product)

                <div class="group relative">
                    <div
                        class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">


                        <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                             alt="{{  $product->getTranslation('name')  }}"
                             class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-sm text-gray-700">
                                <a href="{{ route('product', $product->slug) }}">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $product->getTranslation('name') }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">Black</p>
                        </div>
                        <p class="text-sm font-medium text-gray-900">
                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
                            @endif
                            <span class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span>
                        </p>
                    </div>
                </div>
        @endforeach
        <!-- More products... -->
        </div>
    </div>
</div>
