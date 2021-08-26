<!-- Hero Section -->
<div class="gradient-x-overlay-sm-indigo position-relative overflow-hidden">
    <div class="container space-top-3 space-top-lg-3 space-bottom-2">
      <div class="w-lg-60 text-center mx-lg-auto">
        <div class="mb-5">
            <x-ev.label 
            tag="h1"
            class="display-4 mb-3"
            :label="ev_dynamic_translate('Hero 14 Title')">
            </x-ev.label>  
          <p class="lead">
            <x-ev.label 
            :label="ev_dynamic_translate('Hero 14 Description')">
            </x-ev.label>  
            </p>
        </div>

        
        <x-ev.link-button :href="ev_dynamic_translate('#hero-14-button-link')"
        :label="ev_dynamic_translate('Button Hero 14')" class="btn btn-soft-indigo transition-3d-hover">
        </x-ev.link-button>
        
        <small class="text-muted my-3 my-sm-0 mx-2 mx-sm-3">
            {{ translate('or') }}
        </small>

        <x-ev.link-button :href="ev_dynamic_translate('#hero-14-button-link-2')"
        :label="ev_dynamic_translate('Button 2 Hero 14')" class="btn btn-primary transition-3d-hover">
        <i class="fas fa-angle-right ml-1"></i>
        </x-ev.link-button>
      </div>
    </div>
  
    <!-- Mockup -->
    <div class="container space-2">
      <div class="position-relative w-lg-75 text-center mx-lg-auto">
        <div class="position-relative shadow-lg z-index-2 rounded-lg" data-aos="fade-up" data-aos-offset="-50">
          <iframe width="100%" height="500" src="https://www.youtube-nocookie.com/embed/mgnTOjIyt_M?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
  
        <figure class="max-w-15rem w-100 position-absolute top-0 right-0" data-aos="fade-up" data-aos-delay="100" data-aos-offset="-50">
          <div class="mt-n11 mr-n11">
            <img class="img-fluid" src="/assets/svg/components/dots-1.svg" alt="Image Description">
          </div>
        </figure>
        <figure class="max-w-15rem w-100 position-absolute bottom-0 left-0" data-aos="fade-up">
          <div class="mb-n7 ml-n7">
            <img class="img-fluid" src="/assets/svg/components/dots-1.svg" alt="Image Description">
          </div>
        </figure>
      </div>
    </div>
    <!-- End Mockup -->
  
    <!-- SVG Background Shape -->
    {{-- <figure class="w-35 position-absolute top-0 right-0 z-index-n1 mt-n11 mr-n11">
      <img class="img-fluid" src="/assets/svg/components/half-circle-1.svg" alt="Image Description">
    </figure>
  
    <figure class="w-25 position-absolute bottom-0 left-0 z-index-n1 mb-n11 ml-n11">
      <img class="img-fluid" src="/assets/svg/components/half-circle-2.svg" alt="Image Description">
    </figure> --}}
    <!-- End SVG Background Shape -->
  </div>
  <!-- End Hero Section -->