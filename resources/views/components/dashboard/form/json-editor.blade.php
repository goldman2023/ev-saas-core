<div class="w-full" x-data="{
    id: '{{ $id }}',
    editor: null,
    setEditorJSON() {
        setTimeout(() => {
            this.editor.set({{ $field }});
        }, 1000);
    },
    initEditor() {
        $nextTick(async () => {
            this.editor = new JSONEditor(document.getElementById(this.id), {
                mode: '{{ $mode }}',
                onChangeJSON: _.debounce((new_json) => {
                    {{ $field }} = this.editor.get();
                }, 400)
            });

            this.setEditorJSON();
        });
    }
}"
x-init="$nextTick(() => { initEditor() });"
x-on:init-form.window="$nextTick(() => { setEditorJSON() })"
wire:ignore>
    <div :id="id" class="w-full h-[350px]">

    </div>
</div>
