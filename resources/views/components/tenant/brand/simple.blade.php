<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5">

        @foreach (\App\Models\Brand::take(5) as $brand)
        <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
            <a href="{{ route('products.brand', $brand->slug) }}" class="">
                <x-tenant.system.image class="h-12" :image="$brand->logo"></x-tenant.system.image>
            </a>
        </div>

        @endforeach
      </div>
    </div>
  </div>
