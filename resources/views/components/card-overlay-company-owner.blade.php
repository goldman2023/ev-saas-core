<div class="card-overlay">
    <div class="card-body card-body-height card-body-centered">
        <img class="avatar avatar-xxl mb-3" src="/assets/svg/illustrations/yelling.svg" alt="Incomplete Profile">
        <p class="card-text">
            {{ translate("You haven't added any company data so far") }}
        </p>
        <a class="btn btn-sm btn-primary mb-3" href="{{ route('attributes') }}" target="_blank">
            {{ translate('Complete your profile') }}
        </a>

        {{-- TODO: Create request information page --}}
        {{-- @if($extraButtonsEnabled) --}}
        <a class="btn btn-sm btn-white" target="_blank" href="/contacts/">
            {{ translate('Get Support') }}
        </a>
        {{-- @endif --}}
    </div>
</div>
