@if ($company->user->shop->company_is_verified())
    <img class="avatar avatar-xs mr-1" src="{{ asset('/assets/img/promo/verified.svg') }}" alt="B2BWood Verified Icon"
        data-toggle="tooltip" data-placement="top" title="" data-original-title="B2BWood Verified Company">
    <span class="badge badge-soft-primary mr-2 w-auto">
        {{ translate('Verified :') }} 2021 06 08
    </span>

@else
    <i class="las la-times" style="color:red"></i>
    <span class="badge badge-soft-danger mr-2 w-auto">
        {{ translate('Not Verified') }}
    </span>
@endif
