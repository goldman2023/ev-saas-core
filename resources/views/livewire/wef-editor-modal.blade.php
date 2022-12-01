<div class="wef-editor-modal fixed z-[10000] inset-0 overflow-y-auto {{ $containerClass }}" x-data="{
  displayModal: @entangle('displayModal'),
  target: @entangle('target').defer,
  subject: @entangle('subject').defer,
  closeEditor() {
    this.subject = null;
    this.displayModal = false;
  },
  showWefEditorModal(data) {
    $wire.changeWefEditor(data);
    displayModal = true;
  }
}" 
@display-wef-editor-modal.window="showWefEditorModal($event.detail)" x-show="displayModal" x-cloak>
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity {{ $wrapperClass }}" x-show="displayModal" x-transition:enter="ease-out duration-300"
          x-transition:enter-start="opacity-0" x-transition:enter-end="oapcity-100"
          x-transition:leave="ease-out duration-300" x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"></div>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">
          &#8203;
      </span>


      <div class="max-w-[90%] lg:max-w-[400px]  overflow-hidden overflow-y-auto relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left  shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:p-6"
          x-show="displayModal" x-transition:enter="ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave="ease-out duration-200"
          x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

          {{-- Dismiss modal - x button --}}
          <button type="button" class="absolute top-5 right-4 z-10" @click="closeEditor()">
              @svg('heroicon-o-x-mark', ['class' => 'w-5 h-5 text-gray-500'])
          </button>

          <div class="flex flex-col py-2" x-data="{}">
            <livewire:dashboard.forms.wef.single-wef-form
              :subject="$subject"
              wef-key="{{ $wefKey }}"
              wef-label="{{ $wefLabel }}"
              data-type="{{ $dataType }}"
              form-type="{{ $formType }}"
              :custom-properties="$customProperties"
              positioning="vertical"
              target="{{ $target }}"
              key="{{ \UUID::generate(4)->string }}" />
          </div>

        </div>
    </div>
</div>