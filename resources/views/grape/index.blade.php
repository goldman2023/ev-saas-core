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
        <livewire:dashboard.tables.recent-invoices-widget-table for="me" :show-per-page="false" :show-search="false"
            :column-select="false" />
    </div>
</div>

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
      {
        'id' : '0001',
        'data' : {
             label: `<div>
              <div class="my-label-block">Tailwind Test</div>
            </div>`,
            content: `<x-dashboard.elements.support-card class="card bg-white p-4 mb-3">
                </x-dashboard.elements.support-card>`,
          attributes: {
          class: "fa 0001",
          id: '0001'
          },
          category: 'Basic element'
        }
      },
      {
        'id' : '0002',
        'data' : {
             label: `<div>
              <div class="my-label-block">Tailwind Test 2</div>
            </div>`,
            content: `<x-dashboard.widgets.user-welcome></x-dashboard.widgets.user-welcome>`,
          attributes: {
          class: "fa 0001",
          id: '0002'
          },
          category: 'Basic element'
        }
      },
      {
        'id' : '0003',
        'data' : {
             label: `<div>
              <div class="my-label-block">Tailwind Test 55</div>
            </div>`,
            content: `
            <div data-gjs-editable="false">
            <livewire:dashboard.tables.recent-invoices-widget-table for="me" :show-per-page="false" :show-search="false" :column-select="false" />
            </div>`,
          attributes: {
          class: "fa 0001",
          id: '0003',
          showSearch: true
          },
          category: 'Basic element'
        }
      }
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
