<!-- Hero Section -->
<div class="position-relative space-top-3" style="overflow: hidden;">
    <div class="container position-relative  space-bottom-2 space-bottom-md-3 space-bottom-xl-3" style="z-index: 99;">
        <div class="row position-relative mt-md-n5">
            <div class="col-md-8 mb-7 mb-md-0">
                <!-- Title -->
                <div class="w-md-75 mb-7">
                    <x-ev.label tag="h1" class="h1 text-white"
                        :label="ev_dynamic_translate('Subscribe to our newsletter', true)"></x-ev.label>

                    <x-ev.label tag="p" class=""
                        :label="ev_dynamic_translate('Newsletter Subscribe Description', true)"></x-ev.label>


                </div>
                <!-- End Title -->

                <!-- Card -->
                <div class="card p-2 mb-3">
                    <!-- Input Group -->
                    <div class="form-row">
                        <div class="col-sm mb-2 mb-sm-0">
                            <div class="input-group input-group-merge input-group-borderless">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>

                                <input type="text" class="form-control" name="newsletter_hero_primary"
                                    placeholder="{{ ev_dynamic_translate('Subscribe to our newsletter', true)->value }}">
                            </div>
                        </div>

                        <div class="col-sm-auto">
                            <button type="button" class="btn btn-block btn-primary px-5">
                                {{ translate('Subscribe') }}
                            </button>
                        </div>
                    </div>
                    <!-- End Input Group -->
                </div>
                <!-- End Card -->
                <x-ev.label tag="span" class="form-text"
                    :label="ev_dynamic_translate('732 Subscribers in last 90 days', true)"></x-ev.label>

            </div>
        </div>
        <!-- End Row -->

        <div class="col-md-6 position-md-absolute top-0 right-0 overflow-hidden" style="overflow: hidden; z-index: -1;">
            <img class="img-fluid"
                src="https://www.morningbrew.com/_next/image?url=https%3A%2F%2Fcdn.sanity.io%2Fimages%2Fbl383u0v%2Fproduction%2Fe8d4891806bfc63474933f1430527ba8e907ccb7-496x956.png&w=1920&q=75"
                alt="Image Description">

            <figure class="max-w-15rem w-100 position-absolute bottom-0 right-0 z-index-n1 overflow-hidden">
                <div class="mb-n7 mr-n7">
                    <img class="img-fluid" src="/assets/svg/components/dots-1.svg" alt="Image Description">
                </div>
            </figure>
        </div>
    </div>

    <div class="col-md-10 position-absolute top-0 left-0 z-index-n1 gradient-y-three-sm-primary h-100"
        style="background-size: calc(1000px + (100vw - 1000px) / 2);"></div>
</div>
<!-- End Hero Section -->
