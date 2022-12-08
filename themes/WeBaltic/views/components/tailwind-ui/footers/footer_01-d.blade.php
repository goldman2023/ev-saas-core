<!--
  This example requires Tailwind CSS v2.0+

  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<footer class="bg-gray-800" aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">Footer</h2>
    <div class="mx-auto max-w-7xl py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
      <div class="pb-8 xl:grid xl:grid-cols-5 xl:gap-8">
        <div class="grid grid-cols-2 gap-8 xl:col-span-4">
          <div class="md:grid md:grid-cols-2 md:gap-8">
            <div>
              <h3 class="text-base font-medium text-white">
                <img class="w-32" src="{{ get_site_logo() }}" />
              </h3>
              <ul role="list" class="mt-4 space-y-2">
                <li>
                  <a href="#" class="text-lg font-bold text-gray-300 hover:text-white">UAB Domantas</a>
                </li>

                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">Pakalnės g. 5e, Domeikava, Kauno raj. 🇱🇹
                </a>
                </li>

                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">
                    Tel.: 8 (671) 81007

                  </a>
                </li>

                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">
                    info@baltic-priekabos.lt
                  </a>
                </li>
              </ul>
            </div>
            <div class="mt-12 md:mt-0">
              <h3 class="text-base font-medium text-white">Support</h3>
              <ul role="list" class="mt-4 space-y-4">
                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">Pricing</a>
                </li>

                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">Documentation</a>
                </li>

                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">Guides</a>
                </li>

                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">API Status</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="md:grid md:grid-cols-2 md:gap-8">
            <div>
              <h3 class="text-base font-medium text-white">Company</h3>
              <ul role="list" class="mt-4 space-y-4">
                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">About</a>
                </li>

                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">Blog</a>
                </li>

                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">Jobs</a>
                </li>

                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">Press</a>
                </li>

                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">Partners</a>
                </li>
              </ul>
            </div>
            <div class="mt-12 md:mt-0">
              <h3 class="text-base font-medium text-white">Legal</h3>
              <ul role="list" class="mt-4 space-y-4">
                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">Claim</a>
                </li>

                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">Privacy</a>
                </li>

                <li>
                  <a href="#" class="text-base text-gray-300 hover:text-white">Terms</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="mt-12 xl:mt-0">
          <h3 class="text-base font-medium text-white"></h3>
          <form class="mt-4 sm:max-w-xs">
            <fieldset class="w-full mb-6">
              <div class="relative">
                <img src="https://baltic-priekabos.lt/wp-content/uploads/2022/03/Screenshot-2022-03-07-at-15.36.58.png" />
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
                  <!-- Heroicon name: mini/chevron-down -->
                  <svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
      </div>
      <div class="border-t border-gray-700 pt-8 lg:flex lg:items-center lg:justify-between xl:mt-0">
        <div>
          <h3 class="text-base font-medium text-white">
            {{ translate('Customer Self Service') }}
          </h3>
          <p class="mt-2 text-base text-gray-300">
            {{ translate('Download invoices, book service appointments and create new orders via our user friendly customer self service zone.') }}
        </p>
        </div>
        <form class="mt-4 sm:flex sm:max-w-md lg:mt-0">
          <label for="email-address" class="sr-only">Email address</label>
          <div class="mt-3 rounded-md sm:mt-0 sm:ml-3 sm:flex-shrink-0">
            <a href="{{ route('user.registration') }}" class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-500 py-2 px-4 text-base font-medium text-white hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                {{ translate('Register') }}
            </a>
          </div>
        </form>
      </div>
      <div class="mt-8 border-t border-gray-700 pt-8 md:flex md:items-center md:justify-between">
        <div class="flex space-x-6 md:order-2">
          <a href="#" class="text-gray-400 hover:text-gray-300">
            <span class="sr-only">Facebook</span>
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
            </svg>
          </a>

          <a href="#" class="text-gray-400 hover:text-gray-300">
            <span class="sr-only">Instagram</span>
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
            </svg>
          </a>






        </div>
        <p class="mt-8 text-base text-gray-400 md:order-1 md:mt-0">
            &copy; {{ date('Y') }} UAB Domantas, Pakalnės g. 5e, Domeikava, Kauno raj.
        </p>
      </div>
    </div>
  </footer>
