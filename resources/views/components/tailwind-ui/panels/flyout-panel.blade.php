<div x-data="{
        show: false,
        id: '{{ $id }}',
     }"
     x-cloak
     x-init="$(document).on('keyup', function(e) { if (e.key == 'Escape' && show) {show = false} });">
    <section
        class="c-flyout-panel fixed bg-white shadow-lg"
        :class="{ 'show': show }"
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
        @display-flyout-panel.window="($event.detail.id === id) ? (show = true) : (show = false)"
    >
        <div class="h-full flex flex-col relative p-4" >
            <div class="flex flex-col h-full">
                <div class="c-flyout-panel__close w-[32px] h-[32px] flex items-center justify-center absolute cursor-pointer" @click="show = false">
                    <svg class="w-[16px] h-[16px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>

                {!! $slot !!}

            </div>

        </div>
    </section>

    {{-- TODO: Fix FadeIn issue --}}
    <div class="c-flyout-panel__overlay"
         x-show="show"
         x-cloak
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 "
         x-transition:enter-end="opacity-70 "
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-70 "
         x-transition:leave-end="opacity-0 "
         @click="show = false"
    >
    </div>
</div>
