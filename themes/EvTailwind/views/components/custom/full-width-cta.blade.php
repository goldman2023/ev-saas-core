{{-- FULL WIDTH CTA --}}
<section class="relative z-[2] lg:pt-[80px]  lg:pb-[80px]  sm:pt-[50px]  sm:pb-[50px]  pt-[40px]  pb-[40px]   bg-primary ">

    <div class="w-full">
        <div class="container !max-w-[90%] sm:!max-w-4xl">
            <div class="action-content text-center">

                <div we-slot="" name="title_slot" we-title="Section Title" class="w-full mb-4">
                    <h2 we-name="section_title" we-title="Title" class="text-[28px]  md:text-[38px]  font-black leading-none mb-5 text-white">
                        {{ translate('Ready to get started with your project?') }}
                    </h2>
                </div>

                <div we-slot="" name="text_slot" we-title="Section Text" class="w-full mb-8">
                    <p we-name="section_text" we-title="Text" class="text-16 md:text-20 font-medium text-white">
                        {{ translate('Create an account') }}
                    </p>
                </div>

                <div we-slot="" name="button_group_slot" we-title="Buttons" class="w-full">
                    <div class="mb-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8 ">
                        <div class="rounded-md shadow ">
                            <a href="{{ route('user.registration') }}"
                                class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-gray-700 bg-primary hover:bg-primary md:py-4 md:text-lg md:px-10 !bg-white"
                                target="_self">
                                {{ translate('Register') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div we-slot="" name="info_slot" we-title="Section Info Text" class="w-full ">
                    <p we-name="section_info" we-title="Text" class="text-14 md:text-14 font-medium text-white">
                        {{ translate('And Book a FREE -  30 minute demo and disovery session') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
