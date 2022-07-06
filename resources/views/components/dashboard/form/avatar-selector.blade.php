<div class="w-full" x-data="{
    id: '{{ $id }}',
}"
@we-media-selected-event.window="
    if($event.detail.for_id === id) {
        {{ $field }}.id = $event.detail.selected[0]['id'] || '';
        {{ $field }}.file_name = $event.detail.selected[0]['file_name'] || '';
    }
">
    <div class="w-full flex justify-center rounded-lg cursor-pointer @error($errorField) border !border-danger @enderror "
            {{-- :class="{'px-6 pt-5 pb-6': {{ $field }} !== null && {{ $field }}.id !== undefined && {{ $field }}.id !== null && {{ $field }}.id > 0 }" --}}
            @click="$wire.emit('showMediaLibrary', id, 'image', [{id:{{ $field }}.id, file_name:{{ $field }}.file_name}])">

        <div class="relative">
            <template x-if="{{ $field }} !== null && {{ $field }}.id !== undefined && {{ $field }}.id !== null && {{ $field }}.id > 0">
                <div class="h-[100px] w-[100px] rounded cursor-pointer">
                    <img class="w-[100px] h-[100px] rounded-lg object-cover" x-bind:src="window.WE.IMG.url({{ $field }}.file_name)" />
                </div>
            </template>
    
            <template x-if="!({{ $field }} !== null && {{ $field }}.id !== undefined && {{ $field }}.id !== null && {{ $field }}.id > 0)">
                <div class="h-[100px] w-[100px] rounded cursor-pointer">
                    <img class="w-[100px] h-[100px] rounded-lg object-cover" src="https://fakeimg.pl/300x300/?text=Avatar" />
                </div>
            </template>

            <div class="absolute right-[6px] bottom-[6px] bg-gray-400 p-1 rounded-full">
                @svg('heroicon-s-pencil', ['class' => 'w-3 h-3 text-white'])
            </div>
        </div>
        

        {{-- <x-system.invalid-msg field="{{  }}"></x-system.invalid-msg> --}}
    </div>
</div>