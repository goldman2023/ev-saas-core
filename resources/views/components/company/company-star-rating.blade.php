@for ($i = 0; $i < $company->getPublicRating(); $i++)
    <span class="company-size-rating">

        <img class="avatar avatar-xss mr-1" src="/assets/svg/illustrations/top-vendor.svg" alt="Review rating"
            data-toggle="tooltip" data-placement="top" title=""
            data-original-title="Company Rating {{ $company->getPublicRating() }}/5">
    </span>

@endfor
