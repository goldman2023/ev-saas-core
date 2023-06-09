<div x-data="{
        show: false,
        id: '{{ $id }}',
     }"
     x-cloak
        {{-- TODO: @vukasin add non jquery version for esc key --}}
     id="{{ $id }}">
    <section
        class="c-flyout-panel h-[100%] overflow-y-auto fixed top-0 bg-white shadow-lg z-[1010]"
        :class="{'show':show}"
        x-cloak
        {{-- x-transition:enter="transform transition ease-in-out duration-500"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0 "
        x-transition:leave="transform transition ease-in-out duration-500"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full" --}}
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
        @toggle-flyout-panel.window="if($event.detail.id === id) { $event.detail.hasOwnProperty('timeout') ? setTimeout(() => { show = !show }, $event.detail.timeout) : (show = !show) }"
        @display-flyout-panel.window="($event.detail.id === id) ? (show = true) : (show = false)"
    >
        <div class="h-full flex flex-col relative p-4" >
            <div class="flex flex-col h-full">
                <div class="c-flyout-panel__close w-[32px] h-[32px] flex items-center justify-center absolute cursor-pointer z-10" @click="show = false">
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
