<div class="w-full" x-data="{
    id: '{{ $id }}',
    editor: null,
    initEditor() {
        $nextTick(() => {
            try {
                this.editor.destroy();
            } catch(error) {}
            
            this.editor = new FroalaEditor('#'+this.id, {
                heightMin: 200,
                heightMax: 800,
                imageUploadURL: '{{ route('we-media-library.froala.upload-image') }}',
                imageManagerLoadURL: '{{ route('we-media-library.froala.load-images') }}',
                events: {
                    'initialized': function () {
                        this.html.insert({{ $field }}, true);
                    },
                    'contentChanged': function () {
                        {{ $field }} = this.html.get(true);
                    }
                }
            });
        }); 
    }
}" 
x-init="initEditor()"
x-on:init-form.window="initEditor()"
wire:ignore>
    <div :id="id">

    </div>
</div>