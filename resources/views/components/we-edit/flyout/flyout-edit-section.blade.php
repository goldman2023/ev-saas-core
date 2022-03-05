<x-we-edit.flyout.flyout-panel id="we-edit-section-panel" title="{{ translate('Your Profile') }}">
    <div class="h-0 flex-1 overflow-y-auto">
        {{-- Panel Header --}}
        <div class="bg-indigo-700 py-6 px-4 sm:px-6" x-data="{
                title: '',
            }"
            @display-flyout-panel.window="if($event.detail.id === id) {
                title = $event.detail.title;
            }">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-white" x-text="title"></h2>
            <div class="ml-3 flex h-7 items-center">
              <button type="button" @click="show = false" class="rounded-md bg-indigo-700 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                <span class="sr-only">Close panel</span>
                <!-- Heroicon name: outline/x -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
          <div class="mt-1">
            {{-- <p class="text-sm text-indigo-300">Get started by filling in the information below to create your new project.</p> --}}
          </div>
        </div>

        {{-- Panel Content --}}
        <div class="flex flex-1 flex-col justify-between">
          <div class="divide-y divide-gray-200 px-4 sm:px-6">
            <div class="space-y-6 pt-6 pb-5">
                <livewire:we-edit.forms.section-edit :current_preview="$currentPreview"></livewire:we-edit.forms.section-edit>
            </div>

            {{-- <div class="pt-4 pb-6">
              <div class="flex text-sm">
                <a href="#" class="group inline-flex items-center font-medium text-indigo-600 hover:text-indigo-900">
                  <!-- Heroicon name: solid/link -->
                  <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2"> Copy link </span>
                </a>
              </div>
              <div class="mt-4 flex text-sm">
                <a href="#" class="group inline-flex items-center text-gray-500 hover:text-gray-900">
                  <!-- Heroicon name: solid/question-mark-circle -->
                  <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2"> Learn more about sharing </span>
                </a>
              </div>
            </div> --}}
          </div>
        </div>
    </div>

    {{-- Panel Footer --}}
    <div class="flex flex-shrink-0 justify-end px-4 py-4">
        <button type="button" @click="show = false" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          Cancel
        </button>
        <button type="submit" class="ml-4 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          Save
        </button>
    </div>
</x-we-edit.flyout.flyout-panel>
