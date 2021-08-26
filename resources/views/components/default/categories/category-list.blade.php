<div>
    <!-- Component used: https://htmlstream.com/front/snippets/ecommerce.html#component-1 -->

    <!-- Categories Section -->
<div class="container space-2">
    <!-- Title -->
    <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-5 mb-md-9">
      <h2>The better way to shop with Front top-products</h2>
    </div>
    <!-- End Title -->
    <div class="row mb-2">
  
    @for($i = 0; $i < 3; $i++)
      <div class="col-md-4 mb-3">
        <!-- Card -->
        <div class="card card-bordered shadow-none d-block">
          <div class="card-body d-flex align-items-center p-0">
            <div class="w-65 border-right">
              <img class="img-fluid" src="https://www.timberindustrynews.com/wp-content/uploads/2018/05/Holzindustrie-Schweighofer-timber-310x220.jpg" alt="Image Description">
            </div>
            <div class="w-35">
              <div class="border-bottom">
                <img class="img-fluid" src="https://www.timberindustrynews.com/wp-content/uploads/2018/05/Holzindustrie-Schweighofer-timber-310x220.jpg" alt="Image Description">
              </div>
              <img class="img-fluid" src="https://www.timberindustrynews.com/wp-content/uploads/2018/05/Holzindustrie-Schweighofer-timber-310x220.jpg" alt="Image Description">
            </div>
          </div>
          <div class="card-footer d-block text-center py-4">
            <h3 class="mb-1">T-shirts</h3>
            <span class="d-block text-muted font-size-1 mb-3">Starting from $29.99</span>
            <a class="btn btn-sm btn-outline-primary btn-pill transition-3d-hover px-5" href="#">View All</a>
          </div>
        </div>
        <!-- End Card -->
      </div>
  
      
    @endfor
</div>
  
    <div class="text-center">
      <p class="small">Limited time only, while stocks last.</p>
    </div>
  </div>
  <!-- End Categories Section -->
</div>