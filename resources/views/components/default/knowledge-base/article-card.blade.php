<a class="card card-frame h-100" href="{{ route('knowledge-base.show', 1) }}">
    <div class="card-body">
      <!-- Icon Block -->
      <div class="media d-block d-sm-flex">
        <figure class="w-100 max-w-8rem mb-2 mb-sm-0 mr-sm-4">
          <img class="img-fluid" src="../assets/svg/icons/icon-1.svg" alt="SVG">
        </figure>
        <div class="media-body">
          <h2 class="h3">Getting started</h2>
          <p class="font-size-1 text-body">Welcome to We-SaaS! We're so glad you're here. Let's get started!</p>

          <div class="media">
            <!-- Contributors List -->
            <div class="avatar-group mr-2">
              <div class="avatar avatar-xs avatar-circle">
                <img class="avatar-img" src="{{ $user->getAvatar() }}" alt="Image Description">
              </div>

            </div>
            <!-- End Contributors List -->

            <div class="media-body">
              <!-- Article Authors -->
              <small class="d-block text-dark">1 article in this collection</small>
              <small class="d-block text-dark">
                <span class="text-muted">Written by</span>
                {{ $user->name }}
                <span class="text-muted">and</span>
                Neil Galavan
              </small>
              <!-- End Article Authors -->
            </div>
          </div>
        </div>
      </div>
      <!-- End Icon Block -->
    </div>
  </a>
