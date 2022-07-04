<x-we-edit.flyout.flyout-panel id="we-edit-section-panel" title="{{ translate('Your Profile') }}">
    <div class="h-0 flex-1 overflow-y-auto" x-data="{
        section: @entangle('section').defer,
        custom_fields_html: @entangle('custom_fields_html').defer, // THIS MUST BE ENTANGLED!
        errors: []
    }"
    @display-flyout-panel.window="if($event.detail.id === id) {
        {{-- TODO: Add loading spinner over whole section-edit form so we can indicate that section data is loading --}}
        setTimeout(function() {
            document.getElementById('section-custom-fields-html').innerHTML = '';
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
                @if($section)
                @php
                   /* TODO Change this to propper key management */
                   $sectionID = $section['data']['hero_info_slot']['components']['hero_info_label']['data']['label'];
                @endphp
                <a href="{{ route('grape.section-editor', [$sectionID]) }}" target="_blank">
                    Section Editor
                </a>
                @endif

                <div id="section-custom-fields-html" x-html="custom_fields_html">
                    {{-- {!! $this->custom_fields_html !!} --}}
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

        {{-- <button type="button" wire:click="$refresh" class="ml-4 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          {{ translate('Refresh') }}
        </button> --}}
        <button type="button" @click="show = false" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            {{ translate('Cancel') }}
        </button>
        <button type="button" @click="$wire.saveSectionData()"  class="ml-4 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            {{ translate('Save') }}
        </button>
        {{-- wire:click="saveSectionData" --}}
    </div>


</x-we-edit.flyout.flyout-panel>

