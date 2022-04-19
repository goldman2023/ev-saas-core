<div class="fixed z-[9999] inset-0 overflow-y-auto" x-data="{
  section: @entangle('section').defer,
  errors: [],
  show: false,
  sectionCodeMirror: null,
  initCodeMirror() {
    try {
      $nextTick(() => {
        this.sectionCodeMirror = CodeMirror(document.getElementById('section-codemirror'), {
          value: this.section.html,
          mode:  'htmlmixed',
          theme: 'material',
          viewportMargin: Infinity,
          lineNumbers: true,
          lineWrapping: true,
        });
      });
    } catch(error) {
      console.log(error);
    }
  },
  updateHTML() {
    this.section.html = this.sectionCodeMirror.getValue();
  },
  saveSection() {
    this.updateHTML();
    $wire.saveSectionData();
  }
}"
  @edit-html-section-modal.window="
    $wire.setSection($event.detail.section_uuid);
    show = true;

    setTimeout(() => {
      initCodeMirror();
    }, 1000);
  "
  @edit-html-section-modal-hide.window="show = false;"
  @validation-errors.window="errors = $event.detail.errors.general || []; console.log(errors);"
  x-show="show"
  x-cloak>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="oapcity-100"
            x-transition:leave="ease-out duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"></div>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="z-[9999] max-w-[95%] h-[90vh] sm:w-full relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle  sm:p-6"
            {{-- x-on:click.outside="show = false" --}}
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

        <div class="flex gap-5 h-full">
          <div class="min-w-[50%] h-full overflow-y-auto resize-x" x-html="_.get(section, 'html', '')">
          
          </div>

          <div class="flex-1 h-full flex flex-col overflow-y-hidden ">
            
            <div class="flex  justify-between items-center w-full mb-3 pb-1 shrink-0 border-b border-gray-200">
              <h4 class="text-20 ">{{ translate('Edit') }}: <span x-text="_.get(section, 'title', '')"></span></h4>
              <button type="button" class="btn-primary" @click="updateHTML()">{{ translate('Refresh') }}</button>
            </div>
            
            <div id="section-codemirror" class="w-full h-full grow-0 overflow-y-auto">

            </div>
            
            <div class="flex flex-shrink-0 justify-end pt-4">
              {{-- <button type="button" @click="$dispatch('display-section-settings-modal')" class="flex items-center mr-auto rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                  @svg('lineawesome-cog-solid', ['class' => ' w-4 h-4 mr-2'])
                  {{ translate('Settings') }}
              </button> --}}
      
              <button type="button" @click="show = false" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                  {{ translate('Cancel') }}
              </button>
              <button type="button" @click="saveSection()"  class="ml-4 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                  {{ translate('Save') }}
              </button>
            </div>
          </div>
        </div> 

        {{-- <x-we-edit.modals.section-settings-modal></x-we-edit.modals.section-settings-modal> --}}

      </div>
    </div>
</div>
  