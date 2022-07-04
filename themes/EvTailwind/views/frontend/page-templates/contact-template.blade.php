@include('components.custom.pix-pro-page-header', [
    'header_title' => translate('Contact Us'),
    'header_subtitle' => null,
])

{{-- Plan Features table --}}
<section class="w-full bg-gradient-to-b from-white to-[#EFF0F4] lg:pt-[80px]  lg:pb-[80px]  sm:pt-[50px]  sm:pb-[50px]  pt-[40px]  pb-[40px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="w-full">
            {{-- <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8"> --}}
            <div class="relative">
                <h2 class="sr-only">
                    {{ tranlsate('Contact us') }}
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-3">
                    <!-- Contact form -->
                    <div class="py-10 px-6 sm:px-10 lg:col-span-2 xl:p-12">
                        <h3 class="text-18 font-bold text-gray-900">{{ translate('Have Questions? Reach Out To Us') }}</h3>
                        <livewire:forms.contact-form />
                    </div>

                    <!-- Contact information -->
                    <div class="relative overflow-hidden py-10 px-6  sm:px-10 xl:p-12">
                        <h3 class="text-[20px] font-bold text-typ-1">{{ translate('Technical & Support Center') }}</h3>
                        <p class="mt-3 sm:mt-6 text-14 text-typ-2 max-w-3xl">
                            {{ translate('Contact us and we will reach out to you in 1 working day.') }}
                        </p>
                        <div class="flex flex-col space-y-1 text-14 py-6 text-typ-2">
                            <span>{{ translate('Address Line 1') }}</span>
                            <span>{{ translate('LT-76300') }}</span>
                        </div>
                        <dl class="mt-2 space-y-3">
                            <dt><span class="sr-only">{{ translate('Phone number') }}</span></dt>
                            <dd class="flex text-base text-typ-3">
                                @svg('heroicon-o-phone', ['class' => 'flex-shrink-0 w-6 h-6 text-primary'])
                                <span class="ml-3">{{ translate('+1 (555) 123-4567') }}</span>
                            </dd>
                            <dt><span class="sr-only">{{ translate('Email') }}</span></dt>
                            <dd class="flex text-base text-typ-3">
                                @svg('heroicon-o-mail', ['class' => 'flex-shrink-0 w-6 h-6 text-primary'])
                                <span class="ml-3">{{ translate('support@example.com') }}</span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
    </div>
</section>
