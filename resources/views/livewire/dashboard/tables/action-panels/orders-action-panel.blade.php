<div class="bg-white border border-gray-200 rounded-lg" x-data="{
    items: @entangle('items').defer,
    table_id: @js($tableId),
    action: @entangle('action').defer,
    get count() {
        return this.items.length;
    },
    toggleItem(data) {
        if(data.table_id === this.table_id) {
            if(this.items.indexOf(data.id) !== -1) {
                this.items.splice(this.items.indexOf(data.id), 1);
            } else {
                this.items.push(data.id);
            }
        }
    },
    runAction(event) {
        event.preventDefault();
        $wire.runAction();
    }
}" @table-item-toggle.window="toggleItem($event.detail)">
    <div class="px-3 py-3 border-b border-gray-200">
        <div class="flex justify-between items-center flex-wrap sm:flex-nowrap">
            <div class="w-full">
                <h4 class="font-semibold">{{ translate('Manage orders') }}</h4>
            </div>
        </div>
    </div>
    <div class="px-3 py-3 sm:px-3">
        <li class="flow-root">
            <div class="grid grid-cols-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                    {{ translate('Action') }}
                </label>
                <select class="block col-span-2 p-2 mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    x-model="action">
                    <option selected>{{ translate('Select an action') }}</option>

                    @if(!empty($availableActions))
                        @foreach($availableActions as $action => $label)
                            <option value="{{ $action }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <a href="#" @click="runAction(event)" class="relative bg-gray-100 m-2 p-3 flex items-center justify-between space-x-4 rounded-xl hover:bg-gray-200">
                <div>
                    <h3 class="text-sm font-medium text-gray-900">
                        <span>{{ translate('Run Action') }}</span>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 line-clamp-2" x-text="'{{ translate('Action will affect') }} '+count+' {{ translate('orders') }}'"></p>
                </div>

                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-lg bg-primary">
                    @svg('heroicon-o-arrow-right', ['class' => 'h-6 w-6 text-white'])
                </div>
            </a>
        </li>
    </div>
</div>
