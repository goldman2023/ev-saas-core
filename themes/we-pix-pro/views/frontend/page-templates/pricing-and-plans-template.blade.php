@include('components.custom.pix-pro-page-header', [
    'header_title' => translate('Plans & Pricing'),
    'header_subtitle' => null,
])


@php
    $models = \App\Models\Plan::published()->get();
@endphp
<section class="relative  lg:pt-[80px]  lg:pb-[80px]  sm:pt-[60px]  sm:pb-[60px]  pt-[40px]  pb-[40px]   bg-[#fff]   " x-data="{
        pricing_mode: 'month',
    }">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:flex-col sm:align-center mb-[40px]">
      {{-- <h1 class="text-5xl font-extrabold text-gray-900 sm:text-center">Pricing Plans</h1>
      <p class="mt-5 text-xl text-gray-500 sm:text-center">Start building for free, then add a site plan to go live. Account plans unlock additional features.</p> --}}
      <div class="relative self-center bg-gray-100 rounded-lg p-0.5 flex ">
        <button type="button" @click="pricing_mode = 'month'" :class="{'bg-primary text-white':pricing_mode == 'month', 'gray-900':pricing_mode != 'month'}" class="relative w-1/2 border border-transparent rounded-md shadow-sm py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">{{ translate('Monthly billing') }}</button>
        <button type="button" @click="pricing_mode = 'annual'" :class="{'bg-primary text-white':pricing_mode == 'annual', 'gray-900':pricing_mode != 'annual'}" class="ml-0.5 relative w-1/2 border border-transparent rounded-md py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">{{ translate('Yearly billing') }}</button>
      </div>
    </div>

    <div class="flex overflow-x-scroll md:overflow-x-hidden md:grid gap-10 grid-cols-1 md:grid-cols-2 lg:grid-cols-4 pb-5 md:pb-0 pr-3 md:pr-0">
      @if($models->isNotEmpty())
        @foreach($models as $model)
          <div class="w-full min-w-[250px] md:min-w-inherit" x-data="{
              month_price: @js($model->getTotalPrice(true)),
              annual_price: @js(\FX::formatPrice($model->getTotalAnnualPrice() / 12)),
              {{-- discount_percent: @js(abs($model->getTotalAnnualPrice() - ($model->getTotalPrice() * 12))), --}}
          }">
            <div class="relative flex flex-col justify-between px-4 py-4 border-gray-300 hover:border-primary border rounded transition-all duration-300 hover:shadow-green" style="height: 505px;">
              {{-- <div class="" x-text="discount_percent">{{ }}</div>   --}}
              
              <div class="price-description">
                    <h3 class="font-bold text-18 text-gray-700 pb-2">{{ $model->name }}</h3>
                    @if($model->non_standard)
                        <div class="flex items-end">
                            <h3 class="text-36 text-dark font-bold mb-0">{{ !empty($model->getCoreMeta('custom_pricing_label')) ? $model->getCoreMeta('custom_pricing_label') : translate('Contact Us') }}</h3>
                        </div>
                    @else
                      <div class="flex items-end">
                          <h3 class="text-36 text-dark font-bold mb-0" x-text="pricing_mode === 'annual' ? annual_price : month_price"></h3>
                          <span class="text-lg2 text-dark font-bold mb-2">/{{ translate('month') }}</span>
                      </div>
                      <div class="w-full text-gray-500 text-14" x-show="pricing_mode === 'annual'" x-cloak>
                        {{ translate('Billed annually') }}
                      </div>
                    @endif

                    <p class=" text-sm text-lightDark py-6 mb-4">
                      {{ $model->excerpt }}
                    </p>
                
                    <div class="w-full space-y-3">
                      @if(!empty($model->features))
                        @foreach($model->features as $feature)
                          <div class="mb-2 flex items-center gap-3">
                            @svg('heroicon-s-check-circle', ['class' => 'w-5 h-5 text-primary'])
                              <p class="text-sm text-gray-700 mb-0">{{ $feature }}</p>
                          </div>
                        @endforeach
                      @endif
                    </div>
                </div>
                <div>
                    @if(!$model->non_standard)
                      <div class="w-full text-danger text-center pb-3 text-14" x-show="pricing_mode === 'annual'" x-cloak>
                        {{ str_replace('%d%', \FX::formatPrice(abs($model->getTotalAnnualPrice() - ($model->getTotalPrice() * 12))), translate('You save %d% per year')) }}
                      </div>

                      @auth
                        <a href="{{ route('my.plans.management') }}" class="bg-transparent transition-all duration-300 mx-auto block text-center hover:border-none  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2 px-14 rounded-lg">
                            {{ translate('Try it free') }}
                        </a>
                      @endauth

                      @guest
                        <a href="{{ route('user.registration') }}" class="bg-transparent transition-all duration-300 mx-auto block text-center hover:border-none  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2 px-14 rounded-lg">
                            {{ translate('Try it free') }}
                        </a>
                      @endguest

                    @else
                      <a href="{{ $model->getCoreMeta('custom_redirect_url') }}" class="bg-transparent transition-all duration-300 mx-auto block text-center hover:border-none  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2 px-14 rounded-lg">
                          {{ !empty($model->getCoreMeta('custom_cta_label')) ? $model->getCoreMeta('custom_cta_label') : translate('Contact Us') }}
                      </a>
                    @endif
                </div>
            </div>
          </div>
        @endforeach
      @endif
      
    </div>

    {{-- <div class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-4">
      Pricing features section
    </div> --}}
  </div>
