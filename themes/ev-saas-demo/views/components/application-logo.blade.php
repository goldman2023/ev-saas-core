@php
    $header_logo = get_setting('header_logo');
@endphp
@if ($header_logo != null)
    <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}"
         class="mw-100 h-30px h-md-40px" height="40">
@else
    <img src="{{ static_asset('img/logo.png') }}" alt="{{ env('APP_NAME') }}"
         class="mw-100 h-30px h-md-40px" height="40">
@endif
