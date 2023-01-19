@php
$models = \App\Models\Plan::published()->get();
@endphp
<section class="relative  lg:pt-[80px]  lg:pb-[80px]  sm:pt-[60px]  sm:pb-[60px]  pt-[40px]  pb-[40px]   bg-[#fff]   "
    x-data="{
        pricing_mode: 'annual',
    }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:flex-col sm:align-center mb-[40px]">
            {{-- <h1 class="text-5xl font-extrabold text-gray-900 sm:text-center">Pricing Plans</h1>
            <p class="mt-5 text-xl text-gray-500 sm:text-center">Start building for free, then add a site plan to go
                live. Account plans unlock additional features.</p> --}}
            <div class="relative self-center bg-gray-100 rounded-lg p-0.5 flex gap-2">
                <button type="button" @click="pricing_mode = 'month'"
                    :class="{'bg-primary text-white':pricing_mode == 'month', 'gray-900':pricing_mode != 'month'}"
                    class="relative w-1/2 border border-transparent rounded-md shadow-sm py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">{{
                    translate('Monthly billing') }}</button>
                <button type="button" @click="pricing_mode = 'annual'"
                    :class="{'bg-primary text-white':pricing_mode == 'annual', 'gray-900':pricing_mode != 'annual'}"
                    class="ml-0.5 relative w-1/2 border border-transparent rounded-md py-2 text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary focus:z-10 sm:w-auto sm:px-8">{{
                    translate('Yearly billing') }}</button>
            </div>
        </div>

        <div
            class="grid gap-10 grid-cols-1 md:grid-cols-2 lg:grid-cols-4 pb-5 md:pb-0 md:pr-0">
            @if($models->isNotEmpty())
            @foreach($models as $model)
            <div class="w-full min-w-[250px] md:min-w-inherit" x-data="{
              month_price: @js($model->getTotalPrice(true, decimals: 0)),
              annual_price: @js(\FX::formatPrice($model->getTotalAnnualPrice() / 12, 0)),
              {{-- discount_percent: @js(abs($model->getTotalAnnualPrice() - ($model->getTotalPrice() * 12))), --}}
          }">
                <div class="relative flex flex-col justify-between px-4 py-4 border-gray-300 hover:border-primary border rounded transition-all duration-300 hover:shadow-green"
                    style="height: 505px;">
                    {{-- <div class="" x-text="discount_percent">{{ }}</div> --}}

                    <div class="price-description">
                        <h3 class="font-bold text-18 text-gray-700 pb-2">{{ $model->name }}</h3>
                        @if($model->non_standard)
                        <div class="flex items-end">
                            <h3 class="text-36 text-dark font-bold mb-0">{{
                                !empty($model->getCoreMeta('custom_pricing_label')) ?
                                $model->getCoreMeta('custom_pricing_label') : translate('Contact Us') }}</h3>
                        </div>
                        @else
                        <div class="flex items-end">
                            <h3 class="text-36 text-dark font-bold mb-0"
                                x-text="pricing_mode === 'annual' ? annual_price : month_price"></h3>
                            <span class="text-lg2 text-dark font-bold mb-2">/{{ translate('month') }}</span>
                        </div>
                        <div class="w-full text-gray-500 text-14" x-show="pricing_mode === 'annual'" x-cloak>
                            {{ translate('Billed annually') }}
                        </div>
                        @endif

                        <p class=" text-sm text-lightDark py-6 mb-4">
                            {!! $model->excerpt !!}
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
                        <div class="w-full text-danger text-center pb-3 text-14" x-show="pricing_mode === 'annual'"
                            x-cloak>
                            {{ str_replace('%d%', \FX::formatPrice(abs($model->getTotalAnnualPrice() -
                            ($model->getTotalPrice() * 12))), translate('You save %d% per year')) }}
                        </div>

                        @auth
                        <a href="{{ route('my.plans.management') }}"
                            class="bg-transparent transition-all duration-300 mx-auto block text-center hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2 px-3 rounded-lg">
                            {{ translate('Try it free') }}
                        </a>
                        @endauth

                        @guest
                        <div x-cloack x-show="pricing_mode === 'annual'">
                            <a href="{{ route('user.registration', ['plan' => $model->id, 'interval' => 'annual']) }}"
                                class="bg-transparent transition-all duration-300 mx-auto block text-center  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2 px-3 rounded-lg">
                                {{ translate('Try it free') }}
                            </a>
                        </div>

                        <div x-cloak x-show="pricing_mode === 'month'">
                            <a href="{{ route('user.registration', ['plan' => $model->id, 'interval' => 'month']) }}"
                                class="bg-transparent transition-all duration-300 mx-auto block text-center   hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2 px-3 rounded-lg">
                                {{ translate('Try it free') }}
                            </a>
                        </div>

                        @endguest

                        @else
                        <a href="{{ $model->getCoreMeta('custom_redirect_url') }}"
                            class="bg-transparent transition-all duration-300 mx-auto block text-center  hover:bg-primary hover:text-white  border border-gray-200  text-gray-500 text-lg font-bold py-2 px-3 rounded-lg">
                            {{ !empty($model->getCoreMeta('custom_cta_label')) ? $model->getCoreMeta('custom_cta_label')
                            : translate('Contact Us') }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            @endif

        </div>


        {{-- <div
            class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-4">
            Pricing features section
        </div> --}}
    </div>
</section>

@include('components.custom.full-width-cta')
