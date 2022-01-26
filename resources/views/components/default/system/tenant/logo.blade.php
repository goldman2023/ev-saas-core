<a {{ $attributes }} class="navbar-brand p-0 mw-100" href="{{ route('home') }}" aria-label="{{ get_site_name() }}">
    @php
    $header_logo = get_setting('header_logo');
    @endphp
    @if ($header_logo != null)
    <img src="{{ uploaded_asset($header_logo) }}" style="max-width: 100%;" height="auto" alt="{{ env('APP_NAME') }}">
    @else
    <img src="{{ static_asset('tenancy/assets/img/logo.jpg') }}" style="max-width: 100%;" height="auto" alt="{{ env('APP_NAME') }}">
    @endif
</a>
