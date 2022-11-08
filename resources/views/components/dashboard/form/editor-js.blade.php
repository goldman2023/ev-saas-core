<div class="w-full border border-gray-200 pt-5" x-data="{
    id: '{{ $id }}',
    editor: null,
    getDataField() {
        if({{ $structureField }} !== null && {{ $structureField }} != '' && {{ $structureField }}.hasOwnProperty('blocks')) {
            return {{ $structureField }};
        } else if({{ $field }} !== null && {{ $field }} != '' && {{ $field }}.length > 0) {
            return {{ $field }};
        }
    },
    setEditorContent() {        
        if({{ $structureField }} !== null && {{ $structureField }} != '' && {{ $structureField }}.hasOwnProperty('blocks')) {
            this.editor.blocks.render({{ $structureField }});
        } else if({{ $field }} !== null && {{ $field }} != '' && {{ $field }}.length > 0) {
            this.editor.blocks.renderFromHTML({{ $field }});
        }
    },
    initEditor() {
        $nextTick(async () => {
            this.editor = new window.EditorJS(_.merge(window.getEditorJsDefaultConfig(this.id), {
                    data: this.getDataField(),
                    minHeight: 100,

                    onChange: _.debounce((ed) => {
                        ed.saver.save().then((outputData) => {
                            {{ $field }} = window.edjsHTML.parse(outputData).join('');
                            {{ $structureField }} = outputData;
                        });
                    }, 500)
                })
            );
            await this.editor.isReady;

            this.setEditorContent();
        });
    }
}"
x-init="$nextTick(() => { initEditor() });"
x-on:init-form.window="$nextTick(() => { setEditorContent() })"
wire:ignore>
    <div :id="id" class="w-full">

    </div>
</div>
