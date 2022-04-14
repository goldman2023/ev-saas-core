<div class="fixed z-50 inset-0 overflow-y-auto" x-data="{
    show: false,
    copyToClipboard() {
      let json = document.getElementById('page_json_content_wrapper').innerHTML.trim();
        navigator.permissions.query({ name: 'clipboard-write' }).then((result) => {
          if (result.state == 'granted' || result.state == 'prompt') {
            navigator.clipboard.writeText(json).then(() => {
                alert('Copied to clipboard');
            });
          }
        });
    }
}"
@display-export-json-modal.window="show = true;"
x-show="show" 
x-cloak>
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
          x-show="show"
          @click="show = false"
          x-transition:enter="ease-out duration-300"
          x-transition:enter-start="opacity-0"
          x-transition:enter-end="oapcity-100"
          x-transition:leave="ease-out duration-300"
          x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"></div>

    <!-- This element is to trick the browser into centering the modal contents. -->
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <div class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left  shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
          x-show="show"
          x-transition:enter="ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave="ease-out duration-200"
          x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
      <div x-data="{}">

          <div class="absolute top-[15px] right-[15px] cursor-pointer" @click="show = false">
            @svg('heroicon-o-x', ['class' => 'w-4 h-4 text-gray-500'])
          </div>

          <div class="w-full flex flex-col">
              <h3 class="text-18">{{ translate('Exported page JSON structure') }}:</h3>
              <button class="btn btn-primary mt-2" @click="copyToClipboard()">
                {{ translate('Copy to clipboard') }}
              </button>
              <pre class="mt-3 bg-gray-100 text-gray-900 flex flex-wrap p-3 whitespace-normal" style="word-break: break-all;" id="page_json_content_wrapper">
                {!! json_encode($json) !!}
              </pre>
          </div>

      </div>
    </div>
  </div>
</div>
