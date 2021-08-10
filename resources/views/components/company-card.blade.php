@php
$class_media = 'd-sm-flex align-items-center';
$class_col_body_1 = 'col-md-7';
$class_top_level = '';
$class_col_body_2 = 'col-md-5';

if ($new) {
    $class_media = 'd-block b2b-new-company';
    $class_col_body_1 = 'col-md-12';
    $class_col_body_2 = 'col-md-12';
    $class_top_level = 'h-100';
}

@endphp

<div class="{{ $class_top_level }}">
    <div class="card card-bordered card-hover-shadow mb-5 {{ $class_top_level }}">
        <div class="card-body">
            <!-- Media -->
            <div class="{{ $class_media }}">
                <div class="media align-items-center align-items-sm-start">
                    {{-- TODO: Move this to separate css file for company card styles --}}
                    <img class="avatar avatar-xl mr-3" style="object-fit:contain; margin-bottom: 10px;"
                        src="{{ $company->user->shop->get_company_logo() }}" alt="{{ $company->name }}">
                    <div class="media-body d-none">
                        <h6 class="mb-0">
                            <a class="text-dark" href="{{ route('shop.visit', $company->slug) }}">
                                {{ $company->name }}
                            </a>

                            <x-company-star-rating :company="$company"></x-company-star-rating>


                        </h6>
                    </div>
                </div>

                <div class="media-body">
                    <div class="row">
                        <div class="col {{ $class_col_body_1 }}">
                            <h3 class="mb-0">
                                {{-- TODO: Add --}}
                                <a class="text-dark" href="{{ route('shop.visit', $company->slug) }}">
                                    {{ $company->name }}
                                </a>
                                {{-- TODO: Create company avatar component, because we need to use it in separate places --}}
                                {{-- <x-company-avatar :company="$company"> </x-company-avatar> --}}
                                <x-company-star-rating :company="$company"></x-company-star-rating>
                            </h3>
                            <div class="d-none d-sm-inline-block">
                                @if (!$new)
                                    <x-company-industries :company="$company->user->shop">
                                    </x-company-industries>
                                @endif
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
                                {{ translate('B2BWood Club member: ') }}
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
                <li class="list-inline-item">{{ translate('Est.') }} {{ $company->user->seller->get_attribute_value_by_id(10) }}</li>
                <li class="list-inline-item">{{ country_name_by_code($company->user->seller->get_attribute_value_by_id(12))  }}</li>
                <li class="list-inline-item">{{ translate('Company Type:') }} {{ $company->user->seller->get_attribute_value_by_id(1)  }}</li>
            </ul>

            {{-- TODO: This should be shown only for sellers with active --}}
            @php
                $seller_package = \App\Models\SellerPackage::find($company->user->seller->seller_package_id);
                
            @endphp
            @if ($seller_package != null)
                <span class="badge badge-soft-success w-auto">
                    {{-- <span class="legend-indicator bg-info"></span> --}}
                    {{ $seller_package->name }} {{ __('Club member') }}
                </span>

            @else
                <span class="badge badge-soft-success w-auto">
                    {{-- <span class="legend-indicator bg-info"></span> --}}
                    {{ __('Prospect Club member') }}
                </span>
            @endif

        </div>
    </div>

</div>
