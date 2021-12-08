<div class="card border h-100">
        <div class="card-img-top position-relative">
            <img class="card-img-top"
                src="{{ $company->get_company_cover() }}"
                alt="Image Description">

            <div class="position-absolute top-0 left-0 mt-3 ml-3">
                <small class="btn btn-xs btn-success btn-pill text-uppercase shadow-soft mb-3">
                    {{ translate('New!') }}
                </small>
            </div>

            <div class="position-absolute bottom-0 left-0 mb-3 ml-4">
                <div class="d-flex align-items-center flex-wrap">
                    <ul class="list-inline mt-n1 mb-0 mr-2">
                        <x-company.company-star-rating :company="$company"></x-company.company-star-rating>
                    </ul>
                    <span class="d-inline-block">
                        <small class="font-weight-bold text-white mr-1">4.91</small>
                        <small class="text-white-70">(1.5k+ reviews)</small>
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <small class="d-block small font-weight-bold text-cap mb-2">Code</small>

            <div class="mb-3">
                <h3>
                    <a class="text-inherit" href="{{ route('shop.visit', $company->slug) }}">
                        {{ $company->name }}
                    </a>
                </h3>
            </div>

            <div class="d-flex align-items-center">
                <div class="avatar-group">
                    <a class="avatar avatar-xs avatar-circle" data-toggle="tooltip" data-placement="top" title=""
                        href="#" data-original-title="Nataly Gaga">
                        <img class="avatar-img" src="{{ $company->get_company_logo() }}" alt="Image Description">
                    </a>
                </div>
                <div class="d-flex align-items-center ml-auto">
                    <div class="small text-muted">
                        @svg('heroicon-o-heart', ['class' => 'd-block d-sm-inline-block mb-1 mb-sm-0 mr-1', 'style' => 'width: 18px;'])
                        {{ $company->product_count }} {{ translate('Products') }}
                    </div>
                    <small class="text-muted mx-2">|</small>
                    <div class="small text-muted">
                        @svg('heroicon-o-heart', ['class' => 'd-block d-sm-inline-block mb-1 mb-sm-0 mr-1', 'style' => 'width: 18px;'])

                        3h 25m
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer border-0 pt-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mr-2">
                    <small class="d-block text-muted text-lh-sm"><del>$114.99</del></small>
                    <span class="d-block h5 text-lh-sm mb-0">$99.99</span>
                </div>
                <a class="btn btn-sm btn-primary transition-3d-hover" href="{{ route('shop.visit', $company->slug) }}">
                {{ translate('View details') }}
            </a>

            </div>
        </div>
    </div>
