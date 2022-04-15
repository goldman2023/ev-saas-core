<section class="relative {!! $getSectionSettingsClasses !!}" x-data="{
      pricing_mode: 'month',
  }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="sm:flex sm:flex-col sm:align-center mb-[40px]">
        {{-- <h1 class="text-5xl font-extrabold text-gray-900 sm:text-center">Pricing Plans</h1>
        <p class="mt-5 text-xl text-gray-500 sm:text-center">Start building for free, then add a site plan to go live. Account plans unlock additional features.</p> --}}
        <div class="relative self-center bg-gray-100 rounded-lg p-0.5 flex ">
          <button type="button" @click="pricing_mode = 'month'" :class="{'bg-primary text-white':pricing_mode == 'month', 'gray-900':pricing_mode == 'month'}" class="relative w-1/2 border border-transparent rounded-md shadow-sm py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">{{ translate('Monthly billing') }}</button>
          <button type="button" @click="pricing_mode = 'annual'" :class="{'bg-primary text-white':pricing_mode == 'annual', 'gray-900':pricing_mode == 'month'}" class="ml-0.5 relative w-1/2 border border-transparent rounded-md py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">{{ translate('Yearly billing') }}</button>
        </div>
      </div>

      <div class="grid gap-10 grid-cols-12">
        @if($models->isNotEmpty())
          @foreach($models as $model)
            <div class="col-span-12 sm:col-span-6 lg:col-span-3" x-data="{
                month_price: @js($model->getTotalPrice(true)),
                annual_price: @js(\FX::formatPrice($model->getTotalAnnualPrice(true) / 12)),
                {{-- discount_percent: @js(abs($model->getTotalAnnualPrice() - ($model->getTotalPrice() * 12))), --}}
            }">
              <div class="relative flex flex-col justify-between px-4 py-4 border-gray-300 hover:border-primary border rounded transition-all duration-300 hover:shadow-green" style="height: 505px;">
                {{-- <div class="" x-text="discount_percent">{{ }}</div>   --}}
                
                <div class="price-description">
                      <h3 class="font-bold text-18 text-gray-700 pb-2">{{ $model->name }}</h3>
                      <div class="flex items-end">
                          <h3 class="text-36 text-dark font-bold mb-0" x-text="pricing_mode === 'annual' ? annual_price : month_price"></h3>
                          <span class="text-lg2 text-dark font-bold mb-2">/{{ translate('month') }}</span>
                      </div>
                      <div class="w-full text-gray-500 text-14" x-show="pricing_mode === 'annual'" x-cloak>
                        {{ translate('Billed annually') }}
                      </div>

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
                      <div class="w-full text-danger text-center pb-3 text-14" x-show="pricing_mode === 'annual'" x-cloak>
                        {{ str_replace('%d%', \FX::formatPrice(abs($model->getTotalAnnualPrice() - ($model->getTotalPrice() * 12))), translate('You save %d% per year')) }}
                      </div>

                      @auth
                        <a href="{{ route('my.plans.management') }}" class="bg-transparent transition-all duration-300 mx-auto block text-center hover:border-none  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2 px-14 rounded-lg">
                            {{ translate('Try it free') }}
                        </a>
                      @endauth

                      @guest
                        <a href="{{ '/login?redirect_url='.urlencode(route('my.plans.management')) }}" class="bg-transparent transition-all duration-300 mx-auto block text-center hover:border-none  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2 px-14 rounded-lg">
                            {{ translate('Try it free') }}
                        </a>
                      @endguest
                      
                  </div>
              </div>
            </div>
          @endforeach
        @endif
        
      </div>

      <div class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-4">
        {{-- Pricing features section --}}
      </div>
    </div>
</section>