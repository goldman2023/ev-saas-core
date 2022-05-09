<div class="mt-7 text-20 font-semibold">
    {{ translate('Pix-Pro Settings') }}
</div>

<!-- Software download URL -->
<div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-2" x-data="{}">
    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
        {{ translate('Download Software URL') }}
    </label>

    <div class="mt-1 sm:mt-0 sm:col-span-2">
        <x-dashboard.form.input field="settings.pix_pro_software_download_url" />
    </div>
</div>
<!-- END Software download URL -->

<!-- Downloads -->
<div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
        {{ translate('Downloads') }}
    </label>

    <div class="mt-1 sm:mt-0 sm:col-span-2">
        <div class="w-full" x-data="{
            limit: 9999,
            template: {
                'date': '',
                'name': '',
                'version': '',
                'url': '',
            },
            count() {
                if(settings.pix_pro_downloads === undefined || settings.pix_pro_downloads === null) {
                    settings.pix_pro_downloads = [{...this.template}];
                }
        
                return settings.pix_pro_downloads.length;
            },
            add() {
                if(this.count() >= this.limit) {
                    return;
                }
                
                settings.pix_pro_downloads.push({...this.template});
            },
            remove(index) {
                settings.pix_pro_downloads.splice(index, 1);
            },
         }"
         >
            {{-- <template x-if="count() <= 1">
                <div class="flex">
                    <input type="text" 
                            class="form-standard" 
                            placeholder="{{ $placeholder.' 1' }}"
                            x-model="settings.pix_pro_downloads[0]" />
                </div>
            </template> --}}
            <template x-if="count() >= 1">
                <template x-for="(item, index) in settings.pix_pro_downloads">
                    <div class="w-full flex">
                        <div class="grid grid-cols-12 gap-3" :class="{'mt-2': index > 0}">
                            <input type="text" 
                                    class="form-standard col-span-12 lg:col-span-3"
                                    x-bind:placeholder="'{{ translate('Name') }}'"
                                    x-model="item.name" />
    
                                <input type="text" 
                                    class="form-standard col-span-12 lg:col-span-3"
                                    x-bind:placeholder="'{{ translate('Date') }}'"
                                    x-model="item.date" />
    
                                <input type="text" 
                                    class="form-standard col-span-12 lg:col-span-3"
                                    x-bind:placeholder="'{{ translate('Version') }}'"
                                    x-model="item.version" />
    
                                <input type="text" 
                                    class="form-standard col-span-12 lg:col-span-3"
                                    x-bind:placeholder="'{{ translate('URL') }}'"
                                    x-model="item.url" />
    
                            {{-- <template x-if="index > 0"> --}}
                                
                            {{-- </template> --}}
                        </div>

                        <span class="ml-2 flex items-center cursor-pointer" @click="remove(index)">
                            @svg('heroicon-o-trash', ['class' => 'w-5 h-5 text-danger'])
                        </span>
                    </div>
                </template>
            </template>
        
            <div href="javascript:;" class="btn-ghost !pl-0 !text-14 mt-1" @click="add()" x-show="count() < limit">
                @svg('heroicon-o-plus', ['class' => 'h-3 w-3 mr-2'])
                {{ translate('Add new') }}
            </div>
        
            {{-- @if(!empty($field))
                <x-system.invalid-msg field="{{ $field }}" class="mt-1"></x-system.invalid-msg>
            @endif --}}
        </div>
    </div>
</div>
<!-- END Downloads -->