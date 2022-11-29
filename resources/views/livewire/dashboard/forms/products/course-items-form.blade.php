@push('head_scripts')

@endpush

<div x-data="{
        course_items: @js($course_items ?? []),
        current_item: @entangle('current_item').defer,
        onSave() {
            $wire.set('current_item.name', this.current_item.name, true);
            $wire.set('current_item.excerpt', this.current_item.excerpt, true);
            $wire.set('current_item.type', this.current_item.type, true);
            $wire.set('current_item.parent_id', this.current_item.parent_id, true);
            $wire.set('current_item.free', this.current_item.free, true);
            $wire.set('current_item.accessible_after', this.current_item.accessible_after, true);
            $wire.set('current_item.content', this.current_item.content, true);
            $wire.set('current_item.video', this.current_item.video, true);

            if(this.current_item.type === 'quizz') {
                $wire.set('current_item.subject_id', this.current_item.subject_id, true);
            }
        }
    }" class="lw-form container-fluid mb-4" @init-form.window="" x-cloak>

    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:target="saveCourseItem()"
            wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full" wire:loading.class="opacity-30 pointer-events-none" wire:target="saveCourseItem()">
            <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                <div class="border-b border-gray-200 mb-3 pb-3">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Course Items') }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Here you can manage your course
                        items/chapters/data') }}</p>
                </div>

                <div class="col-span-12 w-full ">
                    <ul class="w-full flex-flex-col space-y-3">
                        @if($course_items->isNotEmpty())
                        @foreach($course_items as $course_item)
                        @php course_item_template($course_item); @endphp
                        @endforeach
                        @endif
                    </ul>
                </div>

                <div class="col-span-12 w-full flex mt-4 pt-4 border-t border-gray-200">
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
                    $wire.resetCurrentCourseItem();
                }
            }
        " @hide-course-items-form.window="show = false;" wire:loading.class="opacity-30 pointer-events-none">

            <!-- Type -->
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start pb-5 sm:pt-5 sm:mt-5">
                <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    <span class="mr-2">{{ translate('Type') }}</span>
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.select :items="\App\Enums\CourseItemTypes::toArray()" selected="current_item.type"
                        :nullable="false"></x-dashboard.form.select>
                </div>
            </div>
            <!-- END Type -->

            <!-- Name -->
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5 sm:border-t sm:border-gray-200" x-data="{}">
                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    {{ translate('Name') }}
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.input field="current_item.name" :x="true" />
                </div>
            </div>
            <!-- END Name -->


            {{-- Quizz content --}}
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                x-data="{}" x-show="current_item.type === 'quizz'">
                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    {{ translate('Quizz') }}

                    <a href="" class="block text-gray-400 text-xs" target="_blank">
                        {{ translate('Create new quiz') }}
                    </a>
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.select :items="$available_quizzes" selected="current_item.subject_id"
                        :nullable="false"></x-dashboard.form.select>
                </div>
            </div>
            <!-- END Content -->





            <!-- Excerpt -->
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                x-data="{}">

                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    {{ translate('Excerpt') }}
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <textarea type="text"
                        class="form-standard h-[80px] @error('current_item.excerpt') is-invalid @enderror"
                        placeholder="{{ translate('Write a short description for this course item') }}"
                        x-model="current_item.excerpt">
                    </textarea>

                    <x-system.invalid-msg class="w-full" field="current_item.excerpt"></x-system.invalid-msg>
                </div>
            </div>
            <!-- END Excerpt -->

            <!-- Free -->
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                x-data="{}">
                <label class="block text-sm font-medium text-gray-700">
                    {{ translate('Is Free?') }}
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.toggle field="current_item.free" />
                </div>
            </div>
            <!-- END Free -->

            <!-- Accessible after-->
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                x-data="{}">
                <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
                    {{ translate('Accessible after') }}
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.date field="current_item.accessible_after" :enable-time="true"
                        date-format="d.m.Y H:i"></x-dashboard.form.date>
                </div>
            </div>
            <!-- END Accessible after -->


            <!-- WYSIWG Content -->
            <template x-if="current_item.type === 'wysiwyg'">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                    x-data="{}" wire:ignore>
                    <label class="col-span-3 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        {{ translate('Content (WYSIWYG)') }}
                    </label>

                    <div class="mt-1 sm:mt-0 sm:col-span-3">
                        <x-dashboard.form.editor-js field="current_item.content" id="course-item-content-editor">
                        </x-dashboard.form.editor-js>
                        <x-system.invalid-msg class="w-full" field="current_item.content"></x-system.invalid-msg>
                    </div>
                </div>
            </template>


            {{-- Video content --}}
            <template x-if="current_item.type === 'video'">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5"
                    x-data="{}">
                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        {{ translate('Content (video embed link)') }}
                    </label>

                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <x-dashboard.form.input field="current_item.video" :x="true" />
                    </div>
                </div>
            </template>





             <!-- Parent category -->
             <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    <span class="mr-2">{{ translate('Parent Course Item') }}</span>
                </label>

                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <x-dashboard.form.select :items="$selectable_course_items_flat" selected="current_item.parent_id">
                    </x-dashboard.form.select>
                </div>
            </div>
            <!-- END Parent category -->

            <div class="w-full flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                @if(!empty($current_item->id))
                <button type="button" class="btn btn-danger  btn-sm"
                    wire:click="removeCourseItem({{ $current_item->id }});">
                    {{ translate('Delete') }}
                </button>
                @endif

                <div class="ml-auto">
                    <button type="button" class="btn btn-outline-standard btn-sm text-14" @click="show = false">
                        {{ translate('Cancel') }}
                    </button>

                    <button type="button" class="btn btn-primary ml-2 btn-sm" @click="onSave()"
                        wire:click="saveCourseItem()">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div>

        </div>
    </x-system.form-modal>

    <?php
        function course_item_template($course_item) {
    ?>
    <li class="w-full flex flex-col border border-gray-200 rounded-md py-2 px-3">
        <div class="flex items-center justify-between">
            <strong class="inline-flex items-center">
                {{ $course_item->name }}

                @if($course_item->children->isEmpty())
                @if($course_item->type === 'video')
                @svg('heroicon-s-play', ['class' => 'w-4 h-4 ml-2'])
                @elseif($course_item->type === 'wysiwyg')
                @svg('heroicon-o-document', ['class' => 'w-4 h-4 ml-2'])
                @elseif($course_item->type === 'quizz')
                @svg('heroicon-o-pencil', ['class' => 'w-4 h-4 ml-2'])
                @endif

                @if($course_item->free)
                <span class="badge-success ml-2">{{ translate('Free') }}</span>
                @endif
                @endif
            </strong>


            <div class="">
                <button type="button" class="btn"
                    @click="$dispatch('display-modal', {'id': 'add-course-item-modal', 'current_item_id': {{ $course_item->id }}})">
                    @svg('heroicon-o-pencil-alt', ['class' => 'w-4 h-4'])
                </button>
            </div>
        </div>

        @if($course_item->children?->isNotEmpty() ?? null)
        <ul class="w-full flex-flex-col space-y-3 mt-1 mb-2 pt-4 border-t border-gray-200">
            {{-- {{ 'p-'.($course_item->children->first()->depth*3) }} --}}
            <?php foreach($course_item->children as $child) {
                        course_item_template($child);
                     } ?>
        </ul>
        @endif
    </li>
    <?php
        }
    ?>
</div>
