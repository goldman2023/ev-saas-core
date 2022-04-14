<x-we-edit.flyout.flyout-panel id="we-edit-page-edit-panel">
    <div class="h-0 flex-1 overflow-y-auto" x-data="{
          page: @js($page),
          status: @js($page->status),
          {{-- custom_fields_html: @entangle('custom_fields_html').defer, // THIS MUST BE ENTANGLED! --}}
          errors: [],
      }"
      @display-flyout-panel.window="if($event.detail.id === id) {
          {{-- TODO: Add loading spinner over whole section-edit form so we can indicate that section data is loading --}}
          setTimeout(function() {
              $wire.setPage($event.detail.page_id);
          }, 500);
      }"
      @validation-errors.window="errors = $event.detail.errors.general || []; console.log(errors);">
        {{-- Panel Header --}}
        <div class="bg-indigo-700 py-6 px-4 sm:px-6">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-white" x-text="page.name || ''"></h2>
            <div class="ml-3 flex h-7 items-center">
              <button type="button" @click="show = false" class="rounded-md bg-transparent text-white hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                @svg('heroicon-o-x', ['class' => 'h-6 w-6'])
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

              <!-- Title -->
              <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start" x-data="{}">

                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                    {{ translate('Title') }}
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                  <x-dashboard.form.input field="page.name" />
                </div>
              </div>
              <!-- END Title -->

              <!-- Status -->
              <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-4">
                <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    <span class="mr-2">{{ translate('Status') }}</span>
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.select :items="\App\Enums\StatusEnum::toArray('archived')" selected="status" :nullable="false"></x-dashboard.form.select>
                </div>
              </div>
              <!-- END Status -->

            </div>
          </div>
        </div>


        {{-- Panel Footer --}}
    <div class="flex flex-shrink-0 justify-end px-4 py-4">
        <button type="button" @click="show = false" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            {{ translate('Cancel') }}
        </button>
        <button type="button" @click="
        console.log(status);
          $wire.set('page.status', status, true);
        " wire:click="savePage()" class="ml-4 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            {{ translate('Save') }}
        </button>
    </div>

    </div>

    

</x-we-edit.flyout.flyout-panel>