</section>

{{-- Plan Features table --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div>
        <div class="mb-5 md:mb-0 py-4 overflow-x-auto">
            <div class="inline-block min-w-full overflow-hidden">
                <table class="min-w-[900px] w-full leading-normal">
                    <thead>
                        <tr class=" bg-darkGray ">
                            <th class="px-5 py-3 border-1  bg-gray-100 text-left text-lg2 font-bold text-lightDark">
                                Features
                            </th>
                            <th class="px-5 py-3 border-1  bg-gray-100 text-center text-lg2 font-bold text-lightDark">
                                Solo
                            </th>
                            <th class="px-5 py-3 border-1  bg-gray-100 text-lg2 font-bold text-lightDark text-center">
                                Solo plus
                            </th>
                            <th class="px-5 py-3 border-1  bg-gray-100 text-lg2 font-bold text-lightDark text-center">
                                Premium
                            </th>
                            <th class="px-5 py-3 border-1  bg-gray-100 text-lg2 font-bold text-lightDark text-center">
                                Enterprise
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center">
                                        <p class="text-md font-medium text-dark2 whitespace-no-wrap">
                                            Unlimited layer generation
                                        </p>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center ">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            
                          
                        </tr>
                        <tr>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center">
                                        <p class="text-md font-medium text-dark2 whitespace-no-wrap">
                                            Unlimited layer generation
                                        </p>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            
                          
                        </tr>
                        <tr>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center">
                                        <p class="text-md font-medium text-dark2 whitespace-no-wrap">
                                            Unlimited GCPs
                                        </p>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            
                          
                        </tr>
                        <tr>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center">
                                        <p class="text-md font-medium text-dark2 whitespace-no-wrap">
                                        Unlimited export options
                                        </p>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            
                          
                        </tr>
                        <tr>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center ">
                                        <p class="text-md font-medium text-dark2 whitespace-no-wrap">
                                    Cloud proc essing
                                        </p>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            
                          
                        </tr>
                        <tr>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center">
                                        <p class="text-md font-medium text-dark2 whitespace-no-wrap">
                                    Offline processing
                                        </p>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 18L18 6M6 6L18 18" stroke="#FF4E3E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>


                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                                </div>
                            </td>
                            
                          
                        </tr>
                        <tr>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center">
                                        <p class="text-md font-medium text-dark2 whitespace-no-wrap">
                                Amount of images
                                        </p>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                               <p class="mb-0 font-md font-bold text-dark2">150</p>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <p class="mb-0 font-md font-bold text-dark2">300</p>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <p class="mb-0 font-md font-bold text-dark2">2000</p>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                            <p class="mb-0 font-md font-bold text-dark2">Unlimited</p>
                                </div>
                            </td>
                            
                          
                        </tr>
                        <tr>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center">
                                        <p class="text-md font-medium text-dark2 whitespace-no-wrap">
                                Remote training
                                        </p>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 18L18 6M6 6L18 18" stroke="#FF4E3E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 18L18 6M6 6L18 18" stroke="#FF4E3E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 18L18 6M6 6L18 18" stroke="#FF4E3E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>


                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>

                                </div>
                            </td>
                            
                          
                        </tr>
                        <tr>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center">
                                        <p class="text-md font-medium text-dark2 whitespace-no-wrap">
                                Hands on support
                                        </p>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 18L18 6M6 6L18 18" stroke="#FF4E3E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 18L18 6M6 6L18 18" stroke="#FF4E3E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 18L18 6M6 6L18 18" stroke="#FF4E3E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>


                                </div>
                            </td>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center justify-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 13L9 17L19 7" stroke="#8BC53F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>

                                </div>
                            </td>
                            
                          
                        </tr>
                        <tr>
                            <td class="px-5 py-5 border-1 bg-white ">
                                <div class="flex items-center">
                                        
                                </div>
                            </td>

                            @if($models->isNotEmpty())
                                @foreach($models as $key => $model)
                                    @if(!$model->non_standard)
                                        @php
                                            $url = \Auth::check() ? route('my.plans.management') : route('user.registration');
                                        @endphp
                                        <td class="px-0 py-5 border-1 bg-white ">
                                            <div class="flex justify-center  items-center">
                                                <a href="{{ $url }}" class="btn-primary">
                                                    {{ translate('Try it free') }}
                                                </a>
                                            </div>
                                        </td>
                                    @else
                                        <td class="px-0 py-5 border-1 bg-white ">
                                            <div class="flex  items-center">
                                                <a href="{{ $model->getCoreMeta('custom_redirect_url') }}" class="bg-transparent transition-all duration-300 mx-auto block text-center hover:border-none  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-16 font-medium py-2 px-4 rounded-lg">
                                                    {{ !empty($model->getCoreMeta('custom_cta_label')) ? $model->getCoreMeta('custom_cta_label') : translate('Contact Us') }}
                                                </a>
                                            </div>
                                        </td>
                                    @endif
                                @endforeach
                            @endif
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</section>

@include('components.custom.full-width-cta')