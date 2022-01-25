<a {{ $attributes }} class="navbar-brand p-0" href="{{ route('home') }}" aria-label="{{ get_site_name() }}">
    @php
    $header_logo = get_setting('header_logo');
    @endphp
    @if ($header_logo != null)
    <img src="{{ uploaded_asset($header_logo) }}" height="auto" alt="{{ env('APP_NAME') }}">
    @else
    <img src="{{ static_asset('tenancy/assets/img/logo.jpg') }}" height="auto" alt="{{ env('APP_NAME') }}">
    @endif
</a>
