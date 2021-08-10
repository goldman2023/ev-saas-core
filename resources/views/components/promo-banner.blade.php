@if(isset($heading) && isset($body) && isset($buttonText) && isset($imageSource))
<div class="container">
  <div class="bg-light rounded-lg overflow-hidden space-top-2 space-top-lg-1 pl-5 pl-md-8">
    <div class="row justify-content-lg-between align-items-lg-center no-gutters">
      <div class="col-lg-4">
        <div class="mb-4">
          <h2 class="h1">{{ translate($heading) }}</h2>
          <p>{{ translate($body) }}</p>
        </div>
        <a class="btn btn-primary btn-wide transition-3d-hover" href="{{ route('shops.create') }}">{{ translate($buttonText) }}</a>
      </div>

      <div class="col-lg-7 space-top-1 space-top-sm-2 ml-auto">
        <img class="img-fluid shadow-lg" src="{{ static_asset($imageSource) }}" alt="Image Description">
      </div>
    </div>
  </div>
</div>
@endif
