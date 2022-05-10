{{-- Core Meta --}}
<div class="mt-8 p-4 border bg-white border-gray-200 rounded-lg shadow" x-data="{
    core_meta_template: {
        key: '',
        value: ''
    },
    add() {
        core_meta.push({...this.core_meta_template});
    },
    remove(index) {
        core_meta.splice(index, 1);
    }
}">
    <div class="w-full flex items-center justify-between border-b border-gray-200 pb-3 mb-4">
        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Meta') }}</h3>
    </div>

    <div class="w-full">
        <ul class="w-full">
            <template x-for="(meta, index) in core_meta">
                <li class="grid grid-cols-12 gap-4 mb-4 items-center">
                    <div class="col-span-5" >
                        <x-dashboard.form.input field="meta.key" placeholder="{{ translate('meta_key') }}" :x="true"></x-dashboard.form.input>
                    </div>
                    <div class="col-span-6">
                        <x-dashboard.form.input field="meta.value" placeholder="{{ translate('meta_value') }}" :x="true"></x-dashboard.form.input>
                    </div>
                    <div class="col-span-1 cursor-pointer" @click="remove(index)">
                        @svg('heroicon-o-trash', ['class' => 'h-4 w-4 text-danger'])
                    </div>
                </li>
            </template>
        </ul>

        <div href="javascript:;" class="btn-ghost !pl-0 !text-14" @click="add()">
            @svg('heroicon-o-plus', ['class' => 'h-3 w-3 mr-2'])
            {{ translate('Add new') }}
        </div>
    </div>
</div>
{{-- END Core Meta --}}