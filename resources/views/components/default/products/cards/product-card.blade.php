<div class="group relative bg-white border border-gray-200 rounded-lg flex flex-col overflow-hidden h-full">
    <div class="aspect-w-3 aspect-h-2 bg-gray-200 group-hover:opacity-75 sm:aspect-none sm:h-60">
        @if($product->getThumbnail())
        <a class="card-img-top" href="{{ $product->getPermalink() }}">
            {{-- <div class="p-absolute top-0 left-0 pt-3 pl-3">
                <span class="badge badge-success badge-pill">
                    {{ translate('New arrival!') }}
                </span>
            </div> --}}
            <x-tenant.system.image alt="{{ $product->getTranslation('name') }}"
                class="w-full h-50 object-center object-cover sm:w-full sm:h-full" fit="cover"
                :image="$product->getThumbnail()">
            </x-tenant.system.image>
        </a>
        @endif
    </div>
    <div class="flex-1 p-4 space-y-2 flex flex-col">
        <h3 class="text-sm font-medium text-gray-900">
            <a href="{{ $product->getPermalink() }}">
                <span aria-hidden="true" class="absolute inset-0"></span>
                {{ $product->getTranslation('name') }}
            </a>

        </h3>
        <p class="text-sm text-gray-500">
             {{ translate('Category:') }}
            {{ ($product->categories->pluck('name'))->implode(', ') }}
        </p>

        <p class="text-sm text-gray-500">
            {{ $product->getCondition() ?? '' }}
        </p>
        <div class="hidden flex-1 flex flex-col justify-end">
            <p class="text-sm italic text-gray-500">
                @if($product->brand)
                <x-tenant.system.image class="ev-brand-image-small" :image='$product->brand->getThumbnail()'>
                </x-tenant.system.image>
                @endif
            </p>
            <p class="text-base font-medium text-gray-900">
                <span class="text-dark font-weight-bold">
                    @if ($product->getBasePrice() != $product->getTotalPrice())
                    <del class="fw-600 text-danger opacity-50 mr-1">{{ $product->getBasePrice(true) }}</del>
                    @endif
                    <span class="fw-700 text-black">{{ $product->getTotalPrice(true) }}</span>
                </span>

            </p>
        </div>
        <div class="grid grid-cols-2 gap-3">
                <livewire:actions.wishlist-button :object="$product"></livewire:actions.wishlist-button>


            <a href="{{ $product->getPermalink() }}" type="button" class="btn btn-primary text-xs">
                {{ translate('View') }}
            </a>
        </div>
    </div>
</div>
