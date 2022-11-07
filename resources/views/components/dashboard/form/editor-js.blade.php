<div class="w-full border border-gray-200 pt-5" x-data="{
    id: '{{ $id }}',
    editor: null,
    setEditorContent() {
        this.editor.blocks.renderFromHTML({{ $field }});
    },
    initEditor() {
        $nextTick(async () => {
            this.editor = new window.EditorJS(_.merge(window.getEditorJsDefaultConfig(this.id), {
                    data: {{ $field }},
                    minHeight: 100,

                    onChange: _.debounce((ed) => {
                        ed.saver.save().then((outputData) => {
                            {{ $field }} = (window.edjsHTML()).parse(outputData).join('');
                        });
                    }, 400)
                })
            );
            await this.editor.isReady;
            if({{ $field }} !== null && {{ $field }} != '' && {{ $field }}.length > 0) {
                this.setEditorContent();
            }

            {{-- {
                {{-- heightMin: 200,
                heightMax: 800,
                imageUploadURL: '{{ route('we-media-library.froala.upload-image') }}',
                imageManagerLoadURL: '{{ route('we-media-library.froala.load-images') }}', --}}
                {{-- events: {
                    'initialized': function () {
                        console.log({{ $field }});
                        this.html.insert({{ $field }}, true);
                    },
                    'contentChanged': function () {
                        {{ $field }} = this.html.get(true);
                    }
                } -
            } --}}
        });
    }
}"
x-init="$nextTick(() => { initEditor() });"
x-on:init-form.window="$nextTick(() => { setEditorContent() })"
wire:ignore>
    <div :id="id" class="w-full">

    </div>
</div>
