<!-- Responsive Toggle Button -->
<button type="button" class="navbar-toggler btn btn-icon btn-sm rounde-circle d-lg-none"
        aria-label="Toggle navigation"
        aria-expanded="false"
        aria-controls="sidebarNav"
        data-toggle="collapse"
        data-target="#sidebarNav">
  <span class="navbar-toggler-default">
    <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
      <path fill="currentColor" d="M17.4,6.2H0.6C0.3,6.2,0,5.9,0,5.5V4.1c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,5.9,17.7,6.2,17.4,6.2z M17.4,14.1H0.6c-0.3,0-0.6-0.3-0.6-0.7V12c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,13.7,17.7,14.1,17.4,14.1z"/>
    </svg>
  </span>
    <span class="navbar-toggler-toggled">
    <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
      <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
    </svg>
  </span>
</button>
<!-- End Responsive Toggle Button -->

<!-- Navbar -->
<div class="navbar-expand-lg navbar-expand-lg-collapse-block navbar-light">
    <div id="sidebarNav" class="collapse navbar-collapse navbar-vertical">
        <!-- Card -->
        <div class="card">
            <div class="card-body">
                <!-- Avatar -->
                @auth
                <div class="d-none d-lg-block text-center mb-5">
                    <div class="avatar avatar-xxl avatar-circle mb-3">
                        {{-- TODO: Make this store logo, but think that users can have this --}}
                        <img class="avatar-img" src="{{ Auth::user()->getUpload('avatar') ?: 'https://htmlstream.com/front/assets/img/160x160/img1.jpg' }}" alt="Image Description">
                        <img class="avatar-status avatar-lg-status" src="assets/svg/illustrations/top-vendor.svg" alt="Image Description" data-toggle="tooltip" data-placement="top" title="Verified user">
                    </div>

                    {{-- TODO: Show Business info here instead of user info! (for both single-vendor and multi-vendor apps) --}}
                    <h4 class="card-title">{{ Auth::user()->name }}</h4>
                    <p class="card-text font-size-1">{{ Auth::user()->email }}</p>
                </div>
                @else
                {{-- TODO: Add Guest Register empty state --}}
                @endauth
                <!-- End Avatar -->

                {{-- TODO: Add role-dependent menu items for Customers - purchase history, downloads, wallet, schedules (for bookable services), user settings etc. --}}
                {{-- TODO: Add role-dependent menu items for Sellers(multi-vendor). --}}
                {{-- IMPORTANT: Do not add admin-dependent menu items, like global SaaS settings and all sellers CRUD etc. We already have this in Admin panel! --}}

                @if($menu = \EVS::getVendorMenuByRole('admin'))
                    @foreach($menu as $section)
                        @if($section['label'] === 'hr')
                            <div class="dropdown-divider"></div>
                        @else
                            <h6 class="text-cap small">{{ $section['label'] }}</h6>
                        @endif

                        @if(!empty($section['items']))
                            <ul class="nav nav-sub nav-sm nav-tabs nav-list-y-2 mb-4">

                                @foreach($section['items'] as $item)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $item['is_active'] }}" href="{{ $item['route'] }}">
                                            @svg($item['icon'], ['class' => 'nav-icon'])
                                            {{ $item['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        <!-- End Card -->
    </div>
</div>
<!-- End Navbar -->
