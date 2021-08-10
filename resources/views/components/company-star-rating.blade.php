@for ($i = 0; $i < $company->user->shop->company_size_calculated(); $i++)
    <span class="company-size-rating">

        <img class="avatar avatar-xss ml-1" src="{{ asset('assets/svg/illustrations/top-vendor.svg') }}" alt="Review rating"
            data-toggle="tooltip" data-placement="top" title=""
            data-original-title="Company Size {{ $company->user->shop->company_size_calculated() }}/5">
    </span>

@endfor
