<div class="grid grid-cols-4 gap-3">
    @foreach($documents as $document)
    <div class="text-center  rounded-lg border-2 border-dashed border-gray-300 px-3 py-6">
        @svg('heroicon-o-document', ['class' => 'mx-auto h-12 w-12 text-gray-400'])

        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ $document['title'] }}</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by creating a new project.</p>
        <div class="mt-6">
            <button type="button"
                class="btn-primary">
                {{-- @svg('heroicon-o-document', ['class' => '-ml-1 mr-2 h-5 w-5']) --}}
                {{ translate('Download') }}
            </button>
        </div>
    </div>
    @endforeach
</div>
