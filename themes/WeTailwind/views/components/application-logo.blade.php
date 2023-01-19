<div class="block w-[50px] mh-10 text-gray-600 fill-current">
    @php
        $header_logo = get_setting('header_logo');
    @endphp
    @if ($header_logo != null)
        <img src="{{ uploaded_asset($header_logo) }}"
             width="70px"
             alt="{{ env('APP_NAME') }}"
        >
    @else
        <img src="{{ static_asset('img/logo.jpg') }}"
             width="70px"
             alt="{{ env('APP_NAME') }}"
        >
    @endif
</div>
