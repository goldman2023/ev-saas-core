<div class="js-sticky-block card bg-white">
    <div class="card-body text-center">
        <div class="w-50 mx-auto mb-4">
            <img class="img-fluid" src="https://creditinfo.com/wp-content/uploads/2020/10/0.png"
                alt="Image Description">
        </div>

        <div class="mb-3">

            @php
                $company_country = $company->user->seller->get_attribute_value_by_id(12);

            @endphp

            <h3>
                {{ translate('Get detailed information') }} <br>
                {{-- TODO: make this value dynamic by company meta --}}
                {{ translate('about: ') }} {{ $company->user->shop->name }},  <img src="{{ static_asset('assets/img/flags/png/' . strtolower($company_country) . '.png') }}"
                                                                                                height="16">
            </h3>
            <p>
               {{ translate('If you want to get an access to information, please fill out a data request form') }}
            </p>
        </div>

        <a class="btn btn-primary" href="/page/request-credit-report?company={{ $company->user->shop->slug }}">
            {{ translate('Get company report') }}
        </a>
        <div>
            <small>
                <a href="#" target="blank">
                    {{ translate('Download an example report') }}
                </a>
            </small>

        </div>
    </div>
</div>
