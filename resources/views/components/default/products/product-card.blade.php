<div class="max-h-[230px] bg-white grid grid-cols-12 w-full rounded-lg bg-white shadow-lg">
    <div class="col-span-12 grid grid-cols-12">
        <div class="col-span-4">
            <a href="{{ $product->getPermalink() }}">

        <img class="w-full h-full max-h-[230px] object-cover rounded-t-lg md:rounded-none md:rounded-l-lg"
            src="{{ $product->getThumbnail() }}" alt=" {{ $product->name }}" />
            </a>
        </div>
        <div class="col-span-5 p-6">
            <h5 class="text-gray-900 text-2xl font-medium mb-2">
                <a href="{{ $product->getPermalink() }}">

                {{ $product->name }}
                </a>
            </h5>
            <p class="text-gray-700 text-base mb-4">
                Krovinių dėžės ilgis: 2.5 m <br>
                Krovinių dėžės plotis: 1.25 m <br>
                Keliamoji galia: 540 kg
            </p>
            <p class="text-gray-600 text-xs">
                {{ translate('2 year waranty') }} / {{ translate('Made in Lithuania') }}
            </p>
        </div>

        <div class="col-span-3 p-6">
            <span class="px-3 py-2 text-green-600 text-xl font-bold  rounded-full">
                {{ $product->getTotalPrice(true) }} <small class="text-xs">+ PVM </small>
            </span>
            <div>
                <a class="btn btn-primary my-3" href="{{ $product->getPermalink() }}">
                    {{ translate('View product') }}
                </a>
            </div>
            @if(!$product->isInStock())
            <span class="text-red-600 text-sm">
                {{ translate('Out of stock') }}
            </span>
            @else
            <div class="text-sm">
                {{ translate('Available in warehouse') }}
            </div>
            @endif
        </div>
    </div>
</div>
