@extends('frontend.layouts.' . $globalLayout)


@section('content')
<div class="container space-bottom-2">
    <div class="w-lg-80 mx-lg-auto">
      <!-- Breadcrumbs -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-no-gutter font-size-1 space-1">
          <li class="breadcrumb-item"><a href="index.html">Front Help Center</a></li>
          <li class="breadcrumb-item"><a href="listing.html">Getting started</a></li>
          <li class="breadcrumb-item active" aria-current="page">What's Front?</li>
        </ol>
      </nav>
      <!-- End Breadcrumbs -->

      <!-- Article -->
      <div class="card card-bordered p-4 p-md-7">
        <h1 class="h2">What's Front?</h1>
        <p>How Front works, what it can do for your business and what makes it different to other solutions.</p>

        <!-- Article Authors -->
        <div class="media mb-5">
          <div class="avatar avatar-xs avatar-circle mr-2">
            <img class="avatar-img" src="../assets/img/100x100/img1.jpg" alt="Image Description">
          </div>

          <div class="media-body">
            <small class="d-block">
              <span class="text-muted">Written by</span>
              <span class="text-dark">Luisa Woodfine</span>
            </small>
            <small class="d-block text-body">
              Updated over a week ago
            </small>
          </div>
        </div>
        <!-- End Article Authors -->

        <p>Front is an incredibly beautiful, fully responsive, and mobile-first projects on the web – it is the perfect starting point for any creative and professional sites. Get started with Front's components and options for laying out your Front project, including SVG components, powerful scripts, fully detailed documentation, and yet developer friendly code.</p>

        <h2 class="h3">Free updates and support</h2>
        <p>We would like to draw your attention to the fact that after purchasing a Front Template copy, you get the right for a <span class="font-weight-bold">lifetime</span> entitlement to download updates for <span class="font-weight-bold">FREE!</span> Need help? For any questions or concerns, reach us out at <a href="mailto:hello@example.com">hello@example.com</a>.</p>

        <ul class="list-article">
          <li><span class="font-weight-bold">Free updates:</span> Front offers a lifetime free updates. This means you will never pay for any bug-fixes and compatibility upgrades for your theme, ever.</li>
          <li><span class="font-weight-bold">Technical support:</span> As always, our Customer Support team is available 24/7 to answer any questions you might have. We will do our best to get back to you within <span class="font-weight-bold">24-48 hours</span>.</li>
        </ul>

        <p>Front Template is built by the team that has customers in the background such us Stanford University, The University of Maryland, University of Victoria and many more Governments, Corporate Agencies. To bring the most modern look of any HTML5 template across all Marketplaces – powered by Bootstrap 4, Front sets the new standard with breathtaking design, top-notch support, and incredible featured packed updates that will save your precious time and gives trendy look to all your web projects. On top of that the creators of Bootstrap have closely monitored the ongoing process of the Front and helped to achieve an enormous result.</p>

        <!-- Resolved -->
        <div class="text-center border-top border-bottom my-6 py-6">
          <h4 class="mb-4">
            <i class="far fa-paper-plane mr-1"></i>
            Was this article helpful?
          </h4>

          <button type="button" class="btn btn-sm btn-primary btn-wide mb-2 mx-1">Yes, thanks!</button>
          <button type="button" class="btn btn-sm btn-soft-primary btn-wide mb-2 mx-1">Not really</button>
        </div>
        <!-- End Resolved -->

        <!-- Related Articles -->
        <div class="mb-4">
          <h3 class="h5">Related articles</h3>
        </div>

        <ul class="list-unstyled list-article">
          <li><a class="link-underline" href="index.html">Troubleshoot connection issues</a></li>
          <li><a class="link-underline" href="index.html">Getting started for workspace creators</a></li>
          <li><a class="link-underline" href="index.html">Edit your profile</a></li>
        </ul>
        <!-- End Related Articles -->
      </div>
      <!-- End Article -->
    </div>
  </div>
@endsection
