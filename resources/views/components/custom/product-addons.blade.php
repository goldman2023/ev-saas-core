<div>
<!--
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
<fieldset class="space-y-5">
     <span class="font-medium text-md mb-3 block">
        {{ translate('Extra options') }}
    </span>
    <legend class="sr-only">Notifications</legend>
    <div class="relative flex items-start">
      <div class="flex h-5 items-center">
        <input id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
      </div>
      <div class="ml-3 text-sm">
        <label for="comments" class="font-medium text-gray-700">
            {{ translate('Brakes') }}
        </label>
        <p id="comments-description" class="text-gray-500">
            {{translate('Include brakes') }}
        </p>
      </div>
    </div>
    <div class="relative flex items-start">
      <div class="flex h-5 items-center">
        <input id="candidates" aria-describedby="candidates-description" name="candidates" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
      </div>
      <div class="ml-3 text-sm">
        <label for="candidates" class="font-medium text-gray-700">
            {{ translate('Tent') }}
        </label>
        <p id="candidates-description" class="text-gray-500">
            {{ translate('Include waterproof tent') }}
        </p>
      </div>
    </div>

    <div class="relative flex items-start">
        <div class="flex h-5 items-center">
          <input id="candidates" aria-describedby="candidates-description" name="candidates" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        </div>
        <div class="ml-3 text-sm">
          <label for="candidates" class="font-medium text-gray-700">
              {{ translate('Spare wheel') }}
          </label>
          <p id="candidates-description" class="text-gray-500">
              {{ translate('Include extra spare wheel') }}
          </p>
        </div>
      </div>

      <div class="relative flex items-start">
        <div class="flex h-5 items-center">
          <input id="candidates" aria-describedby="candidates-description" name="candidates" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        </div>
        <div class="ml-3 text-sm">
          <label for="candidates" class="font-medium text-gray-700">
              {{ translate('Winch') }}
          </label>
          <p id="candidates-description" class="text-gray-500">
              {{ translate('I need winch') }}
          </p>
        </div>
      </div>
  </fieldset>
  </div>
