<div class="relative isolate bg-white py-24 px-6 sm:py-16 lg:px-8">
    <svg class="absolute inset-0 -z-10 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
      <defs>
        <pattern id="83fd4e5a-9d52-42fc-97b6-718e5d7ee527" width="200" height="200" x="50%" y="-64" patternUnits="userSpaceOnUse">
          <path d="M100 200V.5M.5 .5H200" fill="none" />
        </pattern>
      </defs>
      <svg x="50%" y="-64" class="overflow-visible fill-gray-50">
        <path d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M299.5 800h201v201h-201Z" stroke-width="0" />
      </svg>
      <rect width="100%" height="100%" stroke-width="0" fill="url(#83fd4e5a-9d52-42fc-97b6-718e5d7ee527)" />
    </svg>
    <div class="mx-auto max-w-xl lg:max-w-4xl">
      <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-gray-900">
        {{ translate('Reikia pagalbos? Susisiekite') }}
      </h1>
      <p class="mt-2 text-lg leading-8 text-gray-600">
        {{ translate('Tero priekabų atstovai pakonsultuos ir atsakys į visus kylančius klausimus.') }}
      </p>
      <div class="mt-16 flex flex-col gap-16 sm:gap-y-20 lg:flex-row">
        <livewire:forms.contact-form />
        <div class="lg:mt-6 lg:w-80 lg:flex-none">
          <img class="h-12 w-auto" src="{{ get_site_logo() }}" alt="{{ get_site_name() }}">
          <figure class="mt-10">
            <blockquote class="text-lg font-semibold leading-8 text-gray-900">
              <p>
                {{ get_tenant_setting('company_name') }}

              </p>
            </blockquote>
            <p>
                {{ get_tenant_setting('company_email') }}
            </p>
            <p>
                {{ get_tenant_setting('company_address') }}, {{ get_tenant_setting('company_city') }}, {{ get_tenant_setting('company_country') }} <br>
                {{ translate('Company Code') }}:  {{ get_tenant_setting('company_number') }} <br>
                {{ translate('Company VAT Code') }}:  {{ get_tenant_setting('company_vat') }}

            </p>
            <figcaption class="mt-10 flex gap-x-6 mb-6">
              <img src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=96&h=96&q=80" alt="" class="h-12 w-12 flex-none rounded-full bg-gray-50">
              <div>
                <div class="text-base font-semibold text-gray-900">Klientų aptarnavimas</div>
                <div class="text-sm leading-6 text-gray-600">{{ translate('8 (671) 81007') }}</div>
                {{-- TODO: Add tenant setting for opening hours --}}
                <small>{{ translate('Darbo dienomis 8h - 18h') }} </small>
              </div>
            </figcaption>

            <div>
                <a class="btn-primary w-full" href="/dashboard/">
                    {{ translate('Klientų savitarna') }}
                </a>
            </div>
          </figure>
        </div>
      </div>
    </div>
  </div>
