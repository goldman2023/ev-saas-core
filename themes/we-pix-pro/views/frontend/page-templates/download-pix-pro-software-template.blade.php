{{-- Download PixPro Software Section --}}
<section class="py-10 sm:py-24 bg-white">
    <div class="container px-4 mx-auto">
        <div class="text-center">
            <span class="inline-block py-px px-2 mb-4 text-xs leading-5 text-green-500 bg-green-100 font-medium rounded-full shadow-sm">Software</span>
            <h3 class="mb-10 mx-auto text-3xl md:text-4xl leading-tight text-coolGray-900 font-bold tracking-tighter max-w-5xl">Download PixPro Photogrammetry Software</h3>
            <div class="relative mb-10 mx-auto max-w-max">
                <img class="relative z-10" src="https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1651855528_Download-Pix-Pro-Photogrammetry-Software.gif" alt="">
            </div>
            <p class="mb-6 mx-auto text-lg md:text-xl text-coolGray-500 font-medium max-w-4xl">Our philosophy is simple — hire a team of diverse, passionate people and foster a culture that empowers you to do you best work.</p>
            <div class="flex flex-wrap justify-center">
                <div class="w-full md:w-auto py-1 md:py-0 md:mr-6">
                    <a href="{{ get_tenant_setting('pix_pro_software_download_url', '#') }}" class="inline-block py-5 px-7 w-full text-base md:text-lg leading-4 text-green-50 font-medium text-center bg-primary hover:bg-primary-dark   shadow-sm rounded-md" >
                        {{ translate('Download') }}
                    </a>
                </div>
                <div class="w-full md:w-auto py-1 md:py-0">
                    <a href="{{ '/page/plans-pricing' }}" class="inline-block py-5 px-7 w-full text-base md:text-lg leading-4 text-gray-700 font-medium text-center bg-white hover:bg-primary hover:text-white border border-gray-200 rounded-md shadow-sm" >
                        {{ translate('Pricing') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


@include('components.custom.full-width-cta')