<!-- This example requires Tailwind CSS v2.0+ -->
<div class="rounded-md bg-green-50 p-4 mb-6">
    <link href="https://calendly.com/assets/external/widget.css" rel="stylesheet">
<script src="https://calendly.com/assets/external/widget.js" type="text/javascript"></script>
    <div class="flex">
      <div class="flex-shrink-0">
        <!-- Heroicon name: mini/check-circle -->
        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
        </svg>
      </div>
      <div class="ml-3">
        <h3 class="text-sm font-medium text-green-800">
            {{ translate('Welcome onboard!') }}
        </h3>
        <div class="mt-2 text-sm text-green-700">
          <p>
           {{ translate('Thank you for signing up. We would like to invite you for short 30 minutes onboarding session.') }}
          </p>
        </div>
        <div class="mt-4">
          <div class="-mx-2 -my-1.5 flex">
            <button
            onclick="Calendly.showPopupWidget('https://calendly.com/mojo-customer-success-1/qa-session');return false;"
            type="button"
            class="rounded-md bg-green-50 px-2 py-1.5 text-sm font-medium text-green-800 bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
               {{ translate('Book a meeting') }}
            </button>
            <button type="button" class="ml-auto rounded-md bg-green-50 px-2 py-1.5 text-sm font-medium text-green-800 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
                {{ translate('Dismiss') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
