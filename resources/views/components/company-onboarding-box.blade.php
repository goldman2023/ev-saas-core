<div class="card mb-3 mb-lg-5">
    <!-- Header -->
    <div class="card-header">
        <h4 class="card-header-title">{{ translate('Welcome to B2BWood Club!') }}</h4>


    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
        <div class="row">
            <div class="col-md mb-3 mb-md-0">
                <div class="mb-4">
                    <span class="card-subtitle mb-0">{{ translate('Your Company:') }}</span>
                    @php
                        $company = auth()->user()->shop;
                    @endphp
                    <h3>
                        <a class="text-dark" href="{{ route('shop.visit', $company->slug) }}"> {{ $company->name }}
                        </a>
                    </h3>
                </div>

                @php
                    $seller_package = \App\Models\SellerPackage::find(auth()->user()->seller->seller_package_id);
                @endphp
                <span class="card-subtitle mb-0">{{ translate('Company Membership') }}</span>
                @if ($seller_package != null)

                    <h2 class="h1 text-primary">
                        {{-- TODO: Make this dynamic based on subscription --}}
                        {{ $seller_package->name }}
                        @if ($seller_package->name !== 'Prime')
                            <a href="{{ route('seller_packages_list') }}" class="display-5">
                                <small style="font-size:12px;">{{ translate('(Upgrade your membership)') }}</small>
                            </a>

                        @endif
                        {{-- It can also be Free/Basic/Prime --}}
                    </h2>
                @else
                    <h2 class="h1 text-primary">
                        <a href="{{ route('seller_packages_list') }}" class="">
                            {{ translate('Prospect') }}
                            <small style="font-size:12px;">{{ translate('*Your profile, has limited functionality') }}</small>

                        </a>
                    </h2>
                @endif
            </div>

            <ul class="list-inline list-unstyled col-md-auto">
                <li class="list-inline-item mb-2 mr-2">
                    <a class="btn btn-white" href="/page/contacts/" targe="_blank">

                        {{ translate('Contact Support') }}
                        <i class="las la-question"></i>
                    </a>
                </li>
                <li class="list-inline-item mb-2">
                    <div id="updatePlanPopover" data-toggle="popover" data-offset="-83" data-placement="bottom" title=""
                        data-content="Check out this Subscription plan modal example." data-html="true"
                        data-original-title="<div class='d-flex align-items-center'>Subscription plan <a href='#!' class='close close-light ml-auto'><i id='closeUpdatePlanPopover' class='tio-clear'></i></a></div>"
                        aria-describedby="popover385880">
                        <a class="btn btn-primary"
                            href="{{ route('shop.visit', auth()->user()->shop->slug) }}">
                            {{ translate('View company Profile') }}
                        </a>
                    </div>
                </li>
            </ul>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Body -->

    <hr class="my-4">

    <!-- Body -->
    <div class="card-body">
        <div class="row align-items-center flex-grow-1 mb-2">
            <div class="col">
                <h4 class="card-header-title">{{ translate('Complete your Profile') }}</h4>
            </div>

            <div class="col-auto">
                <span class="font-weight-bold text-dark">
                    {{ $company->profile_completeness() / 25 }}
                </span>
                {{ translate('out of') }} 4
                {{ translate('steps completed') }}
            </div>
        </div>
        <!-- End Row -->

        <!-- Progress -->
        <div class="progress rounded-pill mb-3">
            <div class="progress-bar" role="progressbar" style="width: {{ $company->profile_completeness() }}%"
                aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <!-- End Progress -->

        <!-- Legend Indicators -->
        <div class="row">
            <div class="col-auto">
                @if ($company->company_has_logo())
                    <del>
                        <span class="legend-indicator bg-primary"></span> {{ translate('Add logo') }}
                    </del>
                @else
                    <span class="legend-indicator bg-primary"></span>
                    <a href="{{ route('shops.index') }}">
                        {{ translate('Add logo') }}
                    </a>
                @endif
            </div>

            <div class="col-auto">
                @if ($company->company_has_description())
                    <del>
                        <span class="legend-indicator bg-primary opacity"></span> {{ translate('Add Company Data') }}
                    </del>
                @else
                    <a href="{{ route('shops.index') }}">
                        <span class="legend-indicator bg-primary opacity"></span> {{ translate('Add Company Data') }}
                    </a>
                @endif
            </div>

            <div class="col-auto">

                <span class="legend-indicator"></span>
                @if ($company->company_has_category())
                    <del>
                        {{ translate('Choose categories') }}
                    </del>
                @else
                    <a href="{{ route('attributes') }}">
                        {{ translate('Choose categories') }}
                    </a>
                @endif
            </div>

            <div class="col-auto">
                <span class="legend-indicator bg-primary"></span>

                @if ($company->company_has_required_attributes())
                    <del>
                        {{ translate('Complete Company Profile') }}
                    </del>
                @else
                    <a href="{{ route('attributes') }}">
                        {{ translate('Complete Company Profile') }}
                    </a>
                @endif
            </div>
        </div>
        <!-- End Legend Indicators -->
    </div>
    <!-- End Body -->
</div>
