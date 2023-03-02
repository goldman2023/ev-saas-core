<div class="bg-white mb-6">
    <div class="mx-auto py-12 px-4 sm:py-12 sm:px-6 container lg:px-8">
      <div class="flex items-center justify-between space-x-4">
        <h2 class="text-lg font-medium text-gray-900">
            {{ translate('Related products') }}
        </h2>
        <a href="/products" class="whitespace-nowrap text-sm font-medium text-indigo-600 hover:text-indigo-500">
          {{ translate('View all') }}
          <span aria-hidden="true"> &rarr;</span>
        </a>
      </div>
      <div class="mt-6 grid grid-cols-1 gap-x-8 gap-y-8 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">
        @foreach($products as $product)
        @if($product->subject_type == 'App\Models\Product')
        <div class="group relative">
          <div class="aspect-w-4 aspect-h-3 overflow-hidden rounded-lg bg-gray-100">
            <img src="{{ $product->getThumbnail() }}" alt="{{ $product->name }}, {{ $product->excerpt }}" class="object-cover object-center">
            <div class="flex items-end p-4 opacity-0 group-hover:opacity-100" aria-hidden="true">
              <div class="w-full rounded-md bg-white bg-opacity-75 py-2 px-4 text-center text-sm font-medium text-gray-900 backdrop-blur backdrop-filter">
                {{ translate('View Product') }}
            </div>
            </div>
          </div>
          <div class="mt-4 flex items-center justify-between space-x-8 text-base font-medium text-gray-900">
            <h3>
              <a href="{{ $product->getPermalink() }}">
                <span aria-hidden="true" class="absolute inset-0"></span>
                {{ $product->name }}
              </a>
            </h3>
            <p>
                {{ FX::formatPrice($product->getBasePrice()) }}
            </p>
          </div>
          <p class="mt-1 text-sm text-gray-500">
            {{ $product->excerpt }}
          </p>
        </div>
        @endif
        @endforeach

        <!-- More products... -->
      </div>
    </div>
  </div>
