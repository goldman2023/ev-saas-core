<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    {{ __('labels.brands_title') }}
                </h2>
                <p class="mt-3 max-w-3xl text-lg text-gray-500">
                    {{ __('labels.brands_description') }}
                </p>
                <div class="mt-8 sm:flex">
{{--                    TODO: Add dynamic buttons --}}
                </div>
            </div>
            <div class="mt-8 grid grid-cols-2 gap-0.5 md:grid-cols-3 lg:mt-0 lg:grid-cols-2">
                @foreach (\App\Models\Brand::all() as $brand)
                    <div class="col-span-1 flex justify-center py-8 px-8 bg-gray-50">
                        <a href="{{ route('products.brand', $brand->slug) }}" class="">
                            <x-tenant.system.image class="max-h-12" :image="$brand->logo"></x-tenant.system.image>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
