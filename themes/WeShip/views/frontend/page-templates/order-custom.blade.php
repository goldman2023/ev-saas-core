<div class="w-full md:flex pt-[80px] md:pt-0" x-data="{
    open: false,
    selectedColor: 'nardo gray',
    maxSpeed: 42,
    range: 60,
    baseRange: 60,
    generator: 'No',
    cruisingSpeed: '32',
    basePrice: 300000,
    mainImage: 'https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674320822_Emarius34(6).jpg',
 }">
 <style>
    footer {
        display: none;
    }
    #default-carousel::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(0deg, rgba(0,0,0,0.6) 0%, rgba(45,253,170,0) 80%, rgba(0,0,0,0.6) 100%);
        z-index: 99;
    }

    [data-carousel-prev], [data-carousel-next] {
        z-index: 99999;
    }
    </style>
    <div class="w-full md:w-[70%] relative">
        <div id="default-carousel" class="-mt-[80px] md:mt-0 min-h-[300px] md:min-h-[100vh] object-cover w-full object-position-right relative"
            data-carousel="static">
            <!-- Carousel wrapper -->
            <div
                class="overflow-hidden relative min-h-[300px] md:min-h-[100vh] object-cover w-full object-position-right relative  overflow-hidden">
                <!-- Item 1 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>

                    <img :src="mainImage" class="object-cover w-full h-full" alt="Emarius electric ship photo">
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674421699_Emarius34(15).jpg"
                        class="object-cover w-full h-full" alt="...">
                </div>
                <!-- Item 3 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674421701_Emarius34(20).jpg"
                        class="object-cover w-full h-full" alt="...">
                </div>
            </div>
            <!-- Slider indicators -->
            <div class="hidden absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1"
                    data-carousel-slide-to="0"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                    data-carousel-slide-to="1"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                    data-carousel-slide-to="2"></button>
            </div>
            <!-- Slider controls -->
            <button type="button"
                class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="mask0_1_316" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="20"
                            height="20">
                            <rect width="20" height="20" fill="#D9D9D9" />
                        </mask>
                        <g mask="url(#mask0_1_316)">
                            <path
                                d="M13.5208 18.3332L5.1875 9.99984L13.5208 1.6665L15 3.14567L8.14583 9.99984L15 16.854L13.5208 18.3332Z"
                                fill="#DDE2E8" />
                        </g>
                    </svg>

                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="mask0_1_313" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                        <rect x="20" y="20" width="20" height="20" transform="rotate(180 20 20)" fill="#D9D9D9"/>
                        </mask>
                        <g mask="url(#mask0_1_313)">
                        <path d="M6.47916 1.66683L14.8125 10.0002L6.47917 18.3335L5 16.8543L11.8542 10.0002L5 3.146L6.47916 1.66683Z" fill="#DDE2E8"/>
                        </g>
                        </svg>

                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>


        <div
            class="
            md:absolute bottom-8 left-0 w-full z-[999]
            items-center mt-8 lg:mt-0 text-center justify-center left-0 flex flex-wrap lg:absolute bottom-8 md:w-[80%] md:pl-[10%]">
            <div class="w-1/2 sm:w-1/2 lg:w-1/4 flex px-4 lg:mb-8">

                <div class="mb-4 mx-auto ">
                    <h3 class="mb-2 text-2xl lg:text-gray-50 font-medium font-heading">
                        <span x-text="maxSpeed"></span> knots
                    </h3>
                    <p class="sm:text-lg lg:text-gray-200">Max Speed</p>
                </div>
            </div>
            <div class="w-1/2 sm:w-1/2 lg:w-1/4 flex px-4 lg:mb-8">

                <div class="mb-4 mx-auto">
                    <h3 class="text-center mb-2 text-2xl lg:text-gray-50 font-medium font-heading">
                        <span x-text="range"></span>NM
                    </h3>
                    <p class="sm:text-lg lg:text-gray-200 whitespace-nowrap">Range (EPA est.)</p>
                </div>
            </div>

            <div class="hidden w-1/2 lg:w-1/4 md:flex px-4 mb-8">
                <div class="mr-6">

                </div>
                <div class="mb-4 mx-auto">
                    <h3 class="text-center mb-2 text-2xl lg:text-gray-50 font-medium font-heading">
                        <span x-text="cruisingSpeed"></span> knots
                    </h3>
                    <p class="whitespace-nowrap text-lg lg:text-gray-200">
                        Cruising Speed
                    </p>
                </div>
            </div>

            <div class="hidden w-1/2 lg:w-1/4 md:flex px-4 mb-8">
                <div class="mr-6">

                </div>
                <div class="mb-4 mx-auto">
                    <h3 class="text-center mb-2 text-2xl lg:text-gray-50 font-medium font-heading">
                        <img class="inline"
                            src="https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674431766_-electricity-triangle-sign.png" />
                    </h3>
                    <p class="text-lg whitespace-nowrap lg:text-gray-200">
                        <span x-text="generator"></span>
                        Generator</p>
                </div>
            </div>






        </div>
        <div class="underline decoration-solid text-center block lg:hidden font-medium text-[#383D43]">
            More specifications
        </div>
    </div>

    <div class="w-full md:w-[30%] p-4 md:p-8 lg:pt-20 md:max-h-[100vh] md:overflow-y-scroll">
        <div class="text-center">
            <h1 class="text-3xl font-medium mb-3">
                Emarius 34S
            </h1>
            <span>
                Est. delivery June 1st, 2023
            </span>

            <div class="text-left mt-6">
                <div class="mb-6">
                    <x-custom.engine-filter></x-custom.engine-filter>
                </div>

                <div>
                    <x-custom.generator-filter></x-custom.generator-filter>

                </div>

                <div class="mb-6">
                    <x-custom.color-filter></x-custom.color-filter>
                </div>

                <div class="mb-6">
                    <x-custom.batery-filter></x-custom.batery-filter>
                </div>
                <div class='text-lg'>
                    Total: <strong>300 000€</strong>
                </div>




                <a href="https://buy.stripe.com/dR600r9zY2BKfBe6op" target="_blank"
                    class="sticky bottom-3 sm:static mt-6 w-full inline-block rounded-full border-2 border-black bg-white px-6 py-3 text-base font-medium text-black shadow-sm hover:bg-black hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-center">
                    Pre-Order now<br>

                </a>
                <div class="text-center">
                    <small class="font-normal">
                        (Deposit 5000€)
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
