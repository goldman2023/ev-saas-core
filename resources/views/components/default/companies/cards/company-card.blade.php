<div class="card h-100 transition-3d-hover">
    <div class="card-body">
      <div class="mb-4">
        {{-- TODO: Move this to separate css file for company card styles --}}
        <img class="avatar avatar-xxl" style="object-fit:contain; margin-bottom: 10px;"
        src="{{ $company->get_company_logo() }}" alt="{{ $company->name }}">
      </div>

      <span class="d-block small font-weight-bold text-cap mb-1">Founder / CEO</span>
      <h4 class="text-lh-sm">
        <a class="" href="{{ route('shop.visit', $company->slug) }}">
            {{ $company->name }}
        </a>
    </h4>
      <p class="font-size-1">{{ $company->description }}</p>
    </div>

    <div class="card-footer border-0 pt-0">
      <!-- Social Networks -->
      <ul class="list-inline mb-0">
        <li class="list-inline-item">
          <a class="btn btn-xs btn-icon btn-soft-secondary rounded-lg" href="#">
            <i class="fab fa-facebook-f"></i>
          </a>
        </li>
        <li class="list-inline-item">
          <a class="btn btn-xs btn-icon btn-soft-secondary rounded-lg" href="#">
            <i class="fab fa-google"></i>
          </a>
        </li>
        <li class="list-inline-item">
          <a class="btn btn-xs btn-icon btn-soft-secondary rounded-lg" href="#">
            <i class="fab fa-twitter"></i>
          </a>
        </li>
      </ul>
      <!-- End Social Networks -->
    </div>
  </div>
