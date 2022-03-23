<div class="fixed z-50 inset-0 overflow-y-auto" x-data="{
        show: false,
        type: @js('type'),
        title: '',
        text: '',
        id: 'info-modal-basic'
    }"
    x-init="$watch('show', function(value) { value ? setTimeout(() => show = false, {{ $timeout }}) : ''; })"
    @inform.window="
            if($event.detail.id === id) {
                type = $event.detail.type;
                title = $event.detail.title;
                text = $event.detail.text;
                show = true;
            }
        "
    x-show="show"
    x-cloak>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <!--
        Background overlay, show/hide based on modal state.
  
        Entering: "ease-out duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100"
          To: "opacity-0"
      -->
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
  
      <!--
        Modal panel, show/hide based on modal state.
  
        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
      <div class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6"
            x-on:click.outside="show = false"
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <div>
          <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full "
                :class="{
                    'bg-green-100':type === 'success',
                    'bg-orange-100':type === 'warning',
                    'bg-blue-100':type === 'info',
                    'bg-red-100':type === 'fail' 
                }">
            
            <template x-if="type === 'success'">
                @svg('heroicon-o-check', ['class' => 'h-6 w-6 text-green-600'])
            </template>
            <template x-if="type === 'warning'">
                @svg('heroicon-o-exclamation', ['class' => 'h-6 w-6 text-orange-600'])
            </template>
            <template x-if="type === 'info'">
                @svg('heroicon-o-exclamation-circle', ['class' => 'h-6 w-6 text-blue-600'])
            </template>
            <template x-if="type === 'fail'">
                @svg('heroicon-o-x', ['class' => 'h-6 w-6 text-red-600'])
            </template>
          </div>
          <div class="mt-3 text-center sm:mt-5">
            <h3 class="text-lg leading-6 font-medium text-gray-900" x-text="title"></h3>

            <template x-if="text">
                <div class="mt-2">
                    <p class="text-sm text-gray-500" x-text="text"></p>
                </div>
            </template>
          </div>
        </div>
        {{-- <div class="mt-5 sm:mt-6">
          <button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">Go back to dashboard</button>
        </div> --}}
      </div>
    </div>
  </div>
  