@auth
    @isset(auth()->user()->shop->slug)
    <div class="text-white">
        <a class="text-white" href="{{ route('shop.visit', auth()->user()->shop->slug) }}">

            {{ translate('Hello, ') }} {{ auth()->user()->shop->name }}
        </a>
    </div>
    @endisset
@endauth
