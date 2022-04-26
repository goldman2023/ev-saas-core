@php 
  $wysiwyg = 'section.data.'.$slot_name.'.components.'.$component_name.'.data';
  $uuid = 'section.data.'.$slot_name.'.components.'.$component_name.'.uuid';
@endphp
<div class="grid grid-cols-10 gap-4" x-data="{
    id: 'wysiwyg-'+{{ $uuid }},
    initEditor() {
        $nextTick(() => {
            let editor = new FroalaEditor('#'+this.id, {
                heightMin: 200,
                heightMax: 800,
                imageUploadURL: '{{ route('we-media-library.froala.upload-image') }}',
                imageManagerLoadURL: '{{ route('we-media-library.froala.load-images') }}',
                events: {
                    'initialized': function () {
                        this.html.insert({{ $wysiwyg.'.content' }});
                    },
                    'contentChanged': function () {
                        {{ $wysiwyg.'.content' }} = this.html.get(true);
                    }
                }
            });
        }); 
    }
}"
x-init="initEditor()"
x-on:init-form.window="initEditor()"
wire:ignore>
    <div class="col-span-10 ">
        <label class="block text-sm font-medium text-gray-700">{{ translate('Content') }}</label>
        <div class="mt-1">
            <div :id="id">

            </div>
        </div>
    </div>

</div>