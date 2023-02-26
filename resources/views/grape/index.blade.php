@extends('frontend.layouts.we-edit-layout')

@section('meta_title')
{{ translate('GrapeJS Page Builder') }}
@endsection

@push('head_scripts')
<style>
    .gjs-editor {
        min-height: 100vh;
    }

    .gjs-block svg {
        max-width: 100%;
        height: auto;
    }

    .gjs-block {
        width: 100% !important;
    }
</style>

<link rel="stylesheet" href="{{ static_asset('bp-assets/grape/grape.min.css') }}">
{{--
<link href="path/to/grapesjs-preset-webpage.min.css" rel="stylesheet" /> --}}

<script src="{{ static_asset('bp-assets/grape/grape.min.js') }}"></script>
<script src="https://unpkg.com/grapesjs-blocks-basic"></script>
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
    <div class="bg-gray-600 text-xs"
        style="width: 250px; position: absolute; left: 0; top: 0; height: 100vh; overflow-y:scoll; z-index: 9999;"
        id="blocks">
        <h2 class="text-xl text-white mb-2 w-full p-3">Sections</h2>
    </div>

    <div id="gjs" style="padding-left: 250px; min-height: 100vh;">
        <div data-gjs-editable="false">
            {!! $content !!}
        </div>
    </div>

    <div id="styles-manager">
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
            console.log(this.editor);
            console.log(this.editor.Pages.getAll()[0]);
            return this.editor.getHtml();
          },
          initGrapeEditor() {
            this.$nextTick(() => {
              this.editor = grapesjs.init({
                fromElement: true,
                storageManager: {
                    type: 'session',
                    options: {
                    session: { key: 'grapeJS' }
                    }
                },
                canvas: {
                  scripts: [
                    // 'http://pix.ev-saas.localhost:8000/themes/WeTailwind/js/alpine.js?id=848edc66a0d77f8d01979c6653c6708a',
                  'https://cdn.tailwindcss.com/3.0.24?plugins=forms@0.5.0,typography@0.5.2,aspect-ratio@0.4.0,line-clamp@0.3.1'
                  ],
                },
                container: '#gjs',
                height: '90%',
                selectorManager: { escapeName },
                blockManager: {
                    appendTo: '#blocks',
                },
                plugins: [
                    // 'gjs-blocks-basic',
                    'grapesjs-preset-webpage',
                    'grapesjs-component-code-editor',
                    'grapesjs-tailwind',
                ],
                pluginsOpts: {
                    'grapesjs-custom-code': {},
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

              // Define a new custom component
this.editor.Components.addType('comp-with-js', {
  model: {
    defaults: {
      // Add some style, just to make the component visible
      style: {
        width: '100px',
        height: '100px',
        background: 'red',
      }
    }
  }
});

// Create a block for the component, so we can drop it easily
this.editor.Blocks.add('test-block', {
  label: 'Test block',
  attributes: { class: 'fa fa-text' },
  content: { type: 'comp-with-js',
 },
});


              var components = [];
                  @foreach($sections as $item)
                    var data = {
                      'id' : '{{ $item->id }}',
                      'data' : {
                        label: `{{ $item->title }}`,
                        content: `{!! strip_comments($item->html_blade) !!}`,
                        media: '<img src="https://images.we-saas.com/insecure/fill/0/0/ce/0/plain/https://businesspress.fra1.digitaloceanspaces.com/uploads/33aa93f7-28b1-4c5f-b896-5a7153fbb7f3/1669384052_1661966732_businesspress.webp@webp" />',
                        attributes: {
                            class: "fa 0001",
                            id: '{{ $item->id }}'
                        },
                        category: 'Global Components',
                        disable: false,
                        select: true,
                        drag: false,
                        draggable: false,
                        activate: true,
                        editable: true,
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
