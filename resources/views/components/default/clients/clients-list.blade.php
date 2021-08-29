<div class="container space-1">
    <div class="w-lg-75 mx-lg-auto">
      <div class="text-center mb-4">

        <x-ev::label
        tag="h2"
        class="divider divider-text"
        :label="ev_dynamic_translate('Clients List Title')">
        </x-ev::label>
      </div>

      <div class="row justify-content-between text-center">
        @php
            $clients = [0,0,0,0];
        @endphp
        @foreach($clients as $key => $client)
        <div class="col-4 col-lg-2 mb-5 mb-lg-0">
          <div class="mx-3">
              {{-- <x-tenant.system.image :image="ev_dynamic_translate('#clients-list-image-{{ $key }}')">
              </x-tenant.system.image> --}}
            <img class="max-w-11rem max-w-md-13rem mx-auto" src="https://www.lrt.lt/media/logo/LTV1.jpg" alt="Image Description">
          </div>
        </div>
        @endforeach




      </div>
    </div>
  </div>
