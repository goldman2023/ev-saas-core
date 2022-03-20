<div class="w-full" x-data="{
    limit: {{ (int) $limit }},
    count() {
        if({{ $field }} === undefined || {{ $field }} === null) {
            {{ $field }} = [''];
        }

        return {{ $field }}.length;
    },
    add() {
        if(this.count() >= this.limit) {
            return;
        }
        
        {{ $field }}.push('');
    },
    remove(index) {
        {{ $field }}.splice(index, 1);
    },
 }"
 >
    <template x-if="count() <= 1">
        <div class="flex">
            <input type="text" 
                    class="form-standard" 
                    placeholder="{{ $placeholder.' 1' }}"
                    x-model="{{ $field }}[0]" />
        </div>
    </template>
    <template x-if="count() > 1">
        <template x-for="[key, value] of Object.entries({{ $field }})">
            <div class="flex" :class="{'mt-2': key > 0}">
                <input type="text" 
                        class="form-standard"
                        x-bind:placeholder="'{{ $placeholder }} '+(Number(key)+1)"
                        x-model="{{ $field }}[key]" />
                <template x-if="key > 0">
                    <span class="ml-2 flex items-center cursor-pointer" @click="remove(key)">
                        @svg('heroicon-o-trash', ['class' => 'w-5 h-5 text-danger'])
                    </span>
                </template>
            </div>
        </template>
    </template>

    <div href="javascript:;" class="btn-ghost !pl-0 !text-14 mt-1" @click="add()" x-show="count() < limit">
        @svg('heroicon-o-plus', ['class' => 'h-3 w-3 mr-2'])
        {{ translate('Add new') }}
    </div>

    @if(!empty($field))
        <x-system.invalid-msg field="{{ $field }}" class="mt-1"></x-system.invalid-msg>
    @endif
</div>