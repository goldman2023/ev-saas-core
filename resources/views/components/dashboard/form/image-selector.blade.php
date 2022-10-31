<div class="w-full" @if($multiple) wire:ignore @endif x-data="{
    id: '{{ $id }}',
    multiple: @js($multiple),
    sortableList: null,
    hasFiles() {
        if(this.multiple) {
            return {{ $field }} !== undefined && 
            {{ $field }} !== null &&
            {{ $field }}.length > 0 &&
            {{ $field }}[0].id !== undefined && 
            {{ $field }}[0].id !== null && 
            {{ $field }}[0].id > 0;
        } else {
            return {{ $field }} !== undefined && 
            {{ $field }} !== null && 
            {{ $field }}.id !== undefined && 
            {{ $field }}.id !== null && 
            {{ $field }}.id > 0;
        }
    },
    removeImage(key = 0) {
        if(this.multiple) {
            {{ $field }}[key].id = '';
            {{ $field }}[key].file_name = '';
            {{ $field }}[key].type = @js($fileType);
        } else {
            {{ $field }}.id = '';
            {{ $field }}.file_name = '';
            {{ $field }}[key].type = @js($fileType);
        }
    },
    makeSortable() {
        $nextTick(() => { 
            if(this.multiple) {
                let args = {
                    onSort: (evt) => {
                        {{ $field }}.forEach((item, index) => {
                            {{ $field }}[index]['order'] = Array.from($el.querySelector('.file-selector__sortable-list').children).indexOf($el.querySelector('.file-selector__sortable-list [data-image-id=\''+item.id+'\']'));
                        });
                    },
                };

                if(this.sortableList) {
                    this.sortableList.destroy();
                    this.sortableList = window.Sortable.create($el.querySelector('.file-selector__sortable-list'), args);
                } else {
                    if($el.querySelector('.file-selector__sortable-list') !== null) {
                        this.sortableList = window.Sortable.create($el.querySelector('.file-selector__sortable-list'), args);
                    }
                }
            }
        });
    }
}" 
x-init="makeSortable()"
@we-media-selected-event.window="
    if($event.detail.for_id === id) {
        if(!hasFiles()) {
            if(multiple) {
                {{ $field }}[0] = @js(toJSONMedia(null));
            } else {
                {{ $field }} = @js(toJSONMedia(null));
            }
        }

        if(multiple) {
            let selected = _.get($event, 'detail.selected', []);
            
            if(selected.length > 0) {
                // Remove empty values (just in case)
                {{ $field }} = {{ $field }}.filter(item => !_.isEmpty(item) && _.get(item, 'id', null) !== null);
                
                selected.forEach((item, index) => {
                    let existingItem = {{ $field }}.filter(fieldItem => Number(fieldItem.id) === Number(item.id));

                    if(_.isEmpty( existingItem )) {
                        if(item.order === undefined) {
                            let lastOrder = 1;

                            if({{ $field }}.length > 0) {
                                lastOrder = Math.max(...{{ $field }}.map(o => o.order).filter( n => n !== undefined ));

                                if(lastOrder) {
                                    lastOrder += 1;
                                }
                                
                            } else {
                                lastOrder = 1;
                            }

                            item['order'] = Number(lastOrder);
                        }

                        {{ $field }}.push(item);

                    }
                });
                
                // Remove empty values (just in case)
                {{ $field }} = {{ $field }}.filter(item => !_.isEmpty(item) && _.get(item, 'id', null) !== null);

                makeSortable();
            }
        } else {
            {{ $field }} = $event.detail.selected[0];
        }
    }
">
    <div :id="'file-selector-'+id" class="@if($template != 'simple') max-w-lg flex justify-center @if(!$multiple) border-2 border-gray-300 border-dashed rounded-md cursor-pointer @endif @endif  @error($errorField) !border-danger @enderror  "
        @if($template != 'simple' && !$multiple):class="{'px-6 pt-5 pb-6': hasFiles() }" @endif
        
        @if(!$multiple)
            @click="$wire.emit('showMediaLibrary', id, 'image', [{{ $field }}])"
        @endif
    >

        @if($multiple)
            <div class="w-full flex flex-col">
                <template x-if="hasFiles()">
                    <ul class="file-selector__sortable-list w-full grid grid-cols-3 gap-3 ">
                        <template x-for="item in {{ $field }}">
                            <li class="flex flex-col border rounded-lg overflow-hidden cursor-grab" :data-image-id="item.id">
                                <template x-if="item.type === 'image'">
                                    <img :src="window.WE.IMG.url(item.file_name)" class="w-full h-[100px] object-cover" />
                                </template>

                                <template x-if="item.type === 'document'">
                                    <div class="w-full px-2 py-3 flex flex-col">
                                        <strong class="text-12" x-text="item.file_original_name"></strong>
                                        <p class="pt-2 text-10" x-text="window.WE.utils.formatSizeUnits(item.file_size)"></p>
                                    </div>
                                </template>
                            </li>
                        </template>
                    </ul>
                </template>
        
                <template x-if="!hasFiles()">
                    <div class="w-full flex justify-center border-2 border-gray-300 border-dashed rounded-md p-6">
                        <p>{{ translate('No items selected...') }}</p>
                    </div>
                </template>

                <div class="w-full flex mt-4">
                    <button type="button" class="btn-primary ml-auto"
                        @click="$wire.emit('showMediaLibrary', id, 'image', {{ $field }}.map((item) => { return {id: item?.id || '', file_name: item?.file_name || '', type: item?.type || @js($fileType) }; }), null, true)">
                        {{ $addNewItemLabel }}
                    </button>
                </div>
            </div>
        @else
            @if($template != 'simple')
                <template x-if="hasFiles()">
                    <div class="h-[200px] w-full rounded cursor-pointer">
                        <img class="w-full h-[200px] object-contain" x-bind:src="window.WE.IMG.url({{ $field }}.file_name)" />
                    </div>
                </template>


                <template x-if="!hasFiles()">
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
                    <template x-if="hasFiles()">
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
                        <button @click="event.preventDefault(); event.stopPropagation(); removeImage()" x-cloak x-show="hasFiles()" type="button" class="relative z-10 -mr-3 -my-2 rounded-full px-3 py-2 inline-flex items-center text-left text-gray-400 group">
                            @svg('heroicon-o-x', ['class' => 'h-5 w-5 text-danger'])
                        </button>
                    </div>
                </div>
            @endif
        @endif
            
        {{-- <x-system.invalid-msg field="{{  }}"></x-system.invalid-msg> --}}
    </div>
</div>
