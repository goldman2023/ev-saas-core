<div class="card h-100">
    <!-- Header -->
    <div class="card-header">
        <h5 class="card-header-title">
            {{ translate('Sync your store with external networks') }}
        </h5>

        <!-- Unfold -->
        <div class="hs-unfold">
            <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                data-hs-unfold-options="{
             &quot;target&quot;: &quot;#reportsOverviewDropdown2&quot;,
             &quot;type&quot;: &quot;css-animation&quot;
           }" data-hs-unfold-target="#reportsOverviewDropdown2" data-hs-unfold-invoker="">
                <i class="tio-more-vertical"></i>
            </a>

            <div id="reportsOverviewDropdown2"
                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right mt-1 hs-unfold-hidden hs-unfold-content-initialized hs-unfold-css-animation animated"
                data-hs-target-height="243" data-hs-unfold-content="" data-hs-unfold-content-animation-in="slideInUp"
                data-hs-unfold-content-animation-out="fadeOut" style="animation-duration: 300ms;">
                <span class="dropdown-header">Settings</span>

                <a class="dropdown-item" href="#">
                    <i class="tio-share dropdown-item-icon"></i> Share chart
                </a>
                <a class="dropdown-item" href="#">
                    <i class="tio-download-to dropdown-item-icon"></i> Download
                </a>
                <a class="dropdown-item" href="#">
                    <i class="tio-alt dropdown-item-icon"></i> Connect other apps
                </a>

                <div class="dropdown-divider"></div>

                <span class="dropdown-header">Feedback</span>

                <a class="dropdown-item" href="#">
                    <i class="tio-chat-outlined dropdown-item-icon"></i> Report
                </a>
            </div>
        </div>
        <!-- End Unfold -->
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
        <p>See and talk to your users and leads immediately by importing your data into the Front Dashboard platform.
        </p>

        <ul class="list-group list-group-flush list-group-no-gutters">
            <li class="list-group-item py-3">
                <h5 class="modal-title">
                    {{ translate('Import Products to: ') }}
                </h5>
            </li>

            <!-- List Group Item -->
            @foreach ($integrations as $integration)
                <li class="list-group-item py-3">
                    <div class="media">
                        <div class="mt-1 mr-3">
                            <img class="avatar avatar-xs avatar-4by3" src="./assets/svg/brands/google.svg"
                                alt="Image Description">
                        </div>
                        <div class="media-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0 text-uppercase">{{ $integration }}</h5>
                                    <span class="d-block font-size-sm">{{ translate('products') }}</span>
                                </div>

                                <div class="col-auto">
                                    <a class="btn btn-sm btn-primary" href="#" title="Launch importer" target="_blank">
                                        Launch <span class="d-none d-sm-inline-block">importer</span>
                                        <i class="tio-open-in-new ml-1"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- End Row -->
                        </div>
                    </div>
                </li>

            @endforeach
            <!-- End List Group Item -->

            <li class="list-group-item"><small>Or you can <a href="#">sync data to EV-SaaS Dashboard</a> to ensure your
                    data is always up-to-date.</small></li>
        </ul>
    </div>
    <!-- End Body -->
</div>
