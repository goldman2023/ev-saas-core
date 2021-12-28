<div class="card border mb-3">
        <div class="card-img-top position-relative">
            <img class="card-img-top"
                src="{{ $company->get_company_cover() }}"
                alt="Image Description">

            <div class="position-absolute top-0 left-0 mt-3 ml-3">
                <small class="btn btn-xs btn-success btn-pill text-uppercase shadow-soft mb-3">
                    {{ translate('New!') }}
                </small>

            </div>



            <div class="position-absolute bottom-0 left-0 mb-n4 ml-3">
                <div class="avatar-group">
                    <a class="avatar avatar-xl avatar-circle" data-toggle="tooltip" data-placement="top" title=""
                        href="{{ route('shop.visit', $company->slug) }}" data-original-title="{{ $company->name }}">
                        <img class="avatar-img bg-light" src="{{ $company->get_company_logo() }}" alt="{{ $company->name }}">
                    </a>
                </div>

            </div>
        </div>

        <div class="card-body">
            <small class="d-block small font-weight-bold text-cap mb-2 mt-3">Code</small>

            <div class="mb-3">
                <h3>
                    <a class="text-inherit" href="{{ route('shop.visit', $company->slug) }}">
                        {{ $company->name }}
                    </a>
                </h3>
            </div>

            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center ml-0">
                    <div class="small text-muted">
                        <div class="d-flex align-items-center flex-wrap">
                            <ul class="list-inline mt-n1 mb-0 mr-2">
                                <x-company.company-star-rating :company="$company"></x-company.company-star-rating>
                            </ul>
                            <span class="d-inline-block">
                                <small class="font-weight-bold mr-1">4.91</small>
                                <small class="text-dark-70">(1.5k+ reviews)</small>
                            </span>
                        </div>
                    </div>
                    <small class="text-muted mx-2">|</small>
                    <div class="small text-muted">
                        @svg('heroicon-o-heart', ['class' => 'd-block d-sm-inline-block mb-1 mb-sm-0 mr-1', 'style' => 'width: 18px;'])
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer border-0 pt-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mr-2">

                </div>
                <a class="btn btn-sm btn-primary transition-3d-hover" href="{{ route('shop.visit', $company->slug) }}">
                {{ translate('View details') }}
            </a>

            </div>
        </div>
    </div>
