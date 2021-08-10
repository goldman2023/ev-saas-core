<div class="container">
    <div class="card card-body">
        <div class="row gx-lg-4">
            <div class="col-sm-6 col-lg-3">
                <div class="media">
                    <div class="media-body">
                        <h6 class="card-subtitle">{{ translate('Registered Companies') }}</h6>
                        <span class="card-title h3">{{ App\Models\Stats::total_companies() }}</span>

                        <div class="d-flex align-items-center">
                            <span class="d-block font-size-sm">
                              {{ translate('B2BWood Club Members') }}
                                </span>
                            <span class="badge badge-soft-success ml-2 w-auto">
                                <i class="tio-trending-up"></i> 4.3%
                            </span>
                        </div>
                    </div>

                    <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                        <i class="las la-users"></i>
                    </span>
                </div>

                <div class="d-lg-none">
                    <hr>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 column-divider-sm">
                <div class="media">
                    <div class="media-body">
                        <h6 class="card-subtitle">{{ translate('Total Turnover') }}</h6>
                        {{-- TODO: Make this dynamic --}}
                        <span class="card-title h3">${{ App\Models\Stats::total_companies_turnover() }}</span>

                        <div class="d-flex align-items-center flex-nowrap">
                            <span class="d-block font-size-sm text-nowrap">
                                {{ translate('By B2BWood Club Members') }}

                            </span>
                            <span class="badge badge-soft-success ml-2 w-auto">
                                <i class="las la-tree"></i> 12.5%
                            </span>
                        </div>
                    </div>

                    <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                        <i class="las la-poll"></i>
                    </span>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 column-divider-sm">
                <div class="media">
                    <div class="media-body">
                        <h6 class="card-subtitle">{{ translate('Manufacturing Capacity') }}</h6>
                        {{-- TODO: Make this dynamic --}}
                        <span class="card-title h3">{{ App\Models\Stats::total_production_capacity() }} UOMS*</span>

                        <div class="d-flex align-items-center flex-nowrap">
                            <span class="d-block font-size-sm text-nowrap">
                                {{ translate('By B2BWood Club Members') }}

                            </span>
                            <span class="badge badge-soft-success ml-2 w-auto">
                            {{-- TODO: this should be an increase/decrease from last month  --}}
                                <i class="las la-tree"></i> 12.5%
                            </span>
                        </div>
                    </div>

                    <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                        <i class="las la-tree"></i>
                    </span>
                </div>

                <div class="d-lg-none">
                    <hr>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 column-divider-lg">
                <div class="media">
                    <div class="media-body">
                          <h6 class="card-subtitle">{{ translate('Purchasing capacity') }}</h6>
                        {{-- TODO: Make this dynamic --}}
                        <span class="card-title h3">{{ App\Models\Stats::total_production_purchasing() }} UOMS*</span>


                        <div class="d-flex align-items-center flex-nowrap">
                            <span class="d-block font-size-sm text-nowrap">
                                {{ translate('By B2BWood Club Members') }}

                            </span>
                            <span class="badge badge-soft-success ml-2 w-auto">
                                <i class="las la-tree"></i> 12.5%
                            </span>
                        </div>
                    </div>

                    <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                        <i class="las la-ruler-combined"></i>
                    </span>
                </div>

                <div class="d-sm-none">
                    <hr>
                </div>
            </div>

            
        </div>
    </div>
    {{-- TODO: Replace UOMS with sufix values like in real life --}}
    {{-- TODO: Move this inline css to external file or make mt-n classes work --}}
    <div class="text-right mb-3 mb-lg-5" style="margin-top: -10px">
        {{ translate('* Units Of Measurment (m2/m3/tons) per year') }}
    </div>
</div>
