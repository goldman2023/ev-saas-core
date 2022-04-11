<section class="relative {!! $getSectionSettingsClasses !!}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="sm:flex sm:flex-col sm:align-center mb-[40px]">
        {{-- <h1 class="text-5xl font-extrabold text-gray-900 sm:text-center">Pricing Plans</h1>
        <p class="mt-5 text-xl text-gray-500 sm:text-center">Start building for free, then add a site plan to go live. Account plans unlock additional features.</p> --}}
        <div class="relative self-center bg-gray-100 rounded-lg p-0.5 flex ">
          <button type="button" class="relative w-1/2 bg-white border-gray-200 rounded-md shadow-sm py-2 text-sm font-medium text-gray-900 whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:z-10 sm:w-auto sm:px-8">Monthly billing</button>
          <button type="button" class="ml-0.5 relative w-1/2 border border-transparent rounded-md py-2 text-sm font-medium text-gray-700 whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:z-10 sm:w-auto sm:px-8">Yearly billing</button>
        </div>
      </div>


      <div class="grid gap-10 grid-cols-12">
        @if($models->isNotEmpty())
          @foreach($models as $model)
            <div class="col-span-12 sm:col-span-6 lg:col-span-3">
              <div class=" flex flex-col justify-between px-4 py-4 border-gray-300 hover:border-primary border rounded transition-all duration-300 hover:shadow-green" style="height: 505px;">
                  <div class="price-description">
                      <h3 class="font-bold text-18 text-gray-700 pb-2">{{ $model->name }}</h3>
                      <div class="flex items-end">
                          <h3 class="text-36 text-dark font-bold mb-0">{{ $model->getTotalPrice(true) }}</h3>
                          <span class="text-lg2 text-dark font-bold mb-2">/{{ translate('month') }}</span>
                      </div>
                      <p class=" text-sm text-lightDark py-6 mb-4">
                        {{ $model->excerpt }}
                      </p>
                  
                      <div class="w-full space-y-3">
                        @if(!empty($model->features))
                          @foreach($model->features as $feature)
                            <div class="d-flex mb-2 flex items-center gap-3">
                              @svg('heroicon-s-check-circle', ['class' => 'w-5 h-5 text-primary'])
                                <p class="text-sm text-gray-700 mb-0">{{ $feature }}</p>
                            </div>
                          @endforeach
                        @endif
                      </div>
                  </div>
                  <div>
                      <a href="#" class="bg-transparent transition-all duration-300 mx-auto block text-center hover:border-none  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2 px-14 rounded-lg">
                          {{ translate('Try it free') }}
                      </a>
                  </div>
              </div>
            </div>
          @endforeach
        @endif
        
      </div>

      <div class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-4">

        @if($models->isNotEmpty())
          @foreach($models as $model)
            <div class="border border-gray-200 rounded-lg shadow-sm divide-y divide-gray-200">
              <div class="p-6">
                <h2 class="text-lg leading-6 font-medium text-gray-900">{{ $model->name }}</h2>
                <p class="mt-4 text-sm text-gray-500 line-clamp-2">{{ $model->excerpt }}</p>
                <p class="mt-8">
                  <span class="text-4xl font-extrabold text-gray-900">{{ $model->getTotalPrice(true) }}</span>
                  <span class="text-base font-medium text-gray-500">/mo</span>
                </p>
                <a href="#" class="mt-8 block w-full bg-gray-800 border border-gray-800 rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-gray-900">Buy Hobby</a>
              </div>
              <div class="pt-6 pb-8 px-6">
                <h3 class="text-xs font-medium text-gray-900 tracking-wide uppercase">What's included</h3>
                <ul role="list" class="mt-6 space-y-4">
                  <li class="flex space-x-3">
                    <!-- Heroicon name: solid/check -->
                    <svg class="flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm text-gray-500">Potenti felis, in cras at at ligula nunc.</span>
                  </li>
      
                  <li class="flex space-x-3">
                    <!-- Heroicon name: solid/check -->
                    <svg class="flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm text-gray-500">Orci neque eget pellentesque.</span>
                  </li>
                </ul>
              </div>
            </div>
          @endforeach
        @endif
        
      </div>
    </div>
</section>