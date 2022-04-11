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
<div class="relative bg-gray-800 overflow-hidden">

    <div class="relative pt-6 pb-16 sm:pb-24">

        <main class="mt-16 sm:mt-24">
            <div class="mx-auto max-w-7xl">
                <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                    <div class="px-4 sm:px-6 sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left lg:flex lg:items-start">
                        <div>

                            <h1 class="mt-4 text-4xl tracking-tight font-bold text-white sm:mt-5 sm:leading-none lg:mt-6 lg:text-5xl xl:text-6xl">
                                <span class="md:block">{{ translate('Welcome to EV-SaaS') }}</span>
                                <span class="text-indigo-400 text-3xl md:block">{{ translate('Upgrade Your Digital Business Today') }}</span>
                            </h1>
                            <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                                {{ translate('It was never easier to launch your SaaS Platform. Just register and try it yourself. Demo tells a thousand words, view it here') }}
                            </p>

                            <div class="mt-10">
                                <a href="https://demo.we-saas.com/" target="_blank" type="button" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Try it live
                                    <!-- Heroicon name: solid/mail -->
                                    <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </a>

                                <a href="https://calendly.com/eim-solutions/new-project-inquries" target="_blank"
                                type="button" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-5">
                                    Book a Demo
                                    <!-- Heroicon name: solid/mail -->
                                    <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </a>
                            </div>

                            <p class="mt-8 text-lg text-white uppercase tracking-wide font-semibold sm:mt-10">
                                {{ translate('Powerful integrations') }}
                            </p>
                            <div class="mt-5 w-full sm:mx-auto  lg:ml-0">
                                <div class="flex  items-start justify-between">
                                    <div class="flex justify-center px-1">
                                        <img class="h-9 sm:h-20" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Stripe_Logo%2C_revised_2016.svg/2560px-Stripe_Logo%2C_revised_2016.svg.png" alt="Tuple">
                                    </div>
                                    <div class="flex justify-center px-1">
                                        <img class="h-9 sm:h-20" src="https://logos-world.net/wp-content/uploads/2021/06/Calendly-Logo.png" alt="Calendly">
                                    </div>
                                    <div class="flex justify-center px-1">
                                        <img class="h-9 sm:h-10  mt-5 w-auto" src="https://www.pngkit.com/png/full/429-4297456_mail-chimp-logo-white-mailchimp.png" alt="Mailchimp">
                                    </div>
                                </div>
                                <span class="text-white opacity-80">* Custom integrations available</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-16 sm:mt-24 lg:mt-0 lg:col-span-6">
                        <div class="bg-white sm:max-w-md sm:w-full sm:mx-auto sm:rounded-lg sm:overflow-hidden">
                            <div class="px-4 py-8 sm:px-10">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">
                                       Get started
                                    </p>

                                    <div class="mt-1 gap-3 w-full">
                                        <div>
                                            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="pl-5">Sign in with Google</span>

                                            </a>
                                        </div>




                                    </div>
                                </div>

                                <div class="mt-6 relative">
                                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                        <div class="w-full border-t border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">
                      Or
                    </span>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <x-central.registration-form></x-central.registration-form>
                                </div>
                            </div>
                            <div class="px-4 py-6 bg-gray-50 border-t-2 border-gray-200 sm:px-10">
                                <p class="text-xs leading-5 text-gray-500">By signing up, you agree to our <a href="#" class="font-medium text-gray-900 hover:underline">Terms</a>, <a href="#" class="font-medium text-gray-900 hover:underline">Data Policy</a> and <a href="#" class="font-medium text-gray-900 hover:underline">Cookies Policy</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
