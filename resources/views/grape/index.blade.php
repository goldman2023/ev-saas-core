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
<link rel="stylesheet" href="//unpkg.com/grapesjs/dist/css/grapes.min.css">
{{--
<link href="path/to/grapesjs-preset-webpage.min.css" rel="stylesheet" /> --}}

<script src="//unpkg.com/grapesjs"></script>
<script src="https://cdn.jsdelivr.net/npm/grapesjs-preset-webpage@0.1.11/dist/grapesjs-preset-webpage.min.js"></script>
<script src="/js/grapesjs-custom-code.min.js"></script>

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


<form action={{ route('grape.save', [$pageID]) }} method="POST" id="grape-form">
    <input type="hidden" name="custom_html" id="custom_html" value="">
    {{-- <button type="submit">{{ translate('Save') }}</button> --}}
</form>

<script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('grapeEditor', () => ({
          editor: null,
          getHTML() {
            return this.editor.getHtml();
          },
          initGrapeEditor() {
            this.$nextTick(() => {
              this.editor = grapesjs.init({
                  canvas: {
                  scripts: [
                  'https://cdn.tailwindcss.com/3.0.24?plugins=forms@0.5.0,typography@0.5.2,aspect-ratio@0.4.0,line-clamp@0.3.1'
                  ],
                },
                container: '#gjs',
                fromElement: 1,
                height: '100%',
                storageManager: { type: 0 },
                plugins: ['gjs-blocks-basic', 'grapesjs-custom-code'],
                pluginsOpts: {
                    'grapesjs-custom-code': {
                    // options
                    }
                }
              });



              this.editor.on('component:add', (model) => {
                // alert('Add');
              });

              var components = [
                  @foreach($sections as $item)
                    {
                      'id' : '{{ $item->getRelativePathName() }}',
                      'data' : {
                          label: `{{ $item->getRelativePathName() }}`,
                          content: `{!! strip_comments(file_get_contents($item->getPathName())) !!}`,
                        attributes: {
                        class: "fa 0001",
                        id: '{{ $item->getRelativePathName() }}'
                        },
                        category: '{{ $item->getRelativePath() }}'
                      }
                    },
                    @endforeach
              ]

              for (i=0;i<components.length;i++) {
                if(components[i].id && components[i].data){
                  this.editor.BlockManager.add(components[i].id, components[i].data)
                }
              }

               /* Colapse all block groups
            Refference: https://github.com/artf/grapesjs/issues/446
            */
            const categories = this.editor.BlockManager.getCategories();
            categories.each(category => {
                console.log(category);
                category.set('open', false).on('change:open', opened => {
                    opened.get('open') && categories.each(category => {
                        category !== opened && category.set('open', false)
                    })
                })
            });
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
