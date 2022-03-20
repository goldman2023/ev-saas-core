<div class="w-full" x-data="{
    id: '{{ $id }}',
    initEditor() {
        $nextTick(() => {
            let editor = new FroalaEditor('#'+this.id, {
                heightMin: 200,
                heightMax: 800,
                events: {
                    'initialized': function () {
                        this.html.insert(content);
                    },
                    'contentChanged': function () {
                        content = this.html.get(true);
                    }
                }
            });
        }); 
    }
}" 
x-init="initEditor()"
@init-form.window="initEditor()">
    <div :id="id">

    </div>
</div>