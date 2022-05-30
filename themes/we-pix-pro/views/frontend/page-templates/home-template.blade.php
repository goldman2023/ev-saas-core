{{-- HERO --}}
<section class="relative lg:pt-[120px] lg:pb-[120px] sm:pt-[80px] sm:pb-[80px] pt-[50px] pb-[50px] bg-[#F5F5F5]">
    <div class="max-w-6xl mx-auto px-4 sm:px-5">
        <main class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                    <div we-slot="" name="title_slot" we-title="Hero Title" class="w-full">
                        <h1 we-name="hero_title" we-title="Title"
                            class="block text-center lg:text-left font-bold lg:font-black leading-none text-gray-900 text-28 sm:text-36 lg:text-[48px] xl:text-[60px] lg:pr-[3rem]">
                            Convert photos to 3D models with pro-grade tools
                        </h1>
                    </div>

                    <div we-slot="" name="text_slot" we-title="Hero Subtitle" class="w-full">
                        <p we-name="hero_text" we-title="Subtitle"
                            class="mt-3 text-center lg:text-left text-base text-gray-500 sm:mt-5 sm:text-18 lg:text-24 leading-6 lg:leading-8 lg:pr-[3rem]">
                            PixPro – professional photogrammetry for everyone.
                            Measure easily in 3D.
                        </p>
                    </div>

                    <div we-slot="" name="button_group_slot" we-title="Buttons" class="w-full">
                        <div class="mt-5 flex justify-center lg:justify-start lg:mt-8">
                            <div class="rounded-md shadow">
                                <a href="#"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary md:py-4 md:text-lg md:px-10"
                                    target="_blank">
                                    Get started free
                                </a>
                            </div>
                        </div>
                    </div>

                    <div we-slot="" name="hero_info_slot" we-title="Info Label" class="w-full mt-4 text-center lg:text-left">
                        <span we-name="hero_info_label" we-title="Info label" class="mt-2 text-base text-gray-500">
                            1 month free trial now
                        </span>
                    </div>
                </div>

                <div
                    class="mt-12 relative sm:max-w-lg sm:mx-auto lg:-mt-32 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                    <div we-slot="" name="image_slot" we-title="Hero Image" class="w-full mt-4">
                        @include('svg.pix-pro-hero-animation')

                    </div>
                </div>
            </div>
        </main>
    </div>
</section>

