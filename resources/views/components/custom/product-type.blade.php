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
            {{ translate('Bodywork type') }}
        </span>
        <legend class="sr-only"> {{ translate('Bodywork type') }}</legend>
        <div class="relative flex items-start">
          <div class="flex h-5 items-center">
            <input id="comments" aria-describedby="comments-description" name="candidates" type="radio" class="h-4 w-4 rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500">
          </div>
          <div class="ml-3 text-sm">
            <label for="comments" class="font-medium text-gray-700">
                {{ translate('Bortinė') }}
            </label>

          </div>
        </div>
        <div class="relative flex items-start">
          <div class="flex h-5 items-center">
            <input id="candidates" aria-describedby="candidates-description" name="candidates" type="radio" class="h-4 w-4 rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500">
          </div>
          <div class="ml-3 text-sm">
            <label for="candidates" class="font-medium text-gray-700">
                {{ translate('Valtinė') }}
            </label>
          </div>
        </div>

        <div class="relative flex items-start">
            <div class="flex h-5 items-center">
              <input id="candidates" aria-describedby="candidates-description" name="candidates" type="radio" class="h-4 w-4 rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500">
            </div>
            <div class="ml-3 text-sm">
              <label for="candidates" class="font-medium text-gray-700">
                  {{ translate('Platforminė') }}
              </label>
            </div>
          </div>

          <div class="relative flex items-start">
            <div class="flex h-5 items-center">
              <input id="candidates" aria-describedby="candidates-description" name="candidates" type="radio" class="h-4 w-4 rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500">
            </div>
            <div class="ml-3 text-sm">
              <label for="candidates" class="font-medium text-gray-700">
                  {{ translate('Spec. Paskirties') }}
              </label>

            </div>
          </div>

          <div class="relative flex items-start">
            <div class="flex h-5 items-center">
              <input id="candidates" aria-describedby="candidates-description" name="candidates" type="radio" class="h-4 w-4 rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500">
            </div>
            <div class="ml-3 text-sm">
              <label for="candidates" class="font-medium text-gray-700">
                  {{ translate('Kita') }}
              </label>
              <span>
                <input type='text' class="rounded form-input mt-1 block w-full" placeholder="Kita" />
              </span>

            </div>
          </div>
      </fieldset>
      </div>
