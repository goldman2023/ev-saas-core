<div class="fixed inset-0 overflow-hidden z-50" x-data="{
    show: false,
    id: '{{ $id }}',
 }"
 x-cloak
 x-show="show"
 x-init="$(document).on('keyup', function(e) { if (e.key == 'Escape' && show) {show = false} });">
    
    <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        @click="show = false"
        x-transition:enter="transform ease-in-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100 "
        x-transition:leave="transition ease-in-out duration-500"
        x-transition:leave-start="opacity-100 "
        x-transition:leave-end="opacity-0">
    </div>
  
    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10"
        x-data="{
            targetItem: null,
            has_warnings: false,
            hideWarnings() {
                this.has_warnings = false;
                $($refs['c-flyout-panel__warnings-text']).html('');
            }
        }"
        x-init="$watch('show', (value) => {
            (!value) ? hideWarnings() : '';
        })"
        @toggle-flyout-panel.window="($event.detail.id === id) ? (show = !show) : null"
        @display-flyout-panel.window="($event.detail.id === id) ? (show = true) : (show = false)">
      <div class="pointer-events-auto w-screen max-w-md"
          x-show="show" 
          x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
          x-transition:enter-start="translate-x-full"
          x-transition:enter-end="translate-x-0 "
          x-transition:leave="transition ease-in duration-500"
          x-transition:leave-start="translate-x-0 "
          x-transition:leave-end="translate-x-full">
        <form class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl">

          {!! $slot !!}
          
        </form>
      </div>
    </div>
</div>
