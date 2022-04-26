<section class="relative {!! $getSectionSettingsClasses !!}">
    <div class="w-full">
        <div class="container !max-w-[90%] sm:!max-w-5xl">
            <div class="action-content text-center">

                {{-- Tagline --}}
                <div we-slot name="tagline_slot" we-title="Tagline" class="w-full">
                    <x-ev.label
                        we-name="tagline"
                        we-title="Title"
                        class="text-18 font-semibold tracking-wider text-primary {{ $weData['tagline_slot']['components']['tagline']['data']['class'] ?? '' }}"
                        :tag="$weData['tagline_slot']['components']['tagline']['data']['tag'] ?? ''"
                        :label="$weData['tagline_slot']['components']['tagline']['data']['label'] ?? ''">
                    </x-ev.label>
                </div>
                {{-- END Tagline --}}
            
                {{-- Title --}}
                <div we-slot name="title_slot" we-title="Title" class="w-full">
                    <x-ev.label
                        we-name="title"
                        we-title="Title"
                        class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-5xl {{ $weData['title_slot']['components']['title']['data']['class'] ?? '' }}"
                        :tag="$weData['title_slot']['components']['title']['data']['tag'] ?? ''"
                        :label="$weData['title_slot']['components']['title']['data']['label'] ?? ''">
                    </x-ev.label>
                </div>
                {{-- END Title --}}
                
                {{-- WYSIWYG --}}
                <div we-slot name="wysiwyg_slot" we-title="Title" class="w-full mt-5">
                    <x-ev.wysiwyg
                        we-name="wysiwyg"
                        we-title="Content"
                        class="w-full text-left {{ $weData['wysiwyg_slot']['components']['wysiwyg']['data']['class'] ?? '' }}"
                        :content="$weData['wysiwyg_slot']['components']['wysiwyg']['data']['content'] ?? ''">
                    </x-ev.wysiwyg>
                </div>
                {{-- END WYSIWYG --}}
            </div>
        </div>
    </div>
</div>