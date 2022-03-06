<div we-slot class="bg-white rounded-lg shadow border mb-3 select-none">
    <div class="bg-indigo-600 px-4 py-5 rounded-t-lg border-b border-gray-200 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-white" we-slot-title></h3>
        <p class="mt-1 text-14 text-white" we-slot-description></p>
    </div>

    <div we-slot-list class="w-full flex flex-col divide-y divide-gray-200 px-3 mt-3">
        <div we-slot-list-item class="w-full flex flex-col border rounded-lg mb-2" x-data="{
                open_component: false,
            }">

            <div class="w-full flex items-center justify-between border-b border-gray-200 py-3 px-3 cursor-pointer" x-on:click="open_component = !open_component">
                <strong we-slot-list-item-title class="pr-2" ></strong>
                @svg('heroicon-o-chevron-down', ['class' => 'w-4 h-4', 'x-bind:class' => "{'rotate-180':open_component}"])
            </div>

            <div we-slot-list-item-content class="w-full px-3 py-3" x-show="open_component">
                
            </div>
        </div>
    </div>
</div>
