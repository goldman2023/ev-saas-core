<div class="p-3">
    <legend class="block text-2xl font-medium mb-6 text-gray-900">
        {{ translate('Select your interests') }}
    </legend>
    <div class="pb-20" style="max-height: 600px; overflow: scroll;">
        <!-- This example requires Tailwind CSS v2.0+ -->
        <fieldset class="">


            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4 ">
                @foreach($categories as $category)
                <!--
        Checked: "border-transparent", Not Checked: "border-gray-300"
        Active: "border-indigo-500 ring-2 ring-indigo-500"
      -->
                <label x-data="{ user_selected: false }" @click="user_selected = true"
                    :class="{ 'border-indigo-500 ring-2 ring-indigo-500': user_selected }"
                    class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none border-gray-300">
                    <input type="radio" name="project-type" value="Newsletter" class="sr-only"
                        aria-labelledby="project-type-0-label"
                        aria-describedby="project-type-0-description-0 project-type-0-description-1">
                    <div class="flex-1 flex">
                        <div class="flex flex-col">
                            <span id="project-type-0-label" class="block text-sm font-medium text-gray-900"> {{
                                $category->name }} </span>
                            <span id="project-type-0-description-0"
                                class="mt-1 flex items-center text-sm text-gray-500">
                            {{  $category->products->count()}} {{ translate('products') }} </span>
                            <span id="project-type-0-description-1" class="mt-6 text-sm font-medium text-gray-900">
                            </span>
                            <span id="project-type-0-description-2" class="mt-6 text-sm font-medium text-gray-900">
                            </span>
                        </div>
                    </div>
                    <!--
          Not Checked: "invisible"

          Heroicon name: solid/check-circle
        -->
                    <svg
                    :class="{ 'invisible': !user_selected }"
                    class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <!--
          Active: "border", Not Active: "border-2"
          Checked: "border-indigo-500", Not Checked: "border-transparent"
        -->
                    <div class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true"></div>
                </label>
                @endforeach

            </div>
        </fieldset>



    </div>
    <div class="mt-6 mb-6">
        <button type="submit" wire:click="saveCategories"
            class="group relative w-full flex justify-center py-4 px-6 border border-transparent text-lg font-medium rounded-md text-white bg-indigo hover:bg-success focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                    x-description="Heroicon name: solid/lock-closed" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </span>
            {{ translate('Next step') }}
        </button>
    </div>
</div>
