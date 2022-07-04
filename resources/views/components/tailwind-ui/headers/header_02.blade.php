<header class="relative">
    {{-- Refference url: https://tailwindui.com/components/ecommerce/page-examples/storefront-pages#component-464ebe7691b135031411ad52b3560cc1 --}}
    <nav aria-label="Top">
      <!-- Top navigation -->
      <div class="bg-gray-900">
        <div class="max-w-7xl mx-auto h-10 px-4 flex items-center justify-between sm:px-6 lg:px-8">
          <!-- Currency selector -->
          <form>
            <div>
              <label for="desktop-currency" class="sr-only">Currency</label>
              <div class="-ml-2 group relative bg-gray-900 border-transparent rounded-md focus-within:ring-2 focus-within:ring-white">
                <select id="desktop-currency" name="currency" class="bg-none bg-gray-900 border-transparent rounded-md py-0.5 pl-2 pr-5 flex items-center text-sm font-medium text-white group-hover:text-gray-100 focus:outline-none focus:ring-0 focus:border-transparent">

                    <option>CAD</option>

                    <option>USD</option>

                    <option>AUD</option>

                    <option>EUR</option>

                    <option>GBP</option>

                </select>
                <div class="absolute right-0 inset-y-0 flex items-center pointer-events-none">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" class="w-5 h-5 text-gray-300">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"></path>
                  </svg>
                </div>
              </div>
            </div>
          </form>

          <div class="flex items-center space-x-6">
            <a href="#" class="text-sm font-medium text-white hover:text-gray-100">Sign in</a>
            <a href="#" class="text-sm font-medium text-white hover:text-gray-100">Create an account</a>
          </div>
        </div>
      </div>

      <!-- Secondary navigation -->
      <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="h-16 flex items-center justify-between">
            <!-- Logo (lg+) -->
            <div class="hidden lg:flex-1 lg:flex lg:items-center">
              <a href="#">
                <span class="sr-only">Workflow</span>
                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&amp;shade=600" alt="">
              </a>
            </div>

            <div class="hidden h-full lg:flex">
              <!-- Flyout menus -->
              <div class="px-4 bottom-0 inset-x-0" x-data="Components.popoverGroup()" x-init="init()">
                <div class="h-full flex justify-center space-x-8">

                    <div class="flex" x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
                      <div class="relative flex">
                        <button type="button" x-state:on="Item active" x-state:off="Item inactive" class="text-gray-700 hover:text-gray-800 relative flex items-center justify-center transition-colors ease-out duration-200 text-sm font-medium" :class="{ 'text-indigo-600': open, 'text-gray-700 hover:text-gray-800': !(open) }" @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="false" :aria-expanded="open.toString()">
                          Women
                          <span class="absolute z-20 -bottom-px inset-x-0 h-0.5 transition ease-out duration-200" aria-hidden="true" x-state:on="Open" x-state:off="Closed" :class="{ 'bg-indigo-600': open }"></span>
                        </button>
                      </div>


                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="'Women' flyout menu, show/hide based on flyout menu state." class="absolute z-10 top-full inset-x-0 bg-white text-sm text-gray-500" x-ref="panel" @click.away="open = false" style="display: none;">
                          <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
                          <div class="absolute inset-0 top-1/2 bg-white shadow" aria-hidden="true"></div>
                          <!-- Fake border when menu is open -->
                          <div class="absolute inset-0 top-0 h-px max-w-7xl mx-auto px-8" aria-hidden="true">
                            <div class="bg-transparent w-full h-px transition-colors ease-out duration-200" x-state:on="Open" x-state:off="Closed" :class="{ 'bg-gray-200': open, 'bg-transparent': !(open) }"></div>
                          </div>

                          <div class="relative">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                              <div class="grid grid-cols-4 gap-y-10 gap-x-8 py-16">

                                  <div class="group relative">
                                    <div class="aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden group-hover:opacity-75">
                                      <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-category-01.jpg" alt="Models sitting back to back, wearing Basic Tee in black and bone." class="object-center object-cover">
                                    </div>
                                    <a href="#" class="mt-4 block font-medium text-gray-900">
                                      <span class="absolute z-10 inset-0" aria-hidden="true"></span>
                                      New Arrivals
                                    </a>
                                    <p aria-hidden="true" class="mt-1">Shop now</p>
                                  </div>

                                  <div class="group relative">
                                    <div class="aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden group-hover:opacity-75">
                                      <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-category-02.jpg" alt="Close up of Basic Tee fall bundle with off-white, ochre, olive, and black tees." class="object-center object-cover">
                                    </div>
                                    <a href="#" class="mt-4 block font-medium text-gray-900">
                                      <span class="absolute z-10 inset-0" aria-hidden="true"></span>
                                      Basic Tees
                                    </a>
                                    <p aria-hidden="true" class="mt-1">Shop now</p>
                                  </div>

                                  <div class="group relative">
                                    <div class="aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden group-hover:opacity-75">
                                      <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-category-03.jpg" alt="Model wearing minimalist watch with black wristband and white watch face." class="object-center object-cover">
                                    </div>
                                    <a href="#" class="mt-4 block font-medium text-gray-900">
                                      <span class="absolute z-10 inset-0" aria-hidden="true"></span>
                                      Accessories
                                    </a>
                                    <p aria-hidden="true" class="mt-1">Shop now</p>
                                  </div>

                                  <div class="group relative">
                                    <div class="aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden group-hover:opacity-75">
                                      <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-category-04.jpg" alt="Model opening tan leather long wallet with credit card pockets and cash pouch." class="object-center object-cover">
                                    </div>
                                    <a href="#" class="mt-4 block font-medium text-gray-900">
                                      <span class="absolute z-10 inset-0" aria-hidden="true"></span>
                                      Carry
                                    </a>
                                    <p aria-hidden="true" class="mt-1">Shop now</p>
                                  </div>

                              </div>
                            </div>
                          </div>
                        </div>

                    </div>

                    <div class="flex" x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
                      <div class="relative flex">
                        <button type="button" x-state:on="Item active" x-state:off="Item inactive" class="text-gray-700 hover:text-gray-800 relative flex items-center justify-center transition-colors ease-out duration-200 text-sm font-medium" :class="{ 'text-indigo-600': open, 'text-gray-700 hover:text-gray-800': !(open) }" @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="false" :aria-expanded="open.toString()">
                          Men
                          <span class="absolute z-20 -bottom-px inset-x-0 h-0.5 transition ease-out duration-200" aria-hidden="true" x-state:on="Open" x-state:off="Closed" :class="{ 'bg-indigo-600': open }"></span>
                        </button>
                      </div>


                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="'Women' flyout menu, show/hide based on flyout menu state." class="absolute z-10 top-full inset-x-0 bg-white text-sm text-gray-500" x-ref="panel" @click.away="open = false" style="display: none;">
                          <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
                          <div class="absolute inset-0 top-1/2 bg-white shadow" aria-hidden="true"></div>
                          <!-- Fake border when menu is open -->
                          <div class="absolute inset-0 top-0 h-px max-w-7xl mx-auto px-8" aria-hidden="true">
                            <div class="bg-transparent w-full h-px transition-colors ease-out duration-200" x-state:on="Open" x-state:off="Closed" :class="{ 'bg-gray-200': open, 'bg-transparent': !(open) }"></div>
                          </div>

                          <div class="relative">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                              <div class="grid grid-cols-4 gap-y-10 gap-x-8 py-16">

                                  <div class="group relative">
                                    <div class="aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden group-hover:opacity-75">
                                      <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-01-men-category-01.jpg" alt="Hats and sweaters on wood shelves next to various colors of t-shirts on hangers." class="object-center object-cover">
                                    </div>
                                    <a href="#" class="mt-4 block font-medium text-gray-900">
                                      <span class="absolute z-10 inset-0" aria-hidden="true"></span>
                                      New Arrivals
                                    </a>
                                    <p aria-hidden="true" class="mt-1">Shop now</p>
                                  </div>

                                  <div class="group relative">
                                    <div class="aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden group-hover:opacity-75">
                                      <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-01-men-category-02.jpg" alt="Model wearing light heather gray t-shirt." class="object-center object-cover">
                                    </div>
                                    <a href="#" class="mt-4 block font-medium text-gray-900">
                                      <span class="absolute z-10 inset-0" aria-hidden="true"></span>
                                      Basic Tees
                                    </a>
                                    <p aria-hidden="true" class="mt-1">Shop now</p>
                                  </div>

                                  <div class="group relative">
                                    <div class="aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden group-hover:opacity-75">
                                      <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-01-men-category-03.jpg" alt="Grey 6-panel baseball hat with black brim, black mountain graphic on front, and light heather gray body." class="object-center object-cover">
                                    </div>
                                    <a href="#" class="mt-4 block font-medium text-gray-900">
                                      <span class="absolute z-10 inset-0" aria-hidden="true"></span>
                                      Accessories
                                    </a>
                                    <p aria-hidden="true" class="mt-1">Shop now</p>
                                  </div>

                                  <div class="group relative">
                                    <div class="aspect-w-1 aspect-h-1 rounded-md bg-gray-100 overflow-hidden group-hover:opacity-75">
                                      <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-01-men-category-04.jpg" alt="Model putting folded cash into slim card holder olive leather wallet with hand stitching." class="object-center object-cover">
                                    </div>
                                    <a href="#" class="mt-4 block font-medium text-gray-900">
                                      <span class="absolute z-10 inset-0" aria-hidden="true"></span>
                                      Carry
                                    </a>
                                    <p aria-hidden="true" class="mt-1">Shop now</p>
                                  </div>

                              </div>
                            </div>
                          </div>
                        </div>

                    </div>



                    <a href="#" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Company</a>

                    <a href="#" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Stores</a>

                </div>
              </div>
            </div>

            <!-- Mobile menu and search (lg-) -->
            <div class="flex-1 flex items-center lg:hidden">
              <button type="button" x-description="Mobile menu toggle, controls the 'mobileMenuOpen' state." class="-ml-2 bg-white p-2 rounded-md text-gray-400" @click="open = true">
                <span class="sr-only">Open menu</span>
                <svg class="h-6 w-6" x-description="Heroicon name: outline/menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
</svg>
              </button>

              <!-- Search -->
              <a href="#" class="ml-2 p-2 text-gray-400 hover:text-gray-500">
                <span class="sr-only">Search</span>
                <svg class="w-6 h-6" x-description="Heroicon name: outline/search" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
<path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
</svg>
              </a>
            </div>

            <!-- Logo (lg-) -->
            <a href="#" class="lg:hidden">
              <span class="sr-only">Workflow</span>
              <img src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&amp;shade=600" alt="" class="h-8 w-auto">
            </a>

            <div class="flex-1 flex items-center justify-end">
              <a href="#" class="hidden text-sm font-medium text-gray-700 hover:text-gray-800 lg:block">
                Search
              </a>

              <div class="flex items-center lg:ml-8">
                <!-- Help -->
                <a href="#" class="p-2 text-gray-400 hover:text-gray-500 lg:hidden">
                  <span class="sr-only">Help</span>
                  <svg class="w-6 h-6" x-description="Heroicon name: outline/question-mark-circle" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
<path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
</svg>
                </a>
                <a href="#" class="hidden text-sm font-medium text-gray-700 hover:text-gray-800 lg:block">Help</a>

                <!-- Cart -->
                <div class="ml-4 flow-root lg:ml-8">
                  <a href="#" class="group -m-2 p-2 flex items-center">
                    <svg class="flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: outline/shopping-bag" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
<path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
</svg>
                    <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">0</span>
                    <span class="sr-only">items in cart, view bag</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
