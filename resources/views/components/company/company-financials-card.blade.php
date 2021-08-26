<div class="card b2b-financials-card">
    <!-- Header -->
    <div class="card-header">
        <h5 class="card-header-title">{{ translate('Company Financials') }}</h5>
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
        @auth
            {{-- Check if company has complete attributes and if this is a company owner --}}
            @if (auth()->user()->id === $company->user->id)
                @if (!$company->user->shop->company_has_required_attributes())
                    <x-card-overlay-company-owner></x-card-overlay-company-owner>
                @endif

            @else
            @endif

        @else
            @if (!$company->company_has_required_attributes)
                <x-card-overlay></x-card-overlay>
            @endif
        @endauth


        <span class="h1 d-block mb-0">
            ${{ $company->get_attribute_value_by_id(35) }}
            USD</span>
        <div class="turnover-label mb-4">
            {{ translate('Anual Turnover') }}
        </div>
        <!-- Progress -->
        <div class="progress rounded-pill mb-2">
            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                data-original-title="Gross value"></div>
            <div class="progress-bar opacity" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0"
                aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                data-original-title="Net volume from sales"></div>
            <div class="progress-bar opacity-xs" role="progressbar" style="width: 9%" aria-valuenow="9"
                aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                data-original-title="New volume from sales"></div>
        </div>

        <div class="d-flex justify-content-between mb-4">
            <span>0%</span>
            <span>100%</span>
        </div>
        <!-- End Progress -->

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-lg table-nowrap card-table mb-0">
                <tbody>
                    <tr>
                        <th scope="row">
                            <span class="legend-indicator bg-primary"></span>{{ translate('Company Type') }}
                        </th>
                        <td>
                            {{ $company->get_attribute_value_by_id(1) }}
                        </td>
                        <td>
                            {{-- <span class="badge badge-soft-success">+12.1%</span> --}}
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <span class="legend-indicator bg-primary"></span>{{ translate('Employees') }}

                        </th>
                        <td>
                            {{ $company->get_attribute_value_by_id(14) }}
                        </td>
                        <td>
                          <span class="badge badge-soft-warning w-auto">
                                {{-- {{ $company->get_attribute_label_by_id(14) }} --}}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <span class="legend-indicator bg-primary opacity-xs"></span> {{ translate('Profit') }}
                        </th>
                        <td>$ {{ $company->get_attribute_value_by_id(44) }}</td>
                        <td>
                           <span class="badge badge-soft-warning w-auto">
                                {{ $company->get_attribute_label_by_id(44) }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <span class="legend-indicator"></span> {{ translate('EBITDA*') }}
                        </th>
                        <td>
                            {{ $company->get_attribute_value_by_id(47) }}
                        </td>
                        <td>
                            <span class="badge badge-soft-warning w-auto">
                                {{ $company->get_attribute_label_by_id(47) }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- End Table -->
    </div>
    <!-- End Body -->
    <div class="card-footer d-none">
        <a class="btn btn-sm btn-primary pull-right" href="/pages/request-credit-report/">
            {{ translate('Get company report') }} <i class="la la-angle-right "></i>
        </a>
    </div>
</div>
