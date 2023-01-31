<div class="w-full md:flex pt-[80px] md:pt-0" x-data="{
    open: false,
    selectedColor: 'linginė',
    maxSpeed: 750,
    engine: 'engine2',
    battery: 'battery1',
    range: 420,
    baseRange: 60,
    generator: 'No',
    cruisingSpeed: '32',
    showSpecifications: false,
    basePrice: 1000,
    showPrice: 1000,
    calculatePrice: function() {
        if(this.engine === 'engine1') {
            this.basePrice = 270000;
        }
        let totalPrice = this.basePrice;
        if(this.generator === '8 kW') {
            totalPrice += 25000;
        }

        if(this.generator === '20 kW') {
            totalPrice += 40000;
        }

        if(this.battery === 'battery2') {
            totalPrice += 55000;
        }


        this.showPrice = totalPrice;
        return totalPrice;
    },
    mainImage: 'https://businesspress.fra1.digitaloceanspaces.com/uploads/cc772c23-0100-43fc-92c2-13eb0ec7507b/1675099069_Screenshot2023-01-30at19.17.23.png',
    toggleSpecification: function() {
        this.showSpecifications = !this.showSpecifications;
        if(this.showSpecifications) {
            this.speficicationText = 'Less Specifications'
        } else {
            this.speficicationText = 'More Specifications'
        }
        return this.showSpecifications;
    },
    speficicationText: 'More Specifications',
 }">
    <style>
        [data-carousel-prev],
        [data-carousel-next] {
            z-index: 99999;
        }
    </style>
    <div class="w-full md:w-[70%] relative">
        <div id="default-carousel"
            class="-mt-[80px] md:mt-0 object-cover w-full object-position-right relative"
            data-carousel="static">
            <!-- Carousel wrapper -->
            <div
                class="overflow-hidden relative object-cover w-full object-position-right relative  overflow-hidden">
                <!-- Item 1 -->
                <div class="duration-700 ease-in-out" data-carousel-item>

                    <img :src="mainImage" class="object-cover w-full h-full" alt="{{ get_site_name() }} main image">
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="#" class="object-cover w-full h-full" alt="...">
                </div>
                <!-- Item 3 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="#" class="object-cover w-full h-full" alt="...">
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
                class="hidden absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
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
                class="hidden absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="mask0_1_313" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="20"
                            height="20">
                            <rect x="20" y="20" width="20" height="20" transform="rotate(180 20 20)" fill="#D9D9D9" />
                        </mask>
                        <g mask="url(#mask0_1_313)">
                            <path
                                d="M6.47916 1.66683L14.8125 10.0002L6.47917 18.3335L5 16.8543L11.8542 10.0002L5 3.146L6.47916 1.66683Z"
                                fill="#DDE2E8" />
                        </g>
                    </svg>

                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>


        <div
            class="
            left-0 w-full z-[999]
            items-center mt-8 text-center justify-center left-0 flex flex-wrap lg:w-[80%] lg:pl-[10%]">
            <div class="w-1/2 sm:w-1/2 lg:w-1/4 flex px-4 lg:mb-8">

                <div class="mb-4 mx-auto ">
                    <h3 class="mb-2 text-2xl  font-medium font-heading">
                        <span x-text="maxSpeed"></span> kg
                    </h3>
                    <p class="sm:text-lg ">
                        {{ translate('Max. Load') }}
                    </p>
                </div>
            </div>
            <div class="w-1/2 sm:w-1/2 lg:w-1/4 flex px-4 lg:mb-8">

                <div class="w-full mb-4 mx-auto">
                    <h3 class="text-center mb-2 text-2xl  font-medium font-heading">
                        <span x-text="range"></span> kg
                    </h3>
                    <p class="sm:text-lg whitespace-nowrap">
                        {{ translate('Weight') }}
                    </p>
                </div>
            </div>

            <div :class="{ 'hidden md:flex': ! showSpecifications }" class="w-1/2 lg:w-1/4 md:flex px-4 lg:mb-8">

                <div class="w-full mb-4 mx-auto">
                    <h3 class="text-center mb-2 text-2xl  font-medium font-heading">
                        {{ translate('2 years') }}
                    </h3>
                    <p class="whitespace-nowrap text-lg ">
                        {{ translate('Warranty') }}
                    </p>
                </div>
            </div>

            <div :class="{ 'hidden md:flex': ! showSpecifications }" class="w-1/2 lg:w-1/4 md:flex px-4 lg:mb-8">

                <div class="mb-4 w-full mx-auto">
                    <h3 class="text-center mb-2 text-2xl font-medium font-heading">
                        <span class="md:hidden" x-text="generator"></span>
                        <img class="hidden md:inline bg-gray-600 rounded-md"
                            src="https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674431766_-electricity-triangle-sign.png" />
                    </h3>
                    <p class="text-lg whitespace-nowrap">
                        {{ translate('Lights socket') }}
                    </p>
                </div>
            </div>
        </div>
        <div x-text="speficicationText" @click="toggleSpecification();"
            class="underline decoration-solid text-center block md:hidden font-medium text-[#383D43]">
        </div>
    </div>

    <div class="md:sticky w-full md:w-[40%] lg:w-[30%] p-4 md:p-8 lg:pt-8 md:max-h-[100vh] md:overflow-y-scroll">
        <form action="{{ route('quote.create') }}" method="get">
            <div class="text-center">
                <h1 class="text-3xl font-medium mb-3">
                    {{ translate('Custom Order') }}
                </h1>
                <span>
                    {{ translate('Create your own') }}
                </span>

                <div class="text-left mt-6">
                    <div class="mb-6">
                        <x-custom.type-filter></x-custom.type-filter>
                    </div>


                    <div class="mb-6">
                        <x-custom.axis-count></x-custom.axis-count>
                    </div>

                    <div class="mb-6">
                        <x-custom.product-addons></x-custom.product-addons>
                    </div>

                    <div class='text-lg'>
                        Total: <strong x-text="showPrice"></strong> €
                    </div>

                    <input type="submit" href="" target="_blank" value="{{ translate('Get a quote') }}"
                        class="sticky bottom-3 sm:static mt-6 w-full inline-block rounded-full border-2 border-black bg-white px-6 py-3 text-base font-medium text-black shadow-sm hover:bg-black hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-center" />
                </div>
        </form>
    </div>
</div>
</div>
