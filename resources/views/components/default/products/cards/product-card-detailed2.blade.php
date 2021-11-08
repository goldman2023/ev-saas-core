<!-- Card -->
<div class="card card-bordered card-hover-shadow h-100">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col">
                <div class="media align-items-center">
                    <x-tenant.system.image alt="{{ $product->getTranslation('name') }}" class="avatar avatar-sm mr-3"
                        :image="$product->thumbnail_img"></x-tenant.system.image>
                    <div class="media-body">
                        <h6 class="mb-0">
                            <a class="text-dark" href="employer.html">Mailchimp</a>
                            {{-- TODO: Make this dynamic  --}}
                            <img class="avatar avatar-xss ml-1" src="../assets/svg/illustrations/top-vendor.svg"
                                alt="Review rating" data-toggle="tooltip" data-placement="top" title="{{ translate('In Stock') }}">
                        </h6>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <!-- Checkbbox Bookmark -->
                <div class="custom-control custom-checkbox-bookmark">
                    <input type="checkbox" id="checkboxBookmark1"
                        class="custom-control-input custom-checkbox-bookmark-input">
                    <label class="custom-checkbox-bookmark-label" for="checkboxBookmark1">
                        <span class="custom-checkbox-bookmark-default" data-toggle="tooltip" data-placement="top"
                            title="Save this job">
                            <i class="far fa-star"></i>
                        </span>
                        <span class="custom-checkbox-bookmark-active" data-toggle="tooltip" data-placement="top"
                            title="Saved">
                            <i class="fas fa-star"></i>
                        </span>
                    </label>
                </div>
                <!-- End Checkbbox Bookmark -->
            </div>
        </div>
        <!-- End Row -->

        <h3 class="mb-3">
            <a class="text-dark" href="{{ $product->permalink }}">
                {{ $product->getTranslation('name') }}
            </a>
        </h3>

        <span class="d-block font-size-1 text-body mb-1">$125k-$135k yearly</span>

        <span class="badge badge-soft-info mr-2">
            <span class="legend-indicator bg-info"></span> {{ $product->getCondition() ?? '' }}
        </span>
    </div>

    <div class="card-footer">
        <ul class="list-inline list-separator small text-body">
            <li class="list-inline-item">Posted 7 hours ago</li>
            <li class="list-inline-item">Oxford</li>
            <li class="list-inline-item">Full time</li>
        </ul>
    </div>
</div>
<!-- End Card -->
