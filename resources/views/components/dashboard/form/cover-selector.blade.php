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
    <div class="w-full flex justify-center rounded-t-lg @error($errorField) border !border-danger @enderror cursor-pointer"
            {{-- :class="{'px-6 pt-5 pb-6': {{ $field }}.id !== undefined && {{ $field }}.id !== null && {{ $field }}.id > 0 }" --}}
            @click="$wire.emit('showMediaLibrary', id, 'image', [{id:{{ $field }}?.id || '', file_name:{{ $field }}?.file_name || '',}])">

        <div class="w-full relative">
            <template x-if="{{ $field }}.id !== undefined && {{ $field }}.id !== null && {{ $field }}.id > 0">
                <div class="h-[160px] w-full rounded cursor-pointer">
                    <img class="w-full h-[160px] rounded-t-lg object-cover" x-bind:src="window.WE.IMG.url({{ $field }}.file_name)" />
                </div>
            </template>
    
            <template x-if="!({{ $field }}.id !== undefined && {{ $field }}.id !== null && {{ $field }}.id > 0)">
                <div class="h-[160px] w-full rounded cursor-pointer">
                    <img class="w-full h-[160px] rounded-t-lg object-cover" src="https://fakeimg.pl/1200x400/?text=Cover%20Photo" />
                </div>
            </template>

            <div class="absolute right-[16px] bottom-[16px] btn-primary">
                @svg('heroicon-s-upload', ['class' => 'w-4 h-4 mr-2'])
                <span>{{ translate('Update cover') }}</span>
            </div>
        </div>
        

        {{-- <x-system.invalid-msg field="{{  }}"></x-system.invalid-msg> --}}
    </div>
</div>