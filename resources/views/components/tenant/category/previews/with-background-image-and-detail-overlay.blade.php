<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white">
    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:mx-auto">
      <div class="relative rounded-lg overflow-hidden lg:h-96">
        <div class="absolute inset-0">
            {{-- TODO: Refactor and fix this, sorry quick dirty update --}}
          <img
          style="    object-fit: cover;
          width: 100%;
          object-position: 0px -390px;"
          src="https://253qv1sx4ey389p9wtpp9sj0-wpengine.netdna-ssl.com/wp-content/uploads/2018/02/Wine_Club_2-700x461.jpg">
        </div>
        <div aria-hidden="true" class="relative w-full h-96 lg:hidden"></div>
        <div aria-hidden="true" class="relative w-full h-32 lg:hidden"></div>
        <div class="absolute inset-x-0 bottom-0 bg-black bg-opacity-75 p-6 rounded-bl-lg rounded-br-lg backdrop-filter backdrop-blur sm:flex sm:items-center sm:justify-between lg:inset-y-0 lg:inset-x-auto lg:w-96 lg:rounded-tl-lg lg:rounded-br-none lg:flex-col lg:items-start">
          <div>
            <h2 class="text-xl font-bold text-white">
                {{ translate('Wine Club') }}
            </h2>
            <p class="mt-1 text-sm text-gray-300">
                {{ translate('Get your favorite beverages to your door every month or week')}}
            </p>
          </div>
          <a href="#" class="mt-6 flex-shrink-0 flex bg-white bg-opacity-0 py-3 px-4 border border-white border-opacity-25 rounded-md items-center justify-center text-base font-medium text-white hover:bg-opacity-10 sm:mt-0 sm:ml-8 lg:ml-0 lg:w-full">
              {{ translate('View Wine Club Memberships') }}
            </a>
        </div>
      </div>
    </div>
  </div>
