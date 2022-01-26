@extends('frontend.layouts.' . $globalLayout)


@section('content')
<main id="content" role="main">
    <!-- Search Section -->
    <div class="bg-dark">
      <div class="bg-img-hero-center" style="background-image: url(../assets/svg/components/abstract-shapes-19.svg);">
        <div class="container space-1">
          <div class="w-lg-80 mx-lg-auto">
            <!-- Input -->
            <form class="input-group input-group-merge input-group-borderless">
              <div class="input-group-prepend">
                <span class="input-group-text" id="askQuestions">
                  <i class="fas fa-search"></i>
                </span>
              </div>
              <input type="search" class="form-control" placeholder="Search for answers" aria-label="Search for answers" aria-describedby="askQuestions">
            </form>
            <!-- End Input -->
          </div>
        </div>
      </div>
    </div>
    <!-- End Search Section -->

    <!-- Breadcrumbs Section -->
    <div class="container space-1">
      <div class="w-lg-80 mx-lg-auto">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter font-size-1">
            <li class="breadcrumb-item"><a href="index.html">Front Help Center</a></li>
            <li class="breadcrumb-item active" aria-current="page">Getting started</li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- End Breadcrumbs Section -->

    <!-- FAQ Section -->
    <div class="container space-bottom-2">
      <div class="w-lg-80 mx-lg-auto">
        <a class="card card-frame mb-3 mb-lg-5" href="article-description.html">
          <div class="card-body">
            <!-- Icon Block -->
            <div class="media d-block d-sm-flex">
              <figure class="w-100 max-w-8rem mb-2 mb-sm-0 mr-sm-4">
                <img class="img-fluid" src="../assets/svg/icons/icon-1.svg" alt="SVG">
              </figure>
              <div class="media-body">
                <h2 class="h3">Getting started</h2>
                <p class="font-size-1 text-body">Welcome to Front! We're so glad you're here. Let's get started!</p>

                <div class="media">
                  <!-- Contributors List -->
                  <div class="avatar-group mr-2">
                    <div class="avatar avatar-xs avatar-circle">
                      <img class="avatar-img" src="../assets/img/100x100/img1.jpg" alt="Image Description">
                    </div>
                    <div class="avatar avatar-xs avatar-circle">
                      <img class="avatar-img" src="../assets/img/100x100/img8.jpg" alt="Image Description">
                    </div>
                  </div>
                  <!-- End Contributors List -->

                  <div class="media-body">
                    <!-- Article Authors -->
                    <small class="d-block text-dark">1 article in this collection</small>
                    <small class="d-block text-dark">
                      <span class="text-muted">Written by</span>
                      Luisa Woodfine
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

        <a class="card card-frame mb-3 mb-lg-5" href="article-description.html">
          <div class="card-body">
            <!-- Icon Block -->
            <div class="media d-block d-sm-flex">
              <figure class="w-100 max-w-8rem mb-2 mb-sm-0 mr-sm-4">
                <img class="img-fluid" src="../assets/svg/icons/icon-46.svg" alt="SVG">
              </figure>
              <div class="media-body">
                <h3>Account</h3>
                <p class="font-size-1 text-body">Adjust your profile and preferences to make Front work just for you!</p>

                <div class="media">
                  <!-- Contributors List -->
                  <div class="avatar-group mr-2">
                    <div class="avatar avatar-xs avatar-circle">
                      <img class="avatar-img" src="../assets/img/100x100/img2.jpg" alt="Image Description">
                    </div>
                    <div class="avatar avatar-xs avatar-circle">
                      <img class="avatar-img" src="../assets/img/100x100/img8.jpg" alt="Image Description">
                    </div>
                  </div>
                  <!-- End Contributors List -->

                  <div class="media-body">
                    <!-- Article Authors -->
                    <small class="d-block text-dark">2 article in this collection</small>
                    <small class="d-block text-dark">
                      <span class="text-muted">Written by</span>
                      Fiona Burke, Luisa Woodfine
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

        <a class="card card-frame mb-3 mb-lg-5" href="article-description.html">
          <div class="card-body">
            <!-- Icon Block -->
            <div class="media d-block d-sm-flex">
              <figure class="w-100 max-w-8rem mb-2 mb-sm-0 mr-sm-4">
                <img class="img-fluid" src="../assets/svg/icons/icon-47.svg" alt="SVG">
              </figure>
              <div class="media-body">
                <h3>Data security</h3>
                <p class="font-size-1 text-body">Detailed information on how our customer data is securely stored.</p>

                <div class="media">
                  <!-- Contributors List -->
                  <ul class="list-inline mr-2 mb-0">
                    <li class="list-inline-item mr-0">
                      <div class="avatar avatar-xs avatar-circle">
                        <img class="avatar-img" src="../assets/img/100x100/img10.jpg" alt="Image Description">
                      </div>
                    </li>
                    <li class="list-inline-item ml-n3 mr-0">
                      <div class="avatar avatar-xs avatar-circle">
                        <img class="avatar-img" src="../assets/img/100x100/img4.jpg" alt="Image Description">
                      </div>
                    </li>
                  </ul>
                  <!-- End Contributors List -->

                  <div class="media-body">
                    <!-- Article Authors -->
                    <small class="d-block text-dark">5 article in this collection</small>
                    <small class="d-block text-dark">
                      <span class="text-muted">Written by</span>
                      Fiona Burke, Luisa Woodfine, Neil Galavan
                      <span class="text-muted">and</span>
                      Monica Garcia
                    </small>
                    <!-- End Article Authors -->
                  </div>
                </div>
              </div>
            </div>
            <!-- End Icon Block -->
          </div>
        </a>

        <a class="card card-frame mb-3 mb-lg-5" href="article-description.html">
          <div class="card-body">
            <!-- Icon Block -->
            <div class="media d-block d-sm-flex">
              <figure class="w-100 max-w-8rem mb-2 mb-sm-0 mr-sm-4">
                <img class="img-fluid" src="../assets/svg/icons/icon-52.svg" alt="SVG">
              </figure>
              <div class="media-body">
                <h3>Market</h3>
                <p class="font-size-1 text-body">Some further explanation on when Front can and cannot be used.</p>

                <div class="media">
                  <!-- Contributors List -->
                  <div class="avatar-group mr-2">
                    <div class="avatar avatar-xs avatar-circle">
                      <img class="avatar-img" src="../assets/img/100x100/img9.jpg" alt="Image Description">
                    </div>
                  </div>
                  <!-- End Contributors List -->

                  <div class="media-body">
                    <!-- Article Authors -->
                    <small class="d-block text-dark">3 article in this collection</small>
                    <small class="d-block text-dark">
                      <span class="text-muted">Written by</span>
                      Luisa Woodfine
                    </small>
                    <!-- End Article Authors -->
                  </div>
                </div>
              </div>
            </div>
            <!-- End Icon Block -->
          </div>
        </a>

        <a class="card card-frame mb-3 mb-lg-5" href="article-description.html">
          <div class="card-body">
            <!-- Icon Block -->
            <div class="media d-block d-sm-flex">
              <figure class="w-100 max-w-8rem mb-2 mb-sm-0 mr-sm-4">
                <img class="img-fluid" src="../assets/svg/icons/icon-39.svg" alt="SVG">
              </figure>
              <div class="media-body">
                <h3>Subscription</h3>
                <p class="font-size-1 text-body">Assistance on how and when you might use the subscription product.</p>

                <div class="media">
                  <!-- Contributors List -->
                  <div class="avatar-group mr-2">
                    <div class="avatar avatar-xs avatar-circle">
                      <img class="avatar-img" src="../assets/img/100x100/img10.jpg" alt="Image Description">
                    </div>
                    <div class="avatar avatar-xs avatar-circle">
                      <img class="avatar-img" src="../assets/img/100x100/img9.jpg" alt="Image Description">
                    </div>
                  </div>
                  <!-- End Contributors List -->

                  <div class="media-body">
                    <!-- Article Authors -->
                    <small class="d-block text-dark">2 article in this collection</small>
                    <small class="d-block text-dark">
                      <span class="text-muted">Written by</span>
                      Fiona Burke, Luisa Woodfine
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

        <a class="card card-frame mb-3 mb-lg-5" href="article-description.html">
          <div class="card-body">
            <!-- Icon Block -->
            <div class="media d-block d-sm-flex">
              <figure class="w-100 max-w-8rem mb-2 mb-sm-0 mr-sm-4">
                <img class="img-fluid" src="../assets/svg/icons/icon-24.svg" alt="SVG">
              </figure>
              <div class="media-body">
                <h3>Tips, tricks &amp; more</h3>
                <p class="font-size-1 text-body">Tips and tools for beginners and experts alike.</p>

                <div class="media">
                  <!-- Contributors List -->
                  <div class="avatar-group mr-2">
                    <div class="avatar avatar-xs avatar-circle">
                      <img class="avatar-img" src="../assets/img/100x100/img2.jpg" alt="Image Description">
                    </div>
                    <div class="avatar avatar-xs avatar-circle">
                      <img class="avatar-img" src="../assets/img/100x100/img4.jpg" alt="Image Description">
                    </div>
                  </div>
                  <!-- End Contributors List -->

                  <div class="media-body">
                    <!-- Article Authors -->
                    <small class="d-block text-dark">1 article in this collection</small>
                    <small class="d-block text-dark">
                      <span class="text-muted">Written by</span>
                      Luisa Woodfine
                      <span class="text-muted">and</span>
                      Monica Garcia
                    </small>
                    <!-- End Article Authors -->
                  </div>
                </div>
              </div>
            </div>
            <!-- End Icon Block -->
          </div>
        </a>
      </div>
    </div>
    <!-- End FAQ Section -->
  </main>
@endsection
