<div class="card h-100">
    <!-- Header -->
    <div class="card-header">
        <h5 class="card-header-title">
            {{ translate('Sync your store with external networks') }}
        </h5>
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
        <p>
        </p>

        <ul class="list-group list-group-flush list-group-no-gutters">
            <li class="list-group-item py-3">
                <h5 class="modal-title">
                    {{ translate('Import Products to: ') }}
                </h5>
            </li>

            <!-- List Group Item -->
            <div class="grid grid-cols-4 gap-20">
            @foreach ($integrations as $integration)
                <li class="list-group-item py-3 gap-20">
                    <div class="media">
                        <div class="mt-1 mr-3">
                            <img class="w-20" src="./assets/svg/brands/google.svg"
                                alt="Image Description">
                        </div>
                        <div class="media-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <span class="d-block font-size-sm">{{ translate('Import') }}</span>
                                    <h5 class="h5">{{ $integration }}</h5>
                                    <span class="d-block font-size-sm">{{ translate('products') }}</span>
                                </div>

                                <div class="col-auto">
                                    <a class="btn btn-sm btn-primary" href="{{ route('integrations.index') }}" title="Launch importer" >
                                        {{ translate('Launch importer') }}
                                        <i class="tio-open-in-new ml-1"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- End Row -->
                        </div>
                    </div>
                </li>

            @endforeach
            </div>
            <!-- End List Group Item -->

            <li class="list-group-item"><small>Or you can <a href="#">sync data to EV-SaaS Dashboard</a> to ensure your
                    data is always up-to-date.</small></li>
        </ul>
    </div>
    <!-- End Body -->
</div>
