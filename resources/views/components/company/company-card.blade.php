@php
$class_media = 'd-sm-flex align-items-center';
$class_col_body_1 = 'col-md-12';
$class_top_level = '';
$class_col_body_2 = 'col-md-12';


@endphp

<div class="{{ $class_top_level }}">
    <div class="card card-bordered card-hover-shadow h-100 mb-5 {{ $class_top_level }}">
        <div class="card-body">
            <!-- Media -->
            <div class="{{ $class_media }}">
                <div class="media align-items-center align-items-sm-start">
                    {{-- TODO: Move this to separate css file for company card styles --}}

                    <div class="media-body d-none">
                        <h6 class="mb-0">
                            <a class="text-dark" href="{{  $company->getPermalink() }}">
                                {{ $company->name }}
                            </a>
                        </h6>
                        <div class="w-100">
                            <x-company.company-star-rating :company="$company"></x-company.company-star-rating>
                        </div>
                    </div>
                </div>

                <div class="media-body">
                    <div class="row">
                        <div class="col {{ $class_col_body_1 }}">
                            <h3 class="mb-0">
                                {{-- TODO: Add --}}
                                <a class="text-dark" href="{{ $company->getPermalink() }}">
                                    {{ $company->name }}
                                </a>
                                {{-- TODO: Create company avatar component, because we need to use it in separate places
                                --}}
                                {{-- <x-company.company-avatar :company="$company"> </x-company.company-avatar> --}}
                            </h3>

                            <div class="mb-3">
                                <x-company.company-star-rating :company="$company"></x-company.company-star-rating>
                            </div>

                            <div class="d-none d-sm-inline-block">

                            </div>

                        </div>

                        <div class="d-none col-auto order-md-3">
                            <!-- Checkbbox Bookmark -->
                            <div class="custom-control custom-checkbox-bookmark">
                                <input type="checkbox" id="checkboxBookmark1"
                                    class="custom-control-input custom-checkbox-bookmark-input">
                                <label class="custom-checkbox-bookmark-label" for="checkboxBookmark1">
                                    <span class="custom-checkbox-bookmark-default" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Save this job">
                                        <i class="far fa-star"></i>
                                    </span>
                                    <span class="custom-checkbox-bookmark-active" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Saved">
                                        <i class="fas fa-star"></i>
                                    </span>
                                </label>
                            </div>
                            <!-- End Checkbbox Bookmark -->
                        </div>

                        <div class="{{ $class_col_body_2 }} mt-3 mt-md-0">
                            <span class="d-block font-size-1  small text-body mb-1 d-none">
                                {{-- TODO: make this dynamic --}}
                                {{ translate('Member Since: ') }}
                                {{ $company->created_at->diffForHumans() }}
                            </span>
                            <x-verified-company-badge :company="$company"></x-verified-company-badge>


                        </div>
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Media -->
        </div>

        <div class="card-footer">
            <ul class="list-inline list-separator small text-body">
                {{-- TODO: create a country column- not a simple attribute, we will need filtering based on that --}}
                <li class="list-inline-item">
                    {{ country_name_by_code($company->settings()->where('company_country')->last()) }}
                </li>
            </ul>

            {{-- TODO: This should be shown only for sellers with active --}}
            @php
            $is_verified = $company->isVerified();

            @endphp
            @if ($is_verified == true)
            <span class="badge badge-soft-success w-auto">
                {{-- <span class="legend-indicator bg-info"></span> --}}
                {{ __('Verified Seller') }}
            </span>
            @else

            @endif

        </div>
    </div>

</div>
