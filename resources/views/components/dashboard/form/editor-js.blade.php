<div class="w-full" x-data="{
    id: '{{ $id }}',
    editor: null,
    initEditor() {
        $nextTick(async () => {
            try {
                this.editor.destroy();
            } catch(error) {}

            this.editor = new window.EditorJS(_.merge(window.getEditorJsDefaultConfig(this.id), {
                    data: {{ $field }},
                    minHeight: 100,
                    {{-- onReady: () => {
                        const undo = new window.EditorJSUndoPlugin(this.editor);
                        undo.initialize({{ $field }});
                    }, --}}
                    onChange: _.debounce((ed) => { 
                        ed.saver.save().then((outputData) => {
                            {{ $field }} = outputData.blocks;
                        });
                    }, 400)
                })
            );
            await this.editor.isReady;
            this.editor.blocks.renderFromHTML({{ $field }});
                
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
x-init="initEditor()"
x-on:init-form.window="initEditor()"
wire:ignore>
    <div :id="id">

    </div>
</div>