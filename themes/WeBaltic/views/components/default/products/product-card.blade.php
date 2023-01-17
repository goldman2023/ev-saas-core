<div class="max-h-[230px] bg-white grid grid-cols-12 w-full rounded-lg bg-white shadow-lg">
    <div class="col-span-12 grid grid-cols-12">
        <div class="col-span-4">
            <a href="{{ $product->getPermalink() }}">

                <img class="w-full h-full max-h-[230px] object-cover rounded-t-lg md:rounded-none md:rounded-l-lg"
                    src="{{ $product->getThumbnail() }}" alt=" {{ $product->name }}" />
            </a>
        </div>
        <div class="col-span-5 p-6">
            <h5 class="text-gray-900 text-2xl font-bold mb-2">
                <a href="{{ $product->getPermalink() }}">

                    {{ $product->name }}
                </a>
            </h5>
            <p class="text-gray-700  text-sm mb-4">
                Krovinių dėžės ilgis: 2.5 m <br>
                Krovinių dėžės plotis: 1.25 m <br>
                Keliamoji galia: 540 kg
            </p>
            <p class="text-gray-600 text-xs">
                {{ translate('2 year waranty') }} / {{ translate('Made in Lithuania') }}
            </p>
        </div>

        <div class="col-span-3 p-6">
            <span class="text-center px-3 py-2 text-gray-800 text-2xl font-medium  rounded-full">
                {{ $product->getTotalPrice(true) }}
            </span>
            <div class="text-center w-full">
                <a class="btn btn-primary my-3" href="{{ $product->getPermalink() }}">
                    {{ translate('View product') }}
                </a>
            </div>
            @if(!$product->isInStock())
            <span class="text-red-600 text-sm">
                {{ translate('Out of stock') }}
            </span>
            @else
            <div class="text-sm flex gap-2">
                <svg class="h-5 w-5 flex-shrink-0 text-green-500" x-description="Heroicon name: mini/check"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ translate('Available in warehouse') }}
            </div>
            @endif
        </div>
    </div>
</div>
