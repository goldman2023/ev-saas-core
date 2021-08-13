<div class="border-b border-gray-200 py-6">
    <h3 class="-my-3 flow-root">
        <!-- Expand/collapse section button -->
        <button type="button" class="py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400 hover:text-gray-500" aria-controls="filter-section-0" aria-expanded="false">
                  <span class="font-medium text-gray-900">
                    Color
                  </span>
            <span class="ml-6 flex items-center">
                    <!--
                      Expand icon, show/hide based on section open state.

                      Heroicon name: solid/plus-sm
                    -->
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                <!--
                  Collapse icon, show/hide based on section open state.

                  Heroicon name: solid/minus-sm
                -->
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                  </span>
        </button>
    </h3>
    <!-- Filter section, show/hide based on section state. -->
    <div class="pt-6" id="filter-section-0">
        <div class="space-y-4">
            <div class="flex items-center">
                <input id="filter-color-0" name="color[]" value="white" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                <label for="filter-color-0" class="ml-3 text-sm text-gray-600">
                    White
                </label>
            </div>

            <div class="flex items-center">
                <input id="filter-color-1" name="color[]" value="beige" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                <label for="filter-color-1" class="ml-3 text-sm text-gray-600">
                    Beige
                </label>
            </div>

            <div class="flex items-center">
                <input id="filter-color-2" name="color[]" value="blue" type="checkbox" checked class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                <label for="filter-color-2" class="ml-3 text-sm text-gray-600">
                    Blue
                </label>
            </div>

            <div class="flex items-center">
                <input id="filter-color-3" name="color[]" value="brown" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                <label for="filter-color-3" class="ml-3 text-sm text-gray-600">
                    Brown
                </label>
            </div>

            <div class="flex items-center">
                <input id="filter-color-4" name="color[]" value="green" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                <label for="filter-color-4" class="ml-3 text-sm text-gray-600">
                    Green
                </label>
            </div>

            <div class="flex items-center">
                <input id="filter-color-5" name="color[]" value="purple" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                <label for="filter-color-5" class="ml-3 text-sm text-gray-600">
                    Purple
                </label>
            </div>
        </div>
    </div>
</div>
