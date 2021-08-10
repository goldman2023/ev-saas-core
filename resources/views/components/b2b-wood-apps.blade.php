<div class="card h-100">
    <!-- Header -->
    <div class="card-header">
        <h5 class="card-header-title">

            {{ translate('B2BWood Services') }}
        </h5>

        
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
        <p>{{ translate('B2BWood is a global club for forestry and wood related industries. Our goal is to help our members to present their business in a digital world and help find reliable partners') }}
        </p>

        <ul class="list-group list-group-flush list-group-no-gutters">
            <li class="list-group-item py-3">
                <h5 class="modal-title">{{ translate('Our services and apps') }}</h5>
            </li>

            <!-- List Group Item -->
            <li class="list-group-item py-3">
                <div class="media">
                    <div class="mt-1 mr-3">
                        <img class="avatar avatar-xs avatar-4by3" src="./assets/svg/brands/capsule.svg"
                            alt="B2BWood News">
                    </div>
                    <div class="media-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">{{ translate('B2BWood News') }}</h5>
                                <span
                                    class="d-block font-size-sm">{{ translate('Latest Forestry Industry News') }}</span>
                            </div>

                            <div class="col-auto">
                                <a class="btn btn-sm btn-primary" href="{{ route('news') }}"
                                    title="{{ translate('Forestry News') }}" target="_blank">
                                    {{ translate('Visit') }}
                                    <i class="la la-angle-right "></i>
                                </a>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                </div>
            </li>
            <!-- End List Group Item -->

            <!-- List Group Item -->
            <li class="list-group-item py-3">
                <div class="media">
                    <div class="mt-1 mr-3">
                        <img class="avatar avatar-xs avatar-4by3" src="{{ asset('assets/svg/illustrations/browse.svg') }} "
                            alt="Image Description">
                    </div>
                    <div class="media-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">{{ translate('Global Companies Catalog') }}</h5>
                                <span
                                    class="d-block font-size-sm">{{ translate('Find reliable and verified partners for your business') }}
                                    {{-- TODO: Create verification process page or remove this before release --}}
                                    </a>
                                </span>
                            </div>

                            <div class="col-auto">
                                <a class="btn btn-sm btn-primary" href="{{ route('sellers') }}"
                                    title="{{ translate('Wood Companies Catalog') }}" target="_blank">
                                    {{ translate('Visit') }}
                                    <i class="la la-angle-right "></i>
                                </a>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                </div>
            </li>
            <!-- End List Group Item -->

            <!-- List Group Item -->
            <li class="list-group-item py-3">
                <div class="media">
                    <div class="mt-1 mr-3">
                        <img class="avatar avatar-xs avatar-4by3" src="./assets/svg/brands/google-webdev.svg"
                            alt="Image Description">
                    </div>
                    <div class="media-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">{{ translate('B2BWood Jobs') }}</h5>
                                <span class="d-block font-size-sm">
                                    {{ translate('Get targeted employees matches for your company') }}
                                </span>
                            </div>

                            <div class="col-auto">
                                <a class="btn btn-sm btn-primary disabled" disabled href="#" title="Launch importer"
                                    target="_blank">
                                    {{ translate('Coming Soon') }}
                                    <i class="tio-open-in-new ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                </div>
            </li>

            <li class="list-group-item py-3">
                <div class="media">
                    <div class="mt-1 mr-3">
                        <img class="avatar avatar-xs avatar-4by3" src="./assets/svg/brands/google-webdev.svg"
                            alt="Image Description">
                    </div>
                    <div class="media-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">{{ translate('Business for Sale') }}</h5>
                                <span class="d-block font-size-sm">
                                    {{ translate('List your business for sale or find investment projects or acquisition opportunities') }}
                                </span>
                            </div>

                            <div class="col-auto">
                                <a class="btn btn-sm btn-primary disabled" disabled href="#" title="Launch importer"
                                    target="_blank">
                                    {{ translate('Coming Soon') }}
                                    <i class="tio-open-in-new ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                </div>
            </li>
            <!-- End List Group Item -->
        </ul>
    </div>
    <!-- End Body -->
</div>
