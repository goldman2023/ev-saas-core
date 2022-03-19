<x-we-edit.flyout.flyout-panel id="we-edit-section-panel" title="{{ translate('Your Profile') }}">
    <div class="h-0 flex-1 overflow-y-auto" x-data="{
        section: @entangle('section'),
        errors: []
    }"
    @display-flyout-panel.window="if($event.detail.id === id) {
        {{-- TODO: Add loading spinner over whole section-edit form so we can indicate that section data is loading --}}
        setTimeout(function() {
            $('#section-custom-fields-html').html('');
            $wire.setSection($event.detail.section_uuid);
        }, 500);
    }"
    @validation-errors.window="errors = $event.detail.errors.general || []; console.log(errors);">
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

                <div id="section-custom-fields-html">
                    {!! $this->custom_fields_html !!}
                </div>
                
            </div>
          </div>
        </div>

        <x-we-edit.modals.section-settings-modal></x-we-edit.modals.section-settings-modal>
    </div>

    {{-- Panel Footer --}}
    <div class="flex flex-shrink-0 justify-end px-4 py-4">
        <button type="button" @click="$dispatch('display-section-settings-modal')" class="flex items-center mr-auto rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            @svg('lineawesome-cog-solid', ['class' => ' w-4 h-4 mr-2'])
            {{ translate('Settings') }}
        </button>

        <button type="button" wire:click="$refresh" class="ml-4 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          {{ translate('Refresh') }}
        </button>
        <button type="button" @click="show = false" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            {{ translate('Cancel') }}
        </button>
        <button type="button" wire:click="saveSectionData" class="ml-4 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            {{ translate('Save') }}
        </button>
    </div>

    
</x-we-edit.flyout.flyout-panel>

