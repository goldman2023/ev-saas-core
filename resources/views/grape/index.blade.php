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
<link href="path/to/grapesjs-preset-webpage.min.css" rel="stylesheet" />

<script src="//unpkg.com/grapesjs"></script>
<script src="https://cdn.jsdelivr.net/npm/grapesjs-preset-webpage@0.1.11/dist/grapesjs-preset-webpage.min.js"></script>

@endpush

@section('content')
<div id="gjs" style="min-height: 100vh;">
    <div data-gjs-editable="false">
        {!! $content !!}
    </div>
</div>

<script>
    var html = editor.getHtml();
</script>
<button x-on:click="">Save</button>
<form action={{ route('grape.save', [$pageID]) }} method="POST" id="grape-form">
    <input type="hidden" name="custom_html" id="custom_html" value="">
    <button type="submit">{{ translate('Save') }}</button>
</form>

<script>
    const editor = grapesjs.init({
        canvas: {
    scripts: [
     'https://cdn.tailwindcss.com'
    ],
  },
	container: '#gjs',
  fromElement: 1,
  height: '100%',
  storageManager: { type: 0 },
  plugins: ['gjs-blocks-basic']
});

editor.on('component:add', (model) => {
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
,
]

let bm = editor.BlockManager;
          for (i=0;i<components.length;i++){
            if(components[i].id && components[i].data){
              bm.add(components[i].id, components[i].data)
            }
          }
</script>

@endsection
