<div class="w-full lg:flex pt-[80px] lg:pt-0"
x-data="{
    open: false,
    selectedColor: 'white',
    mainImage: 'https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674320822_Emarius34(6).jpg',
 }">
    <div class="w-full lg:w-[70%] relative">
        <img class="lg:min-h-[100vh] object-cover w-full object-position-right"
        :src="mainImage" />

        <div
            class="items-center mt-8 lg:mt-0 text-center justify-center left-0 flex flex-wrap lg:absolute bottom-8 w-[80%] pl-[10%]">
            <div class="w-1/2 sm:w-1/2 lg:w-1/4 flex px-4 lg:mb-8">

                <div class="mb-4 ">
                    <h3 class="mb-2 text-2xl lg:text-gray-50 font-medium font-heading">
                        18 knots
                    </h3>
                    <p class="text-lg lg:text-gray-200">Max Speed</p>
                </div>
            </div>
            <div class="w-1/2 sm:w-1/2 lg:w-1/4 flex px-4 lg:mb-8">

                <div class="mb-4">
                    <h3 class="text-center mb-2 text-2xl lg:text-gray-50 font-medium font-heading">
                        150NM
                    </h3>
                    <p class="text-center text-lg lg:text-gray-200 whitespace-nowrap">Range (EPA est.)</p>
                </div>
            </div>
            <div class="hidden w-1/2 lg:w-1/4 md:flex px-4 mb-8">
                <div class="mr-6">

                </div>
                <div class="mb-4">
                    <h3 class="text-center mb-2 text-2xl lg:text-gray-50 font-medium font-heading">
                        <img class="inline"
                            src="https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674431766_-electricity-triangle-sign.png" />
                    </h3>
                    <p class="text-lg lg:text-gray-200">Generator</p>
                </div>
            </div>

            <div class="hidden w-1/2 lg:w-1/4 md:flex px-4 mb-8">
                <div class="mr-6">

                </div>
                <div class="mb-4">
                    <h3 class="text-center mb-2 text-2xl lg:text-gray-50 font-medium font-heading">
                        <img class="inline"
                            src="https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674431751_solar-panel.png" />
                    </h3>
                    <p class="text-lg lg:text-gray-200">Solar Panel</p>
                </div>
            </div>




        </div>
        <div class="underline decoration-solid text-center block lg:hidden font-medium text-[#383D43]">
            More specifications
        </div>
    </div>

    <div class="w-full lg:w-[30%] p-8 lg:pt-20">
        <div class="text-center">
            <h1 class="text-3xl font-medium mb-3">
                Emarius 34S
            </h1>
            <span>
                Est. delivery October 15th, 2023
            </span>

            <div class="text-left mt-6">
                <span class="font-medium text-lg mb-3 block">
                    Emarius 35S single engine
                </span>
                <fieldset>
                    <legend class="sr-only">Server size</legend>
                    <div class="space-y-4">
                        <!--
                    Checked: "border-transparent", Not Checked: "border-gray-300"
                    Active: "border-indigo-500 ring-2 ring-indigo-500"
                  -->
                        <label
                            class="bg-[#DDE2E8] relative block cursor-pointer rounded-full border bg-white px-6 py-4 shadow-sm focus:outline-none sm:flex sm:justify-between">
                            <input type="radio" name="server-size" value="Hobby" class="sr-only">
                            <span class="flex items-center">
                                <span class="flex flex-col text-sm">
                                    <span id="server-size-0-label" class="font-medium text-gray-900">
                                        Emarius 34S, 100kwh
                                    </span>
                                    <span id="server-size-0-description-0" class="text-gray-500">

                                    </span>
                                </span>
                            </span>
                            <span id="server-size-0-description-1"
                                class="mt-2 flex text-sm sm:mt-0 sm:ml-4 sm:flex-col sm:text-right">
                                <span class="font-medium text-gray-900">3528€</span>
                            </span>
                            <!--
                      Active: "border", Not Active: "border-2"
                      Checked: "border-indigo-500", Not Checked: "border-transparent"
                    -->
                            <span class="pointer-events-none absolute -inset-px rounded-full border-2"
                                aria-hidden="true"></span>
                        </label>

                        <!--
                    Checked: "border-transparent", Not Checked: "border-gray-300"
                    Active: "border-indigo-500 ring-2 ring-indigo-500"
                  -->
                        <label
                            class="relative block cursor-pointer rounded-full border bg-white px-6 py-4 shadow-sm focus:outline-none sm:flex sm:justify-between">
                            <input type="radio" name="server-size" value="Hobby" class="sr-only">
                            <span class="flex items-center">
                                <span class="flex flex-col text-sm">
                                    <span id="server-size-0-label" class="font-medium text-gray-900">
                                        Emarius 34S, 150kwh
                                    </span>
                                    <span id="server-size-0-description-0" class="text-gray-500">

                                    </span>
                                </span>
                            </span>
                            <span id="server-size-0-description-1"
                                class="mt-2 flex text-sm sm:mt-0 sm:ml-4 sm:flex-col sm:text-right">
                                <span class="font-medium text-gray-900">3528€</span>
                            </span>
                            <!--
                      Active: "border", Not Active: "border-2"
                      Checked: "border-indigo-500", Not Checked: "border-transparent"
                    -->
                            <span class="pointer-events-none absolute -inset-px rounded-full border-2"
                                aria-hidden="true"></span>
                        </label>


                    </div>
                </fieldset>

                <span class="mt-3 font-medium text-lg mb-3 block">
                    Diesel generator
                </span>
                <fieldset>
                    <legend class="sr-only">Diesel generator</legend>
                    <div class="space-y-4">
                        <!--
                    Checked: "border-transparent", Not Checked: "border-gray-300"
                    Active: "border-indigo-500 ring-2 ring-indigo-500"
                  -->
                        <label
                            class="bg-[#DDE2E8] relative block cursor-pointer rounded-full border bg-white px-4 py-3 shadow-sm focus:outline-none sm:flex sm:justify-between">
                            <input type="radio" name="server-size" value="Hobby" class="sr-only">
                            <span class="flex items-center">
                                <span class="flex flex-col text-sm">
                                    <span id="server-size-0-label" class="font-medium text-gray-900">
                                        Diesel generator
                                    </span>
                                    <span id="server-size-0-description-0" class="text-gray-500">

                                    </span>
                                </span>
                            </span>
                            <span id="server-size-0-description-1"
                                class="mt-2 flex text-sm sm:mt-0 sm:ml-4 sm:flex-col sm:text-right">
                            </span>
                            <!--
                      Active: "border", Not Active: "border-2"
                      Checked: "border-indigo-500", Not Checked: "border-transparent"
                    -->
                            <span class="pointer-events-none absolute -inset-px rounded-full border-2"
                                aria-hidden="true"></span>
                        </label>

                        <!--
                    Checked: "border-transparent", Not Checked: "border-gray-300"
                    Active: "border-indigo-500 ring-2 ring-indigo-500"
                  -->
                        <label
                            class="relative block cursor-pointer rounded-full border bg-white  px-4 py-3 shadow-sm focus:outline-none sm:flex sm:justify-between">
                            <input type="radio" name="server-size" value="Hobby" class="sr-only">
                            <span class="flex items-center">
                                <span class="flex flex-col text-sm">
                                    <span id="server-size-0-label" class="font-medium text-gray-900">
                                        Without diesel generator
                                    </span>
                                    <span id="server-size-0-description-0" class="text-gray-500">

                                    </span>
                                </span>
                            </span>
                            <span id="server-size-0-description-1"
                                class="mt-2 flex text-sm sm:mt-0 sm:ml-4 sm:flex-col sm:text-right">
                            </span>
                            <!--
                      Active: "border", Not Active: "border-2"
                      Checked: "border-indigo-500", Not Checked: "border-transparent"
                    -->
                            <span class="pointer-events-none absolute -inset-px rounded-full border-2"
                                aria-hidden="true"></span>
                        </label>
                    </div>
                </fieldset>

                <span class="mt-6 font-medium text-lg block mb-3">
                    Paint: <span class="capitalize font-bold" x-text="selectedColor"></span>
                </span>
                <fieldset>
                    <div class="flex items-center space-x-3">
                        <!--
                        Active and Checked: "ring ring-offset-1"
                        Not Active and Checked: "ring-2"
                      -->
                        <label
                        @click="selectedColor = 'white'; mainImage = 'https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674320822_Emarius34(6).jpg'"

                            class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-pink-500">
                            <input type="radio" name="color-choice" value="Pink" class="sr-only"
                                aria-labelledby="color-choice-0-label">
                            <span id="color-choice-0-label" class="sr-only">Pink</span>
                            <span aria-hidden="true"
                                class="h-8 w-8 bg-[#C9C9C9] border border-black border-opacity-10 rounded-full"></span>
                        </label>

                        <!--
                        Active and Checked: "ring ring-offset-1"
                        Not Active and Checked: "ring-2"
                      -->
                        <label
                        @click="selectedColor = 'orange'; mainImage = 'https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674445471_Emarius34(5).jpg';"
                            class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-purple-500">
                            <input type="radio" name="color-choice" value="Purple" class="sr-only"
                                aria-labelledby="color-choice-1-label">
                            <span id="color-choice-1-label" class="sr-only">Purple</span>
                            <span
                            aria-hidden="true"
                                class="h-8 w-8 bg-[#F8F5E9] border border-black border-opacity-10 rounded-full">
                            </span>
                        </label>

                        <!--
                        Active and Checked: "ring ring-offset-1"
                        Not Active and Checked: "ring-2"
                      -->
                        <label
                        @click="selectedColor = 'blue'; mainImage = 'https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674437328_Emarius34(13).jpg'"
                            class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-blue-500">
                            <input type="radio" name="color-choice" value="Blue" class="sr-only"
                                aria-labelledby="color-choice-2-label">
                            <span id="color-choice-2-label" class="sr-only">Blue</span>
                            <span aria-hidden="true"
                                class="h-8 w-8 bg-[#308DF9] border border-black border-opacity-10 rounded-full"></span>
                        </label>

                        <!--
                        Active and Checked: "ring ring-offset-1"
                        Not Active and Checked: "ring-2"
                      -->
                        <label
                        @click="selectedColor = 'red'; mainImage = 'https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674421700_Emarius34(17).jpg'"
                            class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-green-500">
                            <input type="radio" name="color-choice" value="Green" class="sr-only"
                                aria-labelledby="color-choice-3-label">
                            <span id="color-choice-3-label" class="sr-only">Green</span>
                            <span aria-hidden="true"
                                class="h-8 w-8 bg-[#EB1B1B] border border-black border-opacity-10 rounded-full"></span>
                        </label>



                    </div>
                </fieldset>




                <a href="https://buy.stripe.com/dR600r9zY2BKfBe6op" target="_blank"
                    class="mt-6 w-full inline-block rounded-full border-2 border-black bg-white px-6 py-3 text-base font-medium text-black shadow-sm hover:bg-black hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-center">
                    Order now
                </a>
            </div>
        </div>
    </div>
</div>
