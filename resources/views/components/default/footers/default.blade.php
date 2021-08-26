<!-- ========== FOOTER ========== -->
<footer class="container space-1">
    <div class="row align-items-md-center text-center">
      <div class="col-md-3 mb-4 mb-md-0">
        <a href="#" aria-label="Front">
            @if (get_setting('header_logo') != null)
            <img class="lazyload" src="{{ uploaded_asset(get_setting('header_logo')) }}"
                 data-src="{{ uploaded_asset(get_setting('header_logo')) }}" alt="{{ get_site_name() }}"
                 height="44">
        @else
            <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                 data-src="{{ static_asset('assets/img/logo.png') }}" alt="{{ get_site_name() }}"
                 height="44">
        @endif
        </a>
      </div>
  
      <div class="col-sm-7 col-md-6 mb-4 mb-sm-0">
        <!-- Nav List -->
        <ul class="nav nav-sm nav-x-0 justify-content-center text-md-center">
          <li class="nav-item px-3">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item px-3">
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item px-3">
            <a class="nav-link" href="#">Our work</a>
          </li>
        </ul>
        <!-- End Nav List -->
      </div>
  
      <div class="col-sm-5 col-md-3 text-sm-right">
        <!-- Social Networks -->
        <ul class="list-inline mb-0">
          <li class="list-inline-item">
            <a class="btn btn-xs btn-icon btn-soft-secondary rounded-circle" href="#">
              <i class="fab fa-facebook-f"></i>
            </a>
          </li>
          <li class="list-inline-item">
            <a class="btn btn-xs btn-icon btn-soft-secondary rounded-circle" href="#">
              <i class="fab fa-google"></i>
            </a>
          </li>
          <li class="list-inline-item">
            <a class="btn btn-xs btn-icon btn-soft-secondary rounded-circle" href="#">
              <i class="fab fa-twitter"></i>
            </a>
          </li>
          <li class="list-inline-item">
            <a class="btn btn-xs btn-icon btn-soft-secondary rounded-circle" href="#">
              <i class="fab fa-github"></i>
            </a>
          </li>
        </ul>
        <!-- End Social Networks -->
      </div>
    </div>
  </footer>
  <!-- ========== END FOOTER ========== -->