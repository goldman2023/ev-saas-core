<div>
    <div class="fixed z-[9999] inset-0 overflow-y-auto" x-data="{
  show: false,
  title: @entangle('title'),
  text: @entangle('text'),
  model_id: @entangle('model_id'),
  model_class: @entangle('model_class'),
  deleteModel() {
    $wire.deleteModel(this.model_id, this.model_class);
  }
}" @invoke-delete.window="
    model_id = $event.detail.model_id;
    model_class = $event.detail.model_class;
    title = $event.detail.title === undefined ? title : $event.detail.title;
    text = $event.detail.text === undefined ? text : $event.detail.text;
    show = true;" @delete-modal-hide.window="show = false;" x-show="show" x-cloak>
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-show="show"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="oapcity-100" x-transition:leave="ease-out duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="z-[9999] relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6"
                x-on:click.outside="show = false" x-show="show" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-out duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        @svg('heroicon-o-trash', ['class' => 'h-6 w-6 text-red-600'])
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" x-text="title"></h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" x-text="text"></p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <button type="button" class="btn-danger sm:col-start-2 !justify-center sm:text-sm"
                        @click="deleteModel()">{{ translate('Trash') }}</button>
                    <button @click="show = false" type="button"
                        class="mt-3 btn btn-white !justify-center sm:mt-0 sm:col-start-1 sm:text-sm">{{
                        translate('Cancel') }}</button>
                </div>

            </div>
        </div>
    </div>
</div>
