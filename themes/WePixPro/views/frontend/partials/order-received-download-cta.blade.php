<section class="py-4 md:py-6 border-b border-gray-200" style="background-image: url('flex-ui-assets/elements/pattern-white.svg'); background-position: center;">
    <div class="container px-4 mx-auto">
      <div class="flex flex-wrap items-center -mx-4">
        <div class="w-full md:w-1/2 px-0 md:px-4 mb-6 md:mb-0">
          <div class="max-w-md">
            <h2 class="mb-2 text-18 md:text-20 font-heading font-bold">{{ translate('Download Pixpro photogrammetry software') }}</h2>
            <p class="text-14 md:text-16 font-heading font-medium text-gray-600">
                {!! translate('Once you download software, get your license from your dashboard and start using our software!') !!}
            </p>
          </div>
        </div>
        <div class="w-full md:w-1/2 px-0 md:px-4">
          <div class="flex flex-wrap items-center md:justify-end">
            <a class="btn-primary" href="{{ get_tenant_setting('pix_pro_software_download_url') }}" target="_blank">{{ translate('Download') }}</a>
        </div>
      </div>
    </div>
</section>
