<div class="w-full bg-white rounded-xl shadow {{ $class }}">
    <div class="w-full px-5 py-4 pb-3 mb-3 flex justify-between items-center border-b border-gray-200">
        <h5 class="text-14 font-semibold">{{ translate('Shop Information') }}</h5>
    </div>

    <div class="px-5 pb-3 flex flex-col ">
        <p class="text-16 text-typ-3">{{ $shop->getShopMeta('tagline') }}</p>

        @if($shop->created_at)
            <div class="w-full flex justify-start text-sm whitespace-nowrap  mt-2">
                <span class="text-typ-2 mr-1">{{ translate('Created')}}:</span>
                <time datetime="{{ $shop->created_at }}" class="text-typ-3">
                    {{ $shop->created_at->diffForHumans() }}
                </time>
            </div>
        @endif

        <div class="w-full flex justify-start text-sm whitespace-nowrap  mt-2">
            <span class="text-typ-2 mr-1">{{ translate('Email')}}:</span>
            <span class="text-typ-3">
                {{ $shop->getShopMeta('email') }}
            </span>
        </div>

        <div class="w-full flex justify-start text-sm whitespace-nowrap  mt-2">
            <span class="text-typ-2 mr-1">{{ translate('Websites')}}:</span>
            <span class="text-typ-3 flex flex-col space-y-2">
                @if(!empty($shop->getShopMeta('websites')) && !empty($shop->getShopMeta('websites')))
                    @foreach($shop->getShopMeta('websites') as $website)
                        <a class="text-primary text-14" href="{{ $website }}" target="_blank">{{ $website }}</a>
                    @endforeach
                @endif
            </span>
        </div>

        <div class="w-full flex justify-start text-sm whitespace-nowrap  mt-2">
            <span class="text-typ-2 mr-1">{{ translate('Phones')}}:</span>
            <span class="text-typ-3 flex flex-col space-y-2">
                @if(!empty($shop->getShopMeta('phones')) && !empty($shop->getShopMeta('phones')))
                    @foreach($shop->getShopMeta('phones') as $phone)
                        <span class="text-primary text-14" href="{{ $phone }}">{{ $phone }}</span>
                    @endforeach
                @endif
            </span>
        </div>
    </div>
</div>