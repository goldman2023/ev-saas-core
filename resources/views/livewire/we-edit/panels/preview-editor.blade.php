<div class="p-preview-editor min-h-full w-full flex flex-col bg-white px-4 py-3" x-data="{
    current_page: @js($current_page),
    current_preview: @js($current_preview),
    pages: @js($all_pages),
    isCurrentPageSelected() {
        if(this.current_preview.content === undefined || this.current_page.content === null) {
            this.current_page.content = {};
        }
        console.log(this.current_page.content );
        return this.current_page !== null && this.current_page !== undefined && Object.values(this.current_page).length > 0;
    },
    errors: [],
}"
@validation-errors.window="errors = $event.detail.errors.general || []; console.log(errors);">
    <div class="w-full">
        <div class="mt-1 relative flex flex-col items-center">
            
            @if(!empty($current_preview->content))
                <div id="render-container" class="bg-white px-6 relative left-0 h-[calc(100vh_-_106px)] overflow-x-hidden overflow-y-auto"
                    style="overflow:hidden; overflow-y: scroll;">
                    @foreach ($current_preview->content as $key => $section)
                        <x-dynamic-component :component="$section['id'] ?? ''" :dataOverides="$section['data'] ?? []" class="mt-4" />
                    @endforeach

                    {{-- The preview rendering idealy should become like this --}}
                    {{-- <x-dynamic-component :component="$section['id'] ?? ''" :dataOverides="$section['data'] ?? []" class="mt-4">
                        @foreach($section['slots'] as $key $slot)
                            <x-slot :name="$key">
                                <x-dynamic-component :component="$section['id']['slots']['section_title']">
                                </x-dynamic-component>
                            </x-slot>
                        @endforeach
                    </x-dynamic-component> --}}
                </div>
            @endif

        </div>
    </div>
{{-- 
    <x-we-edit.flyout.flyout-edit-section :currentPreview="$current_preview"></x-we-edit.flyout.flyout-edit-section> --}}
</div>