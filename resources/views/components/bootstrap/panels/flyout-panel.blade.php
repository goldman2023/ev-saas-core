<div x-data="{
        show: false,
        id: '{{ $id }}',
     }"
     x-cloak
{{-- TODO: @vukasin add non jquery version for esc key --}}

     x-init="">
    <section
        class="c-flyout-panel position-fixed bg-white shadow-lg"
        :class="{ 'show': show }"
        x-data="{
            targetItem: null,
            has_warnings: false,
            hideWarnings() {
                this.has_warnings = false;
                {{-- $refs['c-flyout-panel__warnings-text'].innerHTML = ''; --}}
            }
        }"
        x-init="$watch('show', (value) => {
            (!value) ? hideWarnings() : '';
        })"
        x-effect="window.initClamp('.c-flyout-cart');"
        @toggle-flyout-panel.window="($event.detail.id === id) ? (show = !show) : null"
        @display-flyout-panel.window="($event.detail.id === id) ? (show = true) : (show = false)"
    >
        <div class="h-100 d-flex flex-column position-relative p-4" >
            <div class="d-flex flex-column h-100">
                <div class="c-flyout-panel__close square-32 d-flex align-items-center justify-content-center position-absolute pointer z-10" @click="show = false">
                    <svg class="square-16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>

                {!! $slot !!}

            </div>

        </div>
    </section>

    <div class="c-flyout-panel__overlay"
         x-show="show"
         x-cloak
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 "
         x-transition:enter-end="opacity-7 "
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-7 "
         x-transition:leave-end="opacity-0 "
         @click="show = false"
    >
    </div>
</div>
