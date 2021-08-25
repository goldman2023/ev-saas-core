<div class="lg:col-start-8 lg:col-span-5">
    <div class="flex justify-between">
        <h1 class="text-3xl font-medium text-gray-900">
            {{ $product->getTranslation('name') }}
        </h1>
        <p class="text-xl font-medium text-gray-900">
            <!--   TODO: Add this as a general component         -->
            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
            @endif
            <span class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span>
        </p>
    </div>
    <!-- Reviews -->
    <div class="mt-4">
        <!--  TODO: Make this enable/disable in general settings somewhere to be decided where or suggest your option       -->
        <h2 class="sr-only">Reviews</h2>
        <div class="flex items-center">
            <p class="text-sm text-gray-700">
                <!--    TODO: Make this dynamic             -->
                3.9
                <span class="sr-only"> out of 5 stars</span>
            </p>
            <div class="ml-1 flex items-center">
                <!--
                  Heroicon name: solid/star

                  Active: "text-yellow-400", Inactive: "text-gray-200"
                -->
                <svg class="text-yellow-400 h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>

                <!-- Heroicon name: solid/star -->
                <svg class="text-yellow-400 h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>

                <!-- Heroicon name: solid/star -->
                <svg class="text-yellow-400 h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>

                <!-- Heroicon name: solid/star -->
                <svg class="text-yellow-400 h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>

                <!-- Heroicon name: solid/star -->
                <svg class="text-gray-200 h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor" aria-hidden="true">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <div aria-hidden="true" class="ml-4 text-sm text-gray-300">·</div>
            <div class="ml-4 flex">
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">See all 512 reviews</a>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 lg:col-span-5">
    <form>
        <!-- Color picker -->
        <div>
            <h2 class="text-sm font-medium text-gray-900">Color</h2>

            <fieldset class="mt-2">
                <legend class="sr-only">
                    Choose a color
                </legend>
                <div class="flex items-center space-x-3">
                    <!--
                      Active and Checked: "ring ring-offset-1"
                      Not Active and Checked: "ring-2"
                    -->
                    <label
                        class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-gray-900">
                        <input type="radio" name="color-choice" value="Black" class="sr-only"
                               aria-labelledby="color-choice-0-label">
                        <p id="color-choice-0-label" class="sr-only">
                            Black
                        </p>
                        <span aria-hidden="true"
                              class="h-8 w-8 bg-gray-900 border border-black border-opacity-10 rounded-full"></span>
                    </label>

                    <!--
                      Active and Checked: "ring ring-offset-1"
                      Not Active and Checked: "ring-2"
                    -->
                    <label
                        class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-gray-400">
                        <input type="radio" name="color-choice" value="Heather Grey" class="sr-only"
                               aria-labelledby="color-choice-1-label">
                        <p id="color-choice-1-label" class="sr-only">
                            Heather Grey
                        </p>
                        <span aria-hidden="true"
                              class="h-8 w-8 bg-gray-400 border border-black border-opacity-10 rounded-full"></span>
                    </label>
                </div>
            </fieldset>
        </div>

        <!-- Size picker -->
        <div class="mt-8">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-900">Size</h2>
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">See sizing chart</a>
            </div>

            <fieldset class="mt-2">
                <legend class="sr-only">
                    Choose a size
                </legend>
                <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
                    <!--
                      In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                      Active: "ring-2 ring-offset-2 ring-indigo-500"
                      Checked: "bg-indigo-600 border-transparent text-white hover:bg-indigo-700", Not Checked: "bg-white border-gray-200 text-gray-900 hover:bg-gray-50"
                    -->
                    <label
                        class="border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                        <input type="radio" name="size-choice" value="XXS" class="sr-only"
                               aria-labelledby="size-choice-0-label">
                        <p id="size-choice-0-label">
                            XXS
                        </p>
                    </label>

                    <!--
                      In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                      Active: "ring-2 ring-offset-2 ring-indigo-500"
                      Checked: "bg-indigo-600 border-transparent text-white hover:bg-indigo-700", Not Checked: "bg-white border-gray-200 text-gray-900 hover:bg-gray-50"
                    -->
                    <label
                        class="border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                        <input type="radio" name="size-choice" value="XS" class="sr-only"
                               aria-labelledby="size-choice-1-label">
                        <p id="size-choice-1-label">
                            XS
                        </p>
                    </label>

                    <!--
                      In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                      Active: "ring-2 ring-offset-2 ring-indigo-500"
                      Checked: "bg-indigo-600 border-transparent text-white hover:bg-indigo-700", Not Checked: "bg-white border-gray-200 text-gray-900 hover:bg-gray-50"
                    -->
                    <label
                        class="border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                        <input type="radio" name="size-choice" value="S" class="sr-only"
                               aria-labelledby="size-choice-2-label">
                        <p id="size-choice-2-label">
                            S
                        </p>
                    </label>

                    <!--
                      In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                      Active: "ring-2 ring-offset-2 ring-indigo-500"
                      Checked: "bg-indigo-600 border-transparent text-white hover:bg-indigo-700", Not Checked: "bg-white border-gray-200 text-gray-900 hover:bg-gray-50"
                    -->
                    <label
                        class="border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                        <input type="radio" name="size-choice" value="M" class="sr-only"
                               aria-labelledby="size-choice-3-label">
                        <p id="size-choice-3-label">
                            M
                        </p>
                    </label>

                    <!--
                      In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                      Active: "ring-2 ring-offset-2 ring-indigo-500"
                      Checked: "bg-indigo-600 border-transparent text-white hover:bg-indigo-700", Not Checked: "bg-white border-gray-200 text-gray-900 hover:bg-gray-50"
                    -->
                    <label
                        class="border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                        <input type="radio" name="size-choice" value="L" class="sr-only"
                               aria-labelledby="size-choice-4-label">
                        <p id="size-choice-4-label">
                            L
                        </p>
                    </label>

                    <!--
                      In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                      Active: "ring-2 ring-offset-2 ring-indigo-500"
                      Checked: "bg-indigo-600 border-transparent text-white hover:bg-indigo-700", Not Checked: "bg-white border-gray-200 text-gray-900 hover:bg-gray-50"
                    -->
                    <label
                        class="border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 opacity-25 cursor-not-allowed">
                        <input type="radio" name="size-choice" value="XL" disabled class="sr-only"
                               aria-labelledby="size-choice-5-label">
                        <p id="size-choice-5-label">
                            XL
                        </p>
                    </label>
                </div>
            </fieldset>
        </div>
        <x-tenant.system.product-add-to-cart :product="$product"></x-tenant.system.product-add-to-cart>
    </form>

    <!-- Product details -->
    <div class="mt-10">
        <h2 class="text-sm font-medium text-gray-900">{{ __('Description') }}</h2>

        <div class="mt-4 prose prose-sm text-gray-500">
            {!! $product->getTranslation('description') !!}
        </div>
    </div>

    <div class="mt-8 border-t border-gray-200 pt-8">
        <!--   TODO: Create dynamic options for extra description list items or so      -->
        <h2 class="text-sm font-medium text-gray-900">Fabric &amp; Care</h2>

        <div class="mt-4 prose prose-sm text-gray-500">
            <ul role="list">
                <li>Only the best materials</li>

                <li>Ethically and locally made</li>

                <li>Pre-washed and pre-shrunk</li>

                <li>Machine wash cold with similar colors</li>
            </ul>
        </div>
    </div>

    <!-- Policies -->
    <!--  TODO: Make this dynamic as a number and in general what is shown per product and globally    -->
    <section aria-labelledby="policies-heading" class="mt-10">
        <h2 id="policies-heading" class="sr-only">Our Policies</h2>

        <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                <dt>
                    <!-- Heroicon name: outline/globe -->
                    <svg class="mx-auto h-6 w-6 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="mt-4 text-sm font-medium text-gray-900">
                    International delivery
                  </span>
                </dt>
                <dd class="mt-1 text-sm text-gray-500">
                    Get your order in 2 years
                </dd>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                <dt>
                    <!-- Heroicon name: outline/currency-dollar -->
                    <svg class="mx-auto h-6 w-6 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="mt-4 text-sm font-medium text-gray-900">
                    Loyalty rewards
                  </span>
                </dt>
                <dd class="mt-1 text-sm text-gray-500">
                    Don&#039;t look at other tees
                </dd>
            </div>
        </dl>
    </section>
</div>

