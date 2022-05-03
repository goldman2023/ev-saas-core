<div class="fixed z-[9999] inset-0 overflow-y-auto" x-data="{
        show: false,
        title: @js($title),
        id: @js($id),
    }"
    @display-modal.window="
        if($event.detail.id === id) {
            show = true;
        }
    "
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
  
      <div class="z-[9999] relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6 {{ $class }}"
            @if(!$preventClose) x-on:click.outside="show = false" @endif
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <div class="w-full">
          <h4 class="w-full text-18 pb-1 mb-3 border-b border-gray-200">{{ $title }}</h4>

          {{ $slot }}
          
        </div>
      </div>
    </div>
  </div>
  