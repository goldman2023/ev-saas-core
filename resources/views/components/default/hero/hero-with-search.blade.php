<!-- Hero Section -->
<div class="container space-2">
    <div class="row justify-content-lg-between align-items-lg-center">
      <div class="col-sm-10 col-lg-4 mb-7 mb-lg-0">
        <x-ev.dynamic-image
        class="img-fluid"
        :src="ev_dynamic_translate('#hero-with-search-image')" alt="Product Hero"
        >
        </x-ev.dynamic-image>
      </div>

      <div class="col-md-6">
        <div class="mb-5">
          <h1 class="display-3 mb-3">
            <x-ev.label tag="span" class="text-info" :label="ev_dynamic_translate('Unlock your potential')">
            </x-ev.label>
          </h1>
            <x-ev.label tag="p" class="text-info lead" :label="ev_dynamic_translate('With our platform, you can quantify your skills, grow in your role and stay relevant on critical topics.')">
            </x-ev.label>
        </div>

        <div class="d-sm-flex align-items-sm-center flex-sm-wrap">
          <x-ev.link-button :href="ev_dynamic_translate('#button1')"
          :label="ev_dynamic_translate('Button 1')" class="ev-button btn btn-primary transition-3d-hover mb-2">
          </x-ev.link-button>
          <div class="mx-2"></div>
          <x-ev.link-button :href="ev_dynamic_translate('#button1')"
          :label="ev_dynamic_translate('Button 2')" class="ev-button btn btn-secondary transition-3d-hover mb-2">
          </x-ev.link-button>

        </div>
      </div>
    </div>
  </div>
  <!-- End Hero Section -->
