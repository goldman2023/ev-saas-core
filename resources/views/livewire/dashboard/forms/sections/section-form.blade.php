@push('head_scripts')
<script src="https://pagecdn.io/lib/ace/1.9.6/ace.js" crossorigin="anonymous" integrity="sha256-Df0y/Q99ekLl+f6XctYp2tUMNP0QrIfxg417zUfU57M=" ></script>


<style type="text/css">
</style>
@endpush
<div class="w-full">
    <div class="w-full" x-data="{
        status: @js($section->status ?? \App\Enums\StatusEnum::draft()->value),
        type: @js($section->type ?? 'twig'),
        title: @js($section->title ?? ''),
        content: @js(base64_encode($section->content)),
        ace: null,
        initAce() {
            try {
                $nextTick(() => {

                    this.ace = ace.edit('ace_editor', {
                        mode: 'ace/mode/twig',
                        theme: 'ace/theme/one_dark',
                        fontSize: 17,
                        selectionStyle: 'text',
                        highlightActiveLine: true,
                        highlightSelectedWord: true,
                        cursorStyle: 'ace',
                        copyWithEmptySelection: true,
                        useSoftTabs: true,
                        navigateWithinSoftTabs: true,
                        fadeFoldWidgets: true,
                        maxLines: 30,
                        minLines: 20,
                        foldStyle: 'markbegin',
                    });
    
                    this.ace.setValue(this.content === null ? '' : atob(this.content));

                    this.ace.on('change', _.debounce( (editor) => {
                        this.content = btoa(this.ace.getValue());
                    }, 500));

                    console.log(this.ace);
                });
            } catch(error) {
                console.log(error);
            }
        },
        saveSection() {
            this.content =  btoa(this.ace.getValue());

            $wire.set('section.title', this.title, true);
            $wire.set('section.status', this.status, true);
            $wire.set('section.type', this.type, true);
            $wire.set('section.content', this.content, true);

            $wire.saveSection();
        }
    }"
    {{-- x-on:init-form.window="$nextTick(() => { this.content =  btoa(this.ace.getValue()) })" --}}
    x-init="$nextTick(() => { initAce(); });"
    x-cloak>
        <div class="w-full relative flex flex-col gap-y-10">
    
            <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Section details') }}</h3>
                </div>
    
                <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                    <!-- Title -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
    
                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            {{ translate('Title') }}
                        </label>
    
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.input field="title" error-field="section.title" :x="true" />
                        </div>
                    </div>
                    <!-- END Title -->
                </div>
    
                {{-- Divider --}}
                <div class="my-5">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                          <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center">
                          <div class="inline-flex items-center shadow-sm px-4 py-1.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            @svg('heroicon-o-code', ['class' => '-ml-1.5 mr-1 h-5 w-5 text-gray-400'])
                            <span>{{ translate('Content/Code') }}</span>
                          </div>
                        </div>
                    </div> 
                </div>
                {{-- END Divider --}}
    
                {{-- ACE editor --}}
                <div id="ace_editor" class="w-full h-full grow-0 overflow-y-auto" wire:ignore></div>
                {{-- END ACE editor --}}
    
                <div class="w-full flex flex-shrink-0 justify-end pt-4">
                    <button type="button" @click="saveSection()"  class="ml-4 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        {{ translate('Save') }}
                    </button>
                </div>
                
            </div>
            
            @if(!empty($section->id ?? null))
                <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                    <div id="section-preview" class="w-100" wire:key="{{ mt_rand() }}">
                        <iframe src="{{ route('section.preview', $section->id) }}" class="w-full min-h-[700px]"></iframe>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
