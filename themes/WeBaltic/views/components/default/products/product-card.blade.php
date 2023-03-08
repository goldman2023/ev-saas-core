@if($product)
<div class="relative lg:max-h-[230px] bg-white lg:grid lg:grid-cols-12 w-full rounded-lg bg-white shadow-lg">
    <div class="absolute right-3 top-3">
        <livewire:actions.social-action-button action="save" template="wishlist-button" :object="$product">
        </livewire:actions.social-action-button>
    </div>
    <div class="lg:col-span-12 lg:grid lg:grid-cols-12">
        <div class="col-span-4">
            <a href="{{ $product->getPermalink() }}">

                <img class="w-full h-full max-h-[230px] object-cover rounded-t-lg md:rounded-none md:rounded-l-lg"
                    src="{{ $product->getThumbnail(['w' => 600]) }}" alt=" {{ $product->name }}" />
            </a>
        </div>
        <div class="col-span-8 p-6">

            <div class="grid grid-cols-12">
                <div class="col-span-12">
                    <h5 class="text-gray-900 text-2xl font-bold mb-2">
                        <a href="{{ $product->getPermalink() }}">
                            {{ $product->name }}
                        </a>
                        <span class="font-medium block text-gray-600 text-[16px] line-clamp-1">
                            {{ $product->excerpt }}
                        </span>
                    </h5>

                </div>
                <div class="col-span-7">

                    <p class="text-gray-700  text-sm mb-4">
                       {{ translate('Krovinių dėžės ilgis:') }} <span class="font-bold">{{ $product->getAttrValue('kraunamo-pavirsiaus-ilgis') / 10 }} cm </span><br>
                        {{ translate('Krovinių dėžės plotis:') }} <span class="font-bold">{{ $product->getAttrValue('kraunamo-pavirsiaus-plotis') / 10 }} cm </span><br>
                        {{ translate('Keliamoji galia:') }} <span class="font-bold">{{ $product->getAttrValue('bendra-krova') }} kg </span>

                        <br>
                        @if($product->getAttrValue('stabdziai') == 'mechanical')
                        {{ translate('Su stabdžiais') }}
                        @endif
                    </p>
                    <p class="text-gray-600 text-xs whitespace-nowrap flex">
                        {{ translate('2 year waranty') }} / {{ translate('Made in Lithuania') }} 🇱🇹

                        @auth
                        @if(auth()->user()->isAdmin())
                        / <span class="flex"> @svg('heroicon-o-chart-bar', ['class' => 'h-4 h-4 ml-2 mr-1'])
                        {{ $product->activities_count}}
                        </span>
                        @endif
                        @endauth
                    </p>
                </div>
                <div class="col-span-12 sm:col-span-5 text-right">
                    <div class="col-span-12 sm:col-span-3 p-6 pt-0">
                        <span class="text-right px-3 py-2 text-gray-800 text-2xl font-medium  rounded-full">
                            {{ $product->getTotalPrice(true) }}
                        </span>
                        <div class="text-right w-full">
                            <a class="btn btn-primary my-3" href="{{ $product->getPermalink() }}">
                                {{ translate('View product') }}
                            </a>

                        </div>
                        {{-- @if(!$product->isInStock())

                        @else

                        @endif --}}
                    </div>
                </div>
            </div>


        </div>


    </div>
</div>
@endif
