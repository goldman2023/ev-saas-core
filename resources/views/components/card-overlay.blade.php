<div class="card-overlay">
    <div class="card-body card-body-height card-body-centered">
        <img class="avatar avatar-xxl mb-3" src="/assets/svg/illustrations/yelling.svg" alt="Incomplete Profile">
        <p class="card-text">
            {{ $text }}
        </p>
        <a class="btn btn-sm btn-primary mb-3" href="{{ route('shops.create') }}" target="_blank">
            {{ translate('Register free profile') }}
        </a>

        {{-- TODO: Create request information page --}}
        @if($extraButtonsEnabled)
        <a class="btn btn-sm btn-white" href="/pages/request-credit-report/">
            {{ translate('Request validated data') }}
        </a>
        @endif
    </div>
</div>
