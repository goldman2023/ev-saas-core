<div class="w-full" x-data="{
    id: '{{ $id }}',
    hasImage() {
        return {{ $field }} !== undefined && {{ $field }} !== null && {{ $field }}.id !== undefined && {{ $field }}.id !== null && {{ $field }}.id > 0
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
    <div class="max-w-lg flex justify-center border-2 border-gray-300 @error($errorField) !border-danger @enderror border-dashed rounded-md cursor-pointer"
            :class="{'px-6 pt-5 pb-6': hasImage() }"
            @click="$wire.emit('showMediaLibrary', id, 'image', [{id:{{ $field }}?.id || '', file_name:{{ $field }}?.file_name || ''}])">

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

        {{-- <x-system.invalid-msg field="{{  }}"></x-system.invalid-msg> --}}
    </div>
</div>
