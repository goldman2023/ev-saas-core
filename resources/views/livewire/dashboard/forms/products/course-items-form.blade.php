@push('head_scripts')

@endpush

<div x-data="{
        course_items: @js($course_items ?? []),
        current_item: @entangle('current_item').defer,
        onSave() {
            $wire.set('current_item.type', this.current_item.type, true);
            $wire.set('current_item.parent_id', this.current_item.parent_id, true);
            $wire.set('current_item.free', this.current_item.free, true);
            $wire.set('current_item.accessible_after', this.current_item.accessible_after, true);

            if(this.current_item.type === 'wysiwyg') {
                $wire.set('current_item.content', this.current_item.content, true);
            }
        }
    }"
     class="lw-form container-fluid mb-4"
     @init-form.window=""
     x-cloak>

     <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                              wire:target="saveCourseItem()"
                              wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full"
             wire:loading.class="opacity-30 pointer-events-none"
             wire:target="saveCourseItem()"
        >
            <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                <div class="border-b border-gray-200 mb-3 pb-3">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Course Items') }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Here you can manage your course items/chapters/data') }}</p>
                </div>

                <div class="col-span-12 w-full ">
                    <ul class="w-full flex-flex-col space-y-3">
                        @if($course_items->isNotEmpty())
                            @foreach($course_items as $course_item)
                                <li class="w-full flex items-center justify-between border border-gray-200 rounded-md py-2 px-3">
                                    <strong>{{ $course_item->name }}</strong>

                                    <div class="">
                                        <button type="button" class="btn" @click="$dispatch('display-modal', {'id': 'add-course-item-modal', 'current_item_id': {{ $course_item->id }}})">
                                            @svg('heroicon-o-pencil-alt', ['class' => 'w-4 h-4'])
                                        </button>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div class="col-span-12 w-full mt-4 pt-4 border-t border-gray-200">
                    <button type="button" class="btn btn-primary ml-auto btn-sm"
                        @click="$dispatch('display-modal', {'id': 'add-course-item-modal'})">
                        {{ translate('Add Course Item') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-system.form-modal id="add-course-item-modal" title="Course Item" class="!max-w-3xl" :prevent-close="true">
        <div class="w-full" x-data="{}" @display-modal.window="
            if($event.detail.id === id) {
                if($event.detail.current_item_id !== undefined && $event.detail.current_item_id !== null) {
                    $wire.selectCourseItem($event.detail.current_item_id);
                } else {
                    $wire.addCourseItem();
                }
            }
        ">

            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Course Item') }}</h3>
                {{-- <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Descr') }}</p> --}}
            </div>

            <!-- Name -->
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5" x-data="{}">
                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    {{ translate('Name') }}
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.input field="current_item.name" />
                </div>
            </div>
            <!-- END Name -->

            <!-- Parent category -->
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    <span class="mr-2">{{ translate('Parent Course Item') }}</span>
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    @php
                        $course_items = \App\Models\CourseItem::tree(true)->get()->keyBy('id')->map(fn($item) => $item->name);
                    @endphp
                    <x-dashboard.form.select :items="$course_items" selected="current_item.parent_id"></x-dashboard.form.select>
                </div>
            </div>
            <!-- END Parent category -->

            <!-- Type -->
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    <span class="mr-2">{{ translate('Type') }}</span>
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.select :items="\App\Enums\CourseItemTypes::toArray()" selected="current_item.type" :nullable="false"></x-dashboard.form.select>
                </div>
            </div>
            <!-- END Type -->

            <!-- Excerpt -->
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">

                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    {{ translate('Excerpt') }}
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <textarea type="text" class="form-standard h-[80px] @error('current_item.excerpt') is-invalid @enderror"
                                placeholder="{{ translate('Write a short description for this course item') }}"
                                wire:model.defer="current_item.excerpt">
                    </textarea>

                    <x-system.invalid-msg class="w-full" field="current_item.excerpt"></x-system.invalid-msg>
                </div>
            </div>
            <!-- END Excerpt -->

            <!-- Free -->
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
                <label class="block text-sm font-medium text-gray-700">
                    {{ translate('Is Free?') }}
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.toggle field="current_item.free" />
                </div>
            </div>
            <!-- END Free -->

            <!-- Accessible after-->
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}">
                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                    {{ translate('Accessible after') }}
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.date field="current_item.accessible_after" :enable-time="true" date-format="d.m.Y H:i"></x-dashboard.form.date>
                </div>
            </div>
            <!-- END Accessible after -->


            <!-- Content -->
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5" x-data="{}"x-show="current_item.type === 'wysiwyg'"  wire:ignore>

                <label class="col-span-3 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    {{ translate('Content (WYSIWYG)') }}
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-3">
                    <x-dashboard.form.editor-js field="current_item.content" id="course-item-content-editor"></x-dashboard.form.editor-js>
                    <x-system.invalid-msg class="w-full" field="current_item.content"></x-system.invalid-msg>
                </div>
            </div>

            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5 sm:mt-5" x-data="{}" x-show="current_item.type === 'video'">
                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    {{ translate('Content (video embed link)') }}
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.input field="current_item.content" />
                </div>
            </div>
            <!-- END Content -->

            <div class="w-full flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                <button type="button" class="btn btn-outline-standard btn-sm"
                    @click="show = false">
                    {{ translate('Cancel') }}
                </button>

                <button type="button" class="btn btn-primary ml-auto btn-sm"
                    @click="onSave()"
                    wire:click="saveCourseItem()">
                    {{ translate('Save') }}
                </button>
            </div>
            
        </div>
    </x-system.form-modal>
</div>
