<div class="card card-bordered card-hover-shadow mb-5">
    <div class="card-body">
        <!-- Media -->
        <div class="d-sm-flex">
            <div class="media align-items-center align-items-sm-start mb-3">
                <x-tenant.system.image alt="{{ $product->getTranslation('name') }}" class="avatar avatar-sm mr-3"
                    :image="$product->thumbnail_img"></x-tenant.system.image>
                <div class="media-body d-sm-none">
                    <h6 class="mb-0">
                        <a class="text-dark" href="employer.html">Mailchimp</a>
                        <img class="avatar avatar-xss ml-1" src="../assets/svg/illustrations/top-vendor.svg"
                            alt="Review rating" data-toggle="tooltip" data-placement="top" title=""
                            data-original-title="Claimed profile">
                    </h6>
                </div>
            </div>

            <div class="media-body">
                <div class="row">
                    <div class="col col-md-12">
                        <h3 class="mb-0">
                            <a class="text-dark" href="{{ $product->permalink }}">
                                {{ $product->getTranslation('name') }}
                            </a>
                        </h3>
                        <div class="d-none d-sm-inline-block">

                        </div>
                    </div>

                    <div class="col-auto order-md-3">
                        <!-- Checkbbox Bookmark -->
                        <div class="custom-control custom-checkbox-bookmark">
                            <input type="checkbox" id="checkboxBookmark1"
                                class="custom-control-input custom-checkbox-bookmark-input">
                            <label class="custom-checkbox-bookmark-label" for="checkboxBookmark1">
                                <span class="custom-checkbox-bookmark-default" data-toggle="tooltip"
                                    data-placement="top" title="" data-original-title="Save this job">
                                    <i class="far fa-star"></i>
                                </span>
                                <span class="custom-checkbox-bookmark-active" data-toggle="tooltip" data-placement="top"
                                    title="" data-original-title="Saved">
                                    <i class="fas fa-star"></i>
                                </span>
                            </label>
                        </div>
                        <!-- End Checkbbox Bookmark -->
                    </div>

                    <div class="col-12 col-md mt-3 mt-md-0">
                        <span class="d-block font-size-1 text-body mb-1">
                            <span class="text-dark font-weight-bold">
                                {{ translate('Price: ') }}
                                @if ($product->getBasePrice() != $product->getTotalPrice())
                                    <del class="fw-600 opacity-50 mr-1">{{ $product->getBasePrice(true) }}</del>
                                @endif
                                <span
                                    class="fw-700 text-primary">{{ getTotalPrice(true) }}</span>
                            </span>

                        </span>

                        <span class="badge badge-soft-info mr-2">
                            <span class="legend-indicator bg-info"></span>Remote
                        </span>
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </div>
        <!-- End Media -->
    </div>

    <div class="card-footer">
        {{-- <ul class="list-inline list-separator small text-body">
            <li class="list-inline-item">
                <x-ev.dynamic-attribute-value :data="$product"
                    :attribute="ev_dynamic_attribute('product-card-attribute-1')">
                </x-ev.dynamic-attribute-value>

            </li>
            <li class="list-inline-item">
                <x-ev.dynamic-attribute-value :data="$product"
                    :attribute="ev_dynamic_attribute('product-card-attribute-2')">
                </x-ev.dynamic-attribute-value>
            </li>
            <li class="list-inline-item">
                <x-ev.dynamic-attribute-value :data="$product"
                    :attribute="ev_dynamic_attribute('product-card-attribute-3')">
                </x-ev.dynamic-attribute-value>
            </li>

        </ul> --}}
    </div>
</div>
