<div class="row">
    <div class="col-sm-6">
        <small class=" opacity-50">{{ translate('Sold by') }}: </small>
        @if ($product->added_by == 'seller' && get_setting('vendor_system_activation') == 1)
            <a href="{{ route('shop.visit', $product->user->shop->slug) }}" class="text-reset">
                {{ $product->user->shop->name }}
            </a>
        @else
            {{-- {{ translate('Inhouse product') }} --}}
            <strong class="text-reset">{{ get_site_name() }}</strong>
        @endif

        @if (get_setting('conversation_system') == 1)
            <button class="mt-2 btn btn-xs btn-soft-primary mr-auto" onclick="show_chat_modal()">

                {{ translate('Message Seller') }}
            </button>
        @endif
    </div>

    @if ($product->brand != null)
        <div class="col-sm-6">
            <small class="mr-2 opacity-50">{{ translate('Manufacturer:') }} </small><br>
            <a href="{{ route('products.brand', $product->brand->slug) }}">
                <img class="mt-0" src="{{ uploaded_asset($product->brand->logo ?? '') }}"
                    alt="{{ $product->brand->getTranslation('name') }}" height="60">
            </a>
        </div>
    @endif

</div>
