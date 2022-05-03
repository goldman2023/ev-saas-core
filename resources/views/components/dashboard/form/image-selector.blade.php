<div class="w-full" x-data="{
    id: '{{ $id }}',
    hasImage() {
        return {{ $field }} !== undefined && {{ $field }} !== null && {{ $field }}.id !== undefined && {{ $field }}.id !== null && {{ $field }}.id > 0
    },
    removeImage() {
        {{ $field }}.id = '';
        {{ $field }}.file_name = '';
    }
}"
@we-media-selected-event.window="
    if($event.detail.for_id === id) {
        if(!hasImage()) {
            {{ $field }} = {
                id: null,
                file_name: null,
            };
        }

        {{ $field }}.id = $event.detail.selected[0]['id'] || '';
        {{ $field }}.file_name = $event.detail.selected[0]['file_name'] || '';
    }
">
    <div class="@if($template != 'simple') max-w-lg flex justify-center border-2 border-gray-300 border-dashed rounded-md @endif  @error($errorField) !border-danger @enderror  cursor-pointer"
    @if($template != 'simple'):class="{'px-6 pt-5 pb-6': hasImage() }" @endif
            @click="$wire.emit('showMediaLibrary', id, 'image', [{id:{{ $field }}?.id || '', file_name:{{ $field }}?.file_name || ''}])">

            @if($template != 'simple')
                <template x-if="hasImage()">
                    <div class="h-[200px] w-full rounded cursor-pointer">
                        <img class="w-full h-[200px] object-contain" x-bind:src="window.WE.IMG.url({{ $field }}.file_name)" />
                    </div>
                </template>
        
        
                <template x-if="!hasImage()">
                    <div class="space-y-1 text-center py-7">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>{{ translate('Select a file') }}</span>
                            </label>
                            <p class="pl-1">{{ translate('or drag and drop') }}</p>
                        </div>
                        <p class="text-xs text-gray-500">{{ translate('PNG, JPG, GIF up to 3MB') }}</p>
                    </div>
                </template>
            @else
                <div class="flex flex-col">
                    <template x-if="hasImage()">
                        <div class="w-full cursor-default mb-4 flex justify-between items-center">
                            <p class="font-semibold truncate pr-3" x-text="{{ $field }}.file_name.split(/[\\/]/).pop()"></p>
                            
                            <a class="p-1 rounded border border-gray-200" @click="event.stopPropagation();" :href="'{{ Storage::url('') }}'+{{ $field }}.file_name" target="_blank">
                                @svg('heroicon-o-eye', ['class' => 'h-4 w-4 text-gray-700'])
                            </a>
                            
                        </div>
                    </template>
                    <div class="flex flex-row justify-between">
                        <button type="button" class="-ml-2 -my-2 rounded-full px-3 py-2 inline-flex items-center text-left text-gray-400 group">
                            @svg('heroicon-s-paper-clip', ['class' => '-ml-1 h-5 w-5 mr-2 group-hover:text-gray-500'])
                            <span class="text-sm text-gray-500 group-hover:text-gray-600 italic">{{ translate('Attach a file') }}</span>
                        </button>
                        <button @click="event.preventDefault(); event.stopPropagation(); removeImage()" x-cloak x-show="hasImage()" type="button" class="relative z-10 -mr-3 -my-2 rounded-full px-3 py-2 inline-flex items-center text-left text-gray-400 group">
                            @svg('heroicon-o-x', ['class' => 'h-5 w-5 text-danger'])
                        </button>
                    </div>
                </div>
            @endif
        {{-- <x-system.invalid-msg field="{{  }}"></x-system.invalid-msg> --}}
    </div>
</div>
