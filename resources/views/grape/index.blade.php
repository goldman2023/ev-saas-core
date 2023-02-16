@extends('frontend.layouts.we-edit-layout')

@section('meta_title')
{{ translate('GrapeJS Page Builder') }}
@endsection

@push('head_scripts')
<style>
    .gjs-editor {
        min-height: 100vh;
    }
</style>

<link rel="stylesheet" href="{{ static_asset('bp-assets/grape/grape.min.css') }}">
{{--
<link href="path/to/grapesjs-preset-webpage.min.css" rel="stylesheet" /> --}}

<script src="{{ static_asset('bp-assets/grape/grape.min.js') }}"></script>
<script src="https://unpkg.com/grapesjs-component-code-editor"></script>
<script src="https://cdn.jsdelivr.net/npm/grapesjs-preset-webpage"></script>
<script src="/bp-assets/grape/grapesjs-custom-code.min.js">
    <link href="https://unpkg.com/grapesjs-component-code-editor/dist/grapesjs-component-code-editor.min.css" rel="stylesheet">
<script src="https://unpkg.com/grapesjs-component-code-editor">
</script>
<script src="https://unpkg.com/grapesjs-tailwind"></script>

@endpush

@section('content')

<div class="w-full" x-data="grapeEditor" x-init="initGrapeEditor()">
    <div id="gjs" style="min-height: 100vh;">
        <div data-gjs-editable="false">
            {!! $content !!}
        </div>
    </div>

    <div class="w-full flex justify-between">
        <a class="btn-info ml-5 my-3 " href="{{ route('page.edit', ['id' => $pageID]) }}">Go to Page</a>

        <button class="btn-primary mr-5 my-3 " @click="save()">Save</button>
    </div>
</div>

<form action={{ route('grape.save', [$pageID, $type]) }} method="POST" id="grape-form">
    <input type="hidden" name="custom_html" id="custom_html" value="">
    {{-- <button type="submit">{{ translate('Save') }}</button> --}}
</form>

<script>
    const escapeName = (name) => `${name}`;

    document.addEventListener('alpine:init', () => {
      Alpine.data('grapeEditor', () => ({
          editor: null,
          getHTML() {
            return this.editor.getHtml();
          },
          initGrapeEditor() {
            this.$nextTick(() => {
              this.editor = grapesjs.init({
                fromElement: true,
                storageManager: false,
                canvas: {
                  scripts: [
                    // 'http://pix.ev-saas.localhost:8000/themes/WeTailwind/js/alpine.js?id=848edc66a0d77f8d01979c6653c6708a',
                  'https://cdn.tailwindcss.com/3.0.24?plugins=forms@0.5.0,typography@0.5.2,aspect-ratio@0.4.0,line-clamp@0.3.1'
                  ],
                },
                container: '#gjs',
                height: '90%',
                selectorManager: { escapeName },
                plugins: ['gjs-blocks-basic', 'grapesjs-preset-webpage', 'grapesjs-component-code-editor', 'grapesjs-tailwind'],
                pluginsOpts: {
                    'grapesjs-custom-code': {

                    },
                }
              });

              const pn = this.editor.Panels;
const panelViews = pn.addPanel({
  id: "views"
});
panelViews.get("buttons").add([
  {
    attributes: {
      title: "Open Code"
    },
    className: "fa fa-file-code-o",
    command: "open-code",
    togglable: false, //do not close when button is clicked again
    id: "open-code"
  }
]);

              /* Custom Blocks refference: https://jsfiddle.net/fcsa6z75/7/  */
              // Add blocks
              this.editor.on('component:add', (model) => {
                // alert('Add');
              });


              var components = [];
                  @foreach($sections as $item)
                    var data = {
                      'id' : '{{ $item->id }}',
                      'data' : {
                          label: `{{ $item->title }}`,
                          content: `{!! strip_comments($item->html_blade) !!}`,
                        attributes: {
                        class: "fa 0001",
                        id: '{{ $item->id }}'
                        },
                        category: 'Global Components',
                        removable: false,
                        editable: false,
                      }
                    };

                    components.push(data);
                @endforeach
                    console.log(components);
              for (i=0;i<components.length;i++) {
                if(components[i].id && components[i].data){
                    console.log(components[i].data);
                  this.editor.BlockManager.add(components[i].id, components[i].data)
                }
              }

               /* Colapse all block groups
            Refference: https://github.com/artf/grapesjs/issues/446
            */
            /* const categories = this.editor.BlockManager.getCategories();
            categories.each(category => {
                category.set('open', false).on('change:open', opened => {
                    opened.get('open') && categories.each(category => {
                        category !== opened && category.set('open', false)
                    })
                })
            }); */
            });




          },
          save() {
            document.getElementById('custom_html').value = this.getHTML();
            document.getElementById('grape-form').submit();
          }
      }))
  })
</script>
@endsection