{{-- FEATURES --}}
<div class="relative bg-white py-16 sm:py-24 lg:py-32 lg:pt-[80px] lg:pb-[80px] sm:pt-[50px] sm:pb-[50px] pt-[40px] pb-[40px]">
    <div class="mx-auto max-w-md px-4 text-center sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
        <div we-slot="" name="tagline_slot" we-title="Tagline" class="w-full">
            <h3 we-name="tagline" we-title="Title" class="text-14 sm:text-18 font-semibold tracking-wider text-primary uppercase">
                Features
            </h3>
        </div>

        <div we-slot="" name="title_slot" we-title="Title" class="w-full">
            <h2 we-name="title" we-title="Title"
                class="px-4 mt-2 text-26 font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                Every tool needed under one roof
            </h2>
        </div>

        <div we-slot="" name="subtitle_slot" we-title="Subtitle" class="w-full">
            <p we-name="subtitle" we-title="Subtitle" class="mx-auto mt-5 max-w-prose text-16 sm:text-xl text-gray-500">
                We faciliated all the tools and technology you need to digitally
                create your records and enrich them with beautiful, accurate and
                life-like 3D models
            </p>
        </div>

        <div we-slot="" name="itt_group_slot" we-title="Features" class="w-full mt-3 sm:mt-12">
            <div class="grid gap-4 sm:gap-8  grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                <div class="pt-6">
                    <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg px-6 py-5 h-full">
                        <div class="-mt-6 h-full">
                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md">
                                @include('svg.features.icon-1')
                            </div>

                            <div class="w-full">
                                <h4 class="mt-2 sm:mt-8 text-16 sm:text-20 font-medium tracking-tight text-gray-900 max-w-[250px] mx-auto">
                                    Detailed, quick, precise 2D, 3D measurements
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-6">
                    <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg px-6 py-5 h-full">
                        <div class="-mt-6 h-full">
                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md">
                                @include('svg.features.icon-2')
                            </div>

                            <div class="w-full">
                                <h4 class="mt-2 sm:mt-8 text-16 sm:text-20 font-medium tracking-tight text-gray-900 max-w-[250px] mx-auto">
                                    Interactive digital elevation maps
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-6">
                    <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg px-6 py-5 h-full">
                        <div class="-mt-6 h-full">
                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md">
                                @include('svg.features.icon-3')

                            </div>

                            <div class="w-full">
                                <h4 class="mt-2 sm:mt-8 text-16 sm:text-20 font-medium tracking-tight text-gray-900 max-w-[250px] mx-auto">
                                    True Orthophoto imagery
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-6">
                    <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg px-6 py-5 h-full">
                        <div class="-mt-6 h-full">
                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md">
                                @include('svg.features.icon-4')

                            </div>

                            <div class="w-full">
                                <h4 class="mt-2 sm:mt-8 text-16 sm:text-20 font-medium tracking-tight text-gray-900 max-w-[250px] mx-auto">
                                    3D meshes for various applications
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-6">
                    <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg px-6 py-5 h-full">
                        <div class="-mt-6 h-full">
                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md">
                                @include('svg.features.icon-5')

                            </div>

                            <div class="w-full">
                                <h4 class="mt-2 sm:mt-8 text-16 sm:text-20 font-medium tracking-tight text-gray-900 max-w-[250px] mx-auto">
                                    Realistic textures
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-6">
                    <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg px-6 py-5 h-full">
                        <div class="-mt-6 h-full">
                            <div class="w-full aspect-square inline-flex items-center justify-center rounded-md">
                                @include('svg.features.icon-6')
                            </div>

                            <div class="w-full">
                                <h4 class="mt-2 sm:mt-8 text-16 sm:text-20 font-medium tracking-tight text-gray-900 max-w-[250px] mx-auto">
                                    Single and generated contour lines
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div we-slot="" name="button_group_slot" we-title="Buttons" class="w-full mt-[40px]">
            <div class="w-full flex justify-center">
                <div class="rounded-md shadow">
                    <a href="/page/features"
                        class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary md:py-4 md:text-lg md:px-10"
                        target="_self">
                        View more features
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TESTIMONIALS --}}
<section class="bg-[#F5F5F5] py-[40px] sm:py-[50px] md:py-[80px]">
    <div class="container max-w-full sm:!max-w-[90%]">
        <div class=" text-center">
            <div we-slot="" name="tagline_slot" we-title="Tagline" class="w-full">
                <h3 we-name="tagline" we-title="Title"
                    class="text-14 sm:text-18 font-semibold tracking-wider text-primary uppercase mb-2">
                    {{ translate('Testimonials') }}
                </h3>
            </div>
            <h2 class="mt-2 text-26 md:text-[48px] font-black leading-[28px] md:leading-[48px] text-gray-900 mb-3">{{ translate('We put our clients first') }}</h2>
            <p class="text-16 sm:text-xl text-gray-600">All of our tools and technologies are designed, modiefied &amp; <br class="d-inline"> updated keeping your needs in mind</p>
        </div>
        <div class="client-content pt-10 grid grid-cols-2 gap-10">
            <div class="col-span-2 md:col-span-1">
                <div class="px-5 sm:px-8 py-5 bg-white shadow-2xl rounded-sm hover:shadow-4xl transition-all duration-300"
                    style="background-image: url(assets/images/quate.png); background-repeat: no-repeat; background-position: top 20px center;">
                    <p class="py-7 text-center"> “Thanks to PixPro guys we were able to expand our service (we were not
                        aware before) for our customers by using the PixPro photogrammetry app.”</p>
                    <div class="flex gap-4 items-center justify-center pb-4 text-center">
                        <div>
                            <h5 class="text-16 text-gray-900 font-medium">Gediminas Mažeika</h5>
                            <p class="text-gray-500 text-14">Director, UAB “Tetas”</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <div class="px-5 sm:px-8 py-5 bg-white shadow-2xl rounded-sm hover:shadow-4xl transition-all duration-300"
                    style="background-image: url(assets/images/quate.png); background-repeat: no-repeat; background-position: top 20px center;">
                    <p class="py-7 text-center"> “Now it is easier than ever before – fast and accurate design of
                        solar panels on the roof.
                        And there is no need to
                        access the roof in the design stage.”</p>
                    <div class="flex gap-4 items-center justify-center pb-4 text-center">
                        <div>
                            <h5 class="text-16 text-gray-900 font-medium">Tomas Šimanauskas</h5>
                            <p class="text-gray-500 text-14">Director, UAB “Saulės grąža”</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-center mt-8 gap-3">
            <a href="/users/login" class="mb-0 text-lg2 font-bold text-primary-dark underline ">Start Free 1 Month Trial Now</a>
        </div>
    </div>
</section>

@include('components.custom.full-width-cta')
