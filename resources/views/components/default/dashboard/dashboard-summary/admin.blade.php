<div class="card mb-3 mb-lg-5">
    <!-- Header -->
    <div class="card-header">
      <h5 class="card-header-title">{{ "Welcome to your store!" }}</h5>

      <a class="btn btn-sm btn-ghost-secondary" href="#">
        <i class="fas fa-file-download mr-1"></i>
        {{ translate('Manage orders') }}
      </a>
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
      <div class="row">
        <div class="col-md-7 mb-4 mb-md-0">
          <div class="mb-4">
            <small class="text-cap">{{ translate('Pending orders:') }} </small>
            {{-- TODO: Make this actually number, for single vendor, and admin respectivley --}}
            <h5>3</h5>

          </div>

          <div>
            <small class="text-cap">{{ translate('Total Sales:') }}</small>
            <h3 class="text-primary">€264</h3>
          </div>
        </div>

        <div class="col-md-5 text-md-right">
          <a class="btn btn-sm btn-white mr-1 mb-0 mb-md-2" href="#">{{ translate('Book support meeting') }}</a>
          <a class="btn btn-sm btn-primary transition-3d-hover mb-0 mb-md-2" href="{{ route('ev-products.index') }}">
            {{ translate('Manage Products') }}
        </a>
        </div>
      </div>
    </div>
    <!-- End Body -->

    <hr class="my-3">

    <!-- Body -->
    <div class="card-body">
      <div class="row align-items-center flex-grow-1 mb-2">
        <div class="col">
          <h4 class="card-header-title">Storage usage</h4>
        </div>

        <div class="col-auto">
          <strong class="text-dark">4.27 GB</strong> used of 6 GB
        </div>
      </div>

      <!-- Progress -->
      <div class="progress rounded-pill mb-3">
        <div class="progress-bar" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar opacity" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <!-- End Progress -->

      <!-- Legend Indicators -->
      <div class="list-inline">
        <div class="list-inline-item">
          <span class="legend-indicator bg-primary"></span>Personal usage space
        </div>
        <div class="list-inline-item">
          <span class="legend-indicator bg-primary opacity"></span>Shared space
        </div>
        <div class="list-inline-item">
          <span class="legend-indicator"></span>Unused space
        </div>
      </div>
      <!-- End Legend Indicators -->
    </div>
    <!-- End Body -->
  </div>
